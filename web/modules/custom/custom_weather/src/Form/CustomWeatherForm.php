<?php

namespace Drupal\custom_weather\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines admin form. Validate and save API key.
 */
class CustomWeatherForm extends ConfigFormBase {

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
    // Add a field for entering the API key.
    $form['api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API Key'),
      '#default_value' => $this->config('custom_weather.settings')->get('api_key'),
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * Validate API key.
   */
  public function validateForm(array &$form, FormStateInterface $form_state):void {
    $api_key = $form_state->getValue('api_key');
    if (strlen($api_key) !== 32) {
      $form_state->setErrorByName('api_key', $this->t('API Key should be 32 characters long.'));
    }
  }

  /**
   * Saves the API key value to config.
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $api_key = $form_state->getValue('api_key');
    $this->config('custom_weather.settings')
      ->set('api_key', $api_key)
      ->save();
    $this->messenger()->addStatus($this->t('API key saved successfully'));
  }

}
