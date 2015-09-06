<?php

/**
 * @file
 * Contains RestfulGetFile.
 */

class RestfulGetFile extends \RestfulEntityBase {

  /**
   * Overrides \RestfulDataProviderEFQ::controllersInfo().
   *
   * Accept only GET request with an id.
   */
  public static function controllersInfo() {
    return array(
      '^.*$' => array(
        \RestfulInterface::GET => 'viewEntity',
      ),
    );
  }

  /**
   * Overrides \RestfulEntityBaseNode::publicFieldsInfo().
   */
  public function publicFieldsInfo() {
    $public_fields = array();
    $public_fields['file'] = array(
      'property' => 'fid',
      'process_callbacks' => array(
        array($this, 'fileProcess'),
      ),
    );
    return $public_fields;
  }

  /**
   * Process callback.
   *
   * @param $fid
   *   The file id.
   * @return array
   *  An array containing the file object plus the image style if exists.
   *
   * @throws \Exception
   *  If requested image style does'nt exists.
   */
  protected function fileProcess($fid) {
    $file = file_load($fid);

    $request = $this->getRequest();
    $style = isset($request['style']) ? $request['style'] : FALSE;

    if ($style) {
      if (strpos($file->filemime, 'image') === FALSE) {
        // Non image file can't have an image style.
        $style = FALSE;
      }

      if (!image_style_load($style)) {
        throw new \Exception(format_string('Image style @style does\'nt exists.', array('@style' => $style)));
      }
    }

    return array(
      'file' => $file,
      'style' => $style,
    );
  }
}
