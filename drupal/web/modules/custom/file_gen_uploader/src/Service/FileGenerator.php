<?php

declare(strict_types=1);

namespace Drupal\file_gen_uploader\Service;

use Drupal\node\Entity\Node;
use Drupal\user\Entity\User;

/**
 * Implements FileGeneratorInterface to handle PDF generation and QR code.
 *
 * This class is responsible for generating a PDF file that includes
 * event details and a corresponding QR code for a specified node
 * (event) and user (participant). It also manages the storage and
 * uploading of the generated files.
 */
class FileGenerator implements FileGeneratorInterface {

  /**
   * Pdf Generator service.
   *
   * @var \Drupal\file_gen_uploader\Service\PdfGeneratorInterface
   */
  protected PdfGeneratorInterface $pdfGenerator;

  /**
   * File Storage service.
   *
   * @var \Drupal\file_gen_uploader\Service\FileStorageInterface
   */
  protected FileStorageInterface $fileStorage;

  /**
   * File storage service for temporary files.
   */
  protected QrCodeGeneratorInterface $qrCodeGenerator;

  /**
   * QR code generator service.
   */
  /**
   * FTP service for uploading files.
   */
  protected FtpService $ftpService;

  /**
   * Constructor for the FileGenerator class.
   *
   * @param QrCodeGeneratorInterface $qrCodeGenerator
   *   The QR code generator service.
   * @param PdfGeneratorInterface $pdfGenerator
   *   The PDF generator service.
   * @param FileStorageInterface $fileStorage
   *   The file storage service.
   * @param FtpService $ftpService
   *   The FTP service for file uploads.
   */
  public function __construct(QrCodeGeneratorInterface $qrCodeGenerator, PdfGeneratorInterface $pdfGenerator, FileStorageInterface $fileStorage, FtpService $ftpService) {
    $this->pdfGenerator = $pdfGenerator;
    $this->fileStorage = $fileStorage;
    $this->qrCodeGenerator = $qrCodeGenerator;
    $this->ftpService = $ftpService;
  }

  /**
   * Generates a PDF with a QR code for a specific node and user.
   *
   * This method creates a QR code containing event details and
   * participant information, generates a PDF document, uploads it
   * to an FTP server, and cleans up temporary files.
   *
   * @param \Drupal\node\Entity\Node $node
   *   The node entity representing the event.
   * @param \Drupal\user\Entity\User $user
   *   The user entity representing the participant.
   *
   * @return string
   *   The remote file path of the uploaded PDF.
   *
   * @throws \Exception
   *   Throws an exception if any part of the process fails.
   */
  public function generatePdfWithQrCode(Node $node, User $user): string {
    // Prepare QR code data.
    $qrCodeData = sprintf("Event: %s\nParticipant: %s\nDate: %s",
      $node->getTitle(),
      $user->getDisplayName(),
      date('Y-m-d')
    );

    // Generate the QR code image.
    $qrCodeImage = $this->qrCodeGenerator->generate($qrCodeData, 150);
    $qrCodeFilePath = $this->fileStorage->save($qrCodeImage, 'qr_code_' . $node->id() . '.png');

    // Generate HTML content for the PDF.
    $htmlContent = '<h1>' . $node->getTitle() . '</h1>';
    $htmlContent .= '<p>Participant: ' . $user->getDisplayName() . '</p>';
    $htmlContent .= '<p>Date: ' . date('Y-m-d') . '</p>';
    $htmlContent .= "<p><img src='" . $qrCodeFilePath . "' alt='QR code'/></p>";

    // Generate the PDF and save it to a temporary location.
    $pdfContent = $this->pdfGenerator->generate($htmlContent, $qrCodeFilePath);
    $tempFilePath = 'temporary://event_' . $node->id() . '.pdf';
    // Save the PDF content to a temporary file.
    file_put_contents($tempFilePath, $pdfContent);

    // Define the remote file path for the PDF on the FTP server.
    $remoteFilePath = '/uploads/events/event_' . $node->id() . '.pdf';

    // Upload the generated PDF to the FTP server.
    $this->ftpService->uploadFile($tempFilePath, $remoteFilePath);

    // Clean up the temporary QR code image file.
    $this->fileStorage->delete($qrCodeFilePath);

    // Return the remote file path of the uploaded PDF.
    return $remoteFilePath;
  }

}
