<?php
session_start();
include ('conn/conn.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes App</title>
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
            // Start or resume a session
            

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
                <a class="nav-link active" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="starred_notes.php">Favorites</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="archive_notes.php">Archive</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="account.php">Profile</a>
            </li>
            <li class="nav-item">
                <!-- <a class="nav-link" href="logout.php" onclick="return confirmLogout();">Log-Out</a> -->
                <a class="nav-link" href="logout.php" onclick="confirmLogout(event)">Log-Out</a>

            </li>
        </ul>
    </nav>



    <form class="search-form">
        <input class="searchfield" type="text" id="find" placeholder="Search.." onkeyup="search()">
    </form>


    <!-- holds the main card -->
    <div class="main-panel panel-main">
        <div class="col col-block">
            <div class="card card-container">
                <div class="card-header header-card">
                    <label for="lbl" class="label">
                        All Notes</label>
                    <a href="index.php" class="float-right back"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
                <div class="body-card">
                    <div class="data-item">
                        <!-- Create a Note card using grids -->
                        <ul class="list-group group-list">
                            <!-- Your PHP loop for displaying notes -->
                            <?php
                            include ('conn/conn.php');
                            // $stmt = $conn->prepare("SELECT * FROM `tbl_notes`");
                            // $stmt->execute();
                            $stmt = $conn->prepare("SELECT * FROM `tbl_notes` WHERE `user_ID` = :user_ID AND `archived` = 0");

                            $stmt->bindParam(':user_ID', $user_ID, PDO::PARAM_INT);
                            $stmt->execute();

                            $result = $stmt->fetchAll();
                            foreach ($result as $row) {
                                // Your PHP code for displaying each note
                                $noteID = $row['tbl_notes_id'];
                                $noteTitle = htmlentities($row['note_title']);
                                $noteContent = htmlentities($row['note']);
                                $noteDateTime = $row['date_time'];

                                // Convert the date_time value to a formatted date and time string
                                $formattedDateTime = date('F j, Y H:i A', strtotime($noteDateTime));
                                ?>
                                <li class="list-group-item item-list">
                                    <!-- Dropdown Container -->
                                    <div id="drop" class="dropdown">
                                        <!-- Dropdown toggle button -->
                                        <button class="btn-drop dropdown-toggle" type="button"
                                            id="dropdownMenuButton_<?php echo $noteID ?>" aria-haspopup="true"
                                            aria-expanded="false" title="More">
                                            <i class="fas fa-circle"></i>
                                            <i class="fas fa-circle"></i>
                                            <i class="fas fa-circle"></i>
                                        </button>
                                        <!-- Dropdown menu -->
                                        <div class="dropdown-menu float-right"
                                            aria-labelledby="dropdownMenuButton_<?php echo $noteID ?>"
                                            id="dropdownMenu_<?php echo $noteID ?>">
                                            <!-- Dropdown buttons for actions -->
                                            <div class="btn-group float-right" role="group">
                                                <!-- View Note button -->
                                                <button type="button" class="btn" title="View Note"
                                                    onclick="showNote('<?php echo htmlspecialchars($noteTitle) ?>', '<?php echo htmlspecialchars($noteContent) ?>', '<?php echo htmlspecialchars($formattedDateTime) ?>')">
                                                    <i class="fas fa-eye"> View Note</i>
                                                </button>
                                                <!-- Edit Note button -->
                                                <a href="endpoint/update_note.php?edit=<?php echo $noteID ?>">
                                                    <button type="button" class="btn" title="Edit">
                                                        <i class="fa fa-pencil"><span class="edit-text"> Edit</span>
                                                        </i>
                                                    </button>
                                                </a>
                                                <!-- Delete Note button -->
                                                <button class="btn" onclick="delete_note_all('<?php echo $noteID ?>')"
                                                    id="btn-delete" title="Remove">
                                                    <i class="fa fa-trash"> Delete
                                                    </i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="innernotes">
                                        <!-- Note Title section -->
                                        <h3 style="text-transform:uppercase;" class="note-title">
                                            <b>
                                                <?php echo strlen($noteTitle) > 11 ? substr($noteTitle, 0, 11) . '...' : $noteTitle; ?>
                                            </b>
                                        </h3>
                                        <p class="note-content">
                                            <?php echo $noteContent ?>
                                        </p>
                                        <small id="note-datetime" class="text-muted text-info">Created: <i
                                                class="fa fa-clock-o text-info"></i>
                                            <?php echo $formattedDateTime ?>
                                        </small>
                                    </div>



                                    <!-- Star and Archive buttons -->
                                    <div class="star-archive"> <!-- New class for the container -->
                                        <span class="star-icon">
                                            <?php
                                            $starred = $row['starred'] ?? 0; ?>
                                            <button type="button" class="btn btn-icons"
                                                title="<?php echo $starred == 1 ? 'Unstar' : 'Star' ?>">
                                                <a
                                                    href="endpoint/star.php?id=<?php echo $noteID ?>&action=<?php echo $starred == 1 ? 'unstar' : 'star' ?>">
                                                    <?php if ($starred == 1): ?>
                                                        <i class="fas fa-star"></i> <!-- Use solid star icon if starred -->
                                                    <?php else: ?>
                                                        <i class="far fa-star"></i>
                                                        <!-- Use regular star icon if not starred -->
                                                    <?php endif; ?>
                                                </a>
                                            </button>
                                        </span>

                                        <?php $archived = $row['archived'] ?? 1; ?>
                                        <a href="endpoint/archive.php?id=<?php echo $noteID ?>&action=<?php echo $archived == 1 ? 'unarchived' : 'archive' ?>"
                                            class="no-underline">
                                            <button type="button" class="btn btn-icons"
                                                title="<?php echo $archived == 1 ? 'Unarchived' : 'Archive' ?>">
                                                <i
                                                    class="<?php echo $archived == 1 ? 'fa fa-inbox' : 'fas fa-archive' ?>"></i>
                                            </button>
                                        </a>
                                    </div>
                                </li>

                                <?php
                            }
                            ?>
                        </ul>

                        <!-- Modal for displaying note content -->
                        <div id="noteModal" class="modal" onclick="closeModal()">
                            <div class="modal-content" onclick="event.stopPropagation()">
                                <span class="close" onclick="closeModal()">&times;</span>
                                <h2 id="noteTitle"></h2>
                                <p id="noteContent"></p>
                                <!-- <p id="noteDate"></p> -->
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include_once ('includes/scripts.php');
    ?>
    <script>
        // // Function to toggle the visibility of the dropdown menu
        // function toggleDropdownMenu(menuId) {
        //     var dropdownMenu = document.getElementById(menuId);
        //     dropdownMenu.classList.toggle("show");
        // }

        // // Close the dropdown menu if the user clicks outside of it
        // window.onclick = function (event) {
        //     if (!event.target.matches('.dropdown-toggle')) {
        //         var dropdowns = document.getElementsByClassName("dropdown-menu");
        //         var i;
        //         for (i = 0; i < dropdowns.length; i++) {
        //             var openDropdown = dropdowns[i];
        //             if (openDropdown.classList.contains('show')) {
        //                 openDropdown.classList.remove('show');
        //             }
        //         }
        //     }
        // }
        document.addEventListener("DOMContentLoaded", function () {
            // Function to close dropdowns
            function closeDropdowns() {
                var dropdowns = document.querySelectorAll('.dropdown-menu');
                dropdowns.forEach(function (dropdown) {
                    dropdown.style.display = 'none';
                });
            }

            // Event listener to close dropdowns when clicking outside
            document.addEventListener('click', function (event) {
                var target = event.target;
                if (!target.closest('.dropdown')) {
                    closeDropdowns();
                }
            });

            // Event listener for dropdown button clicks
            var dropdowns = document.querySelectorAll('.dropdown');
            dropdowns.forEach(function (dropdown) {
                dropdown.addEventListener('click', function () {
                    var dropdownContent = this.querySelector('.dropdown-menu');
                    if (dropdownContent.style.display === "none") {
                        closeDropdowns(); // Close other dropdowns
                        dropdownContent.style.display = "block";
                    } else {
                        dropdownContent.style.display = "none";
                    }
                });
            });
        });

    </script>
</body>

</html>
