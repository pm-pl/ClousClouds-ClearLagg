<?php

namespace NurAzliYT\ClearLagg\manager;

use NurAzliYT\ClearLagg\Main;
use pocketmine\Server;
use pocketmine\entity\object\ItemEntity;

class ClearLaggManager {

    private Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function clearLagg(): void {
        $count = 0;
        foreach (Server::getInstance()->getWorldManager()->getWorlds() as $world) {
            foreach ($world->getEntities() as $entity) {
                if ($entity instanceof ItemEntity) {
                    $entity->flagForDespawn();
                    $count++;
                }
            }
        }
        $this->plugin->getStatsManager()->addClearedItems($count);
        if ($this->plugin->getConfigManager()->getConfig()->get("broadcast", true)) {
            $message = str_replace("{count}", (string)$count, $this->plugin->getConfigManager()->getConfig()->get("message", "Cleared {count} items!"));
            Server::getInstance()->broadcastMessage($message);
        }
    }
}
