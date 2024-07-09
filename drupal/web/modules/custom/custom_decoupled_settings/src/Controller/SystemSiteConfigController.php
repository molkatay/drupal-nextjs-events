<?php

namespace Drupal\custom_decoupled_settings\Controller;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class SystemSiteConfigController.
 *
 * Provides system site configuration in JSON format.
 *
 * @category Drupal
 * @package Custom
 * @author Molka Tayahi <tayahi.molka@gmail.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @link https://www.drupal.org/project/custom_decoupled_settings
 * @since 2024
 * @phpversion 8.2
 */
class SystemSiteConfigController extends ControllerBase {
  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a new SystemSiteConfigController object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory responsible for retrieving configuration objects.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The container interface.
   *
   * @return static
   *   Returns an instance of this controller.
   */
  public static function create(ContainerInterface $container): static {
    return new static(
          $container->get('config.factory')
      );
  }

  /**
   * Returns the system site configuration (name, slogan, and logo) in JSON format.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The JSON response.
   */
  public function getConfig() {
    $config = \Drupal::config('system.site');
    $theme = \Drupal::config('system.theme');
    $theme_global = \Drupal::config('system.theme.global');
    $global_logo = \Drupal::service('file_url_generator')
      ->generateString($theme_global->get('logo.path'));
    $global_favicon = \Drupal::service('file_url_generator')
      ->generateString($theme_global->get('favicon.path'));

    $data = [
      "jsonapi" => [
        "version" => "1.0",
        "meta" => [
          "links" => [
            "self" => [
              "href" => "https://jsonapi.org/format/1.0/",
            ],
          ],
        ],
      ],
      "data" => [
        "type" => "site--site",
        "id" => $config->get('uuid'),
        "links" => [
          "self" => [
            "href" => \Drupal::request()->getSchemeAndHttpHost() .
            \Drupal::service('path.current')->getPath() .
            '/' . $config->get('uuid'),
          ],
        ],
        "attributes" => [
          "name" => $config->get('name'),
          "mail" => $config->get('mail'),
          "slogan" => $config->get('slogan'),
          "page_front" => $config->get('page.front'),
          "page_403" => $config->get('page.403'),
          "page_404" => $config->get('page.404'),
          "default_langcode" => $config->get('default_langcode'),
          "default_theme" => $theme->get('default'),
          "admin_theme" => $theme->get('admin'),
          "global_logo" => $global_logo,
          "global_favicon" => $global_favicon,
        ],
      ],
      "links" => [
        "self" => [
          "href" => \Drupal::request()->getUri(),
        ],
      ],
    ];

    \Drupal::moduleHandler()->alter('jsonapi_site_data', $data['data']['attributes']);

    return new JsonResponse(
          $data,
          200,
          ['Content-Type' => 'application/vnd.api+json']
      );
  }

}
