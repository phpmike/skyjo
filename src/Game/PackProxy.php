<?php

namespace Mv\Skyjo\Game;

class PackProxy
{
    /**
     * @var Pack
     */
    protected $pack;

    /**
     * @param Pack $pack
     */
    public function __construct(Pack $pack)
    {
        $this->pack = $pack;
    }

    /**
     * @param Card $card
     * @return $this
     */
    public function pileAdd(Card $card)
    {
        $this->pack->pileAdd($card);

        return $this;
    }

    /**
     * @return false|Card
     */
    public function pileVisible()
    {
        return $this->pack->pileVisible();
    }
}