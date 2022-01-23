<?php

namespace Drupal\custom_employee\Form;

use Drupal;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Url;
use Drupal\Core\Form\FormStateInterface;
use Drupal\custom_employee\EmployeeStorage;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Employee delete form.
 */
class EmployeeDeleteForm extends ConfirmFormBase {

  protected $id;

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'employee_delete';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return t('Are you sure you want to delete employee %id?', ['%id' => $this->id]);
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return t('Delete');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelRoute() {
    return new Url('custom_employee.list');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('custom_employee.list');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $id = NULL) {
    if (!EmployeeStorage::exists($id)) {
      \Drupal::messenger()->addMessage(t('Invalid employee record'), 'error');
      return new RedirectResponse(Url::fromRoute('custom_employee.list')->toString());
    }
    $this->id = $id;
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    EmployeeStorage::delete($this->id);
    \Drupal::messenger()->addMessage(t('Employee %id has been deleted.', ['%id' => $this->id]));
    $form_state->setRedirect('custom_employee.list');
  }

}
