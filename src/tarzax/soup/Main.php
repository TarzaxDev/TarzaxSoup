<?php

namespace tarzax\soup;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\item\ItemFactory;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener{

    public function onEnable(): void
    {
        $this->getLogger()->notice("TarzaxSoup has been successfully activated");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->getResource("config.yml");
    }

    public function OnInteract(PlayerItemUseEvent $event)
    {
        $player = $event->getPlayer();
        if ($player->getInventory()->getItemInHand()->getId() == $this->getConfig()->get("SoupID")) {
            if ($player->getHealth() == $player->getMaxHealth()) {
                $event->cancel();
            } else {
                $item = $event->getItem();
                $player->setHealth($player->getHealth() + $this->getConfig()->get("SoupHEALTH"));
                $player->getInventory()->setItemInHand(ItemFactory::getInstance()->get($item->getId(), 0, $item->getCount() -1));
                $player->sendPopup($this->getConfig()->get("PopupUse"));
            }
        }
    }
}
