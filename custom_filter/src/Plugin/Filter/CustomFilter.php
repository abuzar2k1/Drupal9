<?php

namespace Drupal\custom_filter\Plugin\Filter;

use Drupal\filter\Plugin\FilterBase;
use Drupal\filter\FilterProcessResult;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'example_field_formatter' formatter.
 *
 * @Filter(
 *   id = "custom_filter",
 *   title = @Translation("Custom Filter"),
 *   description = @Translation("Replace token to link on ckeditor"),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 * )
 */

 class CustomFilter extends FilterBase {

   /**
   * {@inheritdoc}
   */

    public function process($text, $langcode) {
        
        $replace = '<span class="custom_class_filter"><a href="/abc">Custom Page Link</a></span>';
        $new_text = str_replace( '[abuzarfilter]', $replace, $text );
        $result = new FilterProcessResult($new_text);

        if($this->settings['customfilter_attach_library'] ?? NULL){
            $result->setAttachments(array(
                'library' => array('custom_filter/filter_library'),  // Attaching library (css)
            ));
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */

    public function settingsForm(array $form, FormStateInterface $form_state) {

        $form['customfilter_attach_library'] = [
            '#type' => 'checkbox',
            '#title' => $this->t('Attach Library'),
            '#default_value' => $this->settings['customfilter_attach_library'],
            '#description' => $this->t('Show link in animated gradient color.'),
        ];

        return $form;

    }

 }