<?php

/**
 * @file
 * Definition of \Drupal\custom_ckeditor_plugin\Plugin\CKEditorPlugin\PanelButton.
 */

namespace Drupal\custom_ckeditor_plugin\Plugin\CKEditorPlugin;

use Drupal\ckeditor\CKEditorPluginInterface;
use Drupal\Component\Plugin\PluginBase;
use Drupal\editor\Entity\Editor;

/**
 * Defines the "PanelButton" plugin.
 *
 * @CKEditorPlugin(
 *   id = "panelbutton",
 *   label = @Translation("PanelButton")
 * )
 */
class PanelButton extends PluginBase implements CKEditorPluginInterface {

  /**
   * Implements \Drupal\ckeditor\Plugin\CKEditorPluginInterface::getDependencies().
   */
  function getDependencies(Editor $editor) {
    return array();
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
    return drupal_get_path('module', 'custom_ckeditor_plugin') . '/js/plugins/panelbutton/plugin.js';
  }

  /**
   * Implements \Drupal\ckeditor\Plugin\CKEditorPluginInterface::getConfig().
   */
  public function getConfig(Editor $editor) {
    return array();
  }
}
