<?php
/** 
 * SOTESHOP/stMailPlugin
 *
 * Ten plik należy do aplikacji stMailPlugin opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stMailPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: MailAccount.php 2947 2010-01-08 15:11:27Z marcin $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/** 
 * Klasa MailAccount
 *
 * @package     stMailPlugin
 * @subpackage  libs
 */
class MailAccount extends BaseMailAccount
{
    public function hydrate(\ResultSet $rs, $startcol = 1)
    {
        $result = parent::hydrate($rs, $startcol);

        if ($this->version >= 2)
        {
            $crypt = Crypt::getInstance();
            $this->password = $crypt->Decrypt($this->password);
        }

        return $result;
    }

    public function save($con = null)
    {
        if ($this->getIsDefault() && $this->isColumnModified(MailAccountPeer::IS_DEFAULT))
        {
            $sc = new Criteria();

            $sc->add(MailAccountPeer::ID, $this->getId(), Criteria::NOT_EQUAL);

            $uc = new Criteria();

            $uc->add(MailAccountPeer::IS_DEFAULT, false);

            $con = Propel::getConnection();

            BasePeer::doUpdate($sc, $uc, $con);
        }
        
        if ($this->getIsNewsletter() && $this->isColumnModified(MailAccountPeer::IS_DEFAULT))
        {
            $sc = new Criteria();

            $sc->add(MailAccountPeer::ID, $this->getId(), Criteria::NOT_EQUAL);

            $uc = new Criteria();

            $uc->add(MailAccountPeer::IS_NEWSLETTER, false);

            $con = Propel::getConnection();

            BasePeer::doUpdate($sc, $uc, $con);
        }

        if ($this->isModified(MailAccountPeer::PASSWORD) || $this->version < 2)
        {
            $crypt = Crypt::getInstance();
            $this->setPassword($crypt->Encrypt($this->getPassword()));
            $this->setVersion(2);
        }

        return parent::save($con);
    }
}

