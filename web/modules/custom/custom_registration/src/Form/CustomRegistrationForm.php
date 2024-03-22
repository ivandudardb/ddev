<?php

namespace Drupal\custom_registration\Form;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Entity\EntityRepositoryInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Locale\CountryManager;
use Drupal\custom_registration\Service\UserDataHandler;
use Drupal\custom_weather\Service\UserCityHandler;
use Drupal\user\RegisterForm;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provide custom form for registration.
 */
class CustomRegistrationForm extends RegisterForm {

  /**
   * {@inheritdoc}
   */
  public function __construct(
    EntityRepositoryInterface $entity_repository,
    LanguageManagerInterface $language_manager,
    protected UserDataHandler $dataBaseService,
    protected UserCityHandler $userCityHandler,
    protected $entityTypeManager,
    protected CountryManager $countryManager,
    EntityTypeBundleInfoInterface $entity_type_bundle_info = NULL,
    TimeInterface $time = NULL,
  ) {
    parent::__construct($entity_repository, $language_manager, $entity_type_bundle_info, $time);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): static {
    return new static(
      $container->get('entity.repository'),
      $container->get('language_manager'),
      $container->get('custom_registration.data_base_service'),
      $container->get('custom_weather.user_city_handler'),
      $container->get('entity_type.manager'),
      $container->get('country_manager'),
      $container->get('entity_type.bundle.info'),
      $container->get('datetime.time'),
    );
  }

  /**
   * Return array with countries.
   */
  public function getCountries(): array {
    return $this->countryManager->getStandardList();
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state): array {
    $form = parent::form($form, $form_state);
    $terms = $this->entityTypeManager->getStorage('taxonomy_term')->loadTree('news');
    $options = [];
    foreach ($terms as $term) {
      $options[$term->tid] = $term->name;
    }
    $form['country'] = [
      '#type' => 'select',
      '#title' => $this->t('Country'),
      '#required' => TRUE,
      '#options' => $this->getCountries(),
    ];

    $form['city'] = [
      '#type' => 'select',
      '#title' => $this->t('City'),
      '#required' => TRUE,
      '#options' => $this->userCityHandler->cities(),
    ];

    $form['interested_in'] = [
      '#type' => 'select',
      '#title' => $this->t('Interested In'),
      '#options' => $options,
      '#required' => TRUE,
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state): void {
    parent::save($form, $form_state);
    $user_id = $form_state->getValue('uid');
    $country_value = $form_state->getValue('country');
    $city_value = $form_state->getValue('city');
    $interested_in_value = $form_state->getValue('interested_in');
    $this->dataBaseService->saveData($country_value, $city_value, $interested_in_value, $user_id);
  }

}
