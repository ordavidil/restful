<?php
/**
 * @file
 * Contains RestfulFormatterFile.
 */
class RestfulFormatterFile extends \RestfulFormatterBase implements \RestfulFormatterInterface {

  protected $contentType;

  /**
   * {@inheritdoc}
   */
  public function prepare(array $data) {
    if (empty($data['file'])) {
      return $data;
    }

    $file = $data['file']['file'];
    $style = $data['file']['style'];

    $this->contentType = $file->filemime;

    return array(
      'file' => $file,
      'style' => $style,
    );
  }

  /**
   * {@inheritdoc}
   */
  public function render(array $structured_data) {
    if(empty($structured_data['file'])) {
      drupal_json_output($structured_data);
      return;
    }

    if ($structured_data['style']) {
      $file = image_style_url($structured_data['style'], $structured_data['file']->uri);
    }
    else {
      $file = $structured_data['file']->uri;
    }

    readfile($file);
  }

  /**
   * {@inheritdoc}
   */
  public function getContentTypeHeader() {
    return $this->contentType;
  }
}
