<?php

declare(strict_types=1);

namespace Drupal\access_jsonapi\EventSubscriber;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Route subscriber.
 */
final class AccessJsonapiRouteSubscriber extends RouteSubscriberBase
{
  /**
   * {@inheritdoc}
   */
    protected function alterRoutes(RouteCollection $collection): void
    {
        foreach ($collection as $route) {
            $defaults = $route->getDefaults();
            if (!empty($defaults['_is_jsonapi'])) {
                $route->setRequirement('_permission', 'access json api routes');
            }
        }
    }
}
