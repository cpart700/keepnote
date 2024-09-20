<?php
session_start();

// Check if user is logged in, otherwise redirect to login page
if (!isset($_SESSION['alogin'])) {
    header("location: login.php");
    exit();
}

include ('conn/conn.php');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archived Notes - Notes App</title>
    <link rel="stylesheet" href="css/styles22.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;700&display=swap" rel="stylesheet">

</head>

<body>

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
                <a class="nav-link active" href="archive_notes.php">Archive</a>
            </li>

            </li>
            <li class="nav-item">
                <a class="nav-link" href="account.php">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php" onclick="confirmLogout(event)">Log-Out</a>
            </li>
        </ul>
    </nav>

    <br>
    <div class="main-panel">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <span class="header-name">
                            Archived Notes </span>
                    </div>
                    <div class="card-body">
                        <div class="data-item">
                            <ul class="list-group">
                                <?php
                                // Fetch only archived notes from the database
                                // $stmt = $conn->prepare("SELECT * FROM  `tbl_notes` WHERE `archived` = 1");
                                
                                // $stmt->execute();
                                $stmt = $conn->prepare("SELECT * FROM `tbl_notes` WHERE `user_ID` = :user_ID AND `archived` = 1");
                                $stmt->bindParam(':user_ID', $user_ID, PDO::PARAM_INT);
                                $stmt->execute();
                                $archivedNotes = $stmt->fetchAll();

                                foreach ($archivedNotes as $row) {
                                    $noteID = $row['tbl_notes_id'];
                                    $noteTitle = $row['note_title'];
                                    $noteContent = $row['note'];
                                    $noteDateTime = $row['date_time'];

                                    // Convert the date_time value to a formatted date and time string
                                    $formattedDateTime = date('F j, Y H:i A', strtotime($noteDateTime));
                                    ?>
                                    <li class="list-group-item mt-2">
                                        <h3 style="text-transform:uppercase;"><b><?php echo $noteTitle ?></b></h3>
                                        <p><?php echo $noteContent ?></p>
                                        <small class="block text-muted text-info">Created: <i
                                                class="fa fa-clock-o text-info"></i>
                                            <?php echo $formattedDateTime ?></small>
                                        <?php
                                        // Define archived variable
                                        $archived = $row['archived'] ?? 0;
                                        ?>
                                        <a
                                            href="endpoint/archive.php?id=<?php echo $noteID ?>&action=<?php echo $archived == 1 ? 'unarchived' : 'archive' ?>">
                                            <?php if ($archived == 1): ?>
                                                <i class="fa fa-inbox"></i> <!-- Use solid archive icon if starred -->
                                            <?php else: ?>
                                                <i class="fa fa-file-archive-o"></i>
                                                <!-- Use regular archive icon if not starred -->
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>