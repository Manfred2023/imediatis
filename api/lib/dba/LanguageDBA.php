<?php

use RedBeanPHP\OODBBean;
abstract class LanguageDBA extends DBA
{
    protected const TABLE = 'language';

    protected const LANNAME = 'name';
    protected const WRITING = 'writing';
    protected const SPEAKING = 'speaking';
    protected const READING = 'reading';
    protected const AVERAGE = 'average';

    static protected function _toBean(?Language $language): ?Language
    {
        if (!$language instanceof Language)
            return null;

        $bean = (int)$language->getId() > 0
            ? R::loadForUpdate(self::TABLE, $language->getId())
            : R::dispense(self::TABLE);

        if (!$bean instanceof OODBBean)
            return null;

        if (is_null($language->getId()))

            $bean->{self::LANNAME} = QString::_set(QString::_latin($language->getName()));
            $bean->{self::WRITING} = (int)$language->getWriting();
            $bean->{self::SPEAKING} = (int)$language->getSpeaking();
            $bean->{self::READING} = (int)$language->getReading();
            $bean->{self::AVERAGE} = (float)$language->getAverage();

        if (($lastID = (int) R::store($bean)) > 0)
            return self::_toObject(R::load(self::TABLE, $lastID));

        return null;
    }

    static protected function _toObject(?OODBBean $bean): ?Language
    {
        if (!$bean instanceof OODBBean)
            return null;

        if (empty($vars = $bean->export()))
            return null;

        return new Language(
            $vars[self::CID],
            $vars[self::LANNAME],
            $vars[self::WRITING],
            $vars[self::SPEAKING],
            $vars[self::READING],
            $vars[self::AVERAGE]
            
        );
    }

    static protected function _findByName(?string $name): ?OODBBean
    {
        if (QString::_isNull($name))
            return null;
        return R::findOne(self::TABLE, " LOWER(`" . self::LANNAME . "`) LIKE '" . strtolower($name) . "%'");
    }


}