<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\NetworkSession;

class ActorPickRequestPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::ACTOR_PICK_REQUEST_PACKET;

	/** @var int */
	public $entityUniqueId;
	/** @var int */
	public $hotbarSlot;
	/** @var bool */
	public $addUserData = false;

	protected function decodePayload(){
		$this->entityUniqueId = $this->getLLong();
		$this->hotbarSlot = $this->getByte();
		if($this->protocol >= BedrockProtocolInfo::PROTOCOL_1_17_30){
			$this->addUserData = $in->getBool();
		}
	}

	protected function encodePayload(){
		$this->putLLong($this->entityUniqueId);
		$this->putByte($this->hotbarSlot);
		if($this->protocol >= BedrockProtocolInfo::PROTOCOL_1_17_30){
			$out->putBool($this->addUserData);
		}
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleActorPickRequest($this);
	}
}
