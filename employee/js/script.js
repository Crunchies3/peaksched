const hamburger = document.querySelector("#toggle-btn");

hamburger.addEventListener("click", function () {
    document.querySelector("#sidebar").classList.toggle("shrink");
    document.querySelector("#main").classList.toggle("shrink");
});

