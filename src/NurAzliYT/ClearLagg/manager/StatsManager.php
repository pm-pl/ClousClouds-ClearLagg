<?php

namespace NurAzliYT\ClearLagg\manager;

class StatsManager {

    private int $totalItemsCleared = 0;
    private int $currentSessionItemsCleared = 0;

    public function addClearedItems(int $count): void {
        $this->totalItemsCleared += $count;
        $this->currentSessionItemsCleared += $count;
    }

    public function getStats(): array {
        return [
            'total' => $this->totalItemsCleared,
            'current' => $this->currentSessionItemsCleared
        ];
    }

    public function resetCurrentSession(): void {
        $this->currentSessionItemsCleared = 0;
    }
}
