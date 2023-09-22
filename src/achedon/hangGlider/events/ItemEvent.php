<?php

namespace achedon\hangGlider\events;

use achedon\hangGlider\Main;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\StringToItemParser;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;

class ItemEvent implements Listener
{

    public function onHand(PlayerItemHeldEvent $event)
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $hangGliderConfig = Main::getInstance()->getConfig()->get("item");
        $hangGlider = StringToItemParser::getInstance()->parse($hangGliderConfig);
        if (is_null($hangGlider)) {
            $hangGlider = VanillaItems::SLIMEBALL();
        }
        if ($item->getName() === $hangGlider->getName()) {
            $player->getEffects()->add(new EffectInstance(VanillaEffects::LEVITATION(), 999999, 1, false));
        } else {
            if (!empty($player->getEffects()->has(VanillaEffects::LEVITATION()))) {
                $player->getEffects()->remove(VanillaEffects::LEVITATION());
            }
        }
    }

    public function onFallDamage(EntityDamageEvent $event)
    {

        $entity = $event->getEntity();
        $cause = $event->getCause();
        if ($entity instanceof Player) {
            $player = $entity;
            if ($cause === EntityDamageEvent::CAUSE_FALL) {
                $hangGliderConfig = Main::getInstance()->getConfig()->get("item");
                $hangGlider = StringToItemParser::getInstance()->parse($hangGliderConfig);
                if (is_null($hangGlider)) {
                    $hangGlider = VanillaItems::SLIMEBALL();
                }
                if ($player->getInventory()->getItemInHand()->getName() === $hangGlider->getName()) {
                    $event->cancel();
                }
            }
        }
    }

    public function onQuit(PlayerQuitEvent $event)
    {
        $player = $event->getPlayer();
        if ($player->getEffects()->has(VanillaEffects::LEVITATION())) {
            $player->getEffects()->remove(VanillaEffects::LEVITATION());
        }
    }
}