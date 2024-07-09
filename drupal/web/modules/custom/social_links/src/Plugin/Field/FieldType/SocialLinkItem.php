<?php

declare(strict_types=1);

namespace Drupal\social_links\Plugin\Field\FieldType;

use Drupal\Core\Entity\TypedData\EntityDataDefinition;
use Drupal\Core\Field\Annotation\FieldType;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\TypedData\DataReferenceDefinition;

/**
 * Defines the 'social_link' field type.
 *
 * @FieldType(
 *   id = "social_link",
 *   label = @Translation("Social Link"),
 *   description = @Translation("Some description."),
 *   default_widget = "social_link_widget",
 *   default_formatter = "social_link_formatter",
 * )
 */
final class SocialLinkItem extends FieldItemBase {
  use StringTranslationTrait;

  /**
   * The entity manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * {@inheritdoc}
   */
  public static function defaultStorageSettings() {
    return [
      'max_length' => 255,
      'is_ascii' => FALSE,
      'case_sensitive' => FALSE,
    ] + parent::defaultStorageSettings();
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['network'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Network'))
      ->setRequired(TRUE);

    $properties['url'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Url'))
      ->addConstraint('ValidPath');

    $properties['icon'] = DataReferenceDefinition::create('entity')
      ->setLabel(new TranslatableMarkup('Icon'))
      ->setDescription(new TranslatableMarkup('Reference to the media entity for the icon.'))
      ->setTargetDefinition(EntityDataDefinition::create('media'))
      ->addConstraint('EntityType', 'media')
      ->addConstraint('Bundle', 'svg')
      ->setSetting('target_bundles', ['svg']);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function setValue($values, $notify = TRUE): void {
    parent::setValue($values, FALSE);

    // Populate the computed "icon" property.
    if (is_array($values) && array_key_exists('icon', $values)) {
      // $this->set('media', $this->getEntityTypeManager()->getStorage('media')->load($values['icon']), $notify);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $network = $this->get('network')->getValue();
    $url = $this->get('url')->getValue();
    $icon = $this->get('icon')->getValue();
    return $network === NULL && $url === NULL && $icon === NULL;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = [
      'columns' => [
        'network' => [
          'type' => 'varchar',
          'length' => 255,
          'not null' => TRUE,
        ],
        'url' => [
          'type' => 'varchar',
          'length' => 2048,
          'not null' => TRUE,
        ],
        'icon' => [
          'type' => 'svg_image_field',
          'unsigned' => TRUE,
          'not null' => FALSE,
          'description' => 'The ID of the media entity for the icon.',
        ],
      ],
    ];

    return $schema;
  }

  /**
   * Gets the entity manager.
   *
   * @return \Drupal\Core\Entity\EntityTypeManagerInterface
   *   The entity manager service.
   */
  protected function getEntityTypeManager() {
    if (!isset($this->entityTypeManager)) {
      $this->entityTypeManager = \Drupal::entityTypeManager();
    }
    return $this->entityTypeManager;
  }

}
