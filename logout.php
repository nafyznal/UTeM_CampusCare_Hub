<?php
session_start();

// 1. Kosongkan semua data sesi
$_SESSION = array();

// 2. Musnahkan sesi sepenuhnya
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

// 3. Alihkan pengguna ke halaman utama / login
header("Location: index.php");
exit;
?>