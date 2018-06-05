<?php

/**
 * @file
 * Contains \Drupal\taxonomy_categories\Plugin\Block\BlockUser.
 */

namespace Drupal\taxonomy_categories\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a custom_block.
 *
 * @Block(
 *   id = "taxonomy_categories",
 *   admin_label = @Translation("Taxonomy Categories"),
 * )
 */
class BlockCategories extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $vid = 'caterories';
    $tree =\Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid,0,1,TRUE);

    $level_1_toyota = [];

    foreach ($tree as $term) {
      $level_1_toyota[] = $term->getName();

    }

    $tree_2 =\Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid,10,1,TRUE);

    $level_2_toyota = [];

    foreach ($tree_2 as $term_2) {
      $level_2_toyota[] = $term_2->getName();

    }

    $tree_3 =\Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid,39,1,TRUE);

    $level_3_toyota = [];

    foreach ($tree_3 as $term_3) {
      $level_3_toyota[] = $term_3->getName();

    }

    $tree_4 =\Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid,10,1,TRUE);

    $level_22_toyota = [];

    foreach ($tree_4 as $term_4) {
      $level_22_toyota[] = $term_4->getName();

    }

    $tree_5 =\Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid,42,1,TRUE);

    $level_32_toyota = [];

    foreach ($tree_5 as $term_5) {
      $level_32_toyota[] = $term_5->getName();

    }

    $tree_6 =\Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid,0,1,TRUE);

    $level_1_volkswagen = [];

    foreach ($tree_6 as $term_6) {
      $level_1_volkswagen[] = $term_6->getName();

    }

    $tree_7 =\Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid,8,1,TRUE);

    $level_2_volkswagen = [];

    foreach ($tree_7 as $term_7) {
      $level_2_volkswagen[] = $term_7->getName();

    }

    $tree_8 =\Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid,46,1,TRUE);

    $level_3_volkswagen = [];

    foreach ($tree_8 as $term_8) {
      $level_3_volkswagen[] = $term_8->getName();

    }

    $tree_9 =\Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid,8,1,TRUE);

    $level_22_volkswagen = [];

    foreach ($tree_9 as $term_9) {
      $level_22_volkswagen[] = $term_9->getName();

    }

    $tree_10 =\Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid,49,1,TRUE);

    $level_32_volkswagen = [];

    foreach ($tree_10 as $term_10) {
      $level_32_volkswagen[] = $term_10->getName();

    }

    $build[] = [
      '#theme' => 'my_taxonomy_categories',
      '#level_1_toyota' => $level_1_toyota[0],
      '#level_2_toyota' => $level_2_toyota[0],
      '#level_3_toyota' => $level_3_toyota,
      '#level_22_toyota' => $level_22_toyota[1],
      '#level_32_toyota' => $level_32_toyota,
      '#level_1_volkswagen' => $level_1_volkswagen[1],
      '#level_2_volkswagen' => $level_2_volkswagen[0],
      '#level_3_volkswagen' => $level_3_volkswagen,
      '#level_22_volkswagen' => $level_22_volkswagen[1],
      '#level_32_volkswagen' => $level_32_volkswagen,
    ];

    /*kint($rows[0]);
    die();*/

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

}