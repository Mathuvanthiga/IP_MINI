function validateNoticeForm() {
    const title = document.getElementById("title").value.trim();
    if (title.length < 5) {
        alert("Notice title must contain at least 5 characters.");
        return false;
    }
    return true;
}