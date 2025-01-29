<?php

namespace Mv\Skyjo\Game;

class Player
{
    protected $name;
    protected $cards = [];
    protected $packProxy;

    public function __construct($name, PackProxy $packProxy)
    {
        $this->name = $name;
        $this->packProxy = $packProxy;
    }

    protected function colEqualsManage()
    {
        for ($i = 0; $i < 4; $i++) {
            if (isset($this->cards[$i], $this->cards[$i + 4], $this->cards[$i + 8]) &&
                $this->cards[$i]->isEqual($this->cards[$i + 4]) &&
                $this->cards[$i]->isEqual($this->cards[$i + 8])) {
                $this->packProxy->pileAdd($this->cards[$i]);
                $this->cards[$i] = null;
                $this->packProxy->pileAdd($this->cards[$i + 4]);
                $this->cards[$i + 4] = null;
                $this->packProxy->pileAdd($this->cards[$i + 8]);
                $this->cards[$i + 8] = null;
            }
        }
        return $this;
    }

    public function addCard(Card $card)
    {
        $this->cards[] = $card;
        return $this;
    }

    public function revealAll()
    {
        array_map(function (Card $card = null) {
            if ($card) {
                $card->setState(Card::PLAYER_VISIBLE);
            }
        }, $this->cards);
        $this->colEqualsManage();
    }

    public function getVisibleScore()
    {
        return array_reduce($this->cards, function ($score, Card $card = null) {
            return $score + ($card && $card->getState() === Card::PLAYER_VISIBLE ? $card->getValue() : 0);
        }, 0);
    }

    public function __toString()
    {
        $display = PHP_EOL;
        for ($i = 0; $i < count($this->cards); $i += 4) {
            for ($j = 0; $j < 4; $j++) {
                $display .= isset($this->cards[$i + $j]) ? $this->cards[$i + $j] . "\t" : "NN\t";
            }
            $display .= PHP_EOL;
        }
        return $display;
    }
}
