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
 * @version    SVN: $Id: sfGuardGroup.php 4 2008-09-24 08:40:58Z marek $
 */
class sfGuardGroup extends BasesfGuardGroup
{
  public function __toString()
  {
    return $this->getDescription();
  }

  public function save($con = null)
  {
    if ($this->isNew() && null === $this->name)
    {
      $this->setName(md5($this->description.uniqid()));
    } 

    parent::save($con);
  }    
}
