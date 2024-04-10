<?php

namespace Drupal\stores\Plugin\views\area;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\area\AreaPluginBase;

/**
 * Views area PointCustomization handler.
 *
 * @ingroup views_area_handlers
 *
 * @ViewsArea("map_area")
 */
class PointCustomization extends AreaPluginBase {

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();

    $options['color'] = ['default' => '#00000'];
    $options['size'] = ['default' => '10'];
    $options['zoom'] = ['default' => '13'];

    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    $form['color'] = [
      '#title' => $this->t('Point color'),
      '#type' => 'color',
      '#default_value' => $this->options['color'],
    ];
    $form['size'] = [
      '#title' => $this->t('Point size'),
      '#type' => 'textfield',
      '#default_value' => $this->options['size'],
      '#element_validate' => [
        [$this, 'validateNumberField'],
      ],
    ];
    $form['zoom'] = [
      '#title' => $this->t('Map zoom'),
      '#type' => 'textfield',
      '#default_value' => $this->options['zoom'],
      '#element_validate' => [
        [$this, 'validateNumberField'],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function render($empty = FALSE) {
    if (!$empty || !empty($this->options['empty'])) {
      $id = $this->view->id() . '_' . $this->view->current_display;
      $test = $this->view;
      foreach ($this->view->result as $item) {
        $field_location_value = $item->_entity->get('field_geo')->getValue();
        $field_location_values[] = $field_location_value;
      }
      $output['#attached']['drupalSettings'][$id] = [
        'stores' => [
          'color' => $this->options['color'],
          'size' => $this->options['size'],
          'zoom' => $this->options['zoom'],
          'locations' => $field_location_values,
        ],
      ];
      $output = [];
      $output['#attached'] = [
        'library' => [
          'stores/map',
          'stores/leaflet',
        ],
      ];

      $output['map_container'] = [
        '#type' => 'container',
        '#attributes' => [
          'id' => 'map',
          'class' => 'leaflet__map',
          'data-view-id' => $id,
          'style' => 'width: 100%; height: 500px;',
        ],
      ];
      return $output;
    }

    return [];
  }

}
