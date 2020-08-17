<?php
class stUserFixUpdate
{
    public function fixTable($step)
    {
        return $step + $this->executeFixUser($step);
    }

    public static function postInstall(sfEvent $event)
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        sfLoader::loadHelpers('stProgressBar');
        sfLoader::loadHelpers('Partial');
        $event->getSubject()->msg .= progress_bar('stUserFixData', 'stUserFixUpdate', 'fixTable', sfGuardUserPeer::doCount(new Criteria()));
    }

    public function executeFixUser($step)
    {

        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $c = new Criteria();
        $c->setLimit(10);
        $c->setOffset($step);
        $users = sfGuardUserPeer::doSelect($c);


        foreach ($users as $user)
        {
            if($user->getHashCode()=="")
            {

                $HashCode = md5(microtime().$user->getUsername());
                $user->setHashCode($HashCode);
                $user->save();
            }

            $c = new Criteria();
            $c->add(UserDataPeer::SF_GUARD_USER_ID, $user->getId());
            $c->add(UserDataPeer::IS_BILLING, null);
            UserDataPeer::doDelete($c);

            $c = new Criteria();
            $c->add(UserDataPeer::SF_GUARD_USER_ID, $user->getId());
            $c->add(UserDataPeer::IS_BILLING, 1);
            $userDataBilling = UserDataPeer::doSelectOne($c);

            if($userDataBilling)
            {
                $c = new Criteria();
                $c->add(UserDataPeer::SF_GUARD_USER_ID, $user->getId());
                $c->add(UserDataPeer::IS_BILLING, "");
                $userDataDelivery = UserDataPeer::doSelectOne($c);

                if(!$userDataDelivery)
                {
                    $userData = new UserData();
                    $userData->setSfGuardUserId($user->getId());
                    $userData->setIsBilling(0);
                    $userData->setIsDefault(1);

                    $userData->setName($userDataBilling->getName());
                    $userData->setSurname($userDataBilling->getSurname());
                    $userData->setStreet($userDataBilling->getStreet());
                    $userData->setHouse($userDataBilling->getHouse());
                    $userData->setFlat($userDataBilling->getFlat());
                    $userData->setCode($userDataBilling->getCode());
                    $userData->setTown($userDataBilling->getTown());
                    $userData->setCountriesId($userDataBilling->getCountriesId());
                    $userData->setPhone($userDataBilling->getPhone());
                    $userData->setCompany($userDataBilling->getCompany());

                    $userData->save();

                }
            }

        }

        return count($users);

    }
}
?>