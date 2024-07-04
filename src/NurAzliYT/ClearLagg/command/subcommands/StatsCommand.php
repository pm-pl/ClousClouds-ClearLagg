<?php

namespace NurAzliYT\ClearLagg;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use NurAzliYT\ClearLagg\Main;

class StatsCommand extends Command implements PluginOwned {
    use PluginOwnedTrait;

    private $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("clearlaggstats", "View ClearLagg statistics", "/clearlagg stats", []);
        $this->plugin = $plugin;
        $this->setPermission("clearlagg.stats.command");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            return false;
        }

        $this->plugin->getStatsManager()->sendStats($sender);
        return true;
    }

    public function getOwningPlugin(): Main {
        return $this->plugin;
    }
}
