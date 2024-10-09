<?php

declare(strict_types=1);

namespace Drupal\file_gen_uploader\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\file_gen_uploader\Service\FileGenerator;
use Drupal\node\NodeStorageInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Returns responses for File Gen Uploader routes.
 *
 * This controller handles the generation of files (PDFs)
 * related to events and participants, using the FileGenerator service.
 */
final class ExportController extends ControllerBase {

  /**
   * File Genrator service.
   *
   * @var \Drupal\file_gen_uploader\Service\FileGenerator
   */
  protected FileGenerator $fileGenerator;

  /**
   * Node interface.
   *
   * @var \Drupal\node\NodeStorageInterface|\Drupal\Core\Entity\EntityStorageInterface
   */
  protected NodeStorageInterface $nodeStorage;

  /**
   * Entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected EntityTypeManagerInterface $entityTypeManager;

  /**
   * Constructor.
   *
   * @param \Drupal\file_gen_uploader\Service\FileGenerator $fileGenerator
   *   The service for generating files.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entity type manager service.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function __construct(FileGenerator $fileGenerator, EntityTypeManagerInterface $entityTypeManager) {
    $this->fileGenerator = $fileGenerator;
    $this->entityTypeManager = $entityTypeManager;
    // Initialize the node storage service.
    $this->nodeStorage = $entityTypeManager->getStorage('node');
  }

  /**
   * Creates an instance of the controller.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The service container.
   *
   * @return static
   *   A new instance of the controller.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('file_gen_uploader.file_generator'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * Generates a PDF for the specified node.
   *
   * This method loads the node by its ID and generates a PDF
   * document with event and participant information, including
   * a QR code.
   *
   * @param int $nid
   *   The node ID for which to generate the PDF.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   The response containing the status of the PDF generation.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException
   *   Throws a 404 exception if the node is not found.
   */
  public function generatePdf($nid) {
    // Load the node by its ID.
    $node = $this->nodeStorage->load($nid);
    if (!$node) {
      // Return a 404 error if the node does not exist.
      throw new HttpException(404, 'Node not found');
    }

    // Load the current user.
    $user = $this->entityTypeManager->getStorage('user')->load($this->currentUser()->id());

    try {
      // Generate the PDF with event and participant info, including a QR code.
      $filePath = $this->fileGenerator->generatePdfWithQrCode($node, $user);

      // Return success response with file path.
      return new Response('PDF generated successfully and stored at: ' . $filePath);

    }
    catch (\Exception $e) {
      // Return error response if PDF generation fails.
      return new Response('Error uploading PDF: ' . $e->getMessage(), 500);
    }
  }

}
