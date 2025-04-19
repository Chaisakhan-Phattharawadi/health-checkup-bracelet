<?php include('server.php'); ?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login - Health Check</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style_login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <h2>Login</h2>
            </div>

            <form action="login_db.php" method="post">
                <?php if(isset($_SESSION['error'])) : ?>
                    <div class="error">
                        <p><?php echo $_SESSION['error'];
                        unset($_SESSION['error']); ?></p>
                    </div>
                <?php endif ?>
                <div class="input-group">
                    <label for="username">username</label>
                    <input type="text" name="username" placeholder="username" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="password" required>
                </div>
                <div class="input-group">
                    <button type="submit" name="login_user" class="btn">Login</button>
                </div>
                <p>Not yet a member? <a href="register.php">Sign Up</a></p>
            </form>
        </div>
    </div>
</body>
</html>
