<?php

declare(strict_types=1);

namespace matsuyuki\book;

use pocketmine\utils\TextFormat;

class MessageFormat {

    public static function defaultMessage(string $message):string {
        return TextFormat::DARK_GRAY. ">>". TextFormat::GRAY. " ". $message;
    }

    public static function errorMessage(string $message):string {
        return TextFormat::DARK_RED. ">> ". $message;
    }

}
