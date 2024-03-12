<?php

namespace Drupal\custom_weather\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * {@inheritdoc}
 */
class TestForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_weather';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['custom_weather.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Масив міст для випадаючого списку.
    $cities = [
      'kyiv' => $this->t('Київ'),
      'lviv' => $this->t('Львів'),
      'Rivne' => $this->t('Рівне'),
      'Lutsk' => $this->t('Луцьк'),
      'Zhytomyr' => $this->t('Житомир'),
      'Chernivtsi' => $this->t('Чернівці'),
      'Ivano-Frankivsk' => $this->t('Івано-Франківськ'),
      'Ternopil' => $this->t('Тернопіль'),
      'Khmelnytskyi' => $this->t('Хмельницький'),
      'Uzhhorod' => $this->t('Ужгород'),
      'Vinnytsia' => $this->t('Вінниця'),
      'Cherkasy' => $this->t('Черкаси'),
      'Poltava' => $this->t('Полтава'),
      'Chernihiv' => $this->t('Чернігів'),
      'Sumy' => $this->t('Суми'),
      'Kharkiv' => $this->t('Харків'),
      'odesa' => $this->t('Одеса'),
    ];

    // Додаємо випадаючий список з містами до форми.
    $form['selected_city'] = [
      '#type' => 'select',
      '#title' => $this->t('Select a city'),
      '#options' => $cities,
      '#default_value' => $this->config('custom_weather.settings')->get('selected_city'),
    ];

    // Додаємо поле для введення API-ключа.
    $form['api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API Key'),
      '#default_value' => $this->config('custom_weather.settings')->get('api_key'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): array {
    // Отримуємо значення обраного міста з форми.
    $selected_city = $form_state->getValue('selected_city');
    // Зберігаємо його в конфігурації.
    $this->config('custom_weather.settings')
      ->set('selected_city', $selected_city)
      ->set('api_key', $form_state->getValue('api_key'))
      ->save();

    // Записуємо отриману назву міста у змінну $build.
    // Повертаємо змінну $build, яка буде передана у темплейт блоку.
    return [
      '#selected_city' => $selected_city,
    ];
  }

}
