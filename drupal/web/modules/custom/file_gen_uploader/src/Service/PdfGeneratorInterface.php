<?php

namespace Drupal\file_gen_uploader\Service;

/**
 * Interface PdfGeneratorInterface.
 *
 * Defines a contract for generating PDF documents from HTML content.
 */
interface PdfGeneratorInterface {

  /**
   * Generates a PDF document from the provided content and QR code file path.
   *
   * @param string $htmlContent
   *   The HTML content to include in the PDF.
   * @param string $qrCodeFilePath
   *   The file path to the QR code image to include in the PDF.
   *
   * @return string
   *   The generated PDF document as a string (binary content).
   */
  public function generate(string $htmlContent, string $qrCodeFilePath): string;

}
