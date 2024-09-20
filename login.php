<?php
session_start();
include ('conn/conn.php');
if (isset($_POST['signin'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM register WHERE email = :email AND password = :password";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $password);
    $stmt->execute();

    $count = $stmt->rowCount();

    if ($count > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['alogin'] = $row['user_ID'];
            echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
        }

    } else {
        $message = "Invalid Details! Account not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="bg-dark">

<head>
    <meta charset="utf-8" />
    <title>Note Application</title>
    <meta name="description"
        content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="css/register.css" type="text/css" />
    <style>

    </style>

</head>

<body>
    <section id="content" class="wrapper">
        <div class="container">
            <div class="logo-wrapper">
                <div class="typing-demo">
                    <h1 class="navbar-brand" href="login.php">Notes App</h1>
                </div>
            </div>
            <section class="panel">
                <header class="panel-heading text-center">
                    <strong>Login Form</strong>
                </header>
                <form name="signin" method="post">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input name="email" type="email" placeholder="Enter Email" class="form-control input-lg"
                                required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Password</label>
                            <input name="password" type="password" id="inputPassword" placeholder="Password"
                                class="form-control input-lg" required>
                        </div>
                        <button name="signin" type="submit" class="btn-primary">Login</button>
                        <p class="text-muted text-center"><small>Do not have an account?</small></p>
                        <a href="signup.php" class="btn btn-default btn-block create-acc">Create an account</a>
                    </div>
                </form>
                <div id="message" class="alert"><?php if (isset($message)) {
                    echo $message;
                } ?></div>

            </section>
        </div>
    </section>

    <!-- footer -->
    <footer id="footer">
        <div class="text-center padder">
        </div>
    </footer>


    <?php
    include_once ('includes/scripts.php');
    ?>
    <script>
        $(document).ready(function () {
            <?php if (isset($message)) { ?>
                $("#message").fadeIn().delay(3000).fadeOut();
            <?php } ?>
        });
    </script>
</body>

</html>