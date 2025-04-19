<?php include('server.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Register - Health Check</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style_register.css"> <!-- เชื่อมโยงไฟล์ CSS -->
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Register</h2>
        </div>

        <form action="register_db.php" method="post">
            <?php include('errors.php'); ?>
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-group">
                <label for="password_1">Password</label>
                <input type="password" id="password_1" name="password_1" placeholder="Enter your password" required>
            </div>
            <div class="input-group">
                <label for="password_2">Confirm Password</label>
                <input type="password" id="password_2" name="password_2" placeholder="Confirm your password" required>
            </div>
            <div class="input-group">
                <button type="submit" name="reg_user" class="btn">Register</button>
            </div>
            <p>Already a member? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
</html>