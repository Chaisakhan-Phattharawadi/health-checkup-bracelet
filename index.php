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
    <link rel="stylesheet" href="style_index.css">
    <!-- ติดตั้ง Chart.js ผ่าน CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- ส่วนหัวแอป -->
    <header class="app-header">
        <h1>HealthRing</h1>
        <div class="profile-section">
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <label for="profile-upload">
                    <img src="<?php echo $profile_pic; ?>" alt="Profile Picture" class="profile-pic">
                </label>
                <input type="file" name="profile-pic" id="profile-upload" accept="image/*" onchange="this.form.submit()" hidden>
            </form>
            <span class="username"> <?php echo htmlspecialchars($user['username']); ?> </span>
        </div>
    </header>

    <!-- ส่วนเนื้อหา -->
    <main class="app-content">
        <!-- ส่วนข้อมูลสุขภาพ -->
        <section class="health-stats">
            <h2>Your Health Status</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-value">72</span>
                    <span class="stat-label">BPM</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">120/80</span>
                    <span class="stat-label">BP</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">98.6°F</span>
                    <span class="stat-label">Temp</span>
                </div>
            </div>
        </section>

        <!-- ส่วนการแสดงข้อมูลกราฟ -->
        <section class="health-charts">
            <h2>Health Trends</h2>
            <div class="chart">
                <!-- Canvas สำหรับกราฟ -->
                <canvas id="bpChart"></canvas>
            </div>
        </section>
        
        <!-- ส่วนคำแนะนำสุขภาพ -->
        <section class="health-tips">
            <h2>Health Tips</h2>
            <div class="tips-list">
                <div class="tip-item">Drink plenty of water.</div>
                <div class="tip-item">Get regular exercise.</div>
                <div class="tip-item">Eat a balanced diet.</div>
                <div class="tip-item">Take regular breaks from screen time.</div>
            </div>
        </section>
    </main>

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

    <!-- โค้ด JavaScript สำหรับสร้างกราฟ -->
    <script>
        const ctx = document.getElementById('bpChart').getContext('2d');

        const bpData = {
            labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'], // วันที่
            datasets: [{
                label: 'Blood Pressure (BP)',
                data: [120, 118, 122, 125, 119, 121, 120], // ค่าความดันโลหิต
                borderColor: '#388E3C', // สีกรอบ
                backgroundColor: 'rgba(56, 142, 60, 0.2)', // สีพื้นหลัง
                borderWidth: 2,
                fill: true, // เติมสีพื้นในกราฟ
                tension: 0.4 // ความโค้งของกราฟ
            }]
        };

        const bpConfig = {
            type: 'line', // ประเภทกราฟเป็น line
            data: bpData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { beginAtZero: true },
                    y: { suggestedMin: 110, suggestedMax: 130 }
                }
            }
        };

        const bpChart = new Chart(ctx, bpConfig);
    </script>
</body>
</html>
