<?php
/**
 * Include
 */
require_once APPSUMO_INCLUDES_PATH . '/helpers.php';

/**
 * Include Vendors
 */
require_once APPSUMO_INCLUDES_PATH . '/vendor/class-api.php';
require_once APPSUMO_INCLUDES_PATH . '/vendor/class-appsumo-api.php';
require_once APPSUMO_INCLUDES_PATH . '/vendor/class-setup.php';

/**
 * Include Classes
 */
require_once APPSUMO_INCLUDES_PATH . '/classes/class-transient.php';
require_once APPSUMO_INCLUDES_PATH . '/classes/class-token.php';
require_once APPSUMO_INCLUDES_PATH . '/classes/class-notices.php';
require_once APPSUMO_INCLUDES_PATH . '/classes/class-attempts.php';
require_once APPSUMO_INCLUDES_PATH . '/classes/class-activation.php';
require_once APPSUMO_INCLUDES_PATH . '/classes/class-admin-page.php';

require_once APPSUMO_INCLUDES_PATH . '/classes/class-appsumo.php';

/**
 * Init Classes
 */
new \AppSumo\Classes\Activation();
