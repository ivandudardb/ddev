<?php

namespace Drupal\custom_weather\Form;

use Drupal\Core\Database\Database;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\custom_weather\Service\DataBaseService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines a configuration form for managing settings related to the module.
 */
class CustomWeatherUserForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function __construct(DataBaseService $database_service) {
    $this->databaseService = $database_service;
    parent::__construct($database_service);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): CustomWeatherUserForm|ConfigFormBase|static {
    return new static(
      $container->get('Drupal\custom_weather\Service\DataBaseService')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'custom_weather_user';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return ['custom_weather_user.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $city = $this->databaseService->getCityFromDatabase();
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
      '#default_value' => $city,
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * Form submission handler for your custom form.
   *
   * @throws \Exception
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $user_id = \Drupal::currentUser()->id();
    $selected_user_city = $form_state->getValue('selected_city');
    $connection = Database::getConnection();
    $query = $connection->select('custom_weather_data', 'cwd');
    $query->fields('cwd', ['user_id']);
    $query->condition('user_id', $user_id);
    $result = $query->execute()->fetchField();

    if ($result) {
      $connection->update('custom_weather_data')
        ->fields([
          'city' => $selected_user_city,
        ])
        ->condition('user_id', $user_id)
        ->execute();
    }
    else {
      $connection->insert('custom_weather_data')
        ->fields([
          'city' => $selected_user_city,
          'user_id' => $user_id,
        ])
        ->execute();
    }
  }

}