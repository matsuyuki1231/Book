<?php

namespace matsuyuki\book\form;

use matsuyuki\book\BookReader;
use matsuyuki\book\model\Book;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class EditBookForm implements Form {

    public function __construct(private Book $book, private string $errorMessage = "") {

    }

    public function handleResponse(Player $player, $data):void {
        if ($data === null) {
            return;
        }
        $isSameId = $this->book->getId() === $data[2];
        if ($isSameId and $data[4]) {
            $player->sendForm(new self($this->book, "コピーを保存する場合はIDを変更してください"));
            return;
        }
        $newBook = clone $this->book;
        if (!$isSameId and !$data[4]) {
            BookReader::getInstance()->delete($player->getName(), $this->book->getId());
        }
        BookReader::getInstance()->setBook($player->getName(), $newBook->setTitle($data[1])->setId($data[2])->setPublic($data[3]));
        $player->sendForm(new PullBookForm($player->getName(), TextFormat::GREEN. "本を編集しました"));
    }

    public function jsonSerialize():array {
        return [
            "type" => "custom_form",
            "title" => "book > pull > {$this->book->getId()} > edit",
            "content" => [
                [
                    "type" => "label",
                    "text" => TextFormat::RED. $this->errorMessage,
                ],
                [
                    "type" => "input",
                    "text" => "本のタイトル",
                    "placeholder" => "タイトル...",
                    "default" => $this->book->getTitle()
                ],
                [
                    "type" => "input",
                    "text" => "本のID (一意)",
                    "placeholder" => "ID...",
                    "default" => $this->book->getId()
                ],
                [
                    "type" => "toggle",
                    "text" => "第三者がこの本をダウンロードできるようにする",
                    "default" => $this->book->isPublic()
                ],
                [
                    "type" => "toggle",
                    "text" => "コピーを保存する",
                    "default" => $this->book->isPublic()
                ]
            ]
        ];
    }


}