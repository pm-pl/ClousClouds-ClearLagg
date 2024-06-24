<?php

namespace NurAzliYT\ClearLagg\manager;

use pocketmine\scheduler\Task;
use NurAzliYT\ClearLagg\Main;
use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\entity\Entity;

class ClearLaggManager extends Task {

    private Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function onRun(): void {
        $this->clearEntities();
    }

    private function clearEntities(): void {
        $config = $this->plugin->getClearLaggConfig();
        $entitiesToClear = ["item", "zombie", "skeleton", "creeper", "spider", "witch"];

        foreach ($config->get("worlds", []) as $worldName => $settings) {
            if ($settings["enable-auto-clear"]) {
                $world = Server::getInstance()->getWorldManager()->getWorldByName($worldName);
                if ($world !== null) {
                    foreach ($world->getEntities() as $entity) {
                        if (!$entity instanceof Player && in_array(strtolower($entity->getName()), $entitiesToClear)) {
                            $entity->flagForDespawn();
                        }
                    }
                }
            }
        }
        if ($config->get("notify-players.enable", true)) {
            $this->plugin->notifyPlayers($config->get("notify-players.message", "All dropped items will be cleared"), $config->get("notify-players.countdown", 60));
        }
        $this->plugin->getLogger()->info("Entities cleared to reduce lag.");
    }
}
