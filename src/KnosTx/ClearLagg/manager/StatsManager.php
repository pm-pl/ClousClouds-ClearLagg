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

class StatsManager{

	public Main $plugin;
	private $itemsCleared;

	public function __construct(Main $plugin){
		$this->plugin = $plugin;
		$this->itemsCleared = 0;
	}

	public function incrementItemsCleared(int $count = 1) : void{
		$this->itemsCleared += $count;
	}

	public function getItemsCleared() : int{
		return $this->itemsCleared;
	}
}
