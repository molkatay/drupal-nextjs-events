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

assert_options(ASSERT_ACTIVE, true);
\Drupal\Component\Assertion\Handle::register();

# ================================================================
# Database credentials.
# ================================================================
$databases['default']['default'] = array (
  'database' => 'druxt_events',
  'username' => 'drupal',
  'password' => 'drupal',
  'prefix' => '',
  'host' => 'db',
  'port' => '5432',
  'namespace' => 'Drupal\\pgsql\\Driver\\Database\\pgsql',
  'driver' => 'pgsql',
  'autoload' => 'core/modules/pgsql/src/Driver/Database/pgsql/',
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
  '^' . preg_quote('varnish.druxt-events.com') . '$',
  '^' . preg_quote('druxt-events.com') . '$',
  '^web$',
  '^varnish$'
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
$config['system.performance']['cache']['page']['use_internal'] = false;
$config['system.performance']['css']['preprocess'] = false;
$config['system.performance']['css']['gzip'] = false;
$config['system.performance']['js']['preprocess'] = false;
$config['system.performance']['js']['gzip'] = false;

# ================================================================
# Debug views settings
# ================================================================
$config['views.settings']['ui']['show']['sql_query']['enabled'] = true;
$config['views.settings']['ui']['show']['performance_statistics'] = true;

# ================================================================
# Expiration of temporary upload files
# ================================================================
$config['system.file']['temporary_maximum_age'] = 604800;

// Change kint max_depth setting.
if (class_exists('Kint')) {
  // Set the max_depth to prevent out-of-memory.
    \Kint::$max_depth = 4;
}
$config['system.logging']['error_level'] = 'verbose';
