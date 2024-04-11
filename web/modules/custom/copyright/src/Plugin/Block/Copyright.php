<?php

namespace Drupal\copyright\Plugin\Block;

use Drupal\config_pages\ConfigPagesLoaderService;
use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'CopyrightBlock' block.
 */
#[Block(
  id: "copyright_block",
  admin_label: new TranslatableMarkup("Custom Copyright block"),
)]
class Copyright extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Constructs a new Copyright.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    protected ConfigPagesLoaderService $configPagesLoaderService,
    protected EntityTypeManager $entityTypeManager,
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(
    ContainerInterface $container,
    array $configuration,
    $plugin_id,
    $plugin_definition,
  ) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config_pages.loader'),
      $container->get('entity_type.manager'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $loader = $this->configPagesLoaderService;
    if ($storage = $loader->load('global_configurations')) {
      $copyrightField = $storage->get('field_copyright')->view('default');
    }
    else {
      $entityTypeManager = $this->entityTypeManager;
      $definition = $entityTypeManager->getDefinition('config_pages');
      $cacheTag = $definition->getListCacheTags();
      $copyrightField = [
        '#markup' => 'Global Configurations is not created <br> You can create it <a href="/admin/structure/config_pages/types/add">here</a>',
        '#cache' => [
          'tags' => $cacheTag,
        ],
      ];
    }
    return $copyrightField;
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['url'] = [
      '#markup' => 'Copyrights text can be edited <a href="/admin/copyright">here</a>',
    ];
    return $form;
  }

}
