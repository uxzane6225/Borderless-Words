const updateBtn = document.querySelectorAll("#updateBtn");
const closeBtn = document.getElementById("closeBtn");
const updatePopup = document.getElementById("updatePopup");
const deletePopup = document.getElementById("deletePopup");

updateBtn.forEach(btn => {
    btn.addEventListener("click", event => {
        event.preventDefault();
        updatePopup.style.visibility = "visible";
    });
});

deletePopup.forEach(btn => {
    btn.addEventListener("click", event => {
        event.preventDefault();
        deletePopup.style.visibility = "visible";
    });
});

closeBtn.addEventListener("click", event => {
    event.preventDefault();
    updatePopup.style.visibility = "hidden";
});