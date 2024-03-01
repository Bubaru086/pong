# Pong - Design System

![logo](/docs/design_system/img/PongLOGO.png)

# Colours

## Background Gradient

| Hex Code | Colour | Display | Description |
| --- | --- | --- | --- |
| #708090 | Slate Grey | ![708090](design_system/708090.svg) | Gradient edges |
| #F5F5F5 | White Smoke | ![F5F5F5](design_system/F5F5F5.svg) | Gradient center |

## Options Button

| Hex Code | Colour | Display | Description |
| --- | --- | --- | --- |
| #000000 | Black | ![000000](design_system/000000.svg) | Button background |
| #0A0A0A | | ![0A0A0A](design_system/0A0A0A.svg) | Button border |
| #F5F5F5 | White Smoke | ![F5F5F5](design_system/F5F5F5.svg) | Button text |

## Options Popup

| Hex Code | Colour | Display | Description |
| --- | --- | --- | --- |
| #000000BF | | ![000000](design_system/000000.svg) | Window cover (75% opacity) |
| #000000 | Black | ![000000](design_system/000000.svg) | Popup text |
| #F5F5F5 | White Smoke | ![F5F5F5](design_system/F5F5F5.svg) | Popup content background |
| #EEEEEE | | ![EEEEEE](design_system/EEEEEE.svg) | Inputs background |
| #90EE90 | Light Green | ![90EE90](design_system/90EE90.svg) | Easy option checked |
| #EEEE90 | Light Yellow | ![EEEE90](design_system/EEEE90.svg) | Medium option checked |
| #EE9090 | Light Red | ![EE9090](design_system/EE9090.svg) | Hard option checked |
| #ADD8E6 | Light Blue | ![ADD8E6](design_system/ADD8E6.svg) | Game mode checked |
| #D8BFD8 | Thistle | ![D8BFD8](design_system/D8BFD8.svg) | Obstacles box checked |

## Game Canvas

| Hex Code | Colour | Display | Description |
| --- | --- | --- | --- |
| #000000 | Black | ![000000](design_system/000000.svg) | Game background |
| #0A0A0A | | ![0A0A0A](design_system/0A0A0A.svg) | Game border & background design |
| #D3D3D3 | Light Grey | ![D3D3D3](design_system/D3D3D3.svg) | Game points/score (text) |
| #F5F5F5 | White Smoke | ![F5F5F5](design_system/F5F5F5.svg) | Game walls & center line |
| #FFFFFF | White | ![FFFFFF](design_system/FFFFFF.svg) | Game ball & paddle |
| #FF0000 | Red | ![FF0000](design_system/FF0000.svg) | Game obstacles foreground |
| #8B0000 | Dark Red | ![8B0000](design_system/8B0000.svg) | Game obstacles background |
| #90EE90 | Light Green | ![90EE90](design_system/90EE90.svg) | Game countdown (text) |

# Fonts

| Font Name | Weight | Size | Colour | Description |
| --- | --- | --- | --- | --- |
| <span style="font-family: Arial; font-weight: 900;">Arial</span> | 900 | | ![D3D3D3](design_system/D3D3D3.svg) | Game points/score |
| <span style="font-family: Trebuchet MS; font-weight: 900;">Trebuchet MS</span> | 900 | | ![90EE90](design_system/90EE90.svg) | Game countdown |
| <span style="font-family: Trebuchet MS; font-weight: 900;">Trebuchet MS</span> | 900 | 24px | ![F5F5F5](design_system/F5F5F5.svg) | Options button |
| <span style="font-family: Times New Roman; font-weight: 600;">Times New Roman</span> | 600 | 14px | ![000000](design_system/000000.svg) | Options inputs |
| <span style="font-family: Arial; font-weight: 900;">Arial</span> | 900 | 16px | ![000000](design_system/000000.svg) | Apply button |
| <span style="font-family: Times New Roman; font-weight: 600;">Times New Roman</span> | 600 | small | ![000000](design_system/000000.svg) | Extra details |

# User Interface

## Options Popup

![options](/docs/design_system/img/pongOptions.png)

#### Radio inputs change colours for different difficulty selections.

```css
.radio-inputs .radio input:checked+#E {
    background-color: #90ee90;
}

.radio-inputs .radio input:checked+#M {
    background-color: #eeee90;
}

.radio-inputs .radio input:checked+#H {
    background-color: #ee9090;
}
```

#### Custom checkbox for obstacles selection.

```css
.checkmark {
    margin: 0 5px;
    height: 5px;
    width: 5px;
    border: 1px solid black;
    background-color: whitesmoke;
    transition: all 0.25s ease;
}

.radio-inputs .radio input:checked+.name .checkmark {
    background-color: black;
}
```

## Regular Pong 

### Medium, Multiplayer, No Obstacles.
![regular](/docs/design_system/img/pongRegular.png)

#### Function that detects ball-paddle collisions.

```js
function collision(ball, paddle) {
    return ball.x < paddle.x + paddle.width
        && ball.x + ball.width > paddle.x
        && ball.y < paddle.y + paddle.height
        && ball.y + ball.height > paddle.y;
}
```

## Custom Pong 

### Easy, Multiplayer, Obstacles.
![easy](/docs/design_system/img/pongEasy.png)

#### Draw rebound obstacles.

```js
ctx.fillStyle = 'red';
obstacles.forEach(obstacle => {
    ctx.fillStyle = 'darkred';
    ctx.fillRect(obstacle.x + obstacle.width * 0.1, obstacle.y + obstacle.height * 0.1, obstacle.width * 0.8, obstacle.height * 0.8);
    ctx.fillStyle = 'red';
    ctx.fillRect(obstacle.x + obstacle.width * 0.35, obstacle.y + obstacle.height * 0.02, obstacle.width * 0.3, obstacle.height * 0.96);
    ctx.fillRect(obstacle.x + obstacle.width * 0.02, obstacle.y + obstacle.height * 0.35, obstacle.width * 0.96, obstacle.height * 0.3);
});
```

