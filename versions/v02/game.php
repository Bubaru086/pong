<?php

class Game {

    public $unit;
    public $singleplayer;
    public $obstaclesBool;

    public $height;
    public $width;

    public $paddleWidth;
    public $paddleHeight;
    public $paddleSpeed;
    public $ballSpeed;
    public $botHeight;
    public $scoreOne;
    public $scoreTwo;
    public $one, $two, $three;

    public $paddleOne;
    public $paddleTwo;
    public $ball;
    public $obstacles;

    public function __construct() {
        $this->unit = $_SESSION['unit']; 
        $this->singleplayer = $_SESSION['singleplayer'];
        $this->obstaclesBool = $_SESSION['obstaclesBool'];

        $this->height = 540;
        $this->width = 720;

        $this->paddleWidth = $this->unit;
        $this->paddleHeight = 100;
        $this->paddleSpeed = 22 * sqrt(22) / sqrt($this->unit);
        $this->ballSpeed = 18 * sqrt(18) / sqrt($this->unit);
        $this->botHeight = 200 + 2400 / $this->unit;
        $this->scoreOne = 0;
        $this->scoreTwo = 0;
        $this->one = false;
        $this->two = false;
        $this->three = false;

        $this->paddleOne = [
            "x" => $this->unit * 2,
            "y" => $this->height / 2 - $this->paddleHeight / 2,
            "width" => $this->paddleWidth,
            "height" => $this->paddleHeight,
            "vy" => 0
        ];
        
        if ($this->singleplayer) {
            $this->paddleOne["y"] = $this->height / 2 - $this->botHeight / 2;
            $this->paddleOne["height"] = $this->botHeight;
            usleep(100000);
            $this->paddleOne["vy"] = $this->paddleSpeed;
        }
        
        $this->paddleTwo = [
            "x" => $this->width - $this->unit * 3,
            "y" => $this->height / 2 - $this->paddleHeight / 2,
            "width" => $this->paddleWidth,
            "height" => $this->paddleHeight,
            "vy" => 0
        ];
        
        $this->ball = [
            "x" => 0,
            "y" => 0,
            "width" => $this->unit,
            "height" => $this->unit,
            "vx" => $this->ballSpeed,
            "vy" => 0,
            "reset" => true
        ];

        $this->obstacles = [];

        if ($this->obstaclesBool) {
            for ($i = 0; $i < 160 / $this->unit; $i++) {
                $obstacle = [
                    "x" => floor((mt_rand() / mt_getrandmax()) * ($this->width / 2) / $this->unit + ($this->width / 4) / $this->unit) * $this->unit,
                    "y" => floor((mt_rand() / mt_getrandmax()) * ($this->height - (6 * $this->unit)) / $this->unit + 3) * $this->unit,
                    "width" => $this->unit,
                    "height" => $this->unit
                ];
                $this->obstacles[] = $obstacle;
            }
        }
    }
        
    public function collision($ball, $paddle) {
        return $ball["x"] < $paddle["x"] + $paddle["width"]
            && $ball["x"] + $ball["width"] > $paddle["x"]
            && $ball["y"] < $paddle["y"] + $paddle["height"]
            && $ball["y"] + $ball["height"] > $paddle["y"];
    }

