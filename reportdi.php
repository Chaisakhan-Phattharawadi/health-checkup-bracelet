<?php
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "report_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// จัดการการส่งฟอร์ม
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['problem'])) {
        $problem = $conn->real_escape_string($_POST['problem']);
        $sql = "INSERT INTO problems (problem_text) VALUES ('$problem')";
        $conn->query($sql);
    } elseif (isset($_POST['answer'])) {
        $answer = $conn->real_escape_string($_POST['answer']);
        $problem_id = (int)$_POST['problem_id'];
        $sql = "INSERT INTO answers (problem_id, answer_text) VALUES ('$problem_id', '$answer')";
        $conn->query($sql);
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แจ้งปัญหาและคำตอบ</title>
    <link rel="stylesheet" href="style_reportdi.css">
</head>
<body>
    <div class="container">
        <h1>แจ้งปัญหาและคำตอบ</h1>
        <form action="" method="POST" class="form">
            <textarea name="problem" placeholder="กรุณากรอกปัญหาของคุณ..." required></textarea>
            <button type="submit">บันทึกปัญหา</button>
        </form>

        <h2>ปัญหาที่ได้รับ</h2>
        <div class="problems">
            <?php
            $sql = "SELECT * FROM problems ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="problem">';
                    echo '<p>' . htmlspecialchars($row['problem_text']) . '</p>';
                    echo '<form action="" method="POST">';
                    echo '<textarea name="answer" placeholder="ตอบคำถาม..." required></textarea>';
                    echo '<input type="hidden" name="problem_id" value="' . $row['id'] . '">';
                    echo '<button type="submit">ส่งคำตอบ</button>';
                    echo '</form>';

                    // ดึงคำตอบ
                    $problem_id = $row['id'];
                    $sql_answers = "SELECT * FROM answers WHERE problem_id = '$problem_id'";
                    $answers_result = $conn->query($sql_answers);
                    if ($answers_result->num_rows > 0) {
                        echo '<div class="answers">';
                        while ($answer_row = $answers_result->fetch_assoc()) {
                            echo '<p><strong>คำตอบ:</strong> ' . htmlspecialchars($answer_row['answer_text']) . '</p>';
                        }
                        echo '</div>';
                    }
                    echo '</div>';
                }
            } else {
                echo "<p>ไม่มีปัญหาที่ได้รับการบันทึก!</p>";
            }
            $conn->close();
            ?>
        </div>
    </div>

    <!-- แถบเมนู -->
    <nav class="bottom-nav">
        <a href="index.php" class="nav-item active">🏠 Home</a>
        <a href="health.php" class="nav-item">❤️ Health</a>
        <a href="reportdi.php" class="nav-item">📊 Reports</a>
        <a href="profile.php" class="nav-item">👤 Profile</a>
    </nav>
</body>
</html>