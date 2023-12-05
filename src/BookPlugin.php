<?php

declare(strict_types=1);

namespace matsuyuki\book;

use matsuyuki\book\command\BookCommand;
use matsuyuki\book\command\PullBookCommand;
use matsuyuki\book\command\PushBookCommand;
use pocketmine\command\Command;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

class BookPlugin extends PluginBase {

    /** @var Listener[] */
    public array $listeners;
    /** @var Command[] */
    public array $commands;

    protected function onEnable():void {
        new BookReader($this);
        $this->commands = [
            new BookCommand(),
            new PullBookCommand(),
            new PushBookCommand()
        ];
        $this->listeners = [];
        $this->registerCommands();
        $this->registerListeners();
    }

    /** @internal */
    private function registerCommands():void {
        foreach ($this->commands as $command) {
            $this->getServer()->getCommandMap()->register($this->getName(), $command);
        }
    }

    /** @internal */
    private function registerListeners():void {
        foreach ($this->listeners as $listener) {
            $this->getServer()->getPluginManager()->registerEvents($listener, $this);
        }
    }

}
