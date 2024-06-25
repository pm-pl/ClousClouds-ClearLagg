<?php

namespace NurAzliYT\ClearLagg\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use NurAzliYT\ClearLagg\Main;

class ClearLaggCommand extends Command {

    private $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("clearlagg", "Clears dropped items", "/clearlagg [stats]", ["cl"]);
        $this->setPermission("clearlagg.command");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            return false;
        }

        if (count($args) > 0 && strtolower($args[0]) === "stats") {
            $sender->sendMessage(TextFormat::GREEN . "Total items cleared: " . $this->plugin->getStatsManager()->getItemsCleared());
        } else {
            $this->plugin->getClearLaggManager()->clearItems();
            $sender->sendMessage(TextFormat::GREEN . "Items cleared!");
        }
        return true;
    }
}
