<?php
/**
 * Address parser
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 * 
 * @example
 * // require_once ("stAddressParser.class.php"); // commented for Symfony, because of autoload
 * $aparser = new stAddressParser('ul. Polna 1a/2');
 * $result  = $aparser->getAddress();
 * print_r($result);
 * 
 * Array
 * (
 *     [s1] => ul. Polna 
 *     [n1] => 1a
 *     [n2] => 2
 * )
 */

/**
 * Address parser
 */
class stAddressParser
{        
    public function __construct($address)
    {
        $this->address=trim($address);
    }
    
    /**
     * Parse address
     * @param string $address
     * @return array
     */
    protected function parse($address)
    {   
        $result = array('s1' => '', 'n1' => '', 'n2' => '');

        if (preg_match('/([\p{L} .,"\'|\\(\\):&!-]+)([0-9a-z]*)[\/ ]*([0-9]*)/iu', $address, $matches))
        {
            if ($matches[1])
            {
                $result['s1'] = trim(trim($matches[1]), ",");
            }

            if ($matches[2])
            {
                $result['n1'] = trim($matches[2]);
            }

            if ($matches[3])
            {
                $result['n2'] = trim($matches[3]);
            }       
        }

        return $result;
    }
        
    /**
     * Get address
     * @return array('s1'=>street,'n1'=>street nr, 'n2'=>'house number')
     */
    public function getAddress()
    {                       
        return $this->parse($this->address);          
    }    
    
}