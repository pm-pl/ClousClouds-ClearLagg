<?php

/**
 * Plugin Created By KnosTx https://github.com/KnosTx
 *    ____ _                 _                      
 *  / ___| | ___  __ _ _ __| |    __ _  __ _  __ _ 
 * | |   | |/ _ \/ _` | '__| |   / _` |/ _` |/ _` |
 * | |___| |  __/ (_| | |  | |__| (_| | (_| | (_| |
 *  \____|_|\___|\__,_|_|  |_____\__,_|\__, |\__, |
 *                                     |___/ |___/ 
 * License LGPL-4
 * KnosTx Team
 * https://xpocketmc.xyz
 */

namespace KnosTx\ClearLagg;

use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\utils\TextFormat;
use KnosTx\ClearLagg\manager\ClearLaggManager;
use KnosTx\ClearLagg\manager\StatsManager;
use KnosTx\ClearLagg\command\ClearLaggCommand;
use KnosTx\ClearLagg\command\subcommands\StatsCommand;

class Main extends PluginBase {

    private $clearLaggManager;
    private $statsManager;
    private $entityCap;

    public function onEnable(): void {
        $this->saveDefaultConfig();
        ConfigNotifier::checkConfigVersion($this);
        UpdateNotifier::checkForUpdates($this);
        $this->clearLaggManager = new ClearLaggManager($this);
        $this->statsManager = new StatsManager($this);

        $this->clearLaggManager->init();

        $this->registerCommands();
        $this->entityCap = $this->getConfig()-get(entity-cap, []);
    }

    private function clearItems(): void {
        foreach (Server::getInstance()->getWorldManager()->getWorlds() as $world) {
           $worldName = $world->getFolderName();
           if (isset($this->entityCap[$worldName])) {
                $entityCount = [];
                foreach ($world->getEntities() as $entity) {
                    $entityId = $entity->getName();
                    if (!isset($entityCount[$entityId])) {
                        $entityCount[$entityId] = 0;
                    }
                    $entityCount[$entityId]++;
                    if ($entityCount[$entityId] > $this->entityCap[$worldName][$entityId]) {
                        $entity->flagForDespawn();
                    }
                }
            }
        }
       $this->getServer()->broadcastMessage($this->clearMessage);
    }

    private function registerCommands(): void {
        $clearLaggCommand = new ClearLaggCommand($this);
        $this->getServer()->getCommandMap()->register("clearlagg", $clearLaggCommand);

        $statsCommand = new StatsCommand($this);
        $this->getServer()->getCommandMap()->register("clearlaggstats", $statsCommand);
    }

    public function onDisable(): void {
        $this->clearLaggManager->shutdown();
    }

    public function getClearLaggManager(): ClearLaggManager {
        return $this->clearLaggManager;
    }

    public function getStatsManager(): StatsManager {
        return $this->statsManager;
    }
}
