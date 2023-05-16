<?php

use RedBeanPHP\OODBBean;
use RedBeanPHP\RedException\SQL;

abstract class ContactDBA extends DBA
{
    protected const TABLE = 'contact';
    protected const TOKEN = 'token';
    protected const FSTNAME = 'firstname';
    protected const LSTNAME = 'lastname';
    protected const DBIRTH = 'dayofbirth';
    protected const MBIRTH = 'monthofbirth';
    protected const YBIRTH = 'yearofbirth';
    protected const GENDER = 'gender';
    protected const PHONE = 'phonenumber';
    protected const PROFESSION = 'profession';
    protected const DESCRIPTION = 'description';
    protected const DATEADD = 'dateadded';
    protected const DATEMODIF = 'dateofmodification';
    protected const CITY = 'city';



    static protected function _toBean(?Contact $contact): ?Contact
    {
        if (!$contact instanceof Contact)
            return null;

        if (!$contact->getCity() instanceof City)
            return null;


        $bean = ($update = (int)$contact->getId() > 0)
            ? R::loadForUpdate(self::TABLE, $contact->getId())
            : R::dispense(self::TABLE);


        if (!$bean instanceof OODBBean)
            return null;

        if (!$update){
            $bean->{self::TOKEN} = self::_shortToken();
            $bean->{self::DATEADD} = date('Y-m-d H:i:s') ;
        }
        $bean->{self::FSTNAME} = QString::_set(QString::_latin($contact->getFirstname()));
        $bean->{self::LSTNAME} = QString::_set(QString::_latin($contact->getLastname()));
        $bean->{self::DBIRTH} = (int)($contact->getDayofbirth());
        $bean->{self::MBIRTH} = (int)($contact->getMonthofbirth());
        $bean->{self::YBIRTH} = (int)($contact->getYearofbirth());
        $bean->{self::GENDER} = QString::_set(QString::_latin($contact->getGender()));
        $bean->{self::PHONE} = QString::_set(QString::_latin($contact->getPhonenumber()));
        $bean->{self::PROFESSION} = QString::_set(QString::_latin($contact->getProfession()));
        $bean->{self::DESCRIPTION} = QString::_set(QString::_latin($contact->getDescription()));
        $bean->{self::DATEMODIF} = date('Y-m-d H:i:s');
        $bean->{self::CITY} = (int)$contact->getCity()->getId();



        if (($lastID = (int)R::store($bean)) > 0)
            return self::_toObject(R::load(self::TABLE, $lastID));

        return null;
    }

    static protected function _toObject(?OODBBean $bean): ?Contact
    {
        if (!$bean instanceof OODBBean)
            return null;

        if (!empty($vars = $bean->export()))

            return new Contact(
                $vars[self::CID],
                $vars[self::CTOKEN],
                $vars[self::FSTNAME],
                $vars[self::LSTNAME],
                $vars[self::DBIRTH],
                $vars[self::MBIRTH],
                $vars[self::YBIRTH],
                $vars[self::GENDER],
                $vars[self::PHONE],
                $vars[self::PROFESSION],
                $vars[self::DESCRIPTION],
                $vars[self::DATEADD],
                $vars[self::DATEMODIF],
                City::_get(Criteria::ID, (int)$vars[self::CITY]),

            );
        return null;
    }

    static protected function _findByPhoneNumber(?string $phone): ?OODBBean
    {
        if (QString::_isNull($phone))
            return null;
        return R::findOne(self::TABLE, " LOWER(`" . self::PHONE . "`) LIKE '%" . strtolower($phone) . "%'");
    }

    static protected function _findByName(?string $name): ?OODBBean
    {
        if (QString::_isNull($name))
            return null;
        return R::findOne(self::TABLE, " LOWER(`" . self::FSTNAME . "`) LIKE '" . strtolower($name) . "%'");
    }

    static protected function _findByProfession(?string $name): ?OODBBean
    {
        if (QString::_isNull($name))
            return null;
        return R::findOne(self::TABLE, " LOWER(`" . self::PROFESSION . "`) LIKE '" . strtolower($name) . "%'");
    }

    static protected function _findByCity(?string $city): ?OODBBean
    {
        if (QString::_isNull($city))
            return null;
        return R::findOne(self::TABLE, " LOWER(`" . self::CITY . "`) LIKE '" . strtolower($city) . "%'");
    }
}
