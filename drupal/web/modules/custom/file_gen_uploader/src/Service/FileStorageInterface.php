<?php

namespace Drupal\file_gen_uploader\Service;

/**
 * Interface FileStorageInterface.
 *
 * Provides an interface for file storage services.
 * This interface defines methods for saving and deleting files.
 */
interface FileStorageInterface {

  /**
   * Saves the content to a file with the specified name.
   *
   * This method is responsible for persisting the provided content
   * into a file within the storage system. The file will be created
   * if it does not exist or overwritten if it does.
   *
   * @param string $content
   *   The content to be saved in the file.
   * @param string $fileName
   *   The name of the file where the content will be stored.
   *
   * @return string
   *   The file path where the content has been saved.
   */
  public function save(string $content, string $fileName): string;

  /**
   * Deletes a file at the specified file path.
   *
   * This method removes the file identified by the given path from
   * the storage system. If the file does not exist, the method will
   * have no effect.
   *
   * @param string $filePath
   *   The path of the file to be deleted.
   */
  public function delete(string $filePath): void;

}
