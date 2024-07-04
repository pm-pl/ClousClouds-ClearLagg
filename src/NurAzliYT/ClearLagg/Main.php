<?php

namespace NurAzliYT\ClearLagg;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\utils\TextFormat;
use NurAzliYT\ClearLagg\manager\ClearLaggManager;
use NurAzliYT\ClearLagg\manager\StatsManager;
use NurAzliYT\ClearLagg\command\ClearLaggCommand;
use NurAzliYT\ClearLagg\command\subcommands\StatsCommand;

class Main extends PluginBase {

    private $clearLaggManager;
    private $statsManager;

    public function onEnable(): void {
        $this->saveDefaultConfig();
        $this->clearLaggManager = new ClearLaggManager($this);
        $this->statsManager = new StatsManager($this);

        $this->clearLaggManager->init();

        $this->registerCommands();
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
