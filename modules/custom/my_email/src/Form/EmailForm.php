<?php

namespace Drupal\my_email\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 *  form.
 */
class EmailForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'message';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['header'] = array(
      '#type' => 'textfield',
      '#required' => true,
      '#placeholder' => t('header'),
    );

    $form['body'] = array(
      '#type' => 'textarea',
      '#required' => true,
      '#placeholder' => t('body'),
    );

    $form['name'] = array(
      '#type' => 'textfield',
      '#required' => true,
      '#placeholder' => t('name'),
    );

    $form['country'] = array(
      '#type' => 'select',
      '#options' => array(
        'English' => t('English'),
        'Ukrainian' => t('Ukrainian'),
        'Polish' => t('Polish')),
      '#empty_option' => 'country',
      '#required' => true,
    );

    $form['email'] = array(
      '#type' => 'email',
      '#required' => TRUE,
      '#placeholder' => t('e-mail'),
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $langcode = 'en';
    $to = $form_state->getValue('email');

    $mailManager = \Drupal::service('plugin.manager.mail');
    $module = 'my_email';
    $key = 'mail';

    $params['title'] = $form_state->getValue('header');

    $body = $form_state->getValue('body');
    $name = $form_state->getValue('name');
    $country = $form_state->getValue('country');

    $params['body'] = [
      'body' => $body,
      'name' => $name,
      'country' => $country,
    ];
    $send = TRUE;

    $mail = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);

    // processing the result.
    if (!$mail) {
      drupal_set_message(t('There was a problem sending your message and it was not sent.'), 'error');
    } else {
      drupal_set_message(t('Your message has been sent.'));
    }
  }
}