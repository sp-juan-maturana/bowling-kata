<?php
namespace Kata;

/**
 * Class Game
 * @package Kata
 */
class Game
{
    protected $totalScore = 0;
    protected $turnScore = 0;

    protected $turnRolls = 0;
    protected $strikeRolls = 0;
    protected $turn = 1;

    protected $isSpare = false;
    protected $isStrike = false;

    public function roll($pins)
    {
        $this->turnRolls++;

        $this->turnScore += $pins;

        if ($this->isSpare) {
            $this->totalScore += $pins;
            $this->isSpare = false;
        }

        if ($this->isStrike) {
            $this->totalScore += $pins;
            $this->strikeRolls++;
            if ($this->strikeRolls == 2) {
                $this->isStrike = false;
                $this->strikeRolls = 0;
            }
        }

        if ($this->turnScore == 10) {
            if ($this->turnRolls == 1) {
                $this->isStrike = true;
                //$this->strikeRolls = 0;
            } else {
                $this->isSpare = true;
            }
        }

        if (($this->turnScore >= 10 || $this->turnRolls == 2) || $this->turn == 11) {
            $this->turn++;
            $this->turnRolls=0;
            $this->totalScore += $this->turnScore;
            $this->turnScore = 0;
        }
    }

    public function score ()
    {
        return $this->totalScore;
    }
}
