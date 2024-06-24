<?php

namespace NurAzliYT\ClearLagg;

use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\TaskHandler;
use pocketmine\Server;
use pocketmine\world\World;
use pocketmine\entity\object\ItemEntity;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Internet;

class Main extends PluginBase {

    private $autoClearInterval;
    private $worldSettings;
    private $notifyPlayersEnable;
    private $notifyPlayersMessage;
    private $notifyPlayersCountdown;
    private $timeRemaining;
    private $clearTaskHandler;

    public function onLoad(): void {
        $this->saveDefaultConfig();
        $this->reloadConfig();
    }

    public function onEnable(): void {
        $this->loadConfigValues();

        $this->getScheduler()->scheduleRepeatingTask(new ClosureTask(function(): void {
            $this->onTick();
        }), 20);

        $this->getScheduler()->scheduleRepeatingTask(new ClosureTask(function(): void {
            $this->broadcastTime();
        }), $this->autoClearInterval * 20);

        // Schedule ClearItemsTask
        $this->clearTaskHandler = $this->getScheduler()->scheduleRepeatingTask(new ClosureTask(function(): void {
            $this->clearItems();
        }), $this->autoClearInterval * 20);
        
        // Check for updates on enable
        $this->checkUpdates();
    }

    private function loadConfigValues(): void {
        $config = $this->getConfig();

        $this->autoClearInterval = $config->get("auto-clear-interval", 300);
        $this->worldSettings = $config->get("worlds", []);
        $this->notifyPlayersEnable = $config->getNested("notify-players.enable", true);
        $this->notifyPlayersMessage = $config->getNested("notify-players.message", "All dropped items will be cleared in {countdown} seconds!");
        $this->notifyPlayersCountdown = $config->getNested("notify-players.countdown", 60);

        $this->timeRemaining = $this->autoClearInterval;
    }

    public function getAutoClearInterval(): int {
        return $this->autoClearInterval;
    }

    public function getWorldSettings(): array {
        return $this->worldSettings;
    }

    public function getNotifyPlayersEnable(): bool {
        return $this->notifyPlayersEnable;
    }

    public function getNotifyPlayersMessage(): string {
        return $this->notifyPlayersMessage;
    }

    public function getNotifyPlayersCountdown(): int {
        return $this->notifyPlayersCountdown;
    }

    public function getTimeRemaining(): int {
        return $this->timeRemaining;
    }

    public function setTimeRemaining(int $timeRemaining): void {
        $this->timeRemaining = $timeRemaining;
    }

    private function onTick(): void {
        if ($this->timeRemaining <= 5 && $this->timeRemaining > 0 && $this->notifyPlayersEnable) {
            $this->getServer()->broadcastMessage(str_replace("{countdown}", (string)$this->timeRemaining, $this->notifyPlayersMessage));
        }

        if ($this->timeRemaining <= 0) {
            $this->clearItems();
            $this->timeRemaining = $this->autoClearInterval;
        } else {
            $this->timeRemaining--;
        }
    }

    private function clearItems(): void {
        foreach (Server::getInstance()->getWorldManager()->getWorlds() as $world) {
            $worldName = $world->getFolderName();
            if (isset($this->worldSettings[$worldName]["enable-auto-clear"]) && $this->worldSettings[$worldName]["enable-auto-clear"] === true) {
                foreach ($world->getEntities() as $entity) {
                    if ($entity instanceof ItemEntity) {
                        $entity->flagForDespawn();
                    }
                }
            }
        }
        $this->getServer()->broadcastMessage("§aGarbage collected correctly.");
    }

    private function broadcastTime(): void {
        if ($this->notifyPlayersEnable) {
            $this->getServer()->broadcastMessage(str_replace("{countdown}", (string)$this->timeRemaining, $this->notifyPlayersMessage));
        }
    }

    private function checkUpdates(): void {
        $pluginName = "ClearLagg";
        $resourceId = 13940; // Replace with your resource ID on poggit or spigot
        
        $this->getLogger()->info("Checking for updates...");
        Internet::getURL("https://poggit.pmmp.io/releases.json?name=" . $pluginName, 10, [], function (string $response, string $error = null) use ($pluginName, $resourceId): void {
            if ($error !== null) {
                $this->getLogger()->warning("Failed to check for updates: $error");
                return;
            }
            
            $data = json_decode($response, true);
            if (isset($data[$pluginName])) {
                $latestVersion = $data[$pluginName][0]["version"];
                if (version_compare($this->getDescription()->getVersion(), $latestVersion, "<")) {
                    $this->getLogger()->info("A new version ($latestVersion) is available! Update at: https://poggit.pmmp.io/r/$resourceId");
                } else {
                    $this->getLogger()->info("Plugin is up to date.");
                }
            } else {
                $this->getLogger()->warning("Failed to check for updates: Data for $pluginName not found.");
            }
        });
    }

    public function onDisable(): void {
        if ($this->clearTaskHandler instanceof TaskHandler) {
            $this->clearTaskHandler->cancel();
        }
    }
}
