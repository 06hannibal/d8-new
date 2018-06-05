<?php
/**
 * Created by PhpStorm.
 * User: hannibal
 * Date: 11.04.18
 * Time: 10:32
 */

namespace Drupal\customform\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 *  form.
 */
class UserForm extends FormBase
{
  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'userform';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form['number'] = array(
      '#type' => 'number',
      '#required' => TRUE,
      '#placeholder' => t('phone'),

    );

    $form['text'] = array(
      '#type' => 'textarea',
      '#required' => TRUE,
      '#placeholder' => t('text'),
    );

    $form['select'] = array(
      '#type' => 'select',
      '#options' => array(
        'English' => t('English'),
        'Ukrainian' => t('Ukrainian'),
        'Polish' => t('Polish')),
      '#empty_option' => 'Country',
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
  public function submitForm(array &$form, FormStateInterface $form_state)
  {

    $number = $form_state->getValue('number');
    $text = $form_state->getValue('text');
    $select = $form_state->getValue('select');
    $email = $form_state->getValue('email');
    drupal_set_message(t('Number: %number Text: %text Select: %select Email: %email', ['%number' => $number, '%text' => $text, '%select' => $select, '%email' => $email]));

  }
}