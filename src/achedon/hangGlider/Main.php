<?php

namespace achedon\hangGlider;

use achedon\hangGlider\events\ItemEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;

class Main extends PluginBase
{

    use SingletonTrait;


    protected function onLoad(): void
    {
        self::setInstance($this);
    }


    protected function onEnable(): void
    {
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents(new ItemEvent(), $this);
    }

    public function getConfig(): Config
    {
        return new Config($this->getDataFolder() . "config.yml", Config::YAML);
    }

}