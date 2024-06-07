<?php

declare(strict_types=1);

namespace Drupal\social_links\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'social_link_widget' widget.
 *
 * @FieldWidget(
 *   id = "social_link_widget",
 *   label = @Translation("Social Link Widget"),
 *   field_types = {
 *     "social_link"
 *   }
 * )
 */
class SocialLinkWidget extends WidgetBase implements ContainerFactoryPluginInterface
{
  /**
   * Constructs a SocialLinkWidget object.
   *
   * @param string $plugin_id
   *   The plugin ID for the widget.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param array $field_definition
   *   The field definition.
   * @param array $settings
   *   The widget settings.
   * @param array $third_party_settings
   *   Any third party settings.
   */
    public function __construct($plugin_id, $plugin_definition, $field_definition, $settings, $third_party_settings)
    {
        parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $third_party_settings);
    }

  /**
   * {@inheritdoc}
   */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
    {
        return new static(
            $plugin_id,
            $plugin_definition,
            $configuration['field_definition'],
            $configuration['settings'],
            $configuration['third_party_settings']
        );
    }

  /**
   * {@inheritdoc}
   */
    public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state)
    {
        $element['network'] = [
        '#type' => 'select',
        '#title' => $this->t('Network'),
        '#default_value' => $items[$delta]->network ?? null,
        '#options' => [
        'facebook' => $this->t('Facebook'),
        'instagram' => $this->t('Instagram'),
        'x' => $this->t('X'),
        ],
        ];

        $element['url'] = [
        '#type' => 'url',
        '#title' => $this->t('URL'),
        '#default_value' => $items[$delta]->url ?? null,
        ];

        $element['icon'] = [
        '#type' => 'media_library',
        '#allowed_bundles' => ["svg"],
        '#multiple' => false,
        '#title' => $this->t('Icon'),
        '#default_value' => $items[$delta]->icon ?? 0,
        '#description' => $this->t('This image will fill the width of the region it is placed in.'),
        '#required' => false,
        ];
        return $element;
    }
    public function extractFormValues(FieldItemListInterface $items, array $form, FormStateInterface $form_state)
    {
        parent::extractFormValues($items, $form, $form_state);
        $t = 0;
    }
}
