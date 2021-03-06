<?php

/**
 * @file
 * Definition of \Drupal\custom_ckeditor_plugin\Plugin\CKEditorPlugin\ColorButton.
 */

namespace Drupal\custom_ckeditor_plugin\Plugin\CKEditorPlugin;

use Drupal\ckeditor\CKEditorPluginInterface;
use Drupal\ckeditor\CKEditorPluginButtonsInterface;
use Drupal\Component\Plugin\PluginBase;
use Drupal\editor\Entity\Editor;

/**
 * Defines the "ColorButton" plugin.
 *
 * @CKEditorPlugin(
 *   id = "colorbutton",
 *   label = @Translation("ColorButton")
 * )
 */
class ColorButton extends PluginBase implements CKEditorPluginInterface, CKEditorPluginButtonsInterface {

  /**
   * Implements \Drupal\ckeditor\Plugin\CKEditorPluginInterface::getDependencies().
   */
  function getDependencies(Editor $editor) {
    return array('panelbutton');
  }

  // Note: Both buttons are using inline CSS styles to style the content, 
  //so they will work only in text formats where 
  //HTML Filter ("Limit allowed HTML tags") is not enabled

  /**
   * Implements \Drupal\ckeditor\Plugin\CKEditorPluginInterface::getLibraries().
   */
  function getLibraries(Editor $editor) {
    return array();
  }

  /**
   * Implements \Drupal\ckeditor\Plugin\CKEditorPluginInterface::isInternal().
   */
  function isInternal() {
    return FALSE;
  }

  /**
   * Implements \Drupal\ckeditor\Plugin\CKEditorPluginInterface::getFile().
   */
  function getFile() {
    return drupal_get_path('module', 'custom_ckeditor_plugin') . '/js/plugins/colorbutton/plugin.js';
  }

  /**
   * Implements \Drupal\ckeditor\Plugin\CKEditorPluginButtonsInterface::getButtons().
   */
  function getButtons() {
    return array(
      'TextColor' => array(
        'label' => t('Text Color'),
        'image' => drupal_get_path('module', 'custom_ckeditor_plugin') . '/js/plugins/colorbutton/icons/textcolor.png',
      ),
      'BGColor' => array(
        'label' => t('Background Color'),
        'image' => drupal_get_path('module', 'custom_ckeditor_plugin') . '/js/plugins/colorbutton/icons/bgcolor.png',
      )
    );
  }

  /**
   * Implements \Drupal\ckeditor\Plugin\CKEditorPluginInterface::getConfig().
   */
  public function getConfig(Editor $editor) {
    return array();
  }
}
