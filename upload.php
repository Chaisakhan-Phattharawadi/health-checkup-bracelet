<?php
include 'server.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile-pic'])) {
    $user_id = 1; // ใส่ user_id ที่ต้องการ
    $target_dir = "uploads/"; // โฟลเดอร์สำหรับเก็บรูปภาพ

    // ตรวจสอบว่าโฟลเดอร์ uploads มีอยู่หรือไม่
    if (!is_dir($target_dir)) {
        // ถ้าไม่มีโฟลเดอร์ ให้สร้างโฟลเดอร์ใหม่
        if (!mkdir($target_dir, 0777, true)) {
            die("Failed to create uploads directory.");
        }
    }

    $target_file = $target_dir . basename($_FILES['profile-pic']['name']);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // ตรวจสอบว่าไฟล์เป็นรูปภาพหรือไม่
    $check = getimagesize($_FILES['profile-pic']['tmp_name']);
    if ($check === false) {
        die("File is not an image.");
    }

    // ตรวจสอบขนาดไฟล์ (ไม่เกิน 5MB)
    if ($_FILES['profile-pic']['size'] > 5000000) {
        die("File is too large.");
    }

    // อนุญาตเฉพาะไฟล์รูปภาพบางประเภท
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        die("Only JPG, JPEG, PNG & GIF files are allowed.");
    }

    // สร้างชื่อไฟล์ใหม่เพื่อป้องกันการทับซ้อน
    $new_file_name = uniqid() . "." . $imageFileType;
    $target_file = $target_dir . $new_file_name;

    // อัปโหลดไฟล์
    if (move_uploaded_file($_FILES['profile-pic']['tmp_name'], $target_file)) {
        // อัปเดต URL ของรูปภาพในฐานข้อมูล
        $profile_pic_url = $target_file;
        $sql = "UPDATE user SET profile_pic = '$profile_pic_url' WHERE id = $user_id";
        if ($condb->query($sql)) {
            header("Location: index.php"); // กลับไปที่หน้า index.php
            exit();
        } else {
            die("Error updating profile picture: " . $condb->error);
        }
    } else {
        die("Error uploading file.");
    }
}