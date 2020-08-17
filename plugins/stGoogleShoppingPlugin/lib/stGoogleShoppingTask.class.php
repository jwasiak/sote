<?php

class stGoogleShoppingTask extends stTask
{
    protected $googleShopping;
    
    public function initialize()
    {
        $this->googleShopping = new stGoogleShopping();
    }
    
    /**
     * W tej metodzie zwracamy ile rekordów/danych zamierzamy wykonać
     */
    public function count(): int
    {                
        return $this->googleShopping->getStepsCount();
    }
    
    public function started() {
        $this->googleShopping->init();
    }

    public function finished() {
        $this->googleShopping->close();
    }

    /**
     * W tej metodzie wykonujemy swoje operacje na danych
     * 
     */
    public function execute(int $offset): int
    {        
        return $this->googleShopping->generate($offset);                         
    }
}