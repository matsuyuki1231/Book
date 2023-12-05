<?php

namespace matsuyuki\book\form;

use matsuyuki\book\BookReader;
use matsuyuki\book\MessageFormat;
use matsuyuki\book\model\Book;
use pocketmine\form\Form;
use pocketmine\item\WritableBookBase;
use pocketmine\item\WritableBookPage;
use pocketmine\item\WrittenBook;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

readonly class PushBookForm implements Form {

    public function __construct(private WritableBookBase $book, private string $errorMessage = "") {

    }

    public function handleResponse(Player $player, $data):void {
        if ($data === null) {
            return;
        }
        if (!$data[4] and BookReader::getInstance()->exist($player->getName(), $data[2])) {
            $player->sendForm(new self($this->book, "ID ". $data[2]. " は、既に使用されています"));
            return;
        }
        BookReader::getInstance()->setBook($player->getName(), new Book($data[2], array_map(fn(WritableBookPage $page) => $page->getText(), $this->book->getPages()), $player->getName(), $data[1], $data[3]));
        $player->sendMessage(MessageFormat::defaultMessage($data[2]. " で本を保存しました"));
    }

    public function jsonSerialize():array {
        return [
            "type" => "custom_form",
            "title" => "book > push",
            "content" => [
                [
                    "type" => "label",
                    "text" => TextFormat::RED. $this->errorMessage,
                ],
                [
                    "type" => "input",
                    "text" => "本のタイトル",
                    "placeholder" => "タイトル...",
                    "default" => ($this->book instanceof WrittenBook) ? $this->book->getTitle() : ""
                ],
                [
                    "type" => "input",
                    "text" => "本のID (一意)",
                    "placeholder" => "ID...",
                    "default" => ($this->book instanceof WrittenBook) ? $this->book->getTitle() : ""
                ],
                [
                    "type" => "toggle",
                    "text" => "第三者がこの本をダウンロードできるようにする",
                    "default" => false
                ],
                [
                    "type" => "toggle",
                    "text" => "同じIDの本が既に存在していた場合、上書きする",
                    "default" => false
                ]
            ]
        ];
    }


}