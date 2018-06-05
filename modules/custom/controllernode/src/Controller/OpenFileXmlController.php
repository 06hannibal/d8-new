<?php

namespace Drupal\controllernode\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Class OpenFileXmlController
 * @package Drupal\controllernode\Controller
 */
class OpenFileXmlController extends ControllerBase {
  public function filexml() {

    $url = '/catalog.xml';
    $file = fopen(__DIR__ . $url, "r") or die("Unable to open file!");
    $xml = fread($file,filesize(__DIR__ . $url));

    $xmlelement=simplexml_load_string($xml) or die("Error: Cannot create object");

    $rows = [];
    $n = 0;
    $link = 'link';

    foreach ($xmlelement as $name) {
      $attributes = $name->attributes();

      if (!empty($attributes['id'])) {
        $uri = Link::fromTextAndUrl($link, Url::fromRoute('controllernode.xmlid',['id' => $attributes['id']]));
      } else {
        $uri = "";
      }

      $rows[] = [
        'N' => ++$n,
        'author' => $name->author,
        'title' => $name->title,
        'genre' => $name->genre,
        'price' => $name->price,
        'publish_date' => $name->publish_date,
        'description' => $name->description,
        'id' => $uri,
      ];
    }

    $header = [
      '№' => t('№'),
      'author' => t('author'),
      'title' => t('title'),
      'genre' => t('genre'),
      'price' => t('price'),
      'publish_date' => t('publish_date'),
      'description' => t('description'),
      'id' => t('uri'),
    ];

    $build['table_pager'][] = [
      '#header' => $header,
      '#type' => 'table',
      '#rows' => $rows,
      '#empty' => t('there is no record!=('),
    ];
    return $build;
  }
}