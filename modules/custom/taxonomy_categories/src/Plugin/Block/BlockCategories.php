<?php

/**
 * @file
 * Contains \Drupal\taxonomy_categories\Plugin\Block\BlockUser.
 */

namespace Drupal\taxonomy_categories\Plugin\Block;

use Drupal\Core\Block\BlockBase;/**
 * Loads taxonomy terms in a tree
 */
class TaxonomyTermTree {
  /**
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;
  /**
   * TaxonomyTermTree constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManager $entityTypeManager
   */
  public function __construct(EntityTypeManager $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }
  /**
   * Loads the tree of a vocabulary.
   *
   * @param string $vocabulary
   *   Machine name
   *
   * @return array
   */
  public function load($vocabulary) {
    $terms = $this->entityTypeManager->getStorage('taxonomy_term')->loadTree($vocabulary);
    $tree = [];
    foreach ($terms as $tree_object) {
      $this->buildTree($tree, $tree_object, $vocabulary);
    }
    return $tree;
  }
  /**
   * Populates a tree array given a taxonomy term tree object.
   *
   * @param $tree
   * @param $object
   * @param $vocabulary
   */
  protected function buildTree(&$tree, $object, $vocabulary) {
    if ($object->depth != 0) {
      return;
    }
    $tree[$object->tid] = $object;
    $tree[$object->tid]->children = [];
    $object_children = &$tree[$object->tid]->children;
    $children = $this->entityTypeManager->getStorage('taxonomy_term')->loadChildren($object->tid);
    if (!$children) {
      return;
    }
    $child_tree_objects = $this->entityTypeManager->getStorage('taxonomy_term')->loadTree($vocabulary, $object->tid);
    foreach ($children as $child) {
      foreach ($child_tree_objects as $child_tree_object) {
        if ($child_tree_object->tid == $child->id()) {
          $this->buildTree($object_children, $child_tree_object, $vocabulary);
        }
      }
    }
  }
}

/**
 * Provides a custom_block.
 *
 * @Block(
 *   id = "taxonomy_categories",
 *   admin_label = @Translation("Taxonomy Categories"),
 * )
 */
class BlockCategories extends BlockBase {

  public function load($vocabulary) {
    $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vocabulary);
    $tree = [];
    foreach ($terms as $tree_object) {
      $this->buildTree($tree, $tree_object, $vocabulary);
    }
    return $tree;
  }

  /**
   * Populates a tree array given a taxonomy term tree object.
   *
   * @param $tree
   * @param $object
   * @param $vocabulary
   */
  protected function buildTree(&$tree, $object, $vocabulary) {
    if ($object->depth != 0) {
      return;
    }
    $tree[$object->tid] = $object;
    $tree[$object->tid]->children = [];
    $object_children = &$tree[$object->tid]->children;
    $children = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadChildren($object->tid);
    if (!$children) {
      return;
    }
    $child_tree_objects = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vocabulary, $object->tid);
    foreach ($children as $child) {
      foreach ($child_tree_objects as $child_tree_object) {
        if ($child_tree_object->tid == $child->id()) {
          $this->buildTree($object_children, $child_tree_object, $vocabulary);
        }
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $rows = $this->load("Caterories");

    $build[] = [
      '#theme' => 'my_taxonomy_categories',
      '#rows' => $rows,
    ];

    return $build;

    }
  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

}