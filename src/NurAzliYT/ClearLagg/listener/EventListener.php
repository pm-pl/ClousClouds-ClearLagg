<?php

namespace NurAzliYT\ClearLagg\listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\entity\EntitySpawnEvent;
use pocketmine\event\entity\EntityDespawnEvent;
use NurAzliYT\ClearLagg\Main;

class EventListener implements Listener {

    /** @var Main */
    private Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    /**
     * Called when a player joins the server.
     * @param PlayerJoinEvent $event
     */
    public function onPlayerJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $player->sendMessage("Welcome to the server! ClearLagg is active to keep the server lag-free.");
    }

    /**
     * Called when a player quits the server.
     * @param PlayerQuitEvent $event
     */
    public function onPlayerQuit(PlayerQuitEvent $event): void {
        $player = $event->getPlayer();
        // Additional actions can be added here if needed
    }

    /**
     * Called when an entity spawns in the world.
     * @param EntitySpawnEvent $event
     */
    public function onEntitySpawn(EntitySpawnEvent $event): void {
        $entity = $event->getEntity();
        // Log entity spawn for debugging purposes, can be disabled in production
        $this->plugin->getLogger()->debug("Entity spawned: " . $entity->getNetworkTypeId());
    }

    /**
     * Called when an entity despawns in the world.
     * @param EntityDespawnEvent $event)
     */
    public function onEntityDespawn(EntityDespawnEvent $event): void {
        $entity = $event->getEntity();
        // Log entity despawn for debugging purposes, can be disabled in production
        $this->plugin->getLogger()->debug("Entity despawned: " . $entity->getNetworkTypeId());
    }
}
