<?php

/**
 * Subclass for representing a row from the 'st_tax' table.
 *
 *
 *
 * @package plugins.stTaxPlugin.lib.model
 */
class Tax extends BaseTax
{
   protected $prevVat = null;

   public function getIsSystemDefault()
   {
      return parent::getIsSystemDefault() || $this->getIsDefault();
   }

   public function setEditIsDefault($v)
   {
      $this->setIsDefault($v);
   }

   /**
    * Obsługa domyślności funkcji VAT
    *
    * @author Marcin Butlak <marcin.butlak@sote.pl>
    *
    * @param unknown_type $con
    */
   public function save($con = null)
   {
      if (($this->isColumnModified(TaxPeer::IS_DEFAULT)) && ($this->getIsDefault()))
      {
         $c = new Criteria();

         $c->add(TaxPeer::IS_DEFAULT, 1);

         $tax = TaxPeer::doSelectOne($c);

         if ($tax)
         {
            $tax->setIsDefault(false);

            $tax->save();
         }
      }
   
      $ret = parent::save($con);

      TaxPeer::clearCache();

      return $ret;
   }

   public function delete($con = null)
   {
      $ret = parent::delete($con);

      TaxPeer::clearCache();

      return $ret;
   }

   /**
    *
    * Przeciążenie metody - zapamiętywanie poprzedniej stawki VAT
    *
    * @param float $v Stawka VAT
    *
    * @author Marcin Butlak <marcin.butlak@sote.pl>
    */
   public function setVat($v)
   {
      if (!$this->isColumnModified(TaxPeer::VAT) && !$this->isNew())
      {
         $this->prevVat = $this->getVat();
      }

      parent::setVat($v);
   }

   /**
    * Wyświetlenie nazwy zamiast id
    *
    * @return   unknown
    */
   public function __toString()
   {
      return $this->getVat() . '%';
   }
}
