// Difficulty
let unit = 20; // E:36, M:20, H:12
let singleplayer = true;
let obstaclesBool = false;
let startup = true;

document.addEventListener("DOMContentLoaded", function () {

    //let game = newGame();
    let game = newGame2();

    options = document.getElementById("optButton");
    apply = document.getElementById("apply");
    popup = document.getElementById("options");

    options.addEventListener("click", function () {
        popup.classList.add("show");
        if (!startup) { game.pause(); }
    });

    apply.addEventListener("click", function () {
        popup.classList.remove("show");
        //game = applyOptions();
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

    // Send options to PHP using AJAX
    return newGame2(unit, singleplayer, obstaclesBool);

    //return newGame();
}

function newGame2(u, s, o) {
    // Create a new XMLHttpRequest object
    const xhr = new XMLHttpRequest();

    // Define the PHP endpoint URL
    const url = '_init.php';

    // Prepare the data to be sent
    const data = JSON.stringify({
        unit: u,
        singleplayer: s,
        obstaclesBool: o,
    });

    // Configure the AJAX request
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    // Send the AJAX request
    xhr.send(data);

    // Optional: Handle response from PHP if needed
    xhr.onload = function () {
        if (xhr.status === 200) {
            // Optional: Handle response from PHP
            console.log(xhr.responseText);
        } else {
            // Handle error
            console.error('Error sending unit to PHP.');
        }
    };

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

    let scoreOne;
    let scoreTwo;
    let one, two, three;
    let paddleSpeed = 22 * Math.sqrt(22) / Math.sqrt(unit);

    // Paddles
    let paddleOne;
    let paddleTwo;

    // Ball
    let ball;

    // Obstacles
    let obstacles;

    // Add event listener for visibility change
    document.addEventListener("visibilitychange", function () {
        if (!startup) {
            if (document.hidden) {
                pause();
                ctx.clearRect(0, 0, canvas.width, canvas.height);
            }
        }
    });

    // Draw game elements
    function draw() {
        // Clear canvas
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Draw score
        ctx.fillStyle = 'lightgray';
        ctx.font = "900 " + canvas.height / 6 + "px Arial";
        ctx.fillText(scoreOne, canvas.width / 5, canvas.height / 2 + canvas.height / 16);
        ctx.fillText(scoreTwo, canvas.width - canvas.width / 3.5, canvas.height / 2 + canvas.height / 16);

        // Draw line
        ctx.fillStyle = 'whitesmoke';
        for (let i = unit; i < canvas.height - unit; i += unit * 2) {
            ctx.fillRect(canvas.width / 2 - unit / 2, i, unit, unit);
        }

        // Draw obstacles
        ctx.fillStyle = 'red';
        obstacles.forEach(obstacle => {
            //ctx.fillStyle = 'white';
            //ctx.fillRect(obstacle.x, obstacle.y, obstacle.width, obstacle.height);
            ctx.fillStyle = 'darkred';
            ctx.fillRect(obstacle.x + obstacle.width * 0.1, obstacle.y + obstacle.height * 0.1, obstacle.width * 0.8, obstacle.height * 0.8);
            ctx.fillStyle = 'red';
            ctx.fillRect(obstacle.x + obstacle.width * 0.35, obstacle.y + obstacle.height * 0.02, obstacle.width * 0.3, obstacle.height * 0.96);
            ctx.fillRect(obstacle.x + obstacle.width * 0.02, obstacle.y + obstacle.height * 0.35, obstacle.width * 0.96, obstacle.height * 0.3);
        });

        // 3, 2, 1
        ctx.fillStyle = 'lightgreen';
        ctx.font = "900 " + canvas.height / 6 + "px Trebuchet MS";
        if (three) {
            ctx.fillText("3", canvas.width / 2 + unit, canvas.height - 1.5 * unit);
        } else if (two) {
            ctx.fillText("2", canvas.width / 2 + unit, canvas.height - 1.5 * unit);
        } else if (one) {
            ctx.fillText("1", canvas.width / 2 + unit, canvas.height - 1.5 * unit);
        }

        // Draw paddles
        ctx.fillStyle = 'white';
        ctx.fillRect(paddleOne.x, paddleOne.y, paddleOne.width, paddleOne.height);
        ctx.fillRect(paddleTwo.x, paddleTwo.y, paddleTwo.width, paddleTwo.height);

        // Draw ball
        ctx.fillStyle = 'white';
        ctx.fillRect(ball.x, ball.y, ball.width, ball.height);

        // Draw walls
        ctx.fillStyle = 'whitesmoke';
        ctx.fillRect(0, 0, canvas.width, unit);
        ctx.fillRect(0, canvas.height - unit, canvas.width, canvas.height);
    }
    
    function update(deltaTime) {
            // Update the game state based on the time elapsed using AJAX
            const xhr = new XMLHttpRequest();
            const url = '_update.php'; // Assuming this is the endpoint for updating the game state
            const data = JSON.stringify({ deltaTime: deltaTime }); // Send deltaTime to PHP
            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.send(data);

            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Optional: Handle response from PHP if needed
                    console.log(xhr.responseText);
                } else {
                    // Handle error
                    console.error('Error updating game state.');
                }
            };
    }

    function getData() {
        console.log("get data")

        fetch('_update.php?action=getGameState')
        .then(response => response.json())
        .then(data => {
            console.log('Received game state:', data);
            scoreOne = data[0];
            scoreTwo = data[1];
            one = data[2];
            two = data[3];
            three = data[4];
            obstacles = data[5];

            paddleOne = {
                x: data[6].x,
                y: data[6].y,
                width: data[6].width,
                height: data[6].height,
                vy: data[6].vy
            };

            paddleTwo = {
                x: data[7].x,
                y: data[7].y,
                width: data[7].width,
                height: data[7].height,
                vy: data[7].vy
            };

            ball = {
                x: data[8].x,
                y: data[8].y,
                width: data[8].width,
                height: data[8].width,
                vx: data[8].vx,
                vy: data[8].vy,
                reset:  data[8].reset
            };

            console.log(ball);

        })
        .catch(error => console.error('Error:', error));
    }

    // Main game loop
    function gameLoop(timestamp) {
        if (!paused) {
            // Calculate the time elapsed since the last frame
            console.log("1")
            const deltaTime = timestamp - lastFrameTime;

            update(deltaTime);

            getData();

            console.log(obstacles)

            // Continue the game loop
            //checkWin();

            console.log("2")

            // 1/7 fps --------------- too slow --------------------
            setTimeout( function() {
                draw();

                requestAnimationFrame(gameLoop);
                lastFrameTime = timestamp;
            }, 7000) // 7 seconds

        }
    }

    window.addEventListener('keydown', function (e) {
        if (e.key === 'w' && !singleplayer) {
            paddleOne.vy = -paddleSpeed;
        } else if (e.key === 's' && !singleplayer) {
            paddleOne.vy = paddleSpeed;
        } else if (e.key === 'ArrowUp') {
            paddleTwo.vy = -paddleSpeed;
        } else if (e.key === 'ArrowDown') {
            paddleTwo.vy = paddleSpeed;
        }
    });

    window.addEventListener('keyup', function (e) {
        if ((e.key === 'w' || e.key === 's') && !singleplayer) {
            paddleOne.vy = 0;
        } else if (e.key === 'ArrowUp' || e.key === 'ArrowDown') {
            paddleTwo.vy = 0;
        }
    });


    if (!startup) {
        // Reset ball
        //reset();

        // Start the game loop
        requestAnimationFrame(gameLoop);
    }

    // Game object
    return {
        pause: pause,
        unpause: unpause
    };
}
