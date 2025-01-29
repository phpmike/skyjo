<?php

namespace Mv\Skyjo\Game;

class Party
{
    /**
     * @var array
     */
    protected $players = [];

    /**
     * @var Pack
     */
    protected $pack;

    /**
     * @var PackProxy
     */
    protected $packProxy;

    /**
     * @param array $names
     */
    public function __construct($names)
    {
        $this->pack = new Pack();
        $this->packProxy = new PackProxy($this->pack);

        foreach ($names as $name) {
            $player = new Player($name, $this->packProxy);
            $this->players[] = $player;
        }
    }

    public function distribute()
    {
        for ($i = 0; $i < 12; $i++) {
            /** @var Player $player */
            foreach ($this->players as $player) {
                $card = $this->pack->unstack();
                $player->addCard($card);
            }
        }
    }

    /**
     * @return array
     */
    public function getPlayers()
    {
        return $this->players;
    }
}