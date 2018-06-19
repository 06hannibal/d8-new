<?php

namespace Drupal\owl_carousel_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\Core\Url;
use Drupal\image\Entity\ImageStyle;

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

    $form['image'] = [
      '#type' => 'managed_file',
      '#upload_location' => 'public://images',
      '#title' => t('Image'),
      /*'#upload_validators' => [
        'file_validate_extensions' => ['jpg', 'jpeg', 'png', 'gif']
      ],*/
      '#default_value' => isset($this->configuration['image']) ? $this->configuration['image'] : '',
      '#description' => t('The image to display'),
      '#multiple' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {

    $image = $form_state->getValue('image');

    if (isset($this->configration['image']) && $image != $this->configuration['image']) {

      if (!empty($image[0])) {
        $file = File::load($image[0]);
        $file->setPermanent();
        $file->save();
      }
    }

    $this->setConfigurationValue('image', $form_state->getValue('image'));
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $image = $this->configuration['image'];

    if (!empty($image)) {
      if ($file = File::loadMultiple($image)) {

        foreach ($file as $key => $value) {
          $urls[$key] = file_create_url($value->getFileUri());
        }
        $build[] = [
          '#theme' => 'owl_carousel_block',
          '#urls' => $urls,
        ];
      }
    }

    $build['#attached']['library'][] = 'owl_carousel_block/owl_carousel_block';

    return $build;

  }

  public function getCacheMaxAge() {
    return 0;
  }
}