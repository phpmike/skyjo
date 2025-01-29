<?php

namespace Mv\Skyjo\Game;

class Player
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var Card[]
     */
    protected $cards;

    /**
     * @var PackProxy
     */
    protected $packProxy;

    /**
     * @param string $name
     * @param PackProxy $packProxy
     */
    public function __construct($name, PackProxy $packProxy)
    {
        $this->name = $name;
        $this->packProxy = $packProxy;
    }

    /**
     * @return $this
     */
    protected function colEqualsManage()
    {
        $i = 0;
        while (array_key_exists($i, $this->cards) && $i < 4) {
            $card = $this->cards[$i];
            if (null !== $card && $card->isEqual($this->cards[$i + 4]) && $card->isEqual($this->cards[$i + 8])) {
                $this->packProxy->pileAdd($card);
                $this->cards[$i] = null;
                $this->packProxy->pileAdd($this->cards[$i + 4]);
                $this->cards[$i + 4] = null;
                $this->packProxy->pileAdd($this->cards[$i + 8]);
                $this->cards[$i + 8] = null;
            }

            ++$i;
        }

        return $this;
    }

    /**
     * @param Card $card
     * @return $this
     */
    public function addCard(Card $card)
    {
        $this->cards[] = $card;

        return $this;
    }

    /**
     * @return void
     */
    public function revealAll()
    {
        $visibilize = function (Card $card = null) {
            if ($card)
                $card->setState(Card::PLAYER_VISIBLE);
        };

        array_map($visibilize, $this->cards);
        $this->colEqualsManage();
    }

    /**
     * @return int
     */
    public function getVisibleScore()
    {
        $score = 0;

        foreach ($this->cards as $card) {
            if (null !== $card && Card::PLAYER_VISIBLE === $card->getState()) {
                $score += $card->getValue();
            }
        }

        return $score;
    }

    public function __toString()
    {
        $display = PHP_EOL;
        $j = 0;
        while (array_key_exists($j, $this->cards)) {
            for ($i = 0; $i < 4; $i++) {
                $val = $this->cards[$j];
                $display .= sprintf("%s\t", null !== $val?$val:"NN");
                $j+= 1;
            }
            $display.= PHP_EOL;
        }

        return $display;
    }
}