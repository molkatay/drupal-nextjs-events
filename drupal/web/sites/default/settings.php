<?php
// get environment context
$environment = getenv('APP_ENVIRONMENT') ? getenv('APP_ENVIRONMENT') : 'dev';

// generic settings variables
$settings['hash_salt'] = file_get_contents('../salt.txt');
$settings['file_scan_ignore_directories'] = ['node_modules'];
$settings['entity_update_batch_size'] = 50;
$settings['custom_translations_directory'] = '../translations';
$settings['update_free_access'] = TRUE;
$settings['rebuild_access'] = FALSE;
$settings['skip_permissions_hardening'] = TRUE;

// config folder
$settings['config_sync_directory'] = '../config/sync';

// public file path
$settings['file_public_path'] = 'upload/public';

// chmod files & folders
$settings['file_chmod_directory'] = 0775;
$settings['file_chmod_file'] = 0664;

// private file path
$settings['file_private_path'] = 'upload/private';

// check if environment settings file is here
if (file_exists($app_root . '/' . $site_path . '/settings.' . $environment . '.php')) {
require_once $app_root . '/' . $site_path . '/settings.' . $environment . '.php';
}
/**
 * Redis config
 *
 * Configuration Redis for the cache
 **/
//try {
//  $redis = new Redis();
//  $redis->connect('Redis', 6379);
//  if ($redis->IsConnected()) {
//    $redis->auth(NULL);
//    $response = $redis->ping();
//    if ($response) {
//      # Configuration Redis for the cache
//      $settings['redis.connection']['host'] = 'redis';
//      $settings['redis.connection']['password'] = NULL;
//      $settings['redis.connection']['port'] = '6379';
//      $settings['redis.connection']['instance'] = 'cache';
//      $settings['redis.connection']['interface'] = 'PhpRedis';
//      $settings['cache']['default'] = 'cache.backend.redis';
//      $settings['container_yamls'][] = 'modules/redis/example.services.yml';
//      $conf['redis_perm_ttl'] = 2592000;
//      $settings['redis_compress_length'] = 100;
//      $settings['redis_compress_level'] = 3;
//    }
//  }
//} catch (Exception $e) {
//}

$settings['reverse_proxy'] = TRUE;

// Modifier l'IP si Varnish n'est pas sur le même serveur.
$settings['reverse_proxy_addresses'] = array('127.0.0.1');

$settings['trusted_host_patterns'] = [
  '^localhost$',
  '127\.0\.0\.1',
  'druxt-events.com'
];

