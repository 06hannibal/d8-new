<?php

namespace Drupal\controllernode\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Provides route responses for the Example module.
 */
class MyNodeController extends ControllerBase {
  public function mynode() {
    $query = \Drupal::database()->select('node_field_data', 'nfd');
    $query->Join('node__body', 'nb', 'nfd.nid = nb.entity_id');
    $query->leftJoin('node__field_image', 'nfi', 'nfd.nid = nfi.entity_id');
    $query->leftJoin('file_managed', 'fm', 'fm.fid = nfi.field_image_target_id');
    $query->fields('nfd', ['title', 'type', 'created', 'changed']);
    $query->fields('nb', ['body_value']);
    $query->orderBy('nfd.created', 'DESC');
    $query->range(0, 10);
    $query->fields('fm', ['uri']);
    /*$query->condition('nfd.type', 'article');*/

    $end = $query->execute()->fetchAll();

    $row = array();
    /*$row2 = '';*/
    $n = 0;
    $image = 'image';
    $date_formatter = \Drupal::service('date.formatter');

    foreach ($end as $output) {

      if (!empty($output->uri)) {
        $url = file_create_url($output->uri);
        $uri = Link::fromTextAndUrl($image, Url::fromUri($url));
      } else {
        $uri = "";
      }

      /*var_dump($output->uri);*/
      $row[] = array(
        'N' => ++$n,
        'title' => $output->title,
        'type' => $output->type,
        'created' => $date_formatter->format($output->created),
        'changed' => $date_formatter->format($output->changed),
        'node__body' => html_entity_decode(strip_tags($output->body_value)),
        'uri' => $uri,
      );
    }

    /*$row2 .= ' ' . $output->title;*/
    $head = array(
      '№' => t('№'),
      'title' => t('title'),
      'type' => t('type'),
      'created' => t('created'),
      'changed' => t('changed'),
      'node__body' => t('node__body'),
      'uri' => t('uri'),
    );

    $build['table_pager'][] = array(
      '#header' => $head,
      '#type' => 'table',
      '#rows' => $row,
      '#empty' => t('there is no record!=('),
    );

    return $build;
  }
}