<?php
session_start();
include('server.php'); // เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่ามีการดึงข้อมูลมา
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "กรุณากรอกชื่อผู้ใช้และรหัสผ่าน";
        header("Location: login.php");
        exit();
    }

    // ใช้ MySQLi ดึงข้อมูลผู้ใช้
    $stmt = $condb->prepare("SELECT id, username, password FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        if ($hashed_password = password_hash($password, PASSWORD_DEFAULT)) {
            $_SESSION['username'] = $user["username"];
            $_SESSION['success'] = "เข้าสู่ระบบสำเร็จ!";
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['error'] = "รหัสผ่านไม่ถูกต้อง";
        }
    } else {
        $_SESSION['error'] = "ไม่มีบัญชีนี้ในระบบ";
    }

    header("Location: login.php");
    exit();
}
?>
