<?php

namespace NurAzliYT\ClearLagg\manager;

use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat;
use pocketmine\plugin\PluginBase;

class StatsManager {

    private PluginBase $plugin;

    public function __construct(PluginBase $plugin) {
        $this->plugin = $plugin;
    }

    public function getStats(): string {
        $entityCount = 0;
        foreach ($this->plugin->getServer()->getWorldManager()->getWorlds() as $world) {
            $entityCount += count($world->getEntities());
        }
        return TextFormat::GREEN . "Current entity count: " . TextFormat::WHITE . $entityCount;
    }
}
