<?php

declare(strict_types=1);

namespace TestDatabaseAPI;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use SubUrbanCradles\DatabaseAPI;

class Main extends PluginBase implements Listener {

    public $path;

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this); /*Just register events (for PlayerJoinEvent)*/

        $this->path = $this->getDataFolder(); /*Database File address (plugin_data)*/

        if (!is_dir($this->path . 'PlayersData')) { /*Make a folder for players database*/
            mkdir($this->path . 'PlayersData');
        }

        DatabaseAPI::setData($this->path, 'Worlds', 'AllWorlds', [], true);/*Add an empty data in Worlds.yml*/

        DatabaseAPI::removeData($this->path, 'Worlds', 'AllWorlds', 'hub', true);

        foreach ($this->getServer()->getLevels() as $level) {/*Add all your map names to Worlds.yml*/
            DatabaseAPI::addData($this->path, 'Worlds', 'AllWorldsss', $level->getFolderName(), true);
        }

    }

    public function onPlayerJoin (PlayerJoinEvent $event) {
        $player = $event->getPlayer();/*Getting player obj*/
        $name = $player->getName();/*Getting player name*/
        $HP = $player->getHealth(); /*Getting player health*/
        DatabaseAPI::setData($this->path . 'PlayersData', $name, 'Health', $HP, true); /*Create database with player name, when player join to your server*/
    }
}
