<?php

namespace matsuyuki\book\form;

use pocketmine\form\Form;
use pocketmine\player\Player;

class BookHomeForm implements Form {

    public function handleResponse(Player $player, $data):void {
        if ($data === null) {
            return;
        }
        switch ($data) {
            case 0:
                $player->chat("/pullbook");
                break;
            case 1:
                $player->chat("/pushbook");
                break;
        }
    }

    public function jsonSerialize():array {
        return [
            "type" => "form",
            "title" => "book",
            "content" => "",
            "buttons" => [["text" => "保存した本の一覧を見る"], ["text" => "手に持っている本をアップロードする"]]
        ];
    }

}