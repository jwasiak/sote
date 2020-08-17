<?php
/**
 * @package    stRSSPlugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfRssUserland091Feed.class.php 2092 2008-11-18 19:28:41Z michal $
 */
class sfRssUserland091Feed extends sfRssFeed
{
  protected function getFeedElements()
  {
    $xml = array();
    foreach ($this->getItems() as $item)
    {
      $xml[] = '<item>';
      $xml[] = '  <title>'.htmlspecialchars($this->getItemFeedTitle($item)).'</title>';
      if ($this->getItemFeedDescription($item))
      {
        $xml[] = '  <description>'.htmlspecialchars($this->getItemFeedDescription($item)).'</description>';
      }
      $xml[] = '  <link>'.$this->getItemFeedLink($item).'</link>';
      $xml[] = '</item>';
    }

    return $xml;
  }

  protected function getVersion()
  {
    return '0.91';
  }
}

?>