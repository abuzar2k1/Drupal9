<?php

namespace Drupal\mymodule_hook_events\EventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

class EntityViewSubscriber implements EventSubscriberInterface {

    public static function getSubscribedEvents() {

            $arr = [HookEventDispatcherInterface::ENTITY_VIEW => 'entityViewCallback'];
            return $arr;

    }

    public function entityViewCallback($event){

        $build = $event->getBuild();

        $build['new_renderable'] = [
            '#type' => 'markup',
            '#markup' => 'Hello hook events subscriber'
        ];

        $event->setBuild($build);

        //kint($event->getBuild());
        //die;
    }

}