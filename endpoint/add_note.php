<?php
session_start(); // Start or resume the session

include ('../conn/conn.php');

// Check if user is logged in
if (!isset($_SESSION['alogin'])) {
    // Redirect to login page if user is not logged in
    header("location: login.php");
    exit();
}

// Get the current user's ID from the session
$user_ID = $_SESSION['alogin'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $noteTitle = $_POST["note_title"];
    $noteContent = $_POST["note_content"];
    $dateTime = date("Y-m-d H:i:s");

    try {
        // Prepare the SQL statement to insert the note into the database
        $stmt = $conn->prepare("INSERT INTO tbl_notes (note_title, note, date_time, user_ID) VALUES (:note_title, :note, :date_time, :user_ID)");
        $stmt->bindParam(':note_title', $noteTitle);
        $stmt->bindParam(':note', $noteContent);
        $stmt->bindParam(':date_time', $dateTime);
        $stmt->bindParam(':user_ID', $user_ID); // Bind the user's ID

        // Execute the SQL statement
        $stmt->execute();

        // Redirect back to the main page after adding the note
echo '<script type="text/javascript">
    window.location.href = "../index.php";
</script>';

// Exit to prevent further execution
    } catch (PDOException $e) {
        // Handle any errors that occur during the database operation
        echo "Error: " . $e->getMessage();
        header("location: http://localhost/keepnote/");
        exit(); // Exit to prevent further execution
    }
}
?>
