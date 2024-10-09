<?php

namespace Drupal\file_gen_uploader\Service;

/**
 * Interface QrCodeGeneratorInterface.
 *
 * Defines a contract for generating QR codes.
 */
interface QrCodeGeneratorInterface {

  /**
   * Generates a QR code image from the given data.
   *
   * @param string $data
   *   The data to encode in the QR code.
   * @param int $size
   *   The size (width and height) of the QR code in pixels.
   *
   * @return string
   *   The generated QR code image as a binary string (PNG format).
   */
  public function generate(string $data, int $size): string;

}
