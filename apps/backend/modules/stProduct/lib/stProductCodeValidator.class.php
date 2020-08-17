<?php

class stProductCodeValidator extends sfValidator
{
   protected $regex = null;

   public function execute(&$value, &$error)
   {
      if (empty($value))
      {
         $error = 'Podaj kod produktu';

         return false;
      }

      if (!$this->regex->execute($value, $error))
      {
         return false;
      }

      if (!$this->validateUnique($value, $error))
      {
         return false;
      }

      return true;
   }

   public function initialize($context, $parameters = array())
   {
      parent::initialize($context, $parameters);

      $this->regex = new sfRegexValidator();

      $this->regex->initialize($context, array('pattern' => '/["\']/', 'match' => false, 'match_error' => 'Kod produktu nie może zawierać znaków \' oraz "'));

      return true;
   }

   protected function validateUnique($value, &$error)
   {
      $r = $this->getContext()->getRequest();

      $c = new Criteria();

      $c->add(ProductPeer::CODE, $value);

      if ($this->getParameter('check_primary_key', true))
      {
         $c->add(ProductPeer::ID, $this->getParameter('primary_key', $r->getParameter(ProductPeer::translateFieldName('Id', BasePeer::TYPE_PHPNAME, BasePeer::TYPE_FIELDNAME))), Criteria::NOT_EQUAL);
      }
      
      if (ProductPeer::doCount($c))
      {
         $error = 'Ten kod produktu już jest wykorzystany. Wpisz inny kod.';

         return false;
      }

      return true;
   }

}
