const updateBtn = document.getElementById("updateBtn");
const deleteBtn = document.getElementById("deleteBtn");
const closeBtn = document.querySelectorAll("#closeBtn");
const popup = document.querySelector(".popup");
const updateConfirm = document.getElementById("updateConfirm");
const deleteConfirm = document.getElementById("deleteConfirm");

updateBtn.addEventListener("click", event => {
    event.preventDefault();
    popup.style.visibility = "visible";
    updateConfirm.style.display = "block";
});

deleteBtn.addEventListener("click", event => {
    event.preventDefault();
    popup.style.visibility = "visible";
    deleteConfirm.style.display = "block";
});

closeBtn.forEach(close => {
    close.addEventListener("click", event => {
        event.preventDefault();
        popup.style.visibility = "hidden";
        const div = popup.closest("div");

        if (updateConfirm.style.display == "block" || deleteConfirm.style.display == "block") {
            updateConfirm.style.display = "none";
            deleteConfirm.style.display = "none";
        }
    });
});
