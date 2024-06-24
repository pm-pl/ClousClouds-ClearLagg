<?php

namespace NurAzliYT\ClearLagg;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\scheduler\TaskScheduler;
use pocketmine\player\Player;
use NurAzliYT\ClearLagg\command\ClearLaggCommand;
use NurAzliYT\ClearLagg\listener\EventListener;
use NurAzliYT\ClearLagg\manager\ClearLaggManager;
use NurAzliYT\ClearLagg\manager\ConfigManager;
use NurAzliYT\ClearLagg\manager\StatsManager;
use NurAzliYT\ClearLagg\task\AutoClearTask;

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

        $interval = $this->getConfig()->get("auto-clear-interval", 300);
        if(!is_int($interval) || $interval <= 0){
            $this->getLogger()->warning("auto-clear-interval in config is invalid, using default value 300 seconds.");
            $interval = 300;
        }

        $this->getLogger()->info("Scheduling AutoClearTask with interval: " . $interval . " seconds.");
        $this->getScheduler()->scheduleRepeatingTask(new AutoClearTask($this), 20 * $interval);

        $this->notifyPlayers();
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

    private function notifyPlayers(): void {
        $notifyConfig = $this->getConfig()->get("notify-players", []);
        if ($notifyConfig["enable"]) {
            $message = $notifyConfig["message"] ?? "All dropped items will be cleared in 60 seconds!";
            $countdown = $notifyConfig["countdown"] ?? 60;

            $this->getScheduler()->scheduleRepeatingTask(new class($this, $message, $countdown) extends \pocketmine\scheduler\Task {
                private $plugin;
                private $message;
                private $countdown;

                public function __construct($plugin, $message, $countdown) {
                    $this->plugin = $plugin;
                    $this->message = $message;
                    $this->countdown = $countdown;
                }

                public function onRun(int $currentTick): void {
                    foreach ($this->plugin->getServer()->getOnlinePlayers() as $player) {
                        $player->sendMessage(TextFormat::RED . str_replace("{seconds}", $this->countdown, $this->message));
                    }
                }
            }, 20 * $countdown);
        }
    }
}
