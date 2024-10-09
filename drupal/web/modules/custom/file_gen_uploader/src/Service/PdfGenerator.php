<?php

namespace Drupal\file_gen_uploader\Service;

use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Mpdf\Mpdf;
use Psr\Log\LoggerInterface;

/**
 * Service to generate PDF files using mPDF.
 */
class PdfGenerator implements PdfGeneratorInterface {

  /**
   * PDF class.
   *
   * @var \Mpdf\Mpdf
   */
  protected Mpdf $mpdf;

  /**
   * Logger interface.
   *
   * @var \Psr\Log\LoggerInterface|\Drupal\Core\Logger\LoggerChannelInterface
   */
  protected LoggerInterface $logger;

  /**
   * PdfGenerator constructor.
   *
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger
   *   Logger service for logging errors.
   */
  public function __construct(LoggerChannelFactoryInterface $logger) {
    // Instantiate mPDF.
    $this->mpdf = new Mpdf();
    $this->logger = $logger->get('file_gen_uploader');
  }

  /**
   * Generate a PDF from the provided HTML content.
   *
   * @param string $htmlContent
   *   The HTML content to be rendered as a PDF.
   * @param string $qrCodeFilePath
   *   The file path of the generated QR code image.
   *
   * @return string
   *   The path to the generated PDF file.
   *
   * @throws \Exception
   */
  public function generate(string $htmlContent, string $qrCodeFilePath): string {
    $tempFile = tempnam(sys_get_temp_dir(), 'pdf_') . '.pdf';

    try {
      // Include the QR code image in the PDF content.
      $htmlContent .= "<p><img src='{$qrCodeFilePath}' alt='QR code'/></p>";

      $this->mpdf->WriteHTML($htmlContent);
      $this->mpdf->Output($tempFile, 'F');

      return $tempFile;
    }
    catch (\Exception $e) {
      // Log the error and rethrow.
      $this->logger->error('PDF generation failed: @error', ['@error' => $e->getMessage()]);
      throw new \Exception('PDF generation failed: ' . $e->getMessage());
    }
  }

}
