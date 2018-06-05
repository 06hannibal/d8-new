<?php

/**
 * @file
 * Contains \Drupal\blockuser\Plugin\Block\BlockUser.
 */

namespace Drupal\blockuser\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a custom_block.
 *
 * @Block(
 *   id = "blockuser",
 *   admin_label = @Translation("Block User"),
 *   category = @Translation("my custom first block")
 * )
 */
class BlockUser extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $query = \Drupal::database()->select('users_field_data', 'nfd');
    $query->fields('nfd', ['name', 'access', 'login']);
    $query->condition('status', 1);

    $userinfo = $query->execute()->fetchAll();

    $rows = array();
    $date_formatter = \Drupal::service('date.formatter');

    foreach ($userinfo as $user) {
      $rows[] = array(
        'name' => $user->name,
        'login' => $date_formatter->format($user->login),
        'access' => $date_formatter->format($user->access),
      );
    }

    $header = array(
      'name' => t('name'),
      'login' => t('current time'),
      'access' => t('previous time'),
    );

    $build[][] = array(
      '#theme' => 'myplugin',
      '#header' => $header,
      '#type' => 'table',
      '#rows' => $rows,
      '#empty' => t('there is no record!=('),
    );
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge()
  {
    return 0;
  }
}
