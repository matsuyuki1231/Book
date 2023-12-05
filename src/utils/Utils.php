<?php

declare(strict_types=1);

namespace matsuyuki\book\utils;

use pocketmine\console\ConsoleCommandSender;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\player\Player;
use pocketmine\Server;

class Utils {

    public static function playerToString(Player|ConsoleCommandSender|string &$player):void {
        if ($player instanceof Player or $player instanceof ConsoleCommandSender) {
            $player = $player->getName();
        }
    }

    public static function getPermission(bool $isOp):string {
        return $isOp ? "Book.Admin" : "Book.Everyone";
    }

}