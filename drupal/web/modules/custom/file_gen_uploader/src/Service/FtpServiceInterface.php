<?php

declare(strict_types=1);

namespace Drupal\file_gen_uploader\Service;

/**
 * Interface FtpServiceInterface.
 *
 * Provides an interface for FTP file upload services.
 * This interface defines the method for uploading files to a remote server.
 */
interface FtpServiceInterface {

  /**
   * Uploads a file from the local file system to a remote FTP server.
   *
   * This method handles the process of transferring a file specified
   * by the local file path to a designated remote file path on the
   * FTP server. It returns a boolean indicating the success or
   * failure of the upload operation.
   *
   * @param string $localFilePath
   *   The path to the file on the local file system that needs to be uploaded.
   * @param string $remoteFilePath
   *   The path on the remote FTP server where the file should be uploaded.
   *
   * @return bool
   *   Returns TRUE if the file upload was successful, or FALSE otherwise.
   */
  public function uploadFile(string $localFilePath, string $remoteFilePath): bool;

}
