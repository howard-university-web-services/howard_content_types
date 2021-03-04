<?php

namespace Drupal\howard_content_types\Services;

require_once('../simplesamlphp/lib/_autoload.php');

use SimpleSAML\Auth\Simple;

/**
 * Class HowardAuthService.
 */
class HowardAuthService {


  /**
   * Constructs a new HowardNewsService object.
   */
  public function __construct() {

  }

  /**
   * Public method to test if users are authenticated via SAML, and return username.
   */
  public function limitToHowardUsers() {

      $as = new Simple('default-sp');
      $as->requireAuth();
      $attributes = $as->getAttributes();
      return $attributes['sAMAccountName'][0];

  }

}
