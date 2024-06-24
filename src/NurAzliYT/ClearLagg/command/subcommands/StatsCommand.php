<?php

namespace NurAzliYT\ClearLagg\command\subcommands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;
use NurAzliYT\ClearLagg\Main;
use pocketmine\player\Player;

class StatsCommand extends Command implements PluginOwned {

    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("clearlaggstats", "Show statistics for ClearLagg", "/clearlaggstats", ["clstats"]);
        $this->plugin = $plugin;
        $this->setPermission("clearlagg.use");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if (!$this->testPermission($sender)) {
            return;
        }
        $statsManager = new \NurAzliYT\ClearLagg\manager\StatsManager($this->plugin);
        $sender->sendMessage($statsManager->getStats());
    }

    public function getOwningPlugin(): Plugin {
        return $this->plugin;
    }
}
