<?php


use RedBeanPHP\OODBBean;

abstract class CityDBA extends DBA
{
    protected const TABLE = 'city';
    protected const CITOKEN = 'token';
    protected const NAME = 'name';
    protected const COUNTRY = 'country';

    static protected function _toBean(?City $city): ?City
    {
        if (!$city instanceof City)
            return null;

        if (!$city->getcountry() instanceof Country)
            return null;



        $bean = ($update = (int)$city->getId() > 0)
            ? R::loadForUpdate(self::TABLE, $city->getId())
            : R::dispense(self::TABLE);


        if (!$bean instanceof OODBBean)
            return null;

        if (!$update)
            $bean->{self::CITOKEN} = self::_shortToken();
            $bean->{self::COUNTRY} = (int)$city->getcountry()->getId();
            $bean->{self::NAME} = QString::_set(QString::_latin($city->getName()));


        if (($lastID = (int)R::store($bean)) > 0)
            return self::_toObject(R::load(self::TABLE, $lastID));

        return null;
    }

    static protected function _toObject(?OODBBean $bean): ?City
    {
        if (!$bean instanceof OODBBean)
            return null;

        if (!empty($vars = $bean->export()))
            return new City(
                $vars[self::CID],
                $vars[self::CTOKEN],
                QString::_get($vars[self::NAME]),
                Country::_get(Criteria::ID, (int)$vars[self::COUNTRY]),

        );
        return null;
    }

    static protected function _findByName(?string $name): ?OODBBean
    {
        if (QString::_isNull($name))
            return null;
        return R::findOne(self::TABLE, " LOWER(`" . self::NAME . "`) LIKE '%" . strtolower($name) . "%'");
    }
}
