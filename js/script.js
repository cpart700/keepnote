

// CLEAR FIELDS
document.addEventListener("DOMContentLoaded", function () {
    const noteTitleInput = document.getElementById("noteTitle");
    const noteTextarea = document.getElementById("note");
    const clearButton = document.querySelector(".clear-btn");

    function clearInputs() {
        noteTitleInput.value = "";
        noteTextarea.value = "";
    }

    clearButton.addEventListener("click", clearInputs);
});


// charactercount for note content text area
const textarea = document.getElementById("note");
const wordCount = document.getElementById("wordCount");
const maxChars = document.getElementById("maxChars");

textarea.addEventListener("input", function () {
    let text = this.value;
    let words = text.trim().split(/\s+/).filter(Boolean).length; // Count words
    let characters = text.length; // Count characters
    wordCount.textContent = characters;

    // Check if exceeded the maximum character limit
    if (characters > 300) {
        this.value = text.slice(0, 300); // Limit to 80 characters
        characters = 300; // Update character count
        wordCount.textContent = characters;
    }
});

// character count for the note title input field
const titleInput = document.getElementById("noteTitle");
const charCountTitle = document.querySelector(".char-count-title");

titleInput.addEventListener("input", function () {
    let titleLength = this.value.length;
    const maxLength = 50; // Maximum allowed characters for the title
    charCountTitle.textContent = titleLength + '/' + maxLength + ' characters';

    // Check if exceeded the maximum character limit
    if (titleLength > maxLength) {
        this.value = this.value.slice(0, maxLength); // Limit to 50 characters
        titleLength = maxLength; // Update character count
        charCountTitle.textContent = titleLength + '/' + maxLength + ' characters';
    }
});



// jQuery for login and register page
// for signup page

