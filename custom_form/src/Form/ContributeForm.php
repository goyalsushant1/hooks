<?php

namespace Drupal\custom_form\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Contribute form.
 */
class ContributeForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => t('Name'),
      '#required' => TRUE,
    );
    $form['mobile'] = array(
      '#type' => 'number',
      '#title' => t('Mobile'),
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
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    # code...
    $values = $form_state->getValues();
    $regex=  '/^[a-z][A-Z ]*$/i';
    if ( !preg_match ($regex,$values['name'])) {
      $form_state->setErrorByName($values['name'],  "Name must only contain letters!");
      }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // foreach ($form_state->getValues() as $key => $value) {
    //   drupal_set_message($key . ': ' . $value);
    // }
      $values = $form_state->getValues();
      $connection = \Drupal::database();
      $connection->insert('custom_form_data')
        ->fields(
          [
            'name' => $values['name'],
            'phone' => $values['mobile'],
            'created' => REQUEST_TIME,
          ]
        )->execute();
    // print_r($form_state->getValues());
    // die();

  }
}
?>