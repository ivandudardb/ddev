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
    $copyrightValue = $entity->get('field_copyright')->getValue();
    $copyrightTextValue = $copyrightValue[0]['value'];
    $socialValue = $entity->get('field_social_title')->getValue();
    $socialTextValue = $socialValue[0]['value'];
    return [
      '#field_social_title' => $socialTextValue,
      '#markup' => $copyrightTextValue,
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
      '#markup' => 'Copyrights text can be edited <a href="/admin/copyright">here</a>',
    ];

    return $form;
  }

}
