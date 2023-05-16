<?php

class Education extends EducationDBA
{
    private ?int $id;
    private ?string $token;
    private string $school;
    private string $diploma;
    private string $studyfield;
    private int $startmonth;
    private int $startyear;
    private int $endmonth;
    private int $endyear;
    private string $association;
    private ?Contact $contact;

    public function __construct(?int $id = NULL, ?string $token = NULL, string $school = NULL,string $diploma = NULL
    ,string $studyfield = NULL,int $startmonth = NULL,int $startyear = NULL,int $endmonth = NULL,int $endyear = NULL,
    string $association = NULL,?Contact $contact = NULL)
    {
        $this->id = $id;
        $this->token = $token;
        $this->school = $school;
        $this->diploma = $diploma;
        $this->studyfield = $studyfield;
        $this->startmonth = $startmonth;
        $this->startyear = $startyear;
        $this->endmonth = $endmonth;
        $this->endyear = $endyear;
        $this->association = $association;
        $this->contact = $contact;
    }

    public function getId():?int
    {
        return $this->id;
    }

    public function getToken():?string
    {
        return $this->token;
    }

    public function getSchool():string
    {
        return $this->school;
    }

    public function getDiploma():string
    {
        return $this->diploma;
    }

    public function getStudyfield():string
    {
        return $this->studyfield;
    }

    public function getStartmonth():int
    {
        return $this->startmonth;
    }

    public function getStartyear():int
    {
        return $this->startyear;
    }

    public function getEndmonth():int
    {
        return $this->endmonth;
    }

    public function getEndyear():int
    {
        return $this->endyear;
    }

    public function getAssociation():string
    {
        return $this->association;
    }

    public function getContact():?Contact
    {
        return $this->contact;
    }

    public function setId(int $id):void
    {
        $this->id = $id;
    }

    public function setToken(string $token):void
    {
        $this->token = $token;
    }

    public function setSchool(string $school):void
    {
        $this->school = $school;
    }

    public function setDilpoma(string $diploma):void
    {
        $this->diploma = $diploma;
    }

    public function setStudyfield(string $studyfield):void
    {
        $this->studyfield = $studyfield;
    }

    public function setStartmonth(int $startmonth):void
    {
        $this->startmonth = $startmonth;
    }

    public function setStartyear(int $startyear):void
    {
        $this->startyear = $startyear;
    }

    public function setEndmonth(int $endmonth):void
    {
        $this->endmonth = $endmonth;
    }

    public function setEndyear(int $endyear):void
    {
        $this->endyear = $endyear;
    }

    public function setAssociation(string $association):void
    {
        $this->association = $association;
    }

    public function setContact(?Contact $contact):void
    {
        $this->contact = $contact;
    }

    private function isOK(): bool
    {
        if (!$this->contact instanceof Contact)
            throw new Exception("Enter the contact" );

        return true;
    }
    public function save(): ?Education
    {
        if ($this->isOK())
            return self::_toBean($this);
        return null;
    }

    public function toArray(): array
    {
        return [
            TOKEN => ($this->token),
            SCHOOL => QString::_get($this->school),
            DIPLOMA => QString::_get($this->diploma),
            STUDYFIELD => QString::_get($this->studyfield),
            SRTMONTH=> (int)$this->startmonth,
            SRTYEAR => (int)$this->startyear,
            ENDMONTH=> (int)$this->endmonth,
            ENDYEAR => (int)$this->endyear,
            ASSOCIATION => QString::_get($this->association),
            //CONTACT => $this->contact instanceof Contact ? $this->contact->toArray() : null
        ];
    }

    static public function _get(int $criteria, $value): ?Education
    {
        return match (true) {
            $criteria == Criteria::ID && (int)$value > 0 => self::_toObject(parent::_getOne(self::TABLE, [parent::CID => (int)$value])),
            $criteria == Criteria::TOKEN && !QString::_isNull($value) => self::_toObject(parent::_getOne(self::TABLE, [parent::CTOKEN => trim($value)])),
            $criteria == Criteria::SCHOOL && !QString::_isNull($value) => self::_toObject(self::_findBySchool(trim($value))),
            $criteria == Criteria::DIPLOMA && !QString::_isNull($value) => self::_toObject(self::_findByDiploma(trim($value))),
            $criteria == Criteria::STUDYFIELD && !QString::_isNull($value) => self::_toObject(self::_findByStudyfield(trim($value))), 
            default => null,
        };
    }

    static public function _listEducation(?Education $education): ?array
    {
        if (!$education instanceof Education)
            return null;

        if (!empty($beans = parent::_getAll(EducationDBA::TABLE, [self::CONTACT => $education->getId()]))) {
            foreach ($beans as $bean)
                if (($item = self::_toObject($bean)) instanceof self)
                    $education[] = $item->toArray();
        }

        return $education ?? null;
    }

    static public function _list(): ?array
    {
        if (!empty($beans = parent::_getAll(self::TABLE, []))) {
            foreach ($beans as $bean)
                if (($item = self::_toObject($bean)) instanceof self)
                    $education[] = $item->toArray();
        }
        return $education ?? null;
    }
    static public function _listEdu(Contact $contact): ?array
    {
        if (!empty($beans = parent::_getAll(self::TABLE, [self::CONTACT => $contact->getId()]))) {
            foreach ($beans as $bean)
                if (($item = self::_toObject($bean)) instanceof self)
                    $education[] = $item->toArray();
        }
        return $education ?? null;
    }

    private function isGood(): bool
    {
            if (is_null(trim($this->token)))
                throw new Exception('Token is required!');

            return true;
    }

    public function delete(): bool
    {
           if ($this->isGood()) {
               parent::_toTrash(self::TABLE, $this->id);
               return true;
           }
            return false;
    }

}