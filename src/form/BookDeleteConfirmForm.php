<?php

namespace matsuyuki\book\form;

use matsuyuki\book\BookReader;
use matsuyuki\book\model\Book;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class BookDeleteConfirmForm implements Form {

    public function __construct(private Book $book) {

    }

    public function handleResponse(Player $player, $data):void {
        if ($data === null) {
            return;
        }
        switch ($data) {
            case 0:
                BookReader::getInstance()->delete($player->getName(), $this->book->getId());
                $player->sendForm(new PullBookForm($player->getName(), TextFormat::GREEN. "削除しました"));
                break;
            case 1:
                $player->sendForm(new PullBookForm($player->getName(), TextFormat::RED. "削除を取り消しました"));
                break;
        }
    }

    public function jsonSerialize():array {
        return [
            "type" => "form",
            "title" => "book > pull > {$this->book->getId()}",
            "content" => "以下の本を削除します。よろしいですか？". PHP_EOL. TextFormat::GRAY. "タイトル: ". TextFormat::WHITE. $this->book->getTitle(). PHP_EOL.
                TextFormat::GRAY. "ID: ". TextFormat::WHITE. $this->book->getId(). PHP_EOL,
            "buttons" => [["text" => "はい (取り消せません)"], ["text" => "いいえ"]]
        ];
    }


}