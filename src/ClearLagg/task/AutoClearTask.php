<?php

namespace ClearLagg\task;

use ClearLagg\Main;
use pocketmine\scheduler\Task;
use pocketmine\player\Player;

class AutoClearTask extends Task {

    private Main $plugin;
    private int $countdown;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
        $this->countdown = $plugin->getConfig()->getNested("notify-players.countdown", 60);
    }

    public function onRun(): void {
        $config = $this->plugin->getConfig();

        if ($config->getNested("notify-players.enable", true) && $this->countdown > 0) {
            foreach ($this->plugin->getServer()->getOnlinePlayers() as $player) {
                $player->sendMessage($config->getNested("notify-players.message"));
            }
            $this->countdown--;
        } else {
            // Clear items in all worlds
            $this->plugin->getClearLaggManager()->clearLagg();
            $this->countdown = $config->getNested("notify-players.countdown", 60);
        }
    }
}
