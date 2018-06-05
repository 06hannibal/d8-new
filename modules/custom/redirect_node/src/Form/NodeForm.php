<?php

namespace Drupal\redirect_node\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

/**
 *  form.
 */
class NodeForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'id';
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['nid'] = array(
      '#type' => 'number',
      '#title' => $this->t('nid'),
      '#required' => true,
    );

    $form['title'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('title'),
      '#required' => true,
    );

    $form['body'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('body'),
      '#required' => true,
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('create a node'),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $query = \Drupal::database()->select('node', 'n');
    $is_exist = (bool)$query
      ->condition('n.nid', $form_state->getValue('nid'))
      ->countQuery()
      ->execute()
      ->fetchField();
    /*var_dump($is_exist);
    die();*/

    if(!$is_exist){
      $node = Node::create([
        'type' => 'article',
        'nid' => $form_state->getValue('nid'),
        'title' => $form_state->getValue('title'),
        'body' => $form_state->getValue('body'),
        ]);
      $node->save();
    } else {
      $form_state->setRedirect('entity.node.canonical', [
        'node' => $form_state->getValue('nid'),
      ]);
    }
  }
}