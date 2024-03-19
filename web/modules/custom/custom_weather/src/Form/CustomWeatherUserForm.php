<?php

namespace Drupal\custom_weather\Form;

use Drupal\Core\Database\Connection;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\custom_weather\Service\UserCityHandler;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines user form. Saves user city to the database.
 */
class CustomWeatherUserForm extends FormBase {

  /**
   * Constructs a new instance of the class.
   *
   * @param \Drupal\custom_weather\Service\UserCityHandler $userCityHandler
   *   The service for handling user city data.
   * @param \Drupal\Core\Session\AccountProxyInterface $currentUser
   *   The current user account.
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection.
   */
  public function __construct(
    protected UserCityHandler $userCityHandler,
    protected AccountProxyInterface $currentUser,
    protected Connection $connection
  ) {
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
      '#default_value' => $this->userCityHandler->getCurrentCity(),
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   *
   * @throws \Exception
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $selected_user_city = $form_state->getValue('selected_city');
    $this->userCityHandler->upsertData($selected_user_city);
  }

}
