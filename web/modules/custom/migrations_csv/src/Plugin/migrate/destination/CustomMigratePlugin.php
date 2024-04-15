<?php

namespace Drupal\migrations_csv\Plugin\migrate\destination;

use Drupal\Core\Database\Connection;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\migrate\Annotation\MigrateDestination;
use Drupal\migrate\Plugin\migrate\destination\DestinationBase;
use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\migrate\Row;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines Custom Migrate Plugin for migration to custom table.
 *
 * @MigrateDestination(
 *   id = "custom_migrate_plugin"
 * )
 */
class CustomMigratePlugin extends DestinationBase implements ContainerFactoryPluginInterface {

  /**
   * Constructs a new CustomMigratePlugin object.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    MigrationInterface $migration,
    protected Connection $connection
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $migration);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(
    ContainerInterface $container,
    array $configuration,
    $plugin_id,
    $plugin_definition,
    MigrationInterface $migration = NULL
  ): CustomMigratePlugin|ContainerFactoryPluginInterface|static {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $migration,
      $container->get('database')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getIds(): array {
    return ['uid' => ['type' => 'integer']];
  }

  /**
   * {@inheritdoc}
   */
  public function fields(): array {
    return [
      'uid' => $this->t('The user id.'),
      'city' => $this->t('The user city.'),
      'country' => $this->t('The user country.'),
      'interested_in' => $this->t('The user interests.'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function import(Row $row, array $old_destination_id_values = []): void {
    $uid = $row->getDestinationProperty('uid');
    $city = $row->getDestinationProperty('city');
    $country = $row->getDestinationProperty('country');
    $interested_in = $row->getDestinationProperty('interested_in');
    $this->connection->upsert('custom_registration_data')
      ->fields([
        'uid' => $uid,
        'city' => $city,
        'country' => $country,
        'interested_in' => $interested_in,
      ])
      ->key('uid')
      ->execute();
  }

}
