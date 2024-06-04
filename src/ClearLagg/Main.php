<?php

namespace ClearLagg;

use pocketmine\plugin\PluginBase;
use ClearLagg\task\ClearLagTask;
use ClearLagg\manager\ClearLagManager;
use ClearLagg\manager\ConfigManager;
use ClearLagg\listener\EventListener;
use ClearLagg\command\ClearLagCommand;

class Main extends PluginBase {

    private ClearLagManager $clearLagManager;
    private ConfigManager $configManager;

    public function onEnable(): void {
        $this->configManager = new ConfigManager($this);
        $this->clearLagManager = new ClearLagManager($this);

        $this->getScheduler()->scheduleRepeatingTask(
            new ClearLagTask($this),
            20 * $this->configManager->getConfig()->get("interval", 300)
        );

        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->getServer()->getCommandMap()->register("clearlag", new ClearLagCommand($this));
    }

    public function getClearLagManager(): ClearLagManager {
        return $this->clearLagManager;
    }

    public function getConfigManager(): ConfigManager {
        return $this->configManager;
    }
}
