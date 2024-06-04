<?php

namespace ClearLagg\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;

class ClearLaggCommand extends Command {

    private Plugin $plugin;

    public function __construct(Plugin $plugin) {
        parent::__construct("clearlagg", "Clears all dropped items", "/clearlagg", []);
        $this->plugin = $plugin;
        $this->setPermission("clearlagg.use");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            return false;
        }
        $this->plugin->getClearLaggManager()->clearLagg();
        $sender->sendMessage("All dropped items have been cleared.");
        return true;
    }
}
