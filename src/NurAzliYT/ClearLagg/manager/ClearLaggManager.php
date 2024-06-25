<?php

namespace NurAzliYT\ClearLagg\manager;

use NurAzliYT\ClearLagg\Main;
use pocketmine\Server;
use pocketmine\entity\object\ItemEntity;
use pocketmine\utils\TextFormat;

class ClearLaggManager {

    private $plugin;
    private $clearMessage;
    private $warningMessage;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
        $config = $plugin->getConfig();
        $this->clearMessage = TextFormat::colorize($config->get("clear-message", "§aGarbage collected correctly."));
        $this->warningMessage = TextFormat::colorize($config->get("warning-message", "§cPicking up trash in {time}..."));
    }

    public function clearItems(): void {
        $itemsCleared = 0;
        foreach (Server::getInstance()->getWorldManager()->getWorlds() as $world) {
            foreach ($world->getEntities() as $entity) {
                if ($entity instanceof ItemEntity) {
                    $entity->flagForDespawn();
                    $itemsCleared++;
                }
            }
        }
        $this->plugin->getStatsManager()->incrementItemsCleared($itemsCleared);
        Server::getInstance()->broadcastMessage($this->clearMessage);
    }

    public function getWarningMessage(int $timeRemaining): string {
        return str_replace("{time}", (string)$timeRemaining, $this->warningMessage);
    }
}
