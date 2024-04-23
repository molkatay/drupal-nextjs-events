<?php declare(strict_types = 1);

namespace Drupal\custom_event;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining an event entity type.
 */
interface EventInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
