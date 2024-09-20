<?php
session_start();

// Check if user is logged in, otherwise redirect to login page
if (!isset($_SESSION['alogin'])) {
    header("location: login.php");
    exit();
}

include ('conn/conn.php');
?>

<?php
include ('includes/head.php');
?>


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


    <form class="search-form">
        <input class="searchfield" type="text" id="filter" placeholder="Search.." onkeyup="searchfilter()">
    </form>


    <!-- Container that Holds  two card -->
    <div class="main-panel">
        <div class="row">
            <div class="col-1 border-right">
                <!-- first card -->
                <div class="card-main">
                    <div class="card-header add">
                        <span class="header-name ">
                            Add Note</span>
                    </div>
                    <div class="card-body">
                        <form method="post" action="endpoint/add_note.php" onsubmit="return validateForm();">


                            <div class="form-group">
                                <label for="noteTitle">Title <span class="char-count-title char-count">0/50
                                        characters</span></label>
                                <input type="text" class="form-control" id="noteTitle" name="note_title"
                                    placeholder="Add note title..." required>
                            </div>
                            <div class="form-group">
                                <label for="note">Note <span class="char-count"><span id="wordCount">0</span>/<span
                                            id="maxChars">300</span> characters</span></label>
                                <textarea class="form-control unadjustable" id="note" name="note_content" rows="6"
                                    placeholder="Add note information..." required></textarea>
                            </div>

                            <span class="buttons-grp">
                                <button type="button" class="btn clear-btn">Clear</button>
                                <button type="submit" class="btn submit-btn">Submit</button>
                            </span>

                            <!-- Error message placeholder -->
                            <div id="error-message"
                                style="display: none; color: red; margin-top: 9px; text-align:center;"></div>

                            <div id="success-message" class="success-notif"></div>


                        </form>
                    </div>
                </div>
            </div>

            <div class="col-2">
                <div id="card" class="card">
                    <div class="card-header">
                        <span class="header-name ">
                            Recently Added</span>
                        <a href="all_notes.php" class="float-right view-all">View All</a>
                    </div>

                    <ul class="list-group">
                        <?php
                        include ('conn/conn.php');

                        $stmt = $conn->prepare("SELECT * FROM `tbl_notes` WHERE `user_ID` = :user_ID AND `archived` = 0 ORDER BY `date_time` DESC LIMIT 4");
                        // $stmt = $conn->prepare("SELECT * FROM `tbl_notes` WHERE `user_ID` = :user_ID");
                        
                        $stmt->bindParam(':user_ID', $user_ID, PDO::PARAM_INT);
                        $stmt->execute();

                        $result = $stmt->fetchAll();

                        foreach ($result as $row) {
                            $noteID = $row['tbl_notes_id'];
                            $noteTitle = $row['note_title'];
                            $noteContent = $row['note'];
                            $noteDateTime = $row['date_time'];

                            // Convert the date_time value to a formatted date and time string
                            $formattedDateTime = date('F j, Y H:i A', strtotime($noteDateTime));
                            ?>
                            <li class="list-group-item mt-2 note">
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
                                        id="dropdownButtons_<?php echo $noteID ?>" style="display: none;">
                                        <!-- Dropdown buttons for actions -->
                                        <div class="btn-group float-right">
                                            <!-- View Note button -->
                                            <button type="button" class="btn eye-btn" title="View Note"
                                                onclick="displayNote('<?php echo htmlspecialchars($noteTitle) ?>', '<?php echo htmlspecialchars($noteContent) ?>', '<?php echo htmlspecialchars($formattedDateTime) ?>')">
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
                                            <button onclick="delete_note('<?php echo $noteID ?>')" type="button" class="btn"
                                                id="btn-delete" title="Remove">
                                                <i class="fa fa-trash"> Delete </i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="innernotes">
                                    <h3 style="text-transform:uppercase;" class="note-title">
                                        <b>
                                            <?php echo strlen($noteTitle) > 11 ? substr($noteTitle, 0, 11) . '...' : $noteTitle; ?>
                                        </b>
                                    </h3>
                                    <p class="note-content">
                                        <?php echo $noteContent ?>
                                    </p>
                                    <small id="note-datetime" class="block text-muted text-info note-datetime">Created:
                                        <i class="fa fa-clock-o text-info"></i>
                                        <?php echo $formattedDateTime ?></small>
                                </div>

                                <!-- Star and Archive buttons -->
                                <div class="star-archive"> <!-- New class for the container -->
                                    <?php $starred = $row['starred'] ?? 0; ?>
                                    <a href="endpoint/star.php?id=<?php echo $noteID ?>&action=<?php echo $starred == 1 ? 'unstar' : 'star' ?>"
                                        class="no-underline">
                                        <button type="button" class="btn btn-icons "
                                            title="<?php echo $starred == 1 ? 'Unstar' : 'Star' ?>">
                                            <i class="<?php echo $starred == 1 ? 'fas fa-star' : 'far fa-star' ?>"></i>
                                        </button>
                                    </a>
                                    <?php $archived = $row['archived'] ?? 1; ?>
                                    <a href="endpoint/archive.php?id=<?php echo $noteID ?>&action=<?php echo $archived == 1 ? 'unarchived' : 'archive' ?>"
                                        class="no-underline">
                                        <button type="button" class="btn btn-icons btn-archive"
                                            title="<?php echo $archived == 1 ? 'Unarchived' : 'Archive' ?>">
                                            <i class="<?php echo $archived == 1 ? 'fa fa-inbox' : 'fas fa-archive' ?>"></i>
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
                            <h2 id="noteTitleIndex"></h2>
                            <p id="noteContent"></p>
                            <!-- <p id="noteDate"></p> -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php
    include_once ('includes/scripts.php');
    ?>
    <!-- <footer>
        <p>&copy; 2024 Your Company. All rights reserved.</p>
    </footer> -->
</body>
<script>
    // document.addEventListener("DOMContentLoaded", function () {
    //     var dropdownButtons = document.querySelectorAll('.dropdown');

    //     dropdownButtons.forEach(function (dropdown) {
    //         var dropdownContent = dropdown.querySelector('.dropdown-menu');

    //         dropdown.addEventListener('click', function () {
    //             if (dropdownContent.style.display === "none" || dropdownContent.style.display === "") {
    //                 dropdownContent.style.display = "block";
    //             } else {
    //                 dropdownContent.style.display = "none";
    //             }
    //         });
    //     });
    // });

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


</html>