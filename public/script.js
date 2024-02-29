// Difficulty
let unit = 20; // E:36, M:20, H:12
let singleplayer = true;
let obstaclesBool = false;
let startup = true;

document.addEventListener("DOMContentLoaded", function () {

    let game = newGame();

    options = document.getElementById("optButton");
    apply = document.getElementById("apply");
    popup = document.getElementById("options");

    options.addEventListener("click", function () {
        popup.classList.add("show");
        if (!startup) { game.pause(); }
    });

    apply.addEventListener("click", function () {
        popup.classList.remove("show");
        game = applyOptions();
    });

    window.addEventListener("click", function (event) {
        if (event.target == popup) {
            popup.classList.remove("show");
            if (!startup) { game.unpause(); }
        }
    });

    document.getElementById("medium").checked = true;
    document.getElementById("single").checked = true;
});

function applyOptions() {
    const easySelect = document.getElementById("easy");
    const hardSelect = document.getElementById("hard");
    const multiSelect = document.getElementById("multi");
    const obstaclesSelect = document.getElementById("obstacles");

    // Update difficulty
    if (easySelect.checked) {
        unit = 36;
    } else if (hardSelect.checked) {
        unit = 12;
    } else {
        unit = 20;
    }

    // Update mode
    if (multiSelect.checked) {
        singleplayer = false;
    } else {
        singleplayer = true;
    }

    // Update obstacles
    obstaclesBool = obstaclesSelect.checked;

    // Start game with new options
    startup = false;

    return newGame();
}
