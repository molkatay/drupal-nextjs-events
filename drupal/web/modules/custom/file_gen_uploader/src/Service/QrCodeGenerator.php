<?php

namespace Drupal\file_gen_uploader\Service;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

/**
 * Class QrCodeGenerator.
 *
 * Provides functionality to generate QR codes.
 */
class QrCodeGenerator implements QrCodeGeneratorInterface {

  /**
   * Generates a QR code from the given data.
   *
   * @param string $data
   *   The data to encode in the QR code.
   * @param int $size
   *   The size of the generated QR code (width and height in pixels).
   *
   * @return string
   *   The generated QR code as a PNG image string.
   */
  public function generate(string $data, int $size): string {
    // Create a new QR code instance with the provided data.
    $qrCode = new QrCode($data);

    // Set the size of the QR code.
    $qrCode->setSize($size);

    // Create a PNG writer for the QR code.
    $writer = new PngWriter();

    // Write the QR code to a PNG string and return it.
    return $writer->write($qrCode)->getString();
  }

}
