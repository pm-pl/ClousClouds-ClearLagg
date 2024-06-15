<?php

namespace ClearLagg;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use ClearLagg\command\ClearLaggCommand;
use ClearLagg\listener\EventListener;
use ClearLagg\manager\ClearLaggManager;
use ClearLagg\manager\ConfigManager;
use ClearLagg\manager\StatsManager;
use ClearLagg\task\AutoClearTask;

class Main extends PluginBase implements Listener {

    /** @var ClearLaggManager */
    private ClearLaggManager $clearLaggManager;

    /** @var ConfigManager */
    private ConfigManager $configManager;

    /** @var StatsManager */
    private StatsManager $statsManager;

    public function onEnable(): void {
        $this->saveDefaultConfig();
        $this->configManager = new ConfigManager($this);
        $this->clearLaggManager = new ClearLaggManager($this);
        $this->statsManager = new StatsManager();

        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->getServer()->getCommandMap()->register("clearlagg", new ClearLaggCommand($this));

        $this->getScheduler()->scheduleRepeatingTask(new AutoClearTask($this), 20 * $this->getConfig()->get("auto-clear-interval"));
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
