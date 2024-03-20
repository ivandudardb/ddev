<?php

namespace Drupal\custom_registration\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\user\RegisterForm;

/**
 * Provide custom form for registration.
 */
class CustomRegistrationForm extends RegisterForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state): array {
    $vid = 'news';
    $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid);

    $options = [];
    foreach ($terms as $term) {
      $options[$term->tid] = $term->name;
    }


    $form = parent::form($form, $form_state);

    // Add custom fields to the form.
    $form['username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Username'),
      '#required' => TRUE,
    ];

    $form['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#required' => TRUE,
    ];

    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#required' => TRUE,
    ];

    $form['interested_in'] = [
      '#type' => 'select',
      '#title' => t('Interested In'),
      '#options' => $options,
      '#required' => TRUE,
    ];

    return $form;
  }

}
