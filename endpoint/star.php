<?php
// Include the database connection file
include('../conn/conn.php');

// Check if the connection is successful
if ($conn) {
    // Get the note ID and action from the form data
    $noteID = $_GET['id'];
    $action = $_GET['action'];

    // Update the "starred" column in the database for the specified note
    if ($action === 'star') {
        $sql = "UPDATE `tbl_notes` SET `starred` = 1 WHERE `tbl_notes_id` = :noteID";
    } elseif ($action === 'unstar') {
        $sql = "UPDATE `tbl_notes` SET `starred` = 0 WHERE `tbl_notes_id` = :noteID";
    } else {
        // Invalid action, handle error or redirect back to original page
        echo '<script type="text/javascript">
    window.location.href = "../index.php";
</script>';
    }

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':noteID', $noteID, PDO::PARAM_INT);
    $stmt->execute();

    // Redirect back to the original page after processing the action
     echo '<script type="text/javascript">
    window.location.href = "../index.php";
</script>';
} else {
    // Connection failed, handle the error or redirect back to original page
      echo '<script type="text/javascript">
    window.location.href = "../index.php";
</script>';
}
?>
