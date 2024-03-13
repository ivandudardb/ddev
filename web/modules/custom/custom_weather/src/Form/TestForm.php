<?php

namespace Drupal\custom_weather\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a configuration form for managing settings related to the module.
 */
class TestForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'custom_weather';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return ['custom_weather.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    // Array of cities for the dropdown list.
    $cities = [
      'Kyiv' => $this->t('Kyiv'),
      'Lviv' => $this->t('Lviv'),
      'Rivne' => $this->t('Rivne'),
      'Lutsk' => $this->t('Lutsk'),
      'Zhytomyr' => $this->t('Zhytomyr'),
      'Chernivtsi' => $this->t('Chernivtsi'),
      'Ternopil' => $this->t('Ternopil'),
      'Khmelnytskyi' => $this->t('Khmelnytskyi'),
      'Uzhhorod' => $this->t('Uzhhorod'),
      'Vinnytsia' => $this->t('Vinnytsia'),
      'Cherkasy' => $this->t('Cherkasy'),
      'Poltava' => $this->t('Poltava'),
      'Chernihiv' => $this->t('Chernihiv'),
    ];

    // Add the dropdown list with cities to the form.
    $form['selected_city'] = [
      '#type' => 'select',
      '#title' => $this->t('Select a city'),
      '#options' => $cities,
      '#default_value' => $this->config('custom_weather.settings')->get('selected_city'),
    ];

    // Add a field for entering the API key.
    $form['api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API Key'),
      '#default_value' => $this->config('custom_weather.settings')->get('api_key'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * Validates the form submission.
   */
  public function validateForm(array &$form, FormStateInterface $form_state):void {
    $api_key = $form_state->getValue('api_key');
    if (empty($api_key)) {
      $form_state->setErrorByName('api_key', $this->t('API Key field is required.'));
    }
    elseif (strlen($api_key) !== 32) {
      $form_state->setErrorByName('api_key', $this->t('API Key should be 32 characters long.'));
    }
  }

  /**
   * Handles the submission of the form and performs necessary actions.
   */
  public function submitForm(array &$form, FormStateInterface $form_state):void {
    $selected_city = $form_state->getValue('selected_city');
    $api_key = $form_state->getValue('api_key');

    // Save the values of the selected city and API key in the configuration.
    $this->config('custom_weather.settings')
      ->set('selected_city', $selected_city)
      ->set('api_key', $api_key)
      ->save();
    $this->messenger()->addMessage($this->t('Your settings have been saved.'));
  }

}
