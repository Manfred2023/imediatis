<?php

class Experience extends ExperienceDBA
{
    private ?int $id;
    private ?string $token;
    private string $position;
    private string $company;
    private string $place;
    private string $typeofplace;
    private int $startmonth;
    private int $startyear;
    private int $endmonth;
    private int $endyear;
    private string $contract;
    private string $description;
    private ?Contact $contact;

    public function __construct(?int $id = NULL, ?string $token = NULL, string $position = NULL, string $company = NULL, string $place = NULL, 
    string $typeofplace = NULL,int $startmonth = NULL,int $startyear = NULL,int $endmonth = NULL,int $endyear = NULL, string $contract = NULL,
    string $description = NULL, ?Contact $contact = NULL)
    {
        $this->id = $id;
        $this->token = $token;
        $this->position = $position;
        $this->company = $company;
        $this->place = $place;
        $this->typeofplace = $typeofplace;
        $this->startmonth = $startmonth;
        $this->startyear = $startyear;
        $this->endmonth = $endmonth;
        $this->endyear = $endyear;
        $this->contract = $contract;
        $this->description = $description;
        $this->contact = $contact;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken():string
    {
        return $this->token;
    }

    public function getPosition():string
    {
        return $this->position;
    }

    public function getCompany():string
    {
        return $this->company;
    }

    public function getPlace():string
    {
        return $this->place;
    }

    public function getTypeofplace():string
    {
        return $this->typeofplace;
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

    public function getContract():string
    {
        return $this->contract;
    }

    public function getDescription():string
    {
        return $this->description;
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

    public function setPosition(string $position):void
    {
        $this->position = $position;
    }

    public function setCompany(string $company):void
    {
        $this->company = $company;
    }

    public function setPlace(string $place):void
    {
        $this->place = $place;
    }

    public function setTypeofplace(string $typeofplace):void
    {
        $this->typeofplace = $typeofplace;
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

    public function setContract(string $contract):void
    {
        $this->contract = $contract;
    }

    public function setDescription(string $description):void
    {
        $this->description = $description;
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
    public function save(): ?Experience
    {
        if ($this->isOK())
            return self::_toBean($this);
        return null;
    }

    public function toArray(): array
    {
        return [
            TOKEN => ($this->token),
            POSITION => QString::_get($this->position),
            COMPANY => QString::_get($this->company),
            PLACE => QString::_get($this->place),
            TYPEPLACE => QString::_get($this->typeofplace),
            SRTMONTH=> (int)$this->startmonth,
            SRTYEAR => (int)$this->startyear,
            ENDMONTH=> (int)$this->endmonth,
            ENDYEAR => (int)$this->endyear,
            CONTRACT => QString::_get($this->contract),
            DESCRIPTION => QString::_get($this->description),
            CONTACT => $this->contact instanceof Contact ? $this->contact->toArray() : null
        ];
    }

    static public function _get(int $criteria, $value): ?Experience
    {
        return match (true) {
            $criteria == Criteria::ID && (int)$value > 0 => self::_toObject(parent::_getOne(self::TABLE, [parent::CID => (int)$value])),
            $criteria == Criteria::TOKEN && !QString::_isNull($value) => self::_toObject(parent::_getOne(self::TABLE, [parent::CTOKEN => trim($value)])),
            $criteria == Criteria::POSITION && !QString::_isNull($value) => self::_toObject(self::_findByPosition(trim($value))),
            $criteria == Criteria::COMPANY && !QString::_isNull($value) => self::_toObject(self::_findByCompany(trim($value))), 
            default => null,
        };
    }

    static public function _list(): ?array
    {
        if (!empty($beans = parent::_getAll(self::TABLE, []))) {
            foreach ($beans as $bean)
                if (($item = self::_toObject($bean)) instanceof self)
                    $experience[] = $item->toArray();
        }
        return $experience ?? null;
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