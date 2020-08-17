<?php
/**
 * @package    stRSSPlugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfRss201rev2Feed.class.php 2092 2008-11-18 19:28:41Z michal $
 */
class sfRss201rev2Feed extends sfRssFeed
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
      if ($this->getItemFeedUniqueId($item))
      {
        $xml[] = '  <guid isPermalink="false">'.$this->getItemFeedUniqueId($item).'</guid>';
      }

      // author information
      if ($this->getItemFeedAuthorEmail($item) && $this->getItemFeedAuthorName($item))
      {
        $xml[] = sprintf('  <author>%s (%s)</author>', $this->getItemFeedAuthorEmail($item), $this->getItemFeedAuthorName($item));
      }
      if ($this->getItemFeedPubdate($item))
      {
        $xml[] = '  <pubDate>'.date('r', $this->getItemFeedPubdate($item)).'</pubDate>';
      }
      if ($this->getItemFeedComments($item))
      {
        $xml[] = '  <comments>'.htmlspecialchars($this->getItemFeedComments($item)).'</comments>';
      }

      // enclosure
      if ((method_exists($item, 'getFeedEnclosure')) && ($enclosure = $item->getFeedEnclosure()))
      {
        $enclosure_attributes = sprintf('url="%s" length="%s" type="%s"', $enclosure->getUrl(), $enclosure->getLength(), $enclosure->getMimeType());
        $xml[] = '  <enclosure '.$enclosure_attributes.'></enclosure>';
      }

      // categories
      foreach ($this->getItemFeedCategories($item) as $category)
      {
        $xml[] = '  <category>'.$category.'</category>';
      }

      $xml[] = '</item>';
    }

    return $xml;
  }

  protected function getVersion()
  {
    return '2.0';
  }
}

?>