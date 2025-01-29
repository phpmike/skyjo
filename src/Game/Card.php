<?php

namespace Mv\Skyjo\Game;

class Card
{
    const PACK_INVISIBLE = 1;
    const PACK_VISIBLE = 2;
    const PLAYER_INVISIBLE = 4;
    const PLAYER_VISIBLE = 8;

    const INVISIBLE = 5;
    const VISIBLE = 10;

    /**
     * @var int
     */
    protected $value;

    /**
     * @var int
     */
    protected $state = self::PACK_INVISIBLE;

    /**
     * @param int $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param int $state
     *
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @param Card $card
     * @return bool
     */
    public function isEqual(Card $card)
    {
        // On ne peut pas dire que des cartes non visibles sont égales !
        if (0 === $this->state & self::VISIBLE || 0 === $card->getState() & self::VISIBLE)
            return false;

        return $card->getValue() === $this->value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}