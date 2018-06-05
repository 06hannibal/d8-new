<?php

namespace Drupal\company\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class CompanySave extends FormBase {
  /**
   * @return string
   */
  public function getFormId() {
    return 'id';
  }

  /**
   * @param array $form
   * @param FormStateInterface $form_state
   * @return array
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => t('Enter the name'),
      '#required' => TRUE,
    ];

    $form['number'] = [
      '#type' => 'number',
      '#title' => t('Specify the year'),
      '#required' => TRUE,

    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('save'),
    ];

    $form['button'] = [
      '#type' => 'submit',
      '#value' => t('remove'),
      '#submit' => ['::setMessage'],
    ];
    return $form;
  }

  /**
   * public function setMessage
   */
  public function setMessage() {

    \Drupal::state()->delete('name');
    \Drupal::state()->delete('number');
    }


  /**
   * @param array $form
   * @param FormStateInterface $form_state
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

       $values = [
        'name' => $form_state->getValue('name'),
        'number' => $form_state->getValue('number'),
      ];
      \Drupal::state()->setMultiple($values);
  }
}