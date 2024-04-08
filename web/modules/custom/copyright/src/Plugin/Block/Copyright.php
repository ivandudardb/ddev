<?php

namespace Drupal\copyright\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Provides a 'WeatherBlock' block.
 */
#[Block(
  id: "copyright_block",
  admin_label: new TranslatableMarkup("Custom Copyright block"),
)]
class Copyright extends BlockBase {

  /**
   *
   */
  public function build() {
    $config_page_machine_name = 'global_configurations';
    $storage = \Drupal::entityTypeManager()->getStorage('config_pages');
    $entity = $storage->load($config_page_machine_name);
    $value = $entity->get('field_copyright')->getValue();
    $text_value = $value[0]['value'];
    return [
      '#markup' => $text_value,
      '#cache' => [
        [
          'tags' => ['global_configurations'],
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['url'] = [
      '#markup' => 'Copyrights text can be edited <a href="https://drupalddev.ddev.site/admin/copyright">here</a>',
    ];

    return $form;
  }

}
