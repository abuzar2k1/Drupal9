<?php

namespace Drupal\custom_multistep_popup_form\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Component\Serialization\Json;

/**
 * Provides a button subscribe to newsletter.
 *
 * @Block(
 *   id = "custom_multistep_popup_form_subsribe_form_button",
 *   admin_label = @Translation("Multistep Popup Form"),
 * )
 */
class SubscribeFormButton extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {

    $link_url = Url::fromRoute('custom_multistep_popup_form.multistep_popup_form');
    
    $link_url->setOptions([
      'attributes' => [
        'class' => ['use-ajax', 'button', 'button--small'],
        'data-dialog-type' => 'modal',
        'data-dialog-options' => Json::encode(['width' => 400]),
      ]
    ]);

    return array(
      '#type' => 'markup',
      '#markup' => Link::fromTextAndUrl(t('Open modal'), $link_url)->toString(),
      '#attached' => ['library' => ['core/drupal.dialog.ajax']]
    );

  }

}