### Hard, Singleplayer, Obstacles.
![hard](/docs/design_system/img/pongHard.png)

#### Display player scores on the canvas.

```js
ctx.fillStyle = 'lightgray';
ctx.font = "900 " + canvas.height / 6 + "px Arial";
ctx.fillText(scoreOne, canvas.width / 5, canvas.height / 2 + canvas.height / 16);
ctx.fillText(scoreTwo, canvas.width - canvas.width / 3.5, canvas.height / 2 + canvas.height / 16);
```

# Player Inputs

| Player | Key Code | Key | Action | 
| --- | --- | --- | -- |
| One | 38 | ArrowUp | Moves right paddle up |
| One | 40 | ArrowDown | Moves right paddle down |
| Two | 87 | W key | Moves left paddle up |
| Two | 83 | S key | Moves left paddle up |

#### Only detect Player Two inputs in multiplayer mode.

```js
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
```

# Functionalities

## Game Difficulties

#### Dynamic game values and canvas objects.

- User decides the game difficulty unit.
- Units: Easy 36, Medium 20, Hard 12.
- As unit gets smaller canvas' pixel/ball get smaller.
- Unit/difficulty decides ball speed.
- Adjust paddle sizes to accomodate for difficulty.

```js
let unit = 20; // E:36, M:20, H:12
let paddleWidth = unit;
let paddleHeight = 100;
let paddleSpeed = 22 * Math.sqrt(22) / Math.sqrt(unit);
let ballSpeed = 18 * Math.sqrt(18) / Math.sqrt(unit);
let botHeight = 200 + 2400 / unit;

let ball = {
    width: unit,
    height: unit,
}
```

## Game modes

#### Singleplayer
- One player.
- User controls right paddle.
- Opponent has the left paddle.
- Bot opponent moves the paddle up and down.
- Inputs: arrow keys.

#### Multiplayer

- Two players.
- Users control left and right paddle.
- Left paddle inputs: W, S.
- Right paddle inputs: arrow keys.

## UX functions

### Full customization of game levels.

```html
<form>
    <div class="radio-inputs">
        <label class="radio">
            <input type="radio" id="easy" name="diff">
            <span class="name" id="E">Easy</span>
        </label>
        <label class="radio">
            <input type="radio" id="medium" name="diff">
            <span class="name" id="M">Medium</span>
        </label>
        <label class="radio">
            <input type="radio" id="hard" name="diff">
            <span class="name" id="H">Hard</span>
        </label>
    </div>
    <div class="radio-inputs">
        <label class="radio">
            <input type="radio" id="single" name="mode">
            <span class="name" id="mode">Singleplayer</span>
        </label>
        <label class="radio">
            <input type="radio" id="multi" name="mode">
            <span class="name" id="mode">Multiplayer</span>
        </label>
    </div>
    <div class="radio-inputs">
        <label class="radio">
            <input type="checkbox" id="obstacles">
            <span class="name" id="O">Obstacles<span class="checkmark"></span></span>
        </label>
    </div>
    <button type="button" id="apply" class="apply-button">Apply</button>
</form>
```

```js
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
```

### Functions to pause the game when options menu is opened. 

- Player can resume game if no options are changed.

```js
options.addEventListener("click", function () {
    popup.classList.add("show");
    if (!startup) { game.pause(); }
});

let paused = false;

function pause() {
    paused = true;
}

function unpause() {
    paused = false;
    lastFrameTime = performance.now();
    requestAnimationFrame(gameLoop);
}

// Main game loop
function gameLoop(timestamp) {
    if (!paused) {
        const deltaTime = timestamp - lastFrameTime;
        update(deltaTime);
        checkWin();
        draw();
        requestAnimationFrame(gameLoop);
        lastFrameTime = timestamp;
    }
}
```

### Click outside of popup parameter to close options popup.

```js
window.addEventListener("click", function (event) {
    if (event.target == popup) {
        popup.classList.remove("show");
        if (!startup) { game.unpause(); }
    }
});
```

### Detects window changes and resets the game to avoid bugs. 

```js
document.addEventListener("visibilitychange", function () {
    if (!startup) {
        if (document.hidden) {
            pause();
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }
    }
});
```

### Added countdown before game resets for better game experience.

```js
ctx.fillStyle = 'lightgreen';
ctx.font = "900 " + canvas.height / 6 + "px Trebuchet MS";
if (three) {
    ctx.fillText("3", canvas.width / 2 + unit, canvas.height - 1.5 * unit);
} else if (two) {
    ctx.fillText("2", canvas.width / 2 + unit, canvas.height - 1.5 * unit);
} else if (one) {
    ctx.fillText("1", canvas.width / 2 + unit, canvas.height - 1.5 * unit);
}
```

### Implementation of points system. 

- Scores increment by one when the ball reaches the opponent's side.

```js
if ((ball.x < 0 || ball.x > canvas.width) && !ball.reset) {
    if (ball.vx >= 0) {
        scoreOne++;
    } else {
        scoreTwo++;
    }
    ball.reset = true;
    // Reset ball position
    reset();
}
```

### Game win when either player reaches 10 points.

```js
function checkWin() {
    if (scoreOne >= 10 || scoreTwo >= 10) {
        winScreen.classList.add("show");
        pause();
        setTimeout(function () {
            winScreen.classList.remove("show");
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }, 3000);
    }
}
```

# Source Code
### [HTML](../public/pong.html)
### [CSS](../public/styles.css)
### [JS](../public/script.js)