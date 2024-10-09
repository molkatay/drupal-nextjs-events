<?php

namespace Drupal\file_gen_uploader\Service;

/**
 * Provides file storage services for handling temporary files.
 *
 * This class implements the FileStorageInterface and
 * provides methods to save and delete files in the temporary
 * directory.
 */
class FileStorage implements FileStorageInterface {

  /**
   * Saves content to a temporary file.
   *
   * @param string $content
   *   The content to be saved in the file.
   * @param string $fileName
   *   The name of the file to be created (including the extension).
   *
   * @return string
   *   The file path where the content was saved.
   */
  public function save(string $content, string $fileName): string {
    $filePath = 'temporary://' . $fileName;
    file_put_contents($filePath, $content);
    return $filePath;
  }

  /**
   * Deletes a specified file.
   *
   * @param string $filePath
   *   The path of the file to be deleted.
   *
   * @return void
   *   No return value.
   */
  public function delete(string $filePath): void {
    // Delete the specified file.
    unlink($filePath);
  }

}
