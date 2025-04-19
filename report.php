<?php
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "report_db";  // ชื่อฐานข้อมูลของคุณ

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// การจัดการการส่งฟอร์มกรอกปัญหา
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['problem'])) {
    $problem = $_POST['problem'];
    $sql = "INSERT INTO problems (problem_text) VALUES ('$problem')";
    if ($conn->query($sql) === TRUE) {
        echo "<p class='success-message'>ปัญหาของคุณถูกบันทึกแล้ว!</p>";
    } else {
        echo "<p class='error-message'>เกิดข้อผิดพลาด: " . $conn->error . "</p>";
    }
}

// การจัดการการตอบคำถาม
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['answer'])) {
    $answer = $_POST['answer'];
    $problem_id = $_POST['problem_id'];
    $sql = "INSERT INTO answers (problem_id, answer_text) VALUES ('$problem_id', '$answer')";
    if ($conn->query($sql) === TRUE) {
        echo "<p class='success-message'>คำตอบของคุณถูกบันทึกแล้ว!</p>";
    } else {
        echo "<p class='error-message'>เกิดข้อผิดพลาด: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <link rel="stylesheet" href="style.css"> <!-- ลิงค์ไปที่ไฟล์ CSS ภายนอก -->
</head>
<body>
    <!-- เนื้อหาหลัก -->
    <h1>แจ้งปัญหาและคำตอบ</h1>

    <!-- ฟอร์มกรอกปัญหา -->
    <form action="report.php" method="POST">
        <label for="problem">กรุณากรอกปัญหาของคุณ:</label><br>
        <textarea name="problem" id="problem" rows="4" cols="50" required></textarea><br><br>
        <input type="submit" value="บันทึกปัญหา">
    </form>

    <hr>

    <!-- แสดงปัญหาที่ได้รับ -->
    <h2>ปัญหาที่ได้รับ</h2>
    <?php
    // ดึงข้อมูลปัญหาจากฐานข้อมูล
    $sql = "SELECT * FROM problems";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // แสดงปัญหาทีละตัว
        while($row = $result->fetch_assoc()) {
            echo '<div class="problem-container"><strong>ปัญหา: </strong>' . $row['problem_text'] . "</div>";

            // ฟอร์มการตอบคำถาม
            echo '<form action="report.php" method="POST">';
            echo '<textarea name="answer" rows="4" cols="50" required></textarea><br>';
            echo '<input type="hidden" name="problem_id" value="' . $row['id'] . '">';
            echo '<input type="submit" value="ตอบคำถาม">';
            echo '</form>';

            // แสดงคำตอบที่มี
            $problem_id = $row['id'];
            $sql_answers = "SELECT * FROM answers WHERE problem_id = '$problem_id'";
            $answers_result = $conn->query($sql_answers);

            if ($answers_result->num_rows > 0) {
                echo '<div class="answer-container">';
                while ($answer_row = $answers_result->fetch_assoc()) {
                    echo "<div><strong>คำตอบ: </strong>" . $answer_row['answer_text'] . "</div>";
                }
                echo '</div>';
            }
            echo "<hr>";
        }
    } else {
        echo "<p>ไม่มีปัญหาที่ได้รับการบันทึก!</p>";
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
    ?>

    <!-- เมนูด้านล่าง -->
    <nav class="bottom-nav">
        <a href="index.php" class="nav-item active">
            <i class="icon">🏠</i>
            <span>Home</span>
        </a>
        <a href="health.php" class="nav-item">
            <i class="icon">❤️</i>
            <span>Health</span>
        </a>
        <a href="report.php" class="nav-item">
            <i class="icon">📊</i>
            <span>Reports</span>
        </a>
        <a href="#" class="nav-item">
            <i class="icon">👤</i>
            <span>Profile</span>
        </a>
    </nav>
</body>
</html>