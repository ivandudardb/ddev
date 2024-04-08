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

  public function __construct(array $configuration, $plugin_id, $plugin_definition, protected ConfigPagesLoaderService $configPagesLoaderService, protected EntityTypeManager $entityTypeManager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
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
    $config_page_machine_name = 'global_configurations';
    $storage = $this->entityTypeManager->getStorage('config_pages');
    $entity = $storage->load($config_page_machine_name);
    $copyrightValue = $entity->get('field_copyright')->getValue();
    $copyrightTextValue = $copyrightValue[0]['value'];
    return [
      '#cache' => [
        'tags' => ['config_pages:1'],
      ],
      '#markup' => $copyrightTextValue,
    ];
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
