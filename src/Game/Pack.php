<?php

namespace Mv\Skyjo\Game;

use Iterator;

class Pack implements Iterator
{
    protected $cards = [];
    protected $pile = [];

    public function __construct()
    {
        $this->init();
    }

    protected function init()
    {
        $this->cards = array_merge(
            $this->createCards([-1, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12], 10),
            $this->createCards([-2], 5),
            $this->createCards([0], 15)
        );

        shuffle($this->cards);
    }

    private function createCards(array $values, int $count)
    {
        $cards = [];
        foreach ($values as $value) {
            for ($i = 0; $i < $count; $i++) {
                $cards[] = new Card($value);
            }
        }
        return $cards;
    }

    protected function invisibilizeCards()
    {
        array_map(function (Card $card) {
            $card->setState(Card::PACK_INVISIBLE);
        }, $this->cards);
    }

    public function unstack()
    {
        $current = $this->current();

        if (!$current) {
            $this->cards = $this->pile;
            $this->pile = [];
            $this->pile[] = array_pop($this->cards);
            $this->invisibilizeCards();
            shuffle($this->cards);

            $current = $this->current();
        }

        $card = $current;
        $this->next();

        return $card;
    }

    public function pileAdd(Card $card)
    {
        $this->pile[] = $card->setState(Card::PACK_VISIBLE);
        return $this;
    }

    public function pileVisible()
    {
        return end($this->pile);
    }

    public function current()
    {
        return current($this->cards);
    }

    public function next()
    {
        next($this->cards);
    }

    public function key()
    {
        return key($this->cards);
    }

    public function valid()
    {
        return (bool)current($this->cards);
    }

    public function rewind()
    {
        reset($this->cards);
    }
}
