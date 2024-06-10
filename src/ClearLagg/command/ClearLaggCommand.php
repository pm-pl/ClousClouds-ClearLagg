<?php

namespace ClearLagg\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use ClearLagg\Main;

class ClearLaggCommand extends Command implements PluginOwned {

    use PluginOwnedTrait;

    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("clearlagg", "Clears all dropped items", "/clearlagg", []);
        $this->plugin = $plugin;
        $this->setPermission("clearlagg.use");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            return false;
        }
        
        if (isset($args[0]) && $args[0] === "stats") {
            $stats = $this->plugin->getStatsManager()->getStats();
            $sender->sendMessage("Items cleared: " . $stats['total'] . "\nSince last restart: " . $stats['current']);
            return true;
        }
        
        $this->plugin->getClearLaggManager()->clearLagg();
        $sender->sendMessage("All dropped items have been cleared.");
        return true;
    }

    public function getOwningPlugin(): Main {
        return $this->plugin;
    }
}
