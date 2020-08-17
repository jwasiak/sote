<?php
/**
 * @package    stRSSPlugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfFeedEnclosure.class.php 2092 2008-11-18 19:28:41Z michal $
 */
class sfFeedEnclosure
{
  private
    $url,
    $length,
    $mimeType;

  public function setUrl ($url)
  {
    $this->url = $url;
  }

  public function getUrl ()
  {
    return $this->url;
  }

  public function setLength ($length)
  {
    $this->length = $length;
  }

  public function getLength ()
  {
    return $this->length;
  }

  public function setMimeType ($mimeType)
  {
    $this->mimeType = $mimeType;
  }

  public function getMimeType ()
  {
    return $this->mimeType;
  }
}

?>