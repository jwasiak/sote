<?php
/**
 * SOTESHOP/stPriceCompare
 *
 * Ten plik należy do aplikacji stPriceCompare opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPriceCompare
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stPriceCompareHelper.php 14287 2011-07-26 07:08:05Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Otwieranie tagów xml
 *
 * @param string $name nazwa tagu xml
 * @return string
 */
function price_compare_xml_open_tag($name)
{
	return "<".$name.">\n";
}

/**
 * Alias do price_compare_xml_open_tag
 *
 * @param string $name nazwa tagu xml
 * @return string
 */
function xml_open_tag($name)
{
	return price_compare_xml_open_tag($name);
}

/**
 * Zamykanie tagów xml
 *
 * @param string $name nazwa tagu xml
 * @return string
 */
function price_compare_xml_close_tag($name)
{
	return "</".$name.">\n";
}

/**
 * Alias do price_compare_xml_close_tag
 *
 * @param string $name nazwa tagu xml
 * @return string
 */
function xml_close_tag($name)
{
	return price_compare_xml_close_tag($name);
}

/**
 * Pełny tag xml
 *
 * @param string $name nazwa tagu xml
 * @param string $content zawartosc tagu
 * @param array $parameters dodatkowe parametry
 * @return string
 */
function price_compare_xml_tag($name, $content, $parameters = array())
{
	$params = '';
	if (!empty($parameters)) foreach ($parameters as $key => $value) $params.= ' '.$key.'="'.$value.'"';
	if (!$name) return '';
	if ($content === null) return "<".$name.$params."/>\n";
	return "<".$name.$params.">".$content."</".$name.">\n";
}

/**
 * Alias do price_compare_xml_tag
 *
 * @param string $name nazwa tagu xml
 * @param string $content zawartosc tagu
 * @param array $parameters dodatkowe parametry
 * @return string
 */
function xml_tag($name, $content, $parameters = array())
{
	return price_compare_xml_tag($name, $content, $parameters);
}

/**
 * Dodawanie CDATA do zawartości tagów xml
 *
 * @param string $content zawartosc tagu
 * @return string
 */
function price_compare_xml_cdata_tag($content)
{
	return "<![CDATA[$content]]>";
}

/**
 * Alias do price_compare_xml_cdata_tag
 *
 * @param string $content zawartosc tagu
 * @return string
 */
function xml_cdata($content)
{
	return price_compare_xml_cdata_tag($content);
}

/**
 * Pełny tag xml z CDATA
 *
 * @param string $content zawartosc tagu
 * @return string
 */
function xml_cdata_tag($name, $content, $parameters = array())
{
	return price_compare_xml_tag($name, xml_cdata($content), $parameters);
}