<?php

namespace Drupal\owl_carousel_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a twitter block block type.
 *
 * @Block(
 *   id = "owl_carousel_block",
 *   admin_label = @Translation("Owl Carousel Block"),
 * )
 */
class CarouselBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {

    $config = $this->getConfiguration();

    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('title'),
      '#default_value' => $config['title'],
      '#required' => TRUE,
    ];

    $form['image'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Image'),
    ];

    $form['image']['limit'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('number of images'),
      '#default_value' => $config['limit'],
      '#upload_location' => "public://images/",
      '#options' => ['' => $this->t('Auto')] + [array_combine(range(1, 5), range(1, 5))],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {

    $this->setConfigurationValue('title',$form_state->getValue('title'));
    foreach (['image'] as $fieldset) {
      $fieldset_values = $form_state->getValue($fieldset);
      foreach ($fieldset_values as $key => $value) {
        $this->setConfigurationValue($key, $value);
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $config = $this->getConfiguration();

    $render['block'] = [

    ];

  }

  public function getCacheMaxAge() {
    return 0;
  }
}