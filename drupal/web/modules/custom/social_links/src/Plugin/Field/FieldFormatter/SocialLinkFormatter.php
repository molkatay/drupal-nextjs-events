<?php

declare(strict_types=1);

namespace Drupal\social_links\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'Social Link Formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "social_link_formatter",
 *   label = @Translation("Social Link Formatter"),
 *   field_types = {"social_link"},
 * )
 */
final class SocialLinkFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $icon_url = '';
      if ($item->icon) {
        $file = \Drupal::entityTypeManager()->getStorage('media')->load($item->icon);
        if ($file) {
          $icon_url = $file->get('field_media_svg')->entity->url();
        }
      }

      $elements[$delta] = [
        '#theme' => 'social_link',
        '#network' => $item->network,
        '#url' => $item->url,
        '#icon' => $icon_url,
      ];
    }

    return $elements;
  }

}
