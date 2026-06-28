const createBtn = document.getElementById("createBtn");
const closeBtn = document.getElementById("closeBtn");
const popup = document.querySelector(".popup");

createBtn.addEventListener("click", event => {
    event.preventDefault();
    popup.style.visibility = "visible";
});

closeBtn.addEventListener("click", event => {
    event.preventDefault();
    popup.style.visibility = "hidden";
});