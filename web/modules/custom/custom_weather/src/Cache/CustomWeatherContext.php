<?php

namespace Drupal\custom_weather\Cache;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Cache\Context\CacheContextInterface;
use Drupal\custom_weather\Service\UserCityHandler;

/**
 * Creates a context for caching the city in the custom_weather block.
 */
class CustomWeatherContext implements CacheContextInterface {

  /**
   * Constructs a new CustomWeatherContext object.
   *
   * @param \Drupal\custom_weather\Service\UserCityHandler $userCityHandler
   *   The user city handler service.
   */
  public function __construct(
    protected UserCityHandler $userCityHandler,
  ) {
  }

  /**
   * {@inheritdoc}
   */
  public static function getLabel() {
    return 'City cache context';
  }

  /**
   * {@inheritdoc}
   */
  public function getContext() {
    $city = $this->userCityHandler->getCurrentCity();
    return 'city_cache_context:' . $city;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheableMetadata() {
    return new CacheableMetadata();
  }

}
