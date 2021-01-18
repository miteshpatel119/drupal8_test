<?php

namespace Drupal\custom_api_module\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\system\Form\SiteInformationForm;

class ExtendedSiteInformationForm extends SiteInformationForm { 

  /** 
   * 'Site API Key' field is added to Site Information form.
   * 
   *  Alter text of submit button.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $site_config = $this->config('system.site');
    $form =  parent::buildForm($form, $form_state);
    $form['site_information']['siteapikey'] = [
      '#type' => 'textfield',
      '#title' => t('Site API Key'),
      '#default_value' => $site_config->get('siteapikey') ? $site_config->get('siteapikey') : 'No API Key yet',
      '#description' => t("Custom field to set the API Key"),
    ];

    if (!empty($site_config->get('siteapikey'))) {
      $form['actions']['submit']['#value'] = t('Update configuration');
    }
    return $form;
  }

  /** 
   * Set the value of 'Site API Key' field on form submit. 
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $site_config = $this->config('system.site');
    if (!empty($form_state->getValue('siteapikey')) && $form_state->getValue('siteapikey') !== 'No API Key yet') {
      drupal_set_message("Site API Key has been saved with the value: '" .$form_state->getValue(['siteapikey'])."'");
    }
    $site_config
      ->set('siteapikey', $form_state->getValue('siteapikey'))
      ->save();
    parent::submitForm($form, $form_state);
  }
}
