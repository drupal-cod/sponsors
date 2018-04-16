<?php

namespace Drupal\sponsor\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SponsorTypeForm.
 */
class SponsorTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $sponsor_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $sponsor_type->label(),
      '#description' => $this->t("Label for the Sponsor type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $sponsor_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\sponsor\Entity\SponsorType::load',
      ],
      '#disabled' => !$sponsor_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $sponsor_type = $this->entity;
    $status = $sponsor_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Sponsor type.', [
          '%label' => $sponsor_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Sponsor type.', [
          '%label' => $sponsor_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($sponsor_type->toUrl('collection'));
  }

}
