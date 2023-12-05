<?php

declare(strict_types=1);

namespace matsuyuki\book\model;

use pocketmine\item\VanillaItems;
use pocketmine\item\WritableBook;
use pocketmine\item\WritableBookPage;
use pocketmine\item\WrittenBook;

class Book {

    /**
     * @param string $id
     * @param string[] $contents
     * @param string $author
     * @param string $title
     * @param bool $public
     */
    public function __construct(private string $id, private array $contents, private string $author, private string $title, private bool $public) {

    }

    public function getId():string {
        return $this->id;
    }

    public function setId(string $id):self {
        $this->id = $id;
        return $this;
    }

    public function getContents():array {
        return $this->contents;
    }

    public function setContents(array $contents):self {
        $this->contents = $contents;
        return $this;
    }

    public function getAuthor():string {
        return $this->author;
    }

    public function setAuthor(string $author):self {
        $this->author = $author;
        return $this;
    }

    public function getTitle():string {
        return $this->title;
    }

    public function setTitle(string $title):self {
        $this->title = $title;
        return $this;
    }

    public function isPublic():bool {
        return $this->public;
    }

    public function setPublic(bool $public):self {
        $this->public = $public;
        return $this;
    }

    public function getBookAsItem(bool $writable):WrittenBook|WritableBook {
        /** @var WrittenBook|WritableBook $book */
        $book = $writable ? VanillaItems::WRITABLE_BOOK() : VanillaItems::WRITTEN_BOOK();
        $book->setPages(array_map(fn(string $context) => new WritableBookPage($context), $this->contents));
        if ($book instanceof WrittenBook) {
            $book->setTitle($this->title);
            $book->setAuthor($this->author);
        }
        return $book;
    }

    public function serialize():array {
        return [
            "id" => $this->id,
            "contents" => $this->contents,
            "author" => $this->author,
            "title" => $this->title,
            "public" => $this->public
        ];
    }

    public static function deserialize(array $array):self {
        return new self($array["id"], $array["contents"], $array["author"], $array["title"], $array["public"]);
    }

    public function __debugInfo():?array {
        return $this->serialize();
    }

}