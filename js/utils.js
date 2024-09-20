// Function to display note with transition effect
// for INDEX page
function displayNote(title, content, date) {
    var modal = document.getElementById("noteModal");
    var noteTitle = document.getElementById("noteTitleIndex");
    var noteContent = document.getElementById("noteContent");

    noteTitle.innerHTML = title; // Set the title
    noteContent.innerHTML = content; // Set the content

    modal.style.display = "block";
    setTimeout(function () {
        modal.classList.add("show"); // Add class to show modal with transition
    }, 10);
}



/////ALL NOTES PAGE ////////////////////////
//Display Note with Transition Effect
function showNote(title, content, date) {
    var modal = document.getElementById("noteModal");
    var noteTitle = document.getElementById("noteTitle");
    var noteContent = document.getElementById("noteContent");

    noteTitle.innerHTML = title;
    noteContent.innerHTML = content;

    modal.style.display = "block";
    setTimeout(function () {
        modal.classList.add("show"); // Add class to show modal with transition
    }, 10);
}




// Function to close the modal with transition effect
function closeModal() {
    var modal = document.getElementById("noteModal");
    modal.classList.remove("show"); // Remove class to hide modal with transition
    setTimeout(function () {
        modal.style.display = "none";
    }, 300); // Wait for transition to complete before hiding modal
}

// Close the modal when clicking outside of it with transition effect
document.addEventListener('click', function (event) {
    var modal = document.getElementById("noteModal");
    if (event.target === modal) {
        closeModal();
    }
});

