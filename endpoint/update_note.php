<?php
include ('../conn/conn.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the note ID from the form
    $noteID = $_POST['note_id'];

    // Retrieve the note from the database based on the ID
    $stmt = $conn->prepare("SELECT * FROM `tbl_notes` WHERE tbl_notes_id = :note_id");
    $stmt->bindParam(':note_id', $noteID);
    $stmt->execute();
    $note = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    // If not submitted, get note ID from URL parameter
    if (isset($_GET['edit'])) {
        $noteID = $_GET['edit'];

        // Retrieve the note from the database based on the ID
        $stmt = $conn->prepare("SELECT * FROM `tbl_notes` WHERE tbl_notes_id = :note_id");
        $stmt->bindParam(':note_id', $noteID);
        $stmt->execute();
        $note = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit - Note App</title>
    <link rel="stylesheet" href="../css/styles.css">
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
                <a class="nav-link active" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="starred_notes.php">Favorites</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="archive_notes.php">Archive</a>
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



    <!--  container/holder of card -->
    <div class="main-panel edit-panel">
        <div class="row">
            <!-- Edit Note -->
            <div class="col-card ">
                <!-- edit card holder/container -->
                <div class="card-main edit-card">
                    <div class="card-header">
                        Edit Note
                    </div>
                    <div class="card-body">
                        <form method="post" action="update_note_process.php" onsubmit="return validateEditForm();">

                            <input type="hidden" name="note_id" value="<?php echo $note['tbl_notes_id']; ?>">
                            <div class="form-group">

                                <label for="noteTitle">Title <span class="char-count-title char-count">0/50
                                        characters</span></label>
                                <input type="text" class="form-control" id="noteTitle" name="note_title"
                                    value="<?php echo $note['note_title']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="note">Note <span class="char-count"><span id="wordCount">0</span>/<span
                                            id="maxChars">300</span> characters</span> </label>
                                <textarea class="form-control unadjustable" id="note" name="note_content" rows="6"
                                    required><?php echo htmlspecialchars($note['note']); ?></textarea>
                            </div>


                            <div class="buttons2">
                                <button type="submit" class="btn btn-secondary btn-update">Update</button>
                                <!-- <button href="index.php" type="submit"
                                    class="btn btn-secondary btn-cancelled">Cancel</button> -->
                                <a href="../index.php" class="btn btn-secondary btn-cancelled">Cancel</a>
                            </div>

                            <!-- Error message placeholder -->
                            <div id="error-message"
                                style="display: none; color: red; margin-top: 9px; text-align:center;"></div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>


    <?php
    include_once ('../includes/scripts.php');
    ?>

</body>

</html>