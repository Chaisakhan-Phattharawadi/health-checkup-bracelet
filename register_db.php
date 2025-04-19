<?php
session_start();
$errors = array();

// เชื่อมต่อฐานข้อมูล
$condb = mysqli_connect('localhost', 'root', '', 'checkup_health_login'); // แก้ไขตามการตั้งค่าของคุณ
if (!$condb) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['reg_user'])) {
    $username = mysqli_real_escape_string($condb, $_POST['username']);
    $email = mysqli_real_escape_string($condb, $_POST['email']);
    $password_1 = mysqli_real_escape_string($condb, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($condb, $_POST['password_2']);

    // ตรวจสอบค่าว่าง
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    // ตรวจสอบว่ามี username หรือ email ซ้ำหรือไม่
    $user_check_query = "SELECT * FROM user WHERE username = '$username' OR email = '$email' LIMIT 1";
    $query = mysqli_query($condb, $user_check_query);
    $result = mysqli_fetch_assoc($query);

    if ($result) {
        if ($result['username'] === $username) {
            array_push($errors, "Username already exists");
        }
        if ($result['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    // ถ้าไม่มีข้อผิดพลาด ให้ทำการลงทะเบียน
    if (count($errors) == 0) {
        $password = md5($password_1); // เข้ารหัส password

        $sql = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')";
        if (mysqli_query($condb, $sql)) {
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            if (!headers_sent()) {
                header('location: index.php');
                exit(); // เพิ่ม exit() เพื่อหยุดการทำงานทันทีหลังจาก redirect
            } else {
                echo "Redirect failed. Please <a href='index.php'>click here</a> to continue.";
            }
        } else {
            array_push($errors, "Database error: " . mysqli_error($condb));
        }
    }
}

// แสดงข้อผิดพลาด (ถ้ามี)
if (count($errors) > 0) {
    foreach ($errors as $error) {
        echo "<p>$error</p>";
    }
}

mysqli_close($condb); // ปิดการเชื่อมต่อฐานข้อมูล
?>