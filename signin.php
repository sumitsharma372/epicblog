<?php
require 'config/database.php';
$username_email = $_SESSION['signin-data']['username_email'] ?? null;
unset($_SESSION['signin-data']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/79129b46ef.js" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="./css/style.css" />
    <title>EpicBlog</title>
</head>

<body>
    <section class="form_section">
        <div class="container form_section-container">
            <h2>Sign In</h2>
            <?php
            if (isset($_SESSION['signup-success'])) : ?>
                <div class="alert_message success">
                    <p>
                        <?php
                        echo $_SESSION['signup-success'];
                        unset($_SESSION['signup-success']);
                        ?>
                    </p>
                </div>
            <?php
            elseif (isset($_SESSION['signin'])) : ?>
                <div class="alert_message error">
                    <p>
                        <?php
                        echo $_SESSION['signin'];
                        unset($_SESSION['signin']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <form class="actions" action="<?= ROOT_URL ?>signin-logic.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="username_email" placeholder="Username or Email" value="<?= $username_email ?>">
                <input type="password" name="password" placeholder="Password">
                <button type="submit" name="submit" class="btn">Sign Up</button>
                <small>Don't have an account? <a href="signup.php">Sign Up</a></small>
            </form>
        </div>
    </section>

</body>

</html>