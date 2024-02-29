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


function newGame() {

    let lastFrameTime = 0;

    // Initialize canvas
    const canvas = document.getElementById("pong");
    const ctx = canvas.getContext("2d");

    let paused = false;

    function pause() {
        paused = true;
    }

    function unpause() {
        paused = false;
        // Update lastFrameTime to avoid a huge jump in time
        lastFrameTime = performance.now();
        // Request a new animation frame to resume the game loop
        requestAnimationFrame(gameLoop);
    }

    // Define
    let paddleWidth = unit;
    //let paddleHeight = 100*Math.sqrt(100)/Math.sqrt(unit*5);
    let paddleHeight = 100;
    let paddleSpeed = 22 * Math.sqrt(22) / Math.sqrt(unit);
    let ballSpeed = 18 * Math.sqrt(18) / Math.sqrt(unit);
    //let botHeight = canvas.height - 10*unit;
    let botHeight = 200 + 2400 / unit;
    let scoreOne = 0;
    let scoreTwo = 0;
    let one, two, three = false;

    // Paddles
    let paddleOne = {
        x: unit * 2,
        y: canvas.height / 2 - paddleHeight / 2,
        width: paddleWidth,
        height: paddleHeight,
        vy: 0
    }

    if (singleplayer) {
        paddleOne.y = canvas.height / 2 - botHeight / 2;
        paddleOne.height = botHeight;
        setTimeout(function () {
            paddleOne.vy = paddleSpeed;
        }, 100)
    }

    let paddleTwo = {
        x: canvas.width - unit * 3,
        y: canvas.height / 2 - paddleHeight / 2,
        width: paddleWidth,
        height: paddleHeight,
        vy: 0
    }

    // Ball
    let ball = {
        x: 0,
        y: 0,
        width: unit,
        height: unit,
        vx: ballSpeed,
        vy: 0,
        reset: true
    }

    // Obstacles
    let obstacles = [];

    if (obstaclesBool) {
        // Create a couple of obstacles
        for (let i = 0; i < 160 / unit; i++) {
            let obstacle = {
                x: Math.floor(Math.random() * (canvas.width / 2) / unit + (canvas.width / 4) / unit) * unit,
                //x: Math.random() * canvas.width / 2 + canvas.width / 4,
                y: Math.floor(Math.random() * (canvas.height - (6 * unit)) / unit + 3) * unit,
                //y: Math.random() * (canvas.height - 6 * unit) + 3 * unit,
                width: unit,
                height: unit
            };
            obstacles.push(obstacle);
        }
    }

    // Add event listener for visibility change
    document.addEventListener("visibilitychange", function () {
        if (!startup) {
            if (document.hidden) {
                pause();
                ctx.clearRect(0, 0, canvas.width, canvas.height);
            }
        }
    });

    // Detect ball-paddle collisions
    function collision(ball, paddle) {
        return ball.x < paddle.x + paddle.width
            && ball.x + ball.width > paddle.x
            && ball.y < paddle.y + paddle.height
            && ball.y + ball.height > paddle.y;
    }
}