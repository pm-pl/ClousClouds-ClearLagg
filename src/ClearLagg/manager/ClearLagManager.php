<?php

namespace ClearLagg\manager;

use pocketmine\utils\TextFormat;
use pocketmine\entity\object\ItemEntity;
use ClearLagg\Main;

class ClearLagManager {

    private Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function clearLag(): void {
        $count = 0;

        foreach ($this->plugin->getServer()->getWorldManager()->getWorlds() as $world) {
            foreach ($world->getEntities() as $entity) {
                if ($entity instanceof ItemEntity) {
                    $entity->flagForDespawn();
                    $count++;
                }
            }
        }

        $message = str_replace("{count}", (string) $count, $this->plugin->getConfigManager()->getConfig()->get("message", "Cleared {count} items!"));
        if ($this->plugin->getConfigManager()->getConfig()->get("broadcast", true)) {
            $this->plugin->getServer()->broadcastMessage(TextFormat::GREEN . $message);
        }
    }
}
