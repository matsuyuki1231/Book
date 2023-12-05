<?php

namespace matsuyuki\book\command;

use matsuyuki\book\form\PushBookForm;
use matsuyuki\book\MessageFormat;
use matsuyuki\book\utils\Utils;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\WritableBookBase;
use pocketmine\player\Player;

class PushBookCommand extends Command {

    public const HOW_TO_USE = "/pushbook";

    public function __construct() {
        parent::__construct("pushbook", "本をアップロードします", self::HOW_TO_USE);
        $this->setPermission(Utils::getPermission(true));
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if (!$sender instanceof Player) {
            $sender->sendMessage(MessageFormat::errorMessage("コンソールからは実行できません"));
            return;
        }
        $itemInHand = $sender->getInventory()->getItemInHand();
        if (!$itemInHand instanceof WritableBookBase) {
            $sender->sendMessage(MessageFormat::errorMessage("手に本を持って実行してください"));
            return;
        }
        $sender->sendForm(new PushBookForm($itemInHand));
    }

}