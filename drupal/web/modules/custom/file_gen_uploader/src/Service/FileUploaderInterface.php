<?php

namespace Drupal\file_gen_uploader\Service;

/**
 * File uploader interface.
 */
interface FileUploaderInterface {

  /**
   * Method upload.
   */
  public function upload($filePath, $remotePath);

}
