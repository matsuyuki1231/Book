<?php

namespace matsuyuki\book\form;

use matsuyuki\book\BookReader;
use matsuyuki\book\model\Book;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class SeeBookForm implements Form {

    public function __construct(private Book $book) {

    }

    public function handleResponse(Player $player, $data):void {
        if ($data === null) {
            return;
        }
        switch ($data) {
            case 0:
                $player->chat("/pullbook {$this->book->getId()} false");
                break;
            case 1:
                $player->chat("/pullbook {$this->book->getId()} true");
                break;
            case 2:
                $player->sendForm(new EditBookForm($this->book));
                break;
            case 3:
                $player->sendForm(new BookDeleteConfirmForm($this->book));
        }
    }

    public function jsonSerialize():array {
        return [
            "type" => "form",
            "title" => "book > pull > {$this->book->getId()}",
            "content" => TextFormat::GRAY. "タイトル: ". TextFormat::WHITE. $this->book->getTitle(). PHP_EOL.
                TextFormat::GRAY. "ID: ". TextFormat::WHITE. $this->book->getId(). PHP_EOL.
                TextFormat::GRAY. "公開: ". TextFormat::WHITE. ($this->book->isPublic() ? "はい" : "いいえ"). PHP_EOL.
                TextFormat::DARK_GRAY. "---". PHP_EOL.
                ($this->book->getContents()[0] ?? ""). (count($this->book->getContents()) >= 2 ? PHP_EOL. "(他 数ページ)" : ""),
            "buttons" => [["text" => "署名済みの本を取得する"], ["text" => "記入可能な本を取得する"], ["text" => "タイトル、IDを変更する"], ["text" => TextFormat::DARK_RED. "この本を削除する"]]
        ];
    }


}