<?php

use RedBeanPHP\OODBBean;

abstract class ExperienceDBA extends DBA
{
    protected const TABLE = 'experience';
    protected const ID = 'id';
    protected const TOKEN = 'token';
    protected const POSITION = 'position';
    protected const COMPANY = 'company';
    protected const PLACE = 'place';
    protected const TYPEPLACE = 'typeofplace';
    protected const SRTMONTH = 'startmonth';
    protected const SRTYEAR = 'startyear';
    protected const ENDMONTH = 'endmonth';
    protected const ENDYEAR = 'endyear';
    protected const CONTRACT = 'contract';
    protected const DESCRIPTION = 'description';
    protected const CONTACT = 'contact';

    static protected function _toBean(?Experience $experience): ?Experience
    {
        if (!$experience instanceof Experience)
            return null;

        if (!$experience->getContact() instanceof Contact)
            return null;


        $bean = ($update = (int)$experience->getId() > 0)
            ? R::loadForUpdate(self::TABLE, $experience->getId())
            : R::dispense(self::TABLE);


        if (!$bean instanceof OODBBean)
            return null;

        if (!$update){
            $bean->{self::TOKEN} = self::_shortToken();
        }
        $bean->{self::POSITION} = QString::_set(QString::_latin($experience->getPosition()));
        $bean->{self::COMPANY} = QString::_set(QString::_latin($experience->getCompany()));
        $bean->{self::PLACE} = QString::_set(QString::_latin($experience->getPlace()));
        $bean->{self::TYPEPLACE} = QString::_set(QString::_latin($experience->getTypeofplace()));
        $bean->{self::SRTMONTH} = (int)($experience->getStartmonth());
        $bean->{self::SRTYEAR} = (int)($experience->getStartyear());
        $bean->{self::ENDMONTH} = (int)($experience->getEndmonth());
        $bean->{self::ENDYEAR} = (int)($experience->getEndyear());
        $bean->{self::CONTRACT} = QString::_set(QString::_latin($experience->getContract()));
        $bean->{self::DESCRIPTION} = QString::_set(QString::_latin($experience->getDescription()));
        $bean->{self::CONTACT} = (int)$experience->getContact()->getId();



        if (($lastID = (int)R::store($bean)) > 0)
            return self::_toObject(R::load(self::TABLE, $lastID));

        return null;
    }

    static protected function _toObject(?OODBBean $bean): ?Experience
    {
        if (!$bean instanceof OODBBean)
            return null;

        if (!empty($vars = $bean->export()))

            return new Experience(
                $vars[self::CID],
                $vars[self::CTOKEN],
                $vars[self::POSITION],
                $vars[self::COMPANY],
                $vars[self::PLACE],
                $vars[self::TYPEPLACE],
                $vars[self::SRTMONTH],
                $vars[self::SRTYEAR],
                $vars[self::ENDMONTH],
                $vars[self::ENDYEAR],
                $vars[self::CONTRACT],
                $vars[self::DESCRIPTION],
                Contact::_get(Criteria::ID, (int)$vars[self::CONTACT]),

            );
        return null;
    }

    static protected function _findByPosition(?string $position): ?OODBBean
    {
        if (QString::_isNull($position))
            return null;
        return R::findOne(self::TABLE, " LOWER(`" . self::POSITION . "`) LIKE '%" . strtolower($position) . "%'");
    }

    static protected function _findByCompany(?string $company): ?OODBBean
    {
        if (QString::_isNull($company))
            return null;
        return R::findOne(self::TABLE, " LOWER(`" . self::COMPANY . "`) LIKE '%" . strtolower($company) . "%'");
    }
}