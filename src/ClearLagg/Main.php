<?php

namespace ClearLagg;

use pocketmine\plugin\PluginBase;
use ClearLagg\task\ClearLaggTask;
use ClearLagg\manager\ClearLaggManager;
use ClearLagg\manager\ConfigManager;
use ClearLagg\listener\EventListener;
use ClearLagg\command\ClearLaggCommand;

class Main extends PluginBase {

    private ClearLaggManager $clearLagManager;
    private ConfigManager $configManager;

    public function onEnable(): void {
        $this->configManager = new ConfigManager($this);
        $this->clearLagManager = new ClearLaggManager($this);

        $this->getScheduler()->scheduleRepeatingTask(
            new ClearLagTask($this),
            20 * $this->configManager->getConfig()->get("interval", 300)
        );

        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->getServer()->getCommandMap()->register("clearlag", new ClearLagCommand($this));
    }

    public function getClearLagManager(): ClearLaggManager {
        return $this->clearLagManager;
    }

    public function getConfigManager(): ConfigManager {
        return $this->configManager;
    }
}
