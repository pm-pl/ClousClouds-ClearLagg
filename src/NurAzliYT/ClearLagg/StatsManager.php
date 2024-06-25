<?php

namespace NurAzliYT\ClearLagg;

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

