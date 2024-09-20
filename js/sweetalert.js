//for  EDIT NOTE IN index.php
function validateEditForm() {
    // Get the value of the note title input
    var noteTitle = document.getElementById("noteTitle").value.trim();

    // Check if the input contains only whitespace
    if (noteTitle === '') {
        // Show SweetAlert error
        Swal.fire({
            title: "Error",
            text: "Note cannot be empty or contain only whitespace.",
            icon: "error",
            confirmButtonText: "OK",
            buttonsStyling: true,
            reverseButtons: true
        });
        return false; // Prevent form submission
    } else {
        // Show SweetAlert success
        Swal.fire({
            title: "Success",
            text: "Title is valid",
            icon: "success",
            confirmButtonText: "OK",
            buttonsStyling: true,
            reverseButtons: true
        });
        return true; // Allow form submission
    }
}

// logout alert
function confirmLogout(event) {
    event.preventDefault(); // Prevent the default action of the link

    Swal.fire({
        title: 'Are you sure?',
        text: "You will be logged out!",
        // icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, log me out!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed with the log-out action by navigating to the logout page
            window.location.href = event.target.href;
        }
    });
}

//for  ADD NOTE IN index.php
function validateForm() {
    var title = document.getElementById("noteTitle").value.trim();
    var content = document.getElementById("note").value.trim();

    // Check if either title or content is empty after trimming whitespace
    if (title === "" || content === "") {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Note cannot be empty or contain only whitespace.',
        });
        return false; // Prevent form submission
    } else {
        // Form is valid, you can submit it
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Note added successfully!',
            timer: 2500 // Close the alert after 1.5 seconds
        });
        return true;
    }
}



//fiunction to delete note in INDEX.PHP
function delete_note(id) {
    const swalWithoutBootstrap = Swal.mixin({
        customClass: {
            confirmButton: "swal-confirm-button", // Custom class for the "delete" button
            cancelButton: "swal-cancel-button" // Custom class for the "cancel" button
        },
        buttonsStyling: false
    });

    swalWithoutBootstrap.fire({
        text: "You won't be able to revert this!",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = "endpoint/delete_note.php?delete=" + id;
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithoutBootstrap.fire({
                title: "Cancelled",
                text: "Your note is safe :)"
            });
        }
    });
}

//fiunction to delete note in ALL.PHP
function delete_note_all(id) {
    const swalWithoutBootstrap = Swal.mixin({
        customClass: {
            confirmButton: "swal-confirm-button", // Custom class for the "delete" button
            cancelButton: "swal-cancel-button" // Custom class for the "cancel" button
        },
        buttonsStyling: false
    });

    swalWithoutBootstrap.fire({
        text: "You won't be able to revert this!",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = "endpoint-second/delete_all_note.php?delete=" + id;
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithoutBootstrap.fire({
                title: "Cancelled",
                text: "Your note is safe :)"
            });
        }
    });
}
