<?php

namespace Mv\Skyjo\Game;

use Iterator;

class Pack implements Iterator
{
    /**
     * @var Card[]
     */
    protected $cards;

    /**
     * @var Card[]
     */
    protected $pile;

    public function __construct()
    {
        $this->init();
    }

    /**
     * @return void
     */
    protected function init()
    {
        $tenCards = [-1, 1, 2, 3, 4, 5, 6, 7 ,8, 9, 10, 11, 12];
        $fiveCards = [-2];
        $fifteenCards = [0];

        foreach ($tenCards as $tenCard) {
            for ($i = 0; $i < 10; $i++) {
                $card = new Card($tenCard);
                $this->cards[] = $card;
            }
        }
        foreach ($fiveCards as $fiveCard) {
            for ($i = 0; $i < 5; $i++) {
                $card = new Card($fiveCard);
                $this->cards[] = $card;
            }
        }
        foreach ($fifteenCards as $fifteenCard) {
            for ($i = 0; $i < 15; $i++) {
                $card = new Card($fifteenCard);
                $this->cards[] = $card;
            }
        }

        shuffle($this->cards);
    }

    protected function invisibilizeCards()
    {
        $invisibilize = function (Card $card) {
            $card->setState(Card::PACK_INVISIBLE);
        };

        array_map($invisibilize, $this->cards);
    }

    /**
     * @return false|Card
     */
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

    /**
     * @param Card $card
     * @return $this
     */
    public function pileAdd(Card $card)
    {
        $this->pile[] = $card->setState(Card::PACK_VISIBLE);
        
        return $this;
    }

    /**
     * @return false|Card
     */
    public function pileVisible()
    {
        return end($this->pile);
    }

    /**
     * @return false|Card
     */
    public function current()
    {
        return current($this->cards);
    }

    /**
     * @return void
     */
    public function next()
    {
        next($this->cards);
    }

    /**
     * @return int|string|null
     */
    public function key()
    {
        $key = key($this->cards);

        return $key;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return (bool)current($this->cards);
    }

    /**
     * @return void
     */
    public function rewind()
    {
        reset($this->cards);
    }

}