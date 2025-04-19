<?php
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "checkup_health_login";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึงข้อมูลผู้ใช้ (ตัวอย่างใช้ id = 1)
$user_id = 1;
$sql = "SELECT username, email, password, profile_pic FROM user WHERE id = $user_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โปรไฟล์ผู้ใช้</title>
    <link rel="stylesheet" href="style_profile.css">
</head>
<body>
    <div class="profile-container">
        <h1>โปรไฟล์ผู้ใช้</h1>
        <?php if ($user): ?>
            <div class="profile-details">
                <p><strong>ชื่อผู้ใช้:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                <p><strong>อีเมล:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>รหัสผ่าน:</strong> <?php echo htmlspecialchars($user['password']); ?></p>
                <p style="text-align: center;">
                    <img src="<?php echo htmlspecialchars($user['profile_pic']); ?>" alt="Profile Picture" class="profile-pic">
                    <br><strong>รูปโปรไฟล์</strong>
                </p>
            </div>
        <?php else: ?>
            <p>ไม่พบข้อมูลผู้ใช้</p>
        <?php endif; ?>
    </div>

    <!-- แถบเมนู -->
    <nav class="bottom-nav">
        <a href="index.php" class="nav-item">🏠 Home</a>
        <a href="health.php" class="nav-item">❤️ Health</a>
        <a href="reportdi.php" class="nav-item">📊 Reports</a>
        <a href="profile.php" class="nav-item active">👤 Profile</a>
    </nav>
</body>
</html>
