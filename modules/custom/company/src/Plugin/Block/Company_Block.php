<?php


namespace Drupal\company\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a custom_block.
 *
 * @Block(
 *   id = "company",
 *   admin_label = @Translation("Company Block"),
 *   category = @Translation("my custom first block")
 * )
 */
class Company_Block extends BlockBase {

  /**
   * @return array
   */
  public function build() {

    $keys = [
      'name',
      'number',
    ];

    $output = \Drupal::state()->getMultiple($keys);

   /* kint($output['number']);
    die();*/

    /*kint($output);
      die();*/

    $build[] = [
      '#theme' => 'company',
      '#output' => [
        'name'=>$output['name'],
        'number'=>$output['number'],
      ],
    ];

    return $build;
  }

  /**
   * @return int
   */
  public function getCacheMaxAge() {
    return 0;
  }
}