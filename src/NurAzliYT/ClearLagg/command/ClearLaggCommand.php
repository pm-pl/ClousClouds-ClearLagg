<?php

namespace NurAzliYT\ClearLagg\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;
use NurAzliYT\ClearLagg\Main;
use pocketmine\player\Player;

class ClearLaggCommand extends Command implements PluginOwned {

    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("clearlagg", "Manage the ClearLagg plugin", "/clearlagg <stats>", ["cl"]);
        $this->plugin = $plugin;
        $this->setPermission("clearlagg.use");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if (!$this->testPermission($sender)) {
            return;
        }
        if (count($args) < 1) {
            $sender->sendMessage("Usage: /clearlagg <stats>");
            return;
        }
        switch (strtolower($args[0])) {
            case "stats":
                $this->plugin->getScheduler()->scheduleTask(new class($this->plugin, $sender) extends Task {
                    private Main $plugin;
                    private CommandSender $sender;

                    public function __construct(Main $plugin, CommandSender $sender) {
                        $this->plugin = $plugin;
                        $this->sender = $sender;
                    }

                    public function onRun(): void {
                        $statsManager = new StatsManager($this->plugin);
                        $this->sender->sendMessage($statsManager->getStats());
                    }
                });
                break;
            default:
                $sender->sendMessage("Usage: /clearlagg <stats>");
                break;
        }
    }

    public function getOwningPlugin(): Plugin {
        return $this->plugin;
    }
}
