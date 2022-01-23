<?php

namespace Drupal\custom_employee\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\custom_employee\Event\EmpWelcomeEvent;
use Drupal\Core\Logger\LoggerChannelFactory;
use Drupal\Core\Mail\MailManager;
use Drupal\Core\Session\AccountProxy;

/**
 * Event subscriber for employee welcome event.
 */
class EmpWelcomeSubscriber implements EventSubscriberInterface {

  /**
   * The Mail Manager.
   *
   * @var Drupal\Core\Mail\MailManager
   */

  protected $mailManager;

  /**
   * The Logger Factory.
   *
   * @var Drupal\Core\Logger\LoggerChannelFactory
   */

  protected $logger;

  /**
   * The Account Proxy.
   *
   * @var Drupal\Core\Session\AccountProxy
   */

  protected $account;

  /**
   * Constructs the EmployeeWelcomeSubscriber.
   *
   * @param \Drupal\Core\Mail\MailManager $mail_manager
   *   The Mail Manager Plugin.
   * @param Drupal\Core\Logger\LoggerChannelFactory $logger
   *   The Logger Factory.
   * @param Drupal\Core\Session\AccountProxy $account
   *   The Account Proxy.
   */
  public function __construct(MailManager $mail_manager,
    LoggerChannelFactory $logger,
  AccountProxy $account) {
    $this->mailManager = $mail_manager;
    $this->logger = $logger;
    $this->account = $account;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events['custom_employee.welcome.mail'][] = ['customSendWelcomeMail', 0];
    return $events;
  }

  /**
   * Responds to the event "employee.welcome.mail".
   *
   * @param Drupal\custom_employee\Event\EmpWelcomeEvent $event
   *   The event object.
   */
  public function customSendWelcomeMail(EmpWelcomeEvent $event) {
    $employee = $event->getEmployeeInfo();
    $mailManager = \Drupal::service('plugin.manager.mail');
    $module = 'custom_employee';
    $key = 'send_welcome_mail';
    $to = $employee->email;
    $langcode = $this->account->getPreferredLangcode();
    $send = TRUE;
    $params['custom_employee'] = $employee;
    $result = $this->mailManager->mail('custom_employee',
      'send_welcome_mail', $to, $langcode, $params, NULL, $send);

    $this->setLogMessage('Employee ' . $employee->id
        . ' added sucessfully and welcome mail has been sent !!'); // log message : below

  }

  /**
   * To set a log message.
   *
   * @param string $message
   *   The message to log.
   */
  private function setLogMessage($message) {
    $this->logger->get('default')
      ->info($message);
  }

}
