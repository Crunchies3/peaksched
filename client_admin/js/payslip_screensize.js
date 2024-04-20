window.addEventListener('resize', getResolution);

function getResolution() {
    if (screen.width > 900) {
        document.getElementById("adjustableRow").classList.add("col-4");
        document.getElementById("adjustableRow").classList.remove("col-12");
    } else {
        document.getElementById("adjustableRow").classList.add("col-12");
        document.getElementById("adjustableRow").classList.remove("col-4");
    }
}