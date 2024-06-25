<?php

namespace NurAzliYT\ClearLagg\manager;

use NurAzliYT\ClearLagg\Main;

class StatsManager {

    private $plugin;
    private $itemsCleared;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
        $this->itemsCleared = 0;
    }

    public function incrementItemsCleared(int $count = 1): void {
        $this->itemsCleared += $count;
    }

    public function getItemsCleared(): int {
        return $this->itemsCleared;
    }
}

