<?php
namespace Kata\Tests;

use Kata\Game;

class GameTest extends \PHPUnit_Framework_TestCase
{

    protected $game;

    protected function setUp()
    {
        $this->game = new Game();
    }

    protected function rollNTimesXPins($times, $pines)
    {
        for ($i=0; $i<$times; $i++) {
            $this->game->roll($pines);
        }
    }

    /**
     * @test
     */
    public function testLaPersonaNoHaTiradoNungunBoloEnTodaLaPartida()
    {
        $this->rollNTimesXPins(20, 0);

        $this->game->score();
        $this->assertSame($this->game->score(), 0);
    }


    public function testLaPersonaTiraUnSoloBolo()
    {
        $this->game->roll(1);
        $this->rollNTimesXPins(19, 0);

        $this->game->score();
        $this->assertSame($this->game->score(), 1);
    }

    public function testLaPersonaHaceUnSpareEnLaPrimeraTiradaYLeBonificaLaSiguienteTirada()
    {
        $this->game->roll(5);
        $this->game->roll(5);
        $this->game->roll(1);
        $this->rollNTimesXPins(17, 0);

        $this->game->score();
        $this->assertSame($this->game->score(), 12);
    }


    public function testLaPersonaTiraBolosEnVariosTurnosSinBonificar ()
    {
        $this->game->roll(5);
        $this->game->roll(0);
        $this->game->roll(5);
        $this->game->roll(1);
        $this->rollNTimesXPins(16, 0);

        $this->game->score();
        $this->assertSame($this->game->score(), 11);
    }

    public function testLaPersonaHaceDosSparesSeguidos()
    {
        $this->game->roll(5);
        $this->game->roll(5);
        $this->game->roll(1);
        $this->game->roll(9);
        $this->game->roll(1);
        $this->rollNTimesXPins(15, 0);

        $this->game->score();
        $this->assertSame($this->game->score(), 23);
    }

    public function testLaPersonaHaceTodoSpares()
    {
        $this->rollNTimesXPins(21, 5);

        $this->game->score();
        $this->assertSame($this->game->score(), 155);
    }

    public function testLaPersonaHaceUnStrike()
    {
        $this->game->roll(10);

        $this->game->roll(1);
        $this->game->roll(1);

        $this->rollNTimesXPins(16, 0);

        $this->game->score();
        $this->assertSame($this->game->score(), 14);
    }

    public function testLaPersonaHaceUnStrikeYSpareSeguidos()
    {
        $this->game->roll(10);

        $this->game->roll(5);
        $this->game->roll(5);

        $this->game->roll(1);
        $this->game->roll(0);

        $this->rollNTimesXPins(14, 0);

        $this->game->score();
        $this->assertSame($this->game->score(), 32);
    }

    public function testLaPersonaHaceDosStrikesSeguidos()
    {
        $this->game->roll(10);//21

        $this->game->roll(10);//11

        $this->game->roll(1);//1
        $this->game->roll(0);

        $this->rollNTimesXPins(14, 0);

        $this->game->score();
        $this->assertSame($this->game->score(), 33);
    }

    public function testLaPartidaPerfecta()
    {
        $this->rollNTimesXPins(12, 10);

        $this->game->score();
        $this->assertSame($this->game->score(), 300);
    }

}