    public function update($deltaTime) {
        $deltaTimeSeconds = $deltaTime / 1000;
    
        // Move paddles
        $this->paddleOne['y'] += $this->paddleOne['vy'] * $this->paddleSpeed * $deltaTimeSeconds;
        $this->paddleTwo['y'] += $this->paddleTwo['vy'] * $this->paddleSpeed * $deltaTimeSeconds;
    
        // Paddle collisions with walls
        if ($this->singleplayer) {
            if ($this->paddleOne['y'] < 20 || $this->paddleOne['y'] > $this->height - $this->paddleOne['height'] - $this->unit / 2) {
                $this->paddleOne['y'] -= 20 * $this->paddleOne['vy'] / $this->paddleSpeed;
                $this->paddleOne['vy'] *= -1;
            }
        } else {
            if ($this->paddleOne['y'] < $this->unit) {
                $this->paddleOne['y'] = $this->unit;
            } else if ($this->paddleOne['y'] > $this->height - $this->paddleHeight - $this->unit) {
                $this->paddleOne['y'] = $this->height - $this->paddleHeight - $this->unit;
            }
        }
    
        if ($this->paddleTwo['y'] < $this->unit) {
            $this->paddleTwo['y'] = $this->unit;
        } else if ($this->paddleTwo['y'] > $this->height - $this->paddleHeight - $this->unit) {
            $this->paddleTwo['y'] = $this->height - $this->paddleHeight - $this->unit;
        }
    
        // Move ball
        $this->ball['x'] += $this->ball['vx'] * $this->ballSpeed * $deltaTimeSeconds;
        $this->ball['y'] += $this->ball['vy'] * $this->ballSpeed * $deltaTimeSeconds;
    
        // Ball collisions with walls
        if ($this->ball['y'] < $this->unit || $this->ball['y'] + $this->unit > $this->height - $this->unit) {
            $this->ball['y'] -= 10 * $this->ball['vy'] / $this->ballSpeed;
            $this->ball['vy'] *= -1;
        }
    
        // Ball collisions with paddles
        if ($this->collision($this->ball, $this->paddleOne)) {
            $this->ball['vx'] *= -1;
            $this->ball['x'] = $this->paddleOne['x'] + $this->paddleOne['width'];
        }
    
        if ($this->collision($this->ball, $this->paddleTwo)) {
            $this->ball['vx'] *= -1;
            $this->ball['x'] = $this->paddleTwo['x'] - $this->ball['width'];
        }
    
        // Ball collisions with obstacles
        foreach ($this->obstacles as $key => $obs) {
            if ($this->collision($this->ball, $obs)) {
    
                // Change ball's direction
                $this->ball['vy'] *= -1;
    
                // Remove obstacle
                unset($this->obstacles[$key]);
    
                $obstacle = [
                    'x' => floor((mt_rand() / mt_getrandmax()) * ($this->width / 2) / $this->unit + ($this->width / 4) / $this->unit) * $this->unit,
                    'y' => floor((mt_rand() / mt_getrandmax()) * ($this->height - (6 * $this->unit)) / $this->unit + 3) * $this->unit,
                    'width' => $this->unit,
                    'height' => $this->unit
                ];
                $this->obstacles[] = $obstacle;
            }
        }
    
        // Ball out of bounds
        if (($this->ball['x'] < 0 || $this->ball['x'] > $this->width) && !$this->ball['reset']) {
            if ($this->ball['vx'] >= 0) {
                $this->scoreOne++;
            } else {
                $this->scoreTwo++;
            }
            $this->ball['reset'] = true;
    
            // Reset ball position
            $this->reset();
        }
    }

    public function reset() {
        $this->three = true;
        usleep(500000); // 500ms delay
    
        $this->three = false;
        $this->two = true;
        usleep(500000); // 500ms delay
    
        $this->two = false;
        $this->one = true;
        usleep(500000); // 500ms delay
    
        $this->one = false;
    
        // Reset ball position
        $this->ball['x'] = $this->width / 2;
        $this->ball['y'] = mt_rand() / mt_getrandmax() * $this->height / 2 + $this->height / 4;
        if ($this->singleplayer) {
            $this->ball['vx'] = $this->ballSpeed;
        }
        $this->ball['vy'] = -$this->ballSpeed;
        $this->ball['reset'] = false;
    }
    
    public function getData() {
        return [
            $this->scoreOne, 
            $this->scoreTwo, 
            $this->one, 
            $this->two, 
            $this->three,
            $this->obstacles,
            $this->paddleOne,
            $this->paddleTwo,
            $this->ball
        ];
    }
}
