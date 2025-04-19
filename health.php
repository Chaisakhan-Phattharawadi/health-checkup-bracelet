
<?php
    include 'server.php';
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "checkup_health_login";

    // เชื่อมต่อฐานข้อมูล
    $condb = mysqli_connect($servername, $username, $password, $dbname);
    if ($condb->connect_error) {
        die("Connection failed: " . $condb->connect_error);
    }

    // ดึงข้อมูลผู้ใช้
    $user_id = 1; // ใส่ user_id ที่ต้องการ
    $sql = "SELECT username, profile_pic FROM user WHERE id = $user_id"; // ดึง username และ profile_pic
    $result = $condb->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        die("User not found");
    }

    // กำหนดรูปโปรไฟล์เริ่มต้นของเฟซบุ๊ก
    $default_profile_pic = "https://www.facebook.com/images/default-profile.png";
    $profile_pic = $user['profile_pic'] ? $user['profile_pic'] : $default_profile_pic;
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Health Check App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style_health.css">
    <!-- ติดตั้ง Chart.js ผ่าน CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- หน้าหลัก Health -->
    <section class="health-section">
        <h2>แนะนำการตรวจสุขภาพ</h2>
        <p class="intro-text">การตรวจสุขภาพประจำปีจะช่วยให้คุณดูแลตัวเองได้ดียิ่งขึ้น ตรวจพบปัญหาสุขภาพตั้งแต่ระยะเริ่มต้นเพื่อการรักษาที่มีประสิทธิภาพ...</p>

        <h3>บริการที่มีให้เลือก</h3>
        <ul class="service-list">
            <li>
                <strong>ตรวจสุขภาพประจำปี</strong>
                <p>การตรวจสุขภาพที่ครอบคลุมช่วยให้รู้สภาพร่างกายและป้องกันโรคในระยะยาว</p>
            </li>
            <li>
                <strong>ตรวจเลือด</strong>
                <p>ตรวจเลือดเพื่อดูการทำงานของอวัยวะต่างๆ และหาความเสี่ยงจากโรค</p>
            </li>
            <li>
                <strong>ตรวจการมองเห็น</strong>
                <p>ตรวจสุขภาพตาเพื่อความชัดเจนในการมองเห็นและป้องกันปัญหาการมองเห็นในอนาคต</p>
            </li>
        </ul>

        <h3>ราคาและโปรแกรมต่างๆ</h3>
        <ul class="price-list">
            <li>
                <strong>โปรแกรมตรวจสุขภาพเบื้องต้น</strong>: 1,000 บาท
            </li>
            <li>
                <strong>โปรแกรมตรวจเลือด</strong>: 800 บาท
            </li>
            <li>
                <strong>โปรแกรมตรวจการมองเห็น</strong>: 500 บาท
            </li>
        </ul>

        <h3>คำแนะนำจากผู้ใช้</h3>
        <ul class="testimonial-list">
            <li>
                <strong>พนักงานบริการดีมาก</strong>: "บริการดีมากเลยครับ ตรวจละเอียด และเจ้าหน้าที่บริการดี"
            </li>
            <li>
                <strong>ราคาคุ้มค่า</strong>: "โปรแกรมตรวจสุขภาพราคาคุ้มค่ามาก ทำให้มั่นใจในสุขภาพ"
            </li>
        </ul>

        <h3>บทความและคำแนะนำเพิ่มเติม</h3>
        <p>เรามีบทความหลากหลายเกี่ยวกับการดูแลสุขภาพ เช่น วิธีการลดน้ำหนัก, การออกกำลังกาย, การรับประทานอาหารที่มีประโยชน์...</p>
    </section>


    <!-- แถบเมนูด้านล่าง -->
    <nav class="bottom-nav">
        <a href="index.php" class="nav-item active">
            <i class="icon">🏠</i>
            <span>Home</span>
        </a>
        <a href="health.php" class="nav-item">
            <i class="icon">❤️</i>
            <span>Health</span>
        </a>
        <a href="reportdi.php" class="nav-item">
            <i class="icon">📊</i>
            <span>Reports</span>
        </a>
        <a href="profile.php" class="nav-item">
            <i class="icon">👤</i>
            <span>Profile</span>
        </a>
    </nav>

</body>
</html>
