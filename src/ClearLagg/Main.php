<?php

namespace ClearLagg;

use pocketmine\plugin\PluginBase;
use ClearLagg\task\ClearLaggTask;
use ClearLagg\manager\ClearLaggManager;
use ClearLagg\manager\ConfigManager;
use ClearLagg\listener\EventListener;
use ClearLagg\command\ClearLaggCommand;

class Main extends PluginBase {

    private ClearLaggManager $clearLaggManager;
    private ConfigManager $configManager;

    public function onEnable(): void {
        $this->configManager = new ConfigManager($this);
        $this->clearLaggManager = new ClearLaggManager($this);

        $this->getScheduler()->scheduleRepeatingTask(
            new ClearLaggTask($this),
            20 * $this->configManager->getConfig()->get("interval", 300)
        );

        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->getServer()->getCommandMap()->register("clearlagg", new ClearLaggCommand($this));
    }

    public function getClearLaggManager(): ClearLaggManager {
        return $this->clearLaggManager;
    }

    public function getConfigManager(): ConfigManager {
        return $this->configManager;
    }
}
