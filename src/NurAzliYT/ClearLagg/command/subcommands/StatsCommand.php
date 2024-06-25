<?php

namespace NurAzliYT\ClearLagg\command\subcommands;

use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use NurAzliYT\ClearLagg\Main;

class StatsCommand {

    private $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender): void {
        $itemsCleared = $this->plugin->getStatsManager()->getItemsCleared();
        $sender->sendMessage(TextFormat::GREEN . "Total items cleared: " . $itemsCleared);
    }
}
