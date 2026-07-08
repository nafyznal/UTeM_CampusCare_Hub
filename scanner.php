<?php
session_start();
include('connect.php');

$message     = "";
$messageType = ""; // success | warning | error

// Handle the scanned QR code, submitted as a normal form POST (no AJAX, no JSON)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['scanned_request_id'])) {

    $requestId = trim($_POST['scanned_request_id']);

    if ($requestId === '' || !ctype_digit($requestId)) {
        $message     = "Invalid QR code. Expected a numeric Request ID.";
        $messageType = "error";

    } else {
        $requestId = (int) $requestId;

        // Look up the request along with student + kit info
        $sql = "SELECT request.RequestID, request.Status, student.Name, kit.KitName
                FROM request
                JOIN student ON request.StudentId = student.StudentId
                JOIN kit ON request.Kit_Id = kit.Kit_Id
                WHERE request.RequestID = $requestId";

        $result = $conn->query($sql);
        $row    = ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;

        if (!$row) {
            $message     = "No request found with ID #$requestId.";
            $messageType = "error";

        } elseif ($row['Status'] === 'Collected') {
            $message     = "Request #$requestId ({$row['Name']} - {$row['KitName']}) was already collected.";
            $messageType = "warning";

        } elseif ($row['Status'] !== 'Approved') {
            $message     = "Request #$requestId is currently '{$row['Status']}'. Only Approved requests can be marked Collected.";
            $messageType = "error";

        } else {
            $updateSql = "UPDATE request SET Status='Collected' WHERE RequestID=$requestId";
            if ($conn->query($updateSql)) {
                $message     = "Request #$requestId ({$row['Name']} - {$row['KitName']}) marked as Collected.";
                $messageType = "success";
            } else {
                $message     = "Failed to update request: " . $conn->error;
                $messageType = "error";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Scanner</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="formatAdmin.css">

    <style>
        .scanner-wrapper {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 40px 20px;
        }

        .scanner-card {
            background-color: #541A1A;
            color: #ffffff;
            border-radius: 16px;
            padding: 24px;
            filter: drop-shadow(5px 5px 6px rgba(24, 24, 24, 0.3));
            width: 100%;
            max-width: 420px;
            box-sizing: border-box;
        }

        #video-wrapper {
            position: relative;
            width: 100%;
            aspect-ratio: 1;
            background: #1a0a0a;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 16px;
        }

        #qr-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        #overlay {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }

        .scan-frame {
            width: 65%;
            height: 65%;
            border: 2px solid rgba(255,255,255,0.6);
            border-radius: 12px;
            box-shadow: 0 0 0 2000px rgba(0,0,0,0.45);
            position: relative;
        }

        .corner {
            position: absolute;
            width: 22px;
            height: 22px;
            border-color: #F1E2D1;
            border-style: solid;
        }
        .tl { top:-2px;    left:-2px;  border-width:3px 0 0 3px; border-radius:4px 0 0 0; }
        .tr { top:-2px;    right:-2px; border-width:3px 3px 0 0; border-radius:0 4px 0 0; }
        .bl { bottom:-2px; left:-2px;  border-width:0 0 3px 3px; border-radius:0 0 0 4px; }
        .br { bottom:-2px; right:-2px; border-width:0 3px 3px 0; border-radius:0 0 4px 0; }

        .scan-line {
            position: absolute;
            left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, #F1E2D1, transparent);
            animation: scanMove 1.8s ease-in-out infinite;
        }
        @keyframes scanMove {
            0%, 100% { top: 10%; }
            50%       { top: 88%; }
        }

        #placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: rgba(241,226,209,0.5);
            gap: 10px;
            font-size: 14px;
        }
        #placeholder svg {
            width: 48px;
            height: 48px;
            opacity: 0.5;
        }

        .btn-group {
            display: flex;
            gap: 8px;
            margin-bottom: 14px;
        }

        .qr-btn {
            flex: 1;
            padding: 10px 12px;
            border: 1.5px solid rgba(241,226,209,0.4);
            border-radius: 10px;
            background: rgba(255,255,255,0.08);
            color: #F1E2D1;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), background 0.15s;
        }
        .qr-btn:hover {
            transform: scale(1.05);
            background: rgba(255,255,255,0.15);
        }
        .qr-btn:disabled {
            opacity: 0.35;
            cursor: not-allowed;
            transform: none;
        }

        #status {
            text-align: center;
            font-size: 13px;
            color: rgba(241,226,209,0.7);
            margin-bottom: 14px;
        }

        .result-box {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(241,226,209,0.25);
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 14px;
        }

        .result-box.box-success {
            border-color: rgba(120,220,150,0.5);
            background: rgba(120,220,150,0.12);
        }

        .result-box.box-warning {
            border-color: rgba(230,180,90,0.5);
            background: rgba(230,180,90,0.12);
        }

        .result-box.box-error {
            border-color: rgba(230,100,100,0.5);
            background: rgba(230,100,100,0.12);
        }

        .result-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: rgba(241,226,209,0.6);
            font-weight: bold;
            margin-bottom: 6px;
        }

        .result-text {
            font-size: 15px;
            color: #F1E2D1;
            word-break: break-word;
        }
    </style>
