<?php

namespace matsuyuki\book\form;

use matsuyuki\book\BookReader;
use matsuyuki\book\model\Book;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

readonly class PullBookForm implements Form {

    /** @var Book[] $books */
    private array $books;

    public function __construct(string $author, private ?string $message = null) {
        $this->books = array_values(BookReader::getInstance()->getBooks($author));
    }

    public function handleResponse(Player $player, $data):void {
        if ($data === null) {
            return;
        }
        if (!isset($this->books[$data])) {
            $player->sendForm(new BookHomeForm());
            return;
        }
        $player->sendForm(new SeeBookForm($this->books[$data]));
    }

    public function jsonSerialize():array {
        return [
            "type" => "form",
            "title" => "book > pull",
            "content" => ($this->message !== null ? $this->message. TextFormat::RESET. PHP_EOL : ""). "あなた自身の保存した本の一覧",
            "buttons" => array_merge(array_map(fn(Book $book) => ["text" => $book->getTitle(). TextFormat::DARK_GRAY. " (". $book->getId(). TextFormat::RESET. TextFormat::DARK_GRAY. ") ". ($book->isPublic() ? TextFormat::DARK_GREEN. "公開" : TextFormat::DARK_RED. "非公開"). PHP_EOL. TextFormat::GRAY. ($book->getContents()[0] ?? "")], $this->books), [["text" => "戻る"]])
        ];
    }

}