<?php
/**
 * @file
 * Contains Drupal\alertbar\Form\MessagesForm.
 */
namespace Drupal\alertbar\Form;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Datetime\DrupalDateTime;

class MessagesForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'alertbar.adminsettings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'alertbar_form';
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('alertbar.adminsettings');

    $form['alert_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Alert Title'),
      '#description' => $this->t('Optional title to add context to an alert message.'),
      '#default_value' => $config->get('alert_title'),
    ];

    $form['alert_text'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Alert Text'),
      '#description' => $this->t('Text to display inside the alert bar.'),
      '#default_value' => $config->get('alert_text'),
    ];

    $form['alert_cta'] = [
      '#type' => 'details',
      '#title' => $this->t('Alert Link'),
      '#open' => TRUE,
    ];

    $form['alert_cta']['alert_link_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Alert Link Text'),
      '#default_value' => $config->get('alert_link_text'),
    ];

    $form['alert_cta']['alert_link'] = [
      '#type' => 'url',
      '#title' => $this->t('Alert Link URL'),
      '#description' => $this->t('Link to the content or offsite.'),
      '#default_value' => $config->get('alert_link'),
    ];

    $form['presentation'] = [
      '#type' => 'details',
      '#title' => $this->t('Alert Presentation'),
      '#open' => TRUE,
    ];

    $form['presentation']['alert_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Select type of alert'),
      '#options' => [
        'alert' => $this->t('Alert (Red)'),
        'warning' => $this->t('Warning (Orange)'),
        'status' => $this->t('Status (Green)'),
      ],
      '#default_value' => $config->get('alert_type'),
    ];

    $form['presentation']['alert_position'] = [
      '#type' => 'select',
      '#title' => $this->t('Select position of alert'),
      '#options' => [
        'top' => $this->t('Top'),
        'bottom' => $this->t('Bottom'),
        'centre' => $this->t('Centre'),
      ],
      '#default_value' => $config->get('alert_position'),
    ];

    $form['presentation']['alert_position_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Select position type'),
      '#options' => [
        'static' => $this->t('Static'),
        'fixed' => $this->t('Fixed'),
      ],
      '#description' => $this->t('When "Static" alert bar will push content away from it. When "Fixed" alert will sit above page and follow the user while scrolling.'),
      '#default_value' => $config->get('alert_position_type'),
    ];

    $form['alert_active'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Activate alert bar'),
      '#description' => $this->t('When checked the alert bar will be visible on all pages.'),
      '#default_value' => $config->get('alert_active'),
    );

    $time = DrupalDateTime::createFromTimestamp(time());
    $form['alert_timestamp'] = array(
      '#type' => 'hidden',
      '#title' => t('Alert Timestamp'),
      '#default_value' => $time->getTimestamp(),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('alertbar.adminsettings')
      ->set('alert_title', $form_state->getValue('alert_title'))
      ->set('alert_text', $form_state->getValue('alert_text'))
      ->set('alert_link', $form_state->getValue('alert_link'))
      ->set('alert_link_text', $form_state->getValue('alert_link_text'))
      ->set('alert_type', $form_state->getValue('alert_type'))
      ->set('alert_position', $form_state->getValue('alert_position'))
      ->set('alert_position_type', $form_state->getValue('alert_position_type'))
      ->set('alert_active', $form_state->getValue('alert_active'))
      ->set('alert_timestamp', $form_state->getValue('alert_timestamp'))
      ->save();
  }
}