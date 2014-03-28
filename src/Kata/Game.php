<?php
namespace Kata;

/**
 * Class Game
 * @package Kata
 */
class Game
{
    protected $turn = 0;
    protected $turnRoll = 0;
    protected $gameData = array();

    public function roll($pins)
    {
        $this->gameData[$this->turn][$this->turnRoll] = $pins;

        $this->turnRoll++;

        if ($this->turnRoll > 1 || $this->returnPinsInTurn($this->turn) === 10) {
            $this->turn++;
            $this->turnRoll = 0;
        }
    }

    public function score ()
    {
        $score = 0;
        foreach ($this->gameData as $turn => $turnData) {
            foreach ($turnData as $turnRoll => $pins) {
                $score += $pins;
                if ($turnRoll === 0 && $this->isSpare($turn-1)) {
                    $score += $pins;
                }
                if ($this->isStrike($turn-1)) {
                    $score += $pins;
                }
                if ($turn < 9 && $this->numRollsInTurn($turn-1) === 1 && $this->isStrike($turn-2)) {
                    $score += $pins;
                }
            }
        }
        return $score;
    }

    protected function returnPinsInTurn($turn)
    {
        $pinsInTurn = 0;
        foreach ($this->gameData[$turn] as $pins) {
            $pinsInTurn += $pins;
        }
        return $pinsInTurn;
    }

    protected function isSpare($turn)
    {
        return ($turn >= 0 && !$this->isStrike($turn) && $this->returnPinsInTurn($turn) === 10);
    }

    protected function isStrike($turn)
    {
        return ($turn >= 0 && $this->gameData[$turn][0] === 10);
    }

    protected function numRollsInTurn($turn)
    {
        if ($turn < 0) {
            return null;
        }
        return sizeof($this->gameData[$turn]);
    }
}
