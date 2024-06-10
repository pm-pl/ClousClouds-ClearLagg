<?php

namespace ClearLagg;

use pocketmine\plugin\PluginBase;
use ClearLagg\task\ClearLaggTask;
use ClearLagg\manager\ClearLaggManager;
use ClearLagg\manager\ConfigManager;
use ClearLagg\manager\StatsManager;
use ClearLagg\listener\EventListener;
use ClearLagg\command\ClearLaggCommand;

class Main extends PluginBase {

    private ClearLaggManager $clearLaggManager;
    private ConfigManager $configManager;
    private StatsManager $statsManager;

    public function onEnable(): void {
        $this->configManager = new ConfigManager($this);
        $this->clearLaggManager = new ClearLaggManager($this);
        $this->statsManager = new StatsManager();

        foreach ($this->configManager->getConfig()->get("worlds", []) as $worldName => $settings) {
            $interval = $settings["interval"] ?? 300;
            $this->getScheduler()->scheduleRepeatingTask(
                new ClearLaggTask($this),
                20 * $interval
            );
        }

        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->getServer()->getCommandMap()->register("clearlagg", new ClearLaggCommand($this));
    }

    public function getClearLaggManager(): ClearLaggManager {
        return $this->clearLaggManager;
    }

    public function getConfigManager(): ConfigManager {
        return $this->configManager;
    }

    public function getStatsManager(): StatsManager {
        return $this->statsManager;
    }
}
