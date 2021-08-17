<?php

namespace ash\HangGlider\Events;

use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Player;

class ItemEvent implements Listener{

    public function onHand(PlayerItemHeldEvent $event){
        $player = $event->getPlayer();
        $item = $event->getItem();
        if($item->getId() === 341){
            $player->addEffect(new EffectInstance(Effect::getEffect(Effect::LEVITATION),123456789,-4,false));

        }else{
            if(!empty($player->getEffect(Effect::LEVITATION))){
                $player->removeEffect(24);
            }
        }
    }

    public function onFallDamage(EntityDamageEvent $event){

        $entity = $event->getEntity();
        $cause = $event->getCause();
        if($entity instanceof Player){
            $player = $entity;
            if($cause === EntityDamageEvent::CAUSE_FALL){
                if($player->getInventory()->getItemInHand()->getId() === 341){
                    $event->setCancelled(true);
                }
            }
        }
    }

    public function onQuit(PlayerQuitEvent $event){
        $player = $event->getPlayer();
        if($player->hasEffect(24)){
            $player->removeEffect(24);
        }
    }
}