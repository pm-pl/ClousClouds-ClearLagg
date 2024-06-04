<?php

namespace ClearLagg\listener;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntitySpawnEvent;
use pocketmine\entity\object\ItemEntity;
use ClearLagg\Main;

class EventListener implements Listener {

    private Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function onEntitySpawn(EntitySpawnEvent $event): void {
        $entity = $event->getEntity();
        if ($entity instanceof ItemEntity) {
        }
    }
}
