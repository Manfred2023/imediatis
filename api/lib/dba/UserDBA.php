<?php

use RedBeanPHP\OODBBean;

abstract class UserDBA extends DBA
{
    protected const TABLE = 'user';
    protected const TOKEN = 'token';
    protected const EMAIL = 'email';
    protected const PASSWORD = 'password';
    protected const CONTACT = 'contact';

    static protected function _toBean(?User $user): ?User
    {
        if (!$user instanceof User)
            return null;

        if (!$user->getContact() instanceof Contact)
            return null;



        $bean = ($update = (int)$user->getId() > 0)
            ? R::loadForUpdate(self::TABLE, $user->getId())
            : R::dispense(self::TABLE);


        if (!$bean instanceof OODBBean)
            return null;

        if (!$update)
            $bean->{self::TOKEN} = self::_shortToken();
        $bean->{self::EMAIL} = QString::_set($user->getEmail());
        $bean->{self::PASSWORD} = QString::_set($user->getPassword());
        $bean->{self::CONTACT} = (int)$user->getContact()->getId();


        if (($lastID = (int)R::store($bean)) > 0)
            return self::_toObject(R::load(self::TABLE, $lastID));

        return null;
    }

    static protected function _toObject(?OODBBean $bean): ?User
        {
            if (!$bean instanceof OODBBean)
                return null;

            if (!empty($vars = $bean->export()))

                return new User(
                    $vars[self::CID],
                    $vars[self::CTOKEN],
                    QString::_get($vars[self::EMAIL]),
                    QString::_get($vars[self::PASSWORD]),
                    Contact::_get(Criteria::ID, (int) $vars[self::CONTACT]),
                );
            return null;
        }

        static protected function _findByEmail(?string $email): ?OODBBean
        {
            if (QString::_isNull($email))
                return null;
            return R::findOne(self::TABLE, " LOWER(`" . self::EMAIL . "`) LIKE '" . strtolower($email) . "%'");
        }
}