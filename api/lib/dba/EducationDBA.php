<?php

use RedBeanPHP\OODBBean;

abstract class EducationDBA extends DBA
{
    protected const TABLE = 'education';
    protected const ID = 'id';
    protected const TOKEN = 'token';
    protected const SCHOOL = 'school';
    protected const DIPLOMA = 'diploma';
    protected const STUDYFIELD = 'studyfield';
    protected const SRTMONTH = 'startmonth';
    protected const SRTYEAR = 'startyear';
    protected const ENDMONTH = 'endmonth';
    protected const ENDYEAR = 'endyear';
    protected const ASSOCIATION = 'association';
    protected const CONTACT = 'contact';

    static protected function _toBean(?Education $education): ?Education
    {
        if (!$education instanceof Education)
            return null;

        if (!$education->getContact() instanceof Contact)
            return null;


        $bean = ($update = (int)$education->getId() > 0)
            ? R::loadForUpdate(self::TABLE, $education->getId())
            : R::dispense(self::TABLE);


        if (!$bean instanceof OODBBean)
            return null;

        if (!$update){
            $bean->{self::TOKEN} = self::_shortToken();
        }
        $bean->{self::SCHOOL} = QString::_set(QString::_latin($education->getSchool()));
        $bean->{self::DIPLOMA} = QString::_set(QString::_latin($education->getDiploma()));
        $bean->{self::STUDYFIELD} = QString::_set(QString::_latin($education->getStudyfield()));
        $bean->{self::SRTMONTH} = (int)($education->getStartmonth());
        $bean->{self::SRTYEAR} = (int)($education->getStartyear());
        $bean->{self::ENDMONTH} = (int)($education->getEndmonth());
        $bean->{self::ENDYEAR} = (int)($education->getEndyear());
        $bean->{self::ASSOCIATION} = QString::_set(QString::_latin($education->getAssociation()));
        $bean->{self::CONTACT} = (int)$education->getContact()->getId();



        if (($lastID = (int)R::store($bean)) > 0)
            return self::_toObject(R::load(self::TABLE, $lastID));

        return null;
    }

    static protected function _toObject(?OODBBean $bean): ?Education
    {
        if (!$bean instanceof OODBBean)
            return null;

        if (!empty($vars = $bean->export()))

            return new Education(
                $vars[self::CID],
                $vars[self::CTOKEN],
                $vars[self::SCHOOL],
                $vars[self::DIPLOMA],
                $vars[self::STUDYFIELD],
                $vars[self::SRTMONTH],
                $vars[self::SRTYEAR],
                $vars[self::ENDMONTH],
                $vars[self::ENDYEAR],
                $vars[self::ASSOCIATION],
                Contact::_get(Criteria::ID, (int)$vars[self::CONTACT]),

            );
        return null;
    }

    static protected function _findBySchool(?string $school): ?OODBBean
    {
        if (QString::_isNull($school))
            return null;
        return R::findOne(self::TABLE, " LOWER(`" . self::SCHOOL . "`) LIKE '%" . strtolower($school) . "%'");
    }

    static protected function _findByDiploma(?string $diploma): ?OODBBean
    {
        if (QString::_isNull($diploma))
            return null;
        return R::findOne(self::TABLE, " LOWER(`" . self::DIPLOMA . "`) LIKE '%" . strtolower($diploma) . "%'");
    }

    static protected function _findByStudyfield(?string $studyfield): ?OODBBean
    {
        if (QString::_isNull($studyfield))
            return null;
        return R::findOne(self::TABLE, " LOWER(`" . self::STUDYFIELD . "`) LIKE '%" . strtolower($studyfield) . "%'");
    }
}