<?php

namespace Drupal\file_gen_uploader\Service;

use Drupal\node\Entity\Node;
use Drupal\user\Entity\User;

/**
 * Interface FileGeneratorInterface.
 *
 * Provides an interface for generating files, specifically PDFs,
 * with embedded QR codes for events and participants.
 */
interface FileGeneratorInterface {

  /**
   * Generates a PDF containing event details and a QR code.
   *
   * This method is responsible for creating a PDF file that includes
   * information about the specified event (node) and the participant (user).
   * The generated PDF will also contain a QR code that encodes relevant
   * information.
   *
   * @param \Drupal\node\Entity\Node $node
   *   The event node for which the PDF is being generated.
   * @param \Drupal\user\Entity\User $user
   *   The user entity representing the participant.
   *
   * @return string
   *   The file path of the generated PDF.
   */
  public function generatePdfWithQrCode(Node $node, User $user): string;

}
