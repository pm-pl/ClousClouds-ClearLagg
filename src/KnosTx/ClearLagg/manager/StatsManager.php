<?php

namespace KnosTx\ClearLagg\manager;

use KnosTx\ClearLagg\Main;

class StatsManager{

    public Main $plugin;
    private $itemsCleared;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
        $this->itemsCleared = 0;
    }

    public function incrementItemsCleared(int $count = 1): void{
        $this->itemsCleared += $count;
    }

    public function getItemsCleared(): int{
        return $this->itemsCleared;
    }
}
