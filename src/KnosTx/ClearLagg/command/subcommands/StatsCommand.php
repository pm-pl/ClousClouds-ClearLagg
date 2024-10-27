<?php

namespace KnosTx\ClearLagg\command\subcommands;

use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use KnosTx\ClearLagg\Main;

class StatsCommand {

    private $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender): bool {
        try {
            $statsManager = $this->plugin->getStatsManager();
            if ($statsManager === null) {
                $sender->sendMessage(TextFormat::RED . "Stats manager is not initialized.");
                return false;
            }

            $itemsCleared = $statsManager->getItemsCleared();
            $sender->sendMessage(TextFormat::GREEN . "Total items cleared: " . TextFormat::YELLOW . $itemsCleared);
        } catch (\Exception $e) {
            $sender->sendMessage(TextFormat::RED . "An error occurred: " . $e->getMessage());
            $this->plugin->getLogger()->error("Error in StatsCommand: " . $e->getMessage(), $e);
            return false;
        }

        return true;
    }
}
