<?php

namespace Drupal\testmodule\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Provides a 'TestModuleBlock' block.
 *
 * @Block(
 *  id = "test_module_block",
 *  admin_label = @Translation("Test module block"),
 * )
 */
class TestModuleBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function access(AccountInterface $account, $return_as_object = FALSE) {
    if (!empty($this->configuration['display_until_block_settings']) && strtotime($this->configuration['display_until_block_settings']) >= REQUEST_TIME) {
      return AccessResult::allowed();
    }
      return AccessResult::forbidden();
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return array(
      '#type' => 'markup',
      '#markup' => 'Hello World',
    );
  }



  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $form['display_until_block_settings'] = [
      '#type' => 'date',
      '#title' => t('Display until'),
      '#default_value' => isset($this->configuration['display_until_block_settings']) ? $this->configuration['display_until_block_settings'] : '',
      '#description' => t('The block will be displayed until the selected date.'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    parent::blockSubmit($form, $form_state);
    $this->configuration['display_until_block_settings'] =  $form_state->getValue('display_until_block_settings');
    //exit;

  }

}
