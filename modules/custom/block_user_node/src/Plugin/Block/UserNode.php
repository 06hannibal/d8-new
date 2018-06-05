<?php

/**
 * @file
 * Contains \Drupal\block_user_node\Plugin\Block\UserNode.
 */

namespace Drupal\block_user_node\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a custom_block.
 *
 * @Block(
 *   id = "block_user_node",
 *   admin_label = @Translation("User Node"),
 *   category = @Translation("my custom first block")
 * )
 */
class UserNode extends BlockBase
{

  /**
   * {@inheritdoc}
   */
  public function build() {
    $querynode = \Drupal::entityQuery('node');
    $querynode->sort('nid', 'DESC');
    $querynode->condition('type', ['article', 'film', 'page'], 'IN');
    $querynode->range(0, 10);
    $ids = $querynode->execute();

    $list = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple($ids);

    $date_formatter = \Drupal::service('date.formatter');

    $username = \Drupal::currentUser()->getAccountName();
    $currdata = \Drupal::time()->getCurrentTime();
    $userdata = \Drupal::currentUser()->getLastAccessedTime();

    if (!empty($userdata)) {
      $userd = \Drupal::currentUser()->getLastAccessedTime();
    } else {
      $userd = \Drupal::time()->getCurrentTime();
    }

    $rows = array();
    $n = 0;

    foreach ($list as $node) {
      /*kint((html_entity_decode($node->body->value)));
      kint(html_entity_decode(strip_tags($node->body->value)));
      kint($node->body->value);
       die();*/
      $rows[] = array(
        'N' => ++$n,
        'title' => $node->getTitle(),
        'type' => $node->getType(),
        'body' => html_entity_decode(strip_tags($node->body->value)),
        'user' => $username,
        'login' => $date_formatter->format($currdata),
        'access' => $date_formatter->format($userd),
      );


      /*kint($title);
      die();*/
    }

    $header = array(
      '№' => t('№'),
      'title' => t('title'),
      'type' => t('type'),
      'body' => t('body'),
      'user' => t('user'),
      'login' => t('current time'),
      'access' => t('previous time'),
    );

    $build['table_pager'][] = array(
      '#theme' => 'block_user_node',
      '#header' => $header,
      '#type' => 'table',
      '#rows' => $rows,
      '#empty' => t('No users found!'),
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