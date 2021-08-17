<?php

namespace ash\HangGlider;

use ash\HangGlider\Events\ItemEvent;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{

    /**@var $db Config */
    public $db;
    /** @vr main $instance*/
    private static $instance;

    public function onLoad()
    {
        self::$instance = $this;
        @mkdir($this->getDataFolder());

        $this->saveResource("config.yml");

        $this->db = new Config($this->getDataFolder() . "config.yml" . Config::YAML);

        $db = Main::config();
        if($db->get("version") != "v1.0"){
            $this->getLogger()->alert("Please set 'v1.0' in config.yml ");
            $this->getServer()->getPluginManager()->disablePlugin($this);
        }
    }

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents(new ItemEvent(),$this);
    }

    public static function config()
    {
        return new Config(self::$instance->getDataFolder() . "config.yml", Config::YAML);
    }

    public static function getInstance()
    {
        return self::$instance;
    }

}