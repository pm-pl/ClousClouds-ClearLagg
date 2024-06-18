<?php

namespace NurAzliYT\ClearLagg\manager;

use pocketmine\utils\Config;
use NurAzliYT\ClearLagg\Main;

class ConfigManager {

    private Main $plugin;
    private Config $config;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
        $this->plugin->saveDefaultConfig();
        $this->config = $this->plugin->getConfig();
    }

    public function getConfig(): Config {
        return $this->config;
    }
}
