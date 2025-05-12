<?php

/*
 * This file is part of
 *    ___ _              _
 *   / __| |___ __ _ _ _| |   __ _ __ _ __ _
 *  | (__| / -_) _` | '_| |__/ _` / _` / _` |
 *   \___|_\___\__,_|_| |____\__,_\__, \__, |
 *                                |___/|___/
 * @license GPL-3.0
 * @author KnosTx
 * @link https://github.com/KnosTx/ClearLagg
 * Copyright is protected by the Law of the country.
 *
 */

declare(strict_types=1);

namespace KnosTx\ClearLagg\manager;

use KnosTx\ClearLagg\Main;
use pocketmine\entity\object\ItemEntity;
use pocketmine\scheduler\ClosureTask;
use pocketmine\Server;
use function str_replace;

class ClearLaggManager{

	private Main $plugin;
	private int $clearInterval;
	private string $clearMessage;
	private int $broadcastInterval;
	private string $broadcastMessage;
	private int $timeRemaining;

	public function __construct(Main $plugin){
		$this->plugin = $plugin;
	}

	public function init() : void{
		$config = $this->plugin->getConfig();
		$this->clearInterval = $config->get("clear-interval", 300);
		$this->clearMessage = $config->get("clear-message", "§aItems cleared!");

		if($this->clearMessage === null || $this->clearMessage === "") {
			$this->clearMessage = "§aItems cleared!";
		}

		$this->broadcastInterval = $config->get("broadcast-interval", 150);
		$this->broadcastMessage = $config->get("broadcast-message", "§bThe items will be deleted in {time} seconds.");
		$this->timeRemaining = $config->getNested("notify-players.countdown", 300);

		$this->plugin->getScheduler()->scheduleRepeatingTask(new ClosureTask(function() : void{
			$this->onTick();
		}), 20);

		$this->plugin->getScheduler()->scheduleRepeatingTask(new ClosureTask(function() : void{
			$this->broadcastTime();
		}), $this->broadcastInterval * 20);
	}

	private function onTick() : void{
		if($this->timeRemaining <= 0){
			$this->clearItems();
			$this->timeRemaining = $this->clearInterval;
		}else{
			$this->timeRemaining--;
		}
	}

	public function clearItems() : void{
		$config = $this->plugin->getConfig();
		$this->clearMessage = $config->get("clear-message", "§aItems cleared!");
		foreach(Server::getInstance()->getWorldManager()->getWorlds() as $world){
			foreach($world->getEntities() as $entity){
				if($entity instanceof ItemEntity){
					$entity->flagForDespawn();
				}
			}
		}
		Server::getInstance()->broadcastMessage($this->clearMessage);
	}

	private function broadcastTime() : void{
		Server::getInstance()->broadcastMessage(str_replace("{time}", (string) $this->timeRemaining, $this->broadcastMessage));
	}
}
