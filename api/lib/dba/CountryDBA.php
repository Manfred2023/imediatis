<?php

use RedBeanPHP\OODBBean;

    abstract class CountryDBA extends DBA
    {
        protected const TABLE = 'country';
        protected const NAMEFR = 'namefr';
        protected const NAMEEN = 'nameen';
        protected const CODE = 'code';
        protected const ALPHA2 = 'alpha2';
        protected const ALPHA3 = 'alpha3';
        protected const DIALCODE = 'dialcode';

       

        

        static protected function _toBean(Country $country): Country
        {
            if (!$country instanceof Country)
                return null;

            $bean = (int)$country->getId() > 0
                ? R::loadForUpdate(self::TABLE, $country->getId())
                : R::dispense(self::TABLE);

            if (!$bean instanceof OODBBean)
                return null;

            $bean->{self::NAMEFR} = QString::_alphaNumOnly($country->getNamefr());
            $bean->{self::NAMEEN} = QString::_alphaNumOnly($country->getNameen());
            $bean->{self::CODE} = (int)$country->getCode();
            $bean->{self::ALPHA2} = QString::_set($country->getAlpha2());
            $bean->{self::ALPHA3} = QString::_set($country->getAlpha3());
            $bean->{self::DIALCODE} = (int)$country->getDialcode();
            

            if (($lastCID = (int)R::store($bean)) > 0)
                return self::_toObject(R::load(self::TABLE, $lastCID));

            return null;
        }

        static protected function _toObject(?OODBBean $bean): ?Country
        {
            if (!$bean instanceof OODBBean)
                return null;

            if (!empty($vars = $bean->export())) {
                return new Country(
                    (int)$vars[self::CID],
                    QString::_get($vars[self::NAMEFR]),
                    QString::_get($vars[self::NAMEEN]),
                    (int)$vars[self::CODE],
                    QString::_get($vars[self::ALPHA2]),
                    QString::_get($vars[self::ALPHA3]),
                    (int)$vars[self::DIALCODE],
                  
                );
            }
            return null;
        }

        static protected function _findByNamefr(?string $namefr): ?OODBBean
        {
            if (QString::_isNull($namefr))
                return null;
            return R::findOne(self::TABLE, " LOWER(`" . self::NAMEFR . "`) LIKE '" . strtolower($namefr) . "%'");
        }

        static protected function _findByNameen(?string $nameen): ?OODBBean
        {
            if (QString::_isNull($nameen))
                return null;
            return R::findOne(self::TABLE, " LOWER(`" . self::NAMEEN . "`) LIKE '" . strtolower($nameen) . "%'");
        }

    }