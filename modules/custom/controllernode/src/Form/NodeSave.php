<?php

namespace Drupal\controllernode\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\user\Entity\User;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\CssCommand;
/*use Drupal\Core\Ajax\RedirectCommand;*/
/*use Drupal\Core\Ajax\RemoveCommand;*/
/*use Drupal\Core\Ajax\PrependCommand;
use Drupal\Core\Ajax\InsertCommand;*/



/**
 *  form.
 */
class NodeSave extends FormBase {

  /**
   * @return string
   */
  public function getFormId() {
    return 'id';
  }

  /**
   * @param array $form
   * @param FormStateInterface $form_state
   * @return array|void
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $url = '/catalog.xml';
    $file = fopen(__DIR__ . $url, "r") or die("Unable to open file!");
    $xml = fread($file,filesize(__DIR__ . $url));

    $xml_element=simplexml_load_string($xml) or die("Error: Cannot create object");

    $xml_rows = [];

    $id = \Drupal::request()->query->get('id');

    foreach ($xml_element as $xml_id) {
      $attributes = $xml_id->attributes()['id'];

      if($id==$attributes) {
        $xml_rows['id'] = [
          'author' => $xml_id->author,
          'title' => $xml_id->title,
          'genre' => $xml_id->genre,
          'price' => $xml_id->price,
          'publish_date' => $xml_id->publish_date,
          'description' => $xml_id->description,
        ];
      }
    }

    $header_xml = [
      'author' => t('author'),
      'title' => t('title'),
      'genre' => t('genre'),
      'price' => t('price'),
      'publish_date' => t('publish_date'),
      'description' => t('description'),
    ];

    $form['table_pager'] = [
      '#header' => $header_xml,
      '#type' => 'table',
      '#rows' => $xml_rows,
      '#empty' => t('there is no record!=('),
    ];

    $form['system_messages'] = [
      '#markup' => '<div id="form-system-messages"></div>',
      '#weight' => -100,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('save'),
      '#ajax' => [
        'callback' => '::saveNode',
        'event' => 'click',
        'progress' => [
          'type' => 'throbber',
          ],
        ],
    ];

    return $form;
  }

  /**
   * @return AjaxResponse
   */
  public function saveNode() {

    $url = '/catalog.xml';
    $file = fopen(__DIR__ . $url, "r") or die("Unable to open file!");
    $xml = fread($file,filesize(__DIR__ . $url));

    $xml_element=simplexml_load_string($xml) or die("Error: Cannot create object");

    $xml_rows = [];

    $id = \Drupal::request()->query->get('id');

    foreach ($xml_element as $xml_id) {
      $attributes = $xml_id->attributes()['id'];

      if($id==$attributes) {
        $xml_rows['id'] = [
          'author' => $xml_id->author,
          'title' => $xml_id->title,
          'genre' => $xml_id->genre,
          'price' => $xml_id->price,
          'publish_date' => $xml_id->publish_date,
          'description' => $xml_id->description,
        ];
      }
    }

    $query = \Drupal::database()->select('users_field_data', 'u');
    $is_user = $query
      ->condition('u.name', $xml_rows['id']['author'])
      ->countQuery()
      ->execute()
      ->fetchField();

    if(!$is_user) {
      $email = 'mail@mail.com';
      $password = '111';
      $username = trim($xml_rows['id']['author']);

      $user = User::create([
        'type' => 'user',
        'name' => $username,
        'mail' => $email,
        'pass' => $password,
      ]);
      $user->save();
      $uid = $user->id();

      $selector1 = '.responsive-enabled';
      $selector = '.odd';
      /*$selector2 = '.table-responsive';*/
      $css = [
        'background' => '#00bc8c',
      ];

      drupal_set_message(t("user saved."), 'status');

    } else {
      $query = \Drupal::database()->select('users_field_data', 'u');
      $query->fields('u', ['uid','name']);
      $query->condition('u.name', $xml_rows['id']['author']);
      $user_id = $query->execute()->fetchField();
      $uid = $user_id;

      $selector1 = '.responsive-enabled';
      $selector = '.odd';

      $css = [
        'background' => '#e74c3c',
      ];

      drupal_set_message(t("such user already exists."), 'error');
    }


    $query = \Drupal::database()->select('node_field_data', 'n');
    $is_node = $query
      ->condition('n.title', $xml_rows['id']['title'])
      ->countQuery()
      ->execute()
      ->fetchField();

    if(!$is_node) {
      $node = Node::create([
        'type' => 'article',
        'title' => $xml_rows['id']['title'],
        'uid' => $uid,
        'body' => [
          $xml_rows['id']['genre'] . "\n" .
          $xml_rows['id']['price'] . "\n" .
          $xml_rows['id']['publish_date'] . "\n" .
          $xml_rows['id']['description']
        ],
      ]);
      $node->save();

      $selector1 = '.responsive-enabled';
      $selector = '.odd';
      /*$selector2 = '.table-responsive';*/
      $css = [
        'background' => '#00bc8c',
      ];

      drupal_set_message(t("node saved."), 'status');

    } else {

      $selector1 = '.responsive-enabled';
      $selector = '.odd';
      /*$selector2 = '.table-responsive';*/
      $css = [
        'background' => '#e74c3c',
      ];
      drupal_set_message(t("such node already exists."), 'error');
    }
    $ajax_response = new AjaxResponse();
    $message = [
      '#theme' => 'status_messages',
      '#message_list' => drupal_get_messages(),
      '#status_headings' => [
        'status' => t('Status message'),
        'error' => t('Error message'),
        'warning' => t('Warning message'),
      ],
    ];

    $messages = \Drupal::service('renderer')->render($message);
    $ajax_response->addCommand(new HtmlCommand('#form-system-messages', $messages));
    $ajax_response->addCommand(new CssCommand($selector, $css));
    $ajax_response->addCommand(new CssCommand($selector1, $css));


    return $ajax_response;
  }

  /**
   * @param array $form
   * @param FormStateInterface $form_state
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    }
}
/*$ajax_response->addCommand(new RedirectCommand($url));
    $ajax_response->addCommand(new RemoveCommand($selector));
    $ajax_response->addCommand(new PrependCommand($selector2, $data, $settings = NULL));
    $ajax_response->addCommand(new InsertCommand($selector, $data1, $settings = NULL));*/
/*$data = drupal_set_message(t("node saved."), 'warning');
      $data1 = '<p>Destroy for creation</p>';

      $url = '../xml';*/
/* $url = '../xml';
      $data = drupal_set_message(t("node saved."), 'warning');
      $data1 = '<p>Destroy for creation</p>';*/
/*$url = '../xml';
      $data = drupal_set_message(t("node saved."), 'warning');
      $data1 = '<p>Destroy for creation</p>';*/
/*$selector2 = '.table-responsive';*/
/* $url = '../xml';
      $data = drupal_set_message(t("node saved."), 'warning');
      $data1 = '<p>Destroy for creation</p>';*/