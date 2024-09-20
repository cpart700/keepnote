<?php
session_start();

// Check if user is logged in, otherwise redirect to login page
if (!isset($_SESSION['alogin'])) {
    header("location: login.php");
    exit();
}

// Include the database connection file
include ('conn/conn.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounts Page</title>
    <link rel="stylesheet" href="css/styles22.css">
    <!-- Include Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>

    </style>
</head>

<body class="dark-mode">


    <nav class="navbar">
        <a class="navbar-brand" href="#">Notes App</a>

        <ul class="navbar-nav navigate">
            <!-- PHP code to display current user -->
            <?php
            // Check if user is logged in
            if (isset($_SESSION['alogin'])) {
                $user_ID = $_SESSION['alogin'];
                try {
                    // Query to retrieve the full name of the user
                    $sql = "SELECT fullName FROM register WHERE user_ID = :user_ID";

                    // Prepare and execute the statement
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":user_ID", $user_ID, PDO::PARAM_INT);
                    $stmt->execute();

                    // Fetch the result
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Check if any rows were returned
                    if ($row) {
                        // Fetch the full name
                        $fullName = $row['fullName'];

                        // Display the welcome message with user's name
                        echo '<li class="nav-item"><span class="navbar-text">Welcome, ' . $fullName . '</span></li>';
                    }
                } catch (PDOException $e) {
                    // Handle database errors
                    echo "<li class='nav-item'><span class='navbar-text'>Welcome</span></li>"; // Default welcome message if error
                }
            } else {
                // Handle case where user is not logged in
                echo "<li class='nav-item'><span class='navbar-text'>Welcome</span></li>"; // Default welcome message
            }
            ?>

            <li class="nav-item">
                <a class="nav-link " href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="starred_notes.php">Favorites</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="archive_notes.php">Archive</a>
            </li>

            </li>
            <li class="nav-item">
                <a class="nav-link active" href="account.php">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php" onclick="confirmLogout(event)">Log-Out</a>
            </li>
        </ul>
    </nav>

    <header>
        <h1 class="welcome-text">Welcome to Your Profile</h1>
    </header>


    <main>
        <div class="account-container">
            <section id="account-details">
                <h2>Account Details</h2>
                <div class="account-info">

                    <?php
                    try {
                        // Check if the user is logged in
                        if (isset($_SESSION['alogin'])) {
                            $user_ID = $_SESSION['alogin'];

                            // Query to select account details of the logged-in user
                            $sql = "SELECT * FROM register WHERE user_ID = :user_ID";

                            // Prepare and execute the SQL statement
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':user_ID', $user_ID);
                            $stmt->execute();

                            // Fetch the account details of the logged-in user
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);

                            if ($row) {
                                echo "<p><strong>Username:</strong> <span id='username'>" . $row["fullName"] . "</span></p>";
                                echo "<p><strong>Email:</strong> <span id='email'>" . $row["email"] . "</span></p>";
                                // You can add more account details here as needed
                            } else {
                                echo "<p>No account details found.</p>";
                            }
                        } else {
                            echo "<p>User not logged in.</p>";
                        }
                    } catch (PDOException $e) {
                        // Handle any errors that may occur
                        echo "Error: " . $e->getMessage();
                    }
                    ?>


                </div>
            </section>
        </div>
        <!-- You can add more sections for other functionalities as needed -->
    </main>
    <footer>
        <p>&copy; 2024 Your Company. All rights reserved.</p>
    </footer>

    <!-- Include SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

    <!-- Javascript folder -->
    <script src="js/script.js"></script>
    <script src="js/sweetalert.js"></script>
</body>

</html>