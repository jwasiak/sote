<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardPermission.php 4 2008-09-24 08:40:58Z marek $
 */
class sfGuardPermission extends BasesfGuardPermission
{
   public function getLabel()
   {
      return !$this->description ? $this->name : $this->description;
   }

   public function __toString()
   {
      return $this->getName();
   }   
}
