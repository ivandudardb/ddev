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
      '#type' => 'number',
      '#default_value' => $this->options['size'],
    ];
    $form['zoom'] = [
      '#title' => $this->t('Map zoom'),
      '#type' => 'number',
      '#default_value' => $this->options['zoom'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function render($empty = FALSE) {
    $id = $this->view->id() . '_' . $this->view->current_display;
    foreach ($this->view->result as $item) {
      $field_location_value = $item->_entity->get('field_location')->getValue();
      $field_location_values[] = $field_location_value;
    }

    $build['#attached']['library'] = [
      'stores/leaflet',
      'stores/map',
    ];
    $build['#attached']['drupalSettings'][$id] = [
      'stores' => [
        'color' => $this->options['color'],
        'size' => $this->options['size'],
        'zoom' => $this->options['zoom'],
        'locations' => $field_location_values,
      ],
    ];
    $build['#markup'] = ' <div class="leaflet__map" data-view-id = ' . $id . '></div>';
    return $build;
  }

}
