<?php

namespace Drupal\custom_weather\Form;

use Drupal\Core\Database\Connection;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\custom_weather\Service\UserCityHandler;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines a configuration form for managing settings related to the module.
 */
class CustomWeatherUserForm extends FormBase {

  /**
   * Stores current user city.
   */

  protected mixed $city;

  /**
   * Stores current user id.
   */
  protected int $currentUser;

  /**
   * Stores DB connection.
   */
  protected mixed $connection;

  public function __construct(protected UserCityHandler $userCityHandler, AccountProxyInterface $currentUser, Connection $connection) {
    $this->city = $this->userCityHandler->getCurrentCity();
    $this->currentUser = $currentUser->id();
    $this->connection = $connection;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): CustomWeatherUserForm|FormBase|static {
    return new static(
      $container->get('custom_weather.user_city_handler'),
      $container->get('current_user'),
      $container->get('database')
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
      '#default_value' => $this->city,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    ];

    return $form;
  }

  /**
   * Form submission handler for your custom form.
   *
   * @throws \Exception
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $user_id = $this->currentUser;
    $selected_user_city = $form_state->getValue('selected_city');
    $connection = $this->connection;
    $query = $connection->select('custom_weather_data', 'cwd');
    $query->fields('cwd', ['user_id']);
    $query->condition('user_id', $user_id);
    $result = $query->execute()->fetchField();

    if ($result) {
      $this->userCityHandler->updateWeatherData($selected_user_city, $user_id);
    }
    else {
      $this->userCityHandler->setWeatherData($selected_user_city, $user_id);
    }
  }

}
