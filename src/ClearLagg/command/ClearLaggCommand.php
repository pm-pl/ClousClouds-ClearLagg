<?php

namespace ClearLagg\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use pocketmine\plugin\Plugin;
use ClearLagg\Main;

class ClearLaggCommand extends Command implements PluginOwned {

    use PluginOwnedTrait;

    /** @var Main */
    private Main $plugin;

    /**
     * ClearLaggCommand constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin) {
        parent::__construct("clearlagg", "Clears all dropped items", "/clearlagg", ["cl"]);
        $this->plugin = $plugin;
        $this->setPermission("clearlagg.use");
    }

    /**
     * Executes the command.
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            $sender->sendMessage("You do not have permission to use this command.");
            return false;
        }

        if (isset($args[0]) && $args[0] === "stats") {
            $stats = $this->plugin->getStatsManager()->getStats();
            $sender->sendMessage("Items cleared: " . $stats['total'] . "\nSince last restart: " . $stats['current']);
            return true;
        }

        if (empty($args)) {
            $this->plugin->getClearLaggManager()->clearLagg();
            $sender->sendMessage("All dropped items have been cleared.");
            return true;
        }

        // Jika ada argumen yang tidak dikenal, beritahu pengguna tanpa menunjukkan usage message
        $sender->sendMessage("Invalid command usage. Use /clearlagg or /clearlagg stats.");
        return false;
    }

    /**
     * Returns the owning plugin.
     * @return Plugin
     */
    public function getOwningPlugin(): Plugin {
        return $this->plugin;
    }
}
