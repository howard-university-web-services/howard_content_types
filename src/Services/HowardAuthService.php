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
    // Workaround for acquia port:80 issue.
    if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
      $_SERVER['SERVER_PORT'] = 443;
      $_SERVER['HTTPS'] = 'true';
    }
    $as = new Simple('default-sp');
    $as->requireAuth();
    $attributes = $as->getAttributes();
    return $attributes['sAMAccountName'][0];
  }

}
