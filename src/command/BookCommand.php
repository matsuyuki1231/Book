<?php

namespace matsuyuki\book\command;

use matsuyuki\book\MessageFormat;
use matsuyuki\book\utils\Utils;
use matsuyuki\book\form\BookHomeForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class BookCommand extends Command {

    public const HOW_TO_USE = "/book";

    public function __construct() {
        parent::__construct("book", "自身の本を管理します", self::HOW_TO_USE);
        $this->setPermission(Utils::getPermission(true));
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if (!$sender instanceof Player) {
            $sender->sendMessage(MessageFormat::errorMessage("コンソールからは実行できません"));
            return;
        }
        $sender->sendForm(new BookHomeForm());
    }

}