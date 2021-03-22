<?php

namespace Drupal\howard_content_types\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\node\NodeInterface;

/**
 * Class HowardAuthSubscriber.
 *
 * @package Drupal\howard_content_types.
 */
class HowardAuthSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = ['disableCacheForProtectedPage'];
    return $events;
  }

  /**
   * Subscriber Callback for the event.
   */
  public function disableCacheForProtectedPage() {

    // Check if current node type is one we want to exclude from the cache.
    $node = \Drupal::routeMatch()->getParameter('node');
    if ($node instanceof NodeInterface) {
      $node_type = $node->getType();
    }

    if (isset($node_type) && $node_type == 'hc_page') {
      if ($node->hasField('field_hc_hide_for_nonhoward')) {
        $value = $node->get('field_hc_hide_for_nonhoward')->getValue();
        if (isset($value[0]) && $value[0]['value'] == '1') {
          // Pull the cache kill switch
          \Drupal::service('page_cache_kill_switch')->trigger();
          if (\Drupal::currentUser()->isAnonymous()) {
            // Ignore auth requirement if you are a logged in drupal user.
            \Drupal::service('howard.auth')->limitToHowardUsers();
          }
        }
      }
    }
  }

}
