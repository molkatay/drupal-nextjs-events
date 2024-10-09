<?php

declare(strict_types=1);

namespace Drupal\file_gen_uploader\Service;

use Drupal\Core\Site\Settings;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\Ftp\FtpAdapter;
use League\Flysystem\Ftp\FtpConnectionOptions;

/**
 * FTP Service for uploading files to an FTP server using Flysystem.
 */
class FtpService implements FtpServiceInterface {

  /**
   * The Filesystem instance for handling FTP operations.
   *
   * @var \League\Flysystem\Filesystem
   */
  protected Filesystem $filesystem;

  /**
   * Constructs the FtpService.
   *
   * @param \Drupal\Core\Site\Settings $settings
   *   The Drupal settings service containing FTP configuration.
   *
   * @throws \Exception
   *   Throws an exception if the FTP configuration is invalid.
   */
  public function __construct(Settings $settings) {
    // Configure FTP connection parameters.
    $ftpConfig = [
      'host' => $settings->get('ftp_host'),
      'username' => $settings->get('ftp_user'),
      'password' => $settings->get('ftp_pass'),
      // Default FTP port.
      'port' => 21,
      'root' => '/',
      'passive' => FALSE,
      'ssl' => FALSE,
    ];

    // Create an FTP adapter and Filesystem instance.
    $adapter = new FtpAdapter(FtpConnectionOptions::fromArray($ftpConfig));
    $this->filesystem = new Filesystem($adapter);

    // Log the values for debugging.
    \Drupal::logger('file_gen_uploader')->debug('FTP Host: @host, User: @user', [
      '@host' => $ftpConfig['host'],
      '@user' => $ftpConfig['username'],
    ]);
  }

  /**
   * Upload a file to the FTP server.
   *
   * @param string $localFilePath
   *   The local path of the file to upload.
   * @param string $remoteFilePath
   *   The remote path where the file will be uploaded.
   *
   * @return bool
   *   TRUE if the upload was successful, FALSE otherwise.
   *
   * @throws \Exception
   *   Throws an exception if the connection or upload fails.
   */
  public function uploadFile(string $localFilePath, string $remoteFilePath): bool {
    // Check if the local file exists.
    if (!file_exists($localFilePath)) {
      \Drupal::logger('file_gen_uploader')->error('Local file does not exist: @local', ['@local' => $localFilePath]);
      throw new \Exception('Local file does not exist: ' . $localFilePath);
    }

    // Log local and remote paths.
    \Drupal::logger('file_gen_uploader')->debug('Local file path: @local, Remote file path: @remote', [
      '@local' => $localFilePath,
      '@remote' => $remoteFilePath,
    ]);

    try {
      // Upload the file to the FTP server.
      $stream = fopen($localFilePath, 'rb');
      if ($this->filesystem->writeStream($remoteFilePath, $stream)) {
        // Successful upload.
        return TRUE;
      }
      else {
        // Upload failure.
        throw new \Exception('Failed to upload file to the FTP server.');
      }
    }
    catch (FilesystemException $e) {
      \Drupal::logger('file_gen_uploader')->error('FTP transfer failed: @error', ['@error' => $e->getMessage()]);
      throw new \Exception('FTP transfer failed: ' . $e->getMessage());
    }
    finally {
      // Close the stream if it was opened.
      if (isset($stream)) {
        fclose($stream);
      }
    }
  }

}
