<?php declare(strict_types = 1);

namespace Drupal\custom_event\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Event type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "event_type",
 *   label = @Translation("Event type"),
 *   label_collection = @Translation("Event types"),
 *   label_singular = @Translation("event type"),
 *   label_plural = @Translation("events types"),
 *   label_count = @PluralTranslation(
 *     singular = "@count events type",
 *     plural = "@count events types",
 *   ),
 *   handlers = {
 *     "form" = {
 *       "add" = "Drupal\custom_event\Form\EventTypeForm",
 *       "edit" = "Drupal\custom_event\Form\EventTypeForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "list_builder" = "Drupal\custom_event\EventTypeListBuilder",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   admin_permission = "administer event types",
 *   bundle_of = "event",
 *   config_prefix = "event_type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "add-form" = "/admin/structure/event_types/add",
 *     "edit-form" = "/admin/structure/event_types/manage/{event_type}",
 *     "delete-form" = "/admin/structure/event_types/manage/{event_type}/delete",
 *     "collection" = "/admin/structure/event_types",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "uuid",
 *   },
 * )
 */
final class EventType extends ConfigEntityBundleBase {

  /**
   * The machine name of this event type.
   */
  protected string $id;

  /**
   * The human-readable name of the event type.
   */
  protected string $label;

}
