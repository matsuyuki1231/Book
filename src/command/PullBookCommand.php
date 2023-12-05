<?php

namespace matsuyuki\book\command;

use matsuyuki\book\BookReader;
use matsuyuki\book\MessageFormat;
use matsuyuki\book\utils\Utils;
use matsuyuki\book\form\PullBookForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class PullBookCommand extends Command {

    public const HOW_TO_USE = "/pullbook <id: string> [writeAble|userName: boolean|string]";

    public function __construct() {
        parent::__construct("pullbook", "本を取得します", self::HOW_TO_USE, ["pb"]);
        $this->setPermission(Utils::getPermission(true));
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if (!$sender instanceof Player) {
            $sender->sendMessage(MessageFormat::errorMessage("コンソールからは実行できません"));
            return;
        }
        if (count($args) === 0) {
            $sender->sendForm(new PullBookForm($sender->getName()));
            return;
        }
        $id = $args[0];
        if (!isset($args[1]) or in_array(strtolower($args[1]), ["false", "f", "no", "n", "いいえ"], true)) {
            $writable = false;
            $author = null;
        } elseif (in_array(strtolower($args[1]), ["true", "t", "yes", "y", "はい"], true)) {
            $writable = true;
            $author = null;
        } else {
            $writable = false;
            $author = strtolower($args[1]);
            if ($author === $sender->getName()) {
                $author = null;
            }
        }
        $book = BookReader::getInstance()->getBook($author ?? $sender->getName(), $id);
        if ($book === null) {
            $sender->sendMessage(MessageFormat::errorMessage("指定した本 $id は存在しません"));
            return;
        }
        if ($author !== null and !$book->isPublic()) {
            $sender->sendMessage(MessageFormat::errorMessage("指定した本 $id は公開された本ではありません"));
            return;
        }
        $sender->getInventory()->addItem($book->getBookAsItem($writable));
        $sender->sendMessage(MessageFormat::defaultMessage(($author !== null ? "$author の本 ": ""). "$id を入手しました"));
    }

}