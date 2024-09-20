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
    <title>Starred Notes - Notes App</title>
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
            <?php
            // retrieve the full name of the user
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
                    //go to accounts page if error
                    echo "<li class='nav-item'><a class='nav-link' href='account.php'>View Account</a></li>";
                }
            } else {
                // Handle case where user is not logged in
                echo "<li class='nav-item'><a class='nav-link' href='account.php'>View Account</a></li>";
            }
            ?>
            <li class="nav-item">
                <a class="nav-link " href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="starred_notes.php">Favorites</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="archive_notes.php">Archive</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="account.php">Profile</a>
            </li>
            <li class="nav-item">
                <!-- <a class="nav-link" href="logout.php">Log-Out</a> -->
                <a class="nav-link" href="logout.php" onclick="confirmLogout(event)">Log-Out</a>

            </li>
        </ul>
    </nav>


    <!-- Search form -->
    <!-- <form class="search-form">
        <input class="searchfield" type="search" id="find" placeholder="Search" onkeyup="searchfav()">
    </form>
    </nav> -->
    <br>


    <div class="main-panel">
        <div class="row">

            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <span class="header-name">
                            Starred Notes </span>
                    </div>

                    <div class="card-body">
                        <div class="data-item">
                            <ul class="list-group">

                                <?php
                                // Fetch only starred notes from the database
                                // $stmt = $conn->prepare("SELECT * FROM `tbl_notes` WHERE `starred` = 1");
                                // $stmt->execute();
                                $stmt = $conn->prepare("SELECT * FROM `tbl_notes` WHERE `user_ID` = :user_ID AND `starred` = 1");
                                $stmt->bindParam(':user_ID', $user_ID, PDO::PARAM_INT);
                                $stmt->execute();

                                $starredNotes = $stmt->fetchAll();

                                foreach ($starredNotes as $row) {
                                    $noteID = $row['tbl_notes_id'];
                                    $noteTitle = $row['note_title'];
                                    $noteContent = $row['note'];
                                    $noteDateTime = $row['date_time'];

                                    // Convert the date_time value to a formatted date and time string
                                    $formattedDateTime = date('F j, Y H:i A', strtotime($noteDateTime));
                                    ?>
                                    <li class="list-group-item mt-2">
                                        <h3 style="text-transform:uppercase;"><b>
                                                <?php echo $noteTitle ?>
                                            </b></h3>
                                        <p>
                                            <?php echo $noteContent ?>
                                        </p>
                                        <small class="block text-muted text-info">Created: <i
                                                class="fa fa-clock-o text-info"></i>
                                            <?php echo $formattedDateTime ?>
                                        </small>
                                        <?php
                                        // Define $starred variable
                                        $starred = $row['starred'] ?? 0;
                                        ?>
                                        <a
                                            href="endpoint/star.php?id=<?php echo $noteID ?>&action=<?php echo $starred == 1 ? 'unstar' : 'star' ?>">
                                            <?php if ($starred == 1): ?>
                                                <i class="fas fa-star"></i> <!-- Use solid star icon if starred -->
                                            <?php else: ?>
                                                <i class="far fa-star"></i> <!-- Use regular star icon if not starred -->
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


    <?php
    include_once ('includes/scripts.php');
    ?>
</body>

</html>