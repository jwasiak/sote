<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfMinifyFilter automatically adds javascripts and stylesheets information in the sfResponse content.
 *
 * @package    symfony
 * @subpackage sfMinifyPlugin
 * @author     Gordon Franke
 * @version    SVN: $Id: sfMinifyFilter.class.php 666 2009-04-16 07:45:12Z michal $
 */
class sfMinifyFilter extends sfFilter
{
  /**
   * Executes this filter.
   *
   * @param sfFilterChain A sfFilterChain instance
   */
  public function execute($filterChain)
  {
    // execute next filter
    $filterChain->execute();

    // execute this filter only once
    $response = $this->getContext()->getResponse();

    // include javascripts and stylesheets
    $content = $response->getContent();
    if (false !== ($pos = strpos($content, '<!-- ST_ASSET_AUTO_INCLUDE -->')))
    {
      sfLoader::loadHelpers(array('Tag', 'Asset', 'SfMinify'));
      $html = '';
   
      if (!$response->getParameter('stylesheets_included', false, 'symfony/view/asset'))
      {
        $html .= minify_get_stylesheets($response, $this->getParameter('stylesheets', true));
      }
      
      if (!$response->getParameter('javascripts_included', false, 'symfony/view/asset'))
      {
           $html .= minify_get_javascripts($response, $this->getParameter('javascripts', true));
      }

      if ($html)
      {
        $response->setContent(substr($content, 0, $pos).$html.substr($content, $pos));
      }
    }

    $response->setParameter('javascripts_included', false, 'symfony/view/asset');
    $response->setParameter('stylesheets_included', false, 'symfony/view/asset');
  }
}
