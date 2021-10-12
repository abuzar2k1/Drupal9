<?php

namespace Drupal\drupalup_event_form_alter\EventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

class NodeArticleFormAlterEventSubscriber implements EventSubscriberInterface {

    public static function getSubscribedEvents() {
        $arr = [HookEventDispatcherInterface::FORM_ALTER => 'entityViewCallback'];
        return $arr;
    }

    public function entityViewCallback($event) {

        //kint($event->getFormId());
        //die;

        if($event->getFormId() == 'node_article_edit_form'){

            $form = $event->getForm();
            $form['special_markup'] =[
                '#type' => 'markup',
                '#markup' => '<b>Hook events form alter example</b>'
            ];
            $event->setForm($form);

        }
    }

}