</head>
<body>

    <?php include('headerScanner.php'); ?>

    <main>
        <div class="scanner-wrapper">
            <div class="scanner-card">

                <div id="video-wrapper">
                    <video id="qr-video" playsinline muted autoplay></video>

                    <div id="overlay">
                        <div class="scan-frame">
                            <div class="corner tl"></div>
                            <div class="corner tr"></div>
                            <div class="corner bl"></div>
                            <div class="corner br"></div>
                            <div class="scan-line"></div>
                        </div>
                    </div>

                    <div id="placeholder">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M3 7V5a2 2 0 0 1 2-2h2M17 3h2a2 2 0 0 1 2 2v2M21 17v2a2 2 0 0 1-2 2h-2M7 21H5a2 2 0 0 1-2-2v-2"/>
                            <rect x="7" y="7" width="4" height="4" rx="1"/>
                            <rect x="13" y="7" width="4" height="4" rx="1"/>
                            <rect x="7" y="13" width="4" height="4" rx="1"/>
                            <path d="M13 13h1v1M15 15h2v2M13 17h2"/>
                        </svg>
                        Camera is off
                    </div>
                </div>

                <div class="btn-group">
                    <button class="qr-btn" id="startBtn" type="button" onclick="startScanner()">▶ Start</button>
                    <button class="qr-btn" id="stopBtn"  type="button" onclick="stopScanner()"  disabled>⏹ Stop</button>
                    <button class="qr-btn" id="flipBtn"  type="button" onclick="flipScanner()"  disabled>🔄 Flip</button>
                </div>

                <p id="status">Press Start to activate the camera</p>

                <?php if ($message !== ""): ?>
                    <div class="result-box box-<?php echo $messageType; ?>">
                        <div class="result-label">Scan Result</div>
                        <div class="result-text"><?php echo htmlspecialchars($message); ?></div>
                    </div>
                <?php endif; ?>

                <!-- This form is submitted automatically by JS the instant a QR code is decoded.
                     The page reloads and the PHP block at the top processes the result,
                     same pattern as updateFinal.php — no AJAX, no JSON. -->
                <form method="post" action="scanner.php" id="scanForm">
                    <input type="hidden" name="scanned_request_id" id="scanned_request_id" value="">
                </form>

            </div>
        </div>
    </main>

    <script src="https://unpkg.com/@zxing/library@latest/umd/index.min.js"></script>

    <script>
        let codeReader       = null;
        let selectedDeviceId = null;
        let allDevices       = [];
        let hasSubmitted     = false; // stop scanning loop from firing twice before page reloads

        const placeholder = document.getElementById('placeholder');
        const statusEl    = document.getElementById('status');
        const scanForm    = document.getElementById('scanForm');
        const scanInput   = document.getElementById('scanned_request_id');

        async function startScanner() {
            try {
                codeReader = new ZXing.BrowserMultiFormatReader();

                allDevices = await codeReader.listVideoInputDevices();

                if (allDevices.length === 0) {
                    statusEl.textContent = 'No camera found.';
                    return;
                }

                const rearCam = allDevices.find(d =>
                    d.label.toLowerCase().includes('back') ||
                    d.label.toLowerCase().includes('rear') ||
                    d.label.toLowerCase().includes('environment')
                );
                selectedDeviceId = rearCam ? rearCam.deviceId : allDevices[0].deviceId;

                placeholder.style.display = 'none';
                document.getElementById('startBtn').disabled = true;
                document.getElementById('stopBtn').disabled  = false;
                document.getElementById('flipBtn').disabled  = false;
                statusEl.textContent = 'Scanning… point at a QR code';

                await codeReader.decodeFromVideoDevice(
                    selectedDeviceId,
                    'qr-video',
                    (result, err) => {
                        if (result && !hasSubmitted) {
                            const data = result.text;
                            if (data) {
                                submitScan(data);
                            }
                        }
                    }
                );

            } catch (err) {
                statusEl.textContent = 'Error: ' + err.message;
                console.error(err);
            }
        }

        function stopScanner() {
            if (codeReader) {
                codeReader.reset();
                codeReader = null;
            }
            placeholder.style.display = '';
            document.getElementById('startBtn').disabled = false;
            document.getElementById('stopBtn').disabled  = true;
            document.getElementById('flipBtn').disabled  = true;
            statusEl.textContent = 'Camera stopped.';
        }

        async function flipScanner() {
            if (!codeReader || allDevices.length < 2) return;

            const currentIndex = allDevices.findIndex(d => d.deviceId === selectedDeviceId);
            const nextIndex    = (currentIndex + 1) % allDevices.length;
            selectedDeviceId   = allDevices[nextIndex].deviceId;

            statusEl.textContent = 'Switching camera…';

            codeReader.reset();

            await codeReader.decodeFromVideoDevice(
                selectedDeviceId,
                'qr-video',
                (result, err) => {
                    if (result && !hasSubmitted) {
                        const data = result.text;
                        if (data) {
                            submitScan(data);
                        }
                    }
                }
            );

            statusEl.textContent = 'Scanning… point at a QR code';
        }

        // Fills the hidden input and submits the form normally (full page reload).
        // PHP at the top of this same file handles the POST and shows the result.
        function submitScan(data) {
            hasSubmitted = true;
            statusEl.textContent = 'QR detected — submitting…';
            scanInput.value = data;
            scanForm.submit();
        }

        $(document).ready(function () {
            $('body').fadeIn(1000);

            $('#menu-icon').click(function (e) {
                e.preventDefault();
                $('#nav-section').toggleClass('hidden');
            });

            $('.icon, li, #logout').hover(
                function () { $(this).addClass('hover'); },
                function () { $(this).removeClass('hover'); }
            );
        });
    </script>

</body>
</html>