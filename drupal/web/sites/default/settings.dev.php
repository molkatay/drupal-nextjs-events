<?php

/**
 * Assertions.
 *
 * The Drupal project primarily uses runtime assertions to enforce the
 * expectations of the API by failing when incorrect calls are made by code
 * under development.
 *
 * @see http://php.net/assert
 * @see https://www.drupal.org/node/2492225
 *
 * If you are using PHP 7.0 it is strongly recommended that you set
 * zend.assertions=1 in the PHP.ini file (It cannot be changed from .htaccess
 * or runtime) on development machines and to 0 in production.
 *
 * @see https://wiki.php.net/rfc/expectations
 */
assert_options(ASSERT_ACTIVE, TRUE);
\Drupal\Component\Assertion\Handle::register();

# ================================================================
# Database credentials.
# ================================================================
$databases['default']['default'] = array (
  'database' => 'drupal',
  'username' => 'drupal',
  'password' => 'drupal',
  'prefix' => '',
  'host' => 'mariadb',
  'port' => '3306',
  'namespace' => 'Drupal\Core\Database\Driver\mysql',
  'driver' => 'mysql',
  'init_commands' => [
    'isolation_level' => 'SET SESSION tx_isolation=\'READ-COMMITTED\'',
  ],
  'collation' => 'utf8mb4_general_ci',
);

# ================================================================
# Enable local development services.
# ================================================================
$settings['container_yamls'][] = DRUPAL_ROOT . '/sites/default/services.dev.yml';

# ================================================================
# Trusted host patterns.
# ================================================================
$settings['trusted_host_patterns'] = [
 # '^' . preg_quote('varnish.drupal.docker.localhost') . '$',
 # '^' . preg_quote('drupal.docker.localhost') . '$',
  #'^web$'
];

# ================================================================
# Disable page cache and other cache bins
# ================================================================
/*$settings['cache']['bins']['render'] = 'cache.backend.null';
$settings['cache']['bins']['dynamic_page_cache'] = 'cache.backend.null';*/

/*
$cache_bins = array('bootstrap','config','data','default','discovery','dynamic_page_cache','entity','menu','migrate','render','rest','static','toolbar');
foreach ($cache_bins as $bin) {
  $settings['cache']['bins'][$bin] = 'cache.backend.null';
}
*/

# ================================================================
# Performance settings
# ================================================================
$config['system.logging']['error_level'] = 'verbose';
$config['system.performance']['cache']['page']['use_internal'] = FALSE;
$config['system.performance']['css']['preprocess'] = FALSE;
$config['system.performance']['css']['gzip'] = FALSE;
$config['system.performance']['js']['preprocess'] = FALSE;
$config['system.performance']['js']['gzip'] = FALSE;

# ================================================================
# Debug views settings
# ================================================================
$config['views.settings']['ui']['show']['sql_query']['enabled'] = TRUE;
$config['views.settings']['ui']['show']['performance_statistics'] = TRUE;

# ================================================================
# Expiration of temporary upload files
# ================================================================
$config['system.file']['temporary_maximum_age'] = 604800;

// Change kint max_depth setting.
if (class_exists('Kint')) {
  // Set the max_depth to prevent out-of-memory.
  \Kint::$max_depth = 4;
}
