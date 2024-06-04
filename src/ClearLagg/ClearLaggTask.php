<?php

namespace ClearLagg\task;

use pocketmine\scheduler\Task;
use ClearLagg\Main;

class ClearLaggTask extends Task {

    private Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function onRun(): void {
        $this->plugin->getClearLaggManager()->clearLagg();
    }
}
