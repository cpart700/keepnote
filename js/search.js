// for allnotes page SEARCH FILTER
function search() {
    let filter = document.getElementById('find').value.toUpperCase().trim();
    let items = document.querySelectorAll('.note');
    let found = false; // Flag to check if any notes are found

    items.forEach(item => {
        let title = item.querySelector('h3').innerText.toUpperCase();
        let content = item.querySelector('p').innerText.toUpperCase();
        let dateTime = item.querySelector('.text-muted').innerText.toUpperCase();

        if (title.includes(filter) || content.includes(filter) || dateTime.includes(filter)) {
            item.style.display = "";
            found = true; // Set the flag to true if at least one note is found
        } else {
            item.style.display = "none";
        }
    });

    // If no notes are found, display a SweetAlert message
    if (!found) {
        Swal.fire({
            icon: 'info',
            title: 'No Notes Found',
            text: 'Try searching with different keywords.',
            confirmButtonText: 'OK'
        });
    }
}

// for INDEX page SEARCH FILTER
function searchfilter() {
    let filter = document.getElementById('filter').value.toUpperCase();
    let items = document.querySelectorAll('.note');
    let notesFound = false; // Variable to track if any notes are found

    items.forEach(item => {
        let title = item.querySelector('.note-title').innerText.toUpperCase();
        let content = item.querySelector('.note-content').innerText.toUpperCase();
        let dateTime = item.querySelector('.note-datetime').innerText.toUpperCase();

        if (title.includes(filter) || content.includes(filter) || dateTime.includes(filter)) {
            item.style.display = "";
            notesFound = true; // Set to true if any note matches the filter
        } else {
            item.style.display = "none";
        }
    });

    // Show alert if no notes are found
    if (!notesFound) {
        Swal.fire({
            icon: 'info',
            title: 'No Notes Found',
            text: 'Sorry, no notes match your search criteria.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    }
}