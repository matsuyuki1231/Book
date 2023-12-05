<?php

declare(strict_types=1);

namespace matsuyuki\book;

use matsuyuki\book\model\Book;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;

class BookReader {
    use SingletonTrait;

    private Config $config;

    public function __construct(BookPlugin $main) {
        $this->config = new Config($main->getDataFolder(). "books.yml", Config::YAML, []);
        self::setInstance($this);
    }

    /** @return Book[] idをキーとする */
    public function getBooks(string $author):array {
        $author = strtolower($author);
        return array_map(fn(array $array) => Book::deserialize($array), $this->config->get($author, []));
    }

    public function getBook(string $author, string $id):?Book {
        $author = strtolower($author);
        $serializedBook = $this->config->get($author, [])[$id] ?? null;
        if ($serializedBook === null) {
            return null;
        }
        return Book::deserialize($serializedBook);
    }

    public function exist(string $author, string $id):bool {
        $author = strtolower($author);
        return isset($this->config->get($author, [])[$id]);
    }

    public function setBook(string $author, Book $book):void {
        $author = strtolower($author);
        $serializedBooks = $this->config->get($author, []);
        $serializedBooks[$book->getId()] = $book->serialize();
        $this->config->set($author, $serializedBooks);
        $this->config->save();
    }

    public function delete(string $author, string $id):void {
        $author = strtolower($author);
        if (!$this->exist($author, $id)) {
            return;
        }
        $serializedBooks = $this->config->get($author, []);
        unset($serializedBooks[$id]);
        $this->config->set($author, $serializedBooks);
        $this->config->save();
    }

}
