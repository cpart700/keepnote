<?php
session_start();
include ('conn/conn.php');

if (isset($_POST['signup'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = md5($_POST['password']);

  // Check if email already exists
  $stmt = $conn->prepare("SELECT * FROM register WHERE email = :email");
  $stmt->bindParam(':email', $email);
  $stmt->execute();
  $count = $stmt->rowCount();

  if ($count > 0) {
    $message = "Data Already Exist";
  } else {
    // Insert new user
    $stmt = $conn->prepare("INSERT INTO register(fullName, email, password) VALUES(:name, :email, :password)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $message = "Records Successfully Added";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Sign Up | Web Application</title>
  <meta name="description"
    content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="css/register.css">
</head>

<body>
  <section id="content" class="wrapper">
    <div class="container">
     <div class="logo-wrapper">
                <div class="typing-demo">
                    <h1 class="navbar-brand" href="signup.php">Notes App</h1>
                </div>
            </div>
      <section class="panel">
        <header class="panel-heading text-center">
          <strong>Sign up</strong>
        </header>
        <form name="signup" method="POST">
          <div class="panel-body">
            <div class="form-group">
              <label class="control-label">Name</label>
              <input name="name" type="text" placeholder="eg. Your name or company" class="form-control input-lg"
                required>
            </div>
            <div class="form-group">
              <label class="control-label">Email</label>
              <input name="email" type="email" placeholder="test@example.com" class="form-control input-lg" required>
            </div>
            <div class="form-group">
              <label class="control-label">Password</label>
              <input name="password" type="password" id="inputPassword" placeholder="Type a password"
                class="form-control input-lg" required>
            </div>
            <div class="line"></div>
            <button name="signup" type="submit" class="btn btn-primary btn-block">Sign up</button>
            <div class="line"></div>
            <p class="text-muted text-center"><small>Already have an account? <a href="login.php">Login</a></small></p>
          </div>
        </form>
      </section>
    </div>
  </section>

  <!-- footer -->
  <footer id="footer">
  </footer>

  <!-- Alert message -->
  <div id="message"></div>

  <?php
  include_once ('includes/scripts.php');
  ?>
  <script>
    $(document).ready(function () {
      <?php if (isset($message)) { ?>
        $("#message").text("<?php echo $message; ?>").fadeIn().delay(3000).fadeOut();
        <?php if ($message == "Records Successfully Added") { ?>
          $("#message").attr("id", "successMessage");
        <?php } else { ?>
          $("#errormessage").attr("id", "errorMessage");
        <?php } ?>
      <?php } ?>
    });
  </script>

</body>

</html>