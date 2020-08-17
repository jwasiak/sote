<?php

class stKeyGenerator
{
    protected $template;
    protected $prefix;

    public function __construct($prefix, $template = null)
    {
        $this->template = null === $template ?  '@-##99' : $template;
        $this->prefix = $prefix;
    }

    public function generate()
    {
        $k = strlen($this->template);
        $sernum = '';
        
        for ($i=0; $i<$k; $i++)
        {
            switch($this->template[$i])
            {
                case '@': $sernum .= $this->prefix; break;
                case '#': $sernum .= chr(rand(65,90)); break;
                case '9': $sernum .= rand(0,9); break;
                case '-': $sernum .= '-';  break;
                default: $sernum .= $this->template[$i]; break; 
            }
        }

        return $sernum;
    }
}