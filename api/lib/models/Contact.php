<?php

/* use RedBeanPHP\RedException\SQL; */

class Contact extends ContactDBA
{
    private ?int $id;
    private ?string $token;
    private string $firstname;
    private string $lastname;
    private int $dayofbirth;
    private int $monthofbirth;
    private int $yearofbirth;
    private string $gender;
    private string $phonenumber;
    private string $profession;
    private string $description;
    private ?string $dateadded;
    private ?string $datemodification;
    private ?City $city;

    public function __construct(?int $id = NULL, ?string $token = NULL, string $firstname = NULL, string $lastname = NULL, $dayofbirth = NULL, 
    int $monthofbirth = NULL, int $yearofbirth = NULL, string $gender = NULL, string $phonenumber = NULL, string $profession = NULL, 
    string $description = NULL, ?string $dateadded = NULL, ?string $datemodification = NULL, ?City $city = NULL)
    {
        $this->id = $id;
        $this->token = $token;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->dayofbirth = $dayofbirth;
        $this->monthofbirth = $monthofbirth;
        $this->yearofbirth = $yearofbirth;
        $this->gender = $gender;
        $this->phonenumber = $phonenumber;
        $this->profession = $profession;
        $this->description = $description;
        $this->dateadded =  $dateadded;
        $this->datemodification = $datemodification;
        $this->city = $city;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getDayofbirth(): int 
    {
        return $this->dayofbirth;
    }

    public function getMonthofbirth(): int 
    {
        return $this->monthofbirth;
    }

    public function getYearofbirth(): int 
    {
        return $this->yearofbirth;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getPhonenumber(): string
    {
        return $this->phonenumber;
    }

    public function getProfession(): string
    {
        return $this->profession;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

     public function getDateAdded(): string
    {
        return $this->dateadded;
    }

    public function getDateModification(): string
    {
        return $this->datemodification;
    } 

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function setDayofbirth(int $dayofbirth): void
    {
        $this->dayofbirth = $dayofbirth;
    }

    public function setMonthofbirth(int $monthofbirth): void
    {
        $this->monthofbirth = $monthofbirth;
    }

    public function setYearofbirth(int $yearofbirth): void
    {
        $this->yearofbirth = $yearofbirth;
    }

    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    public function setPhonenumber(string $phonenumber): void
    {
        $this->phonenumber = $phonenumber;
    }

    public function setProfession(string $profession): void
    {
        $this->profession = $profession;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    
    public function setDateadded(string $dateadded): void
    {
        $this->dateadded = $dateadded;
    }

    public function setDateModification($datemodification): void
    {
        $this->datemodification = $datemodification;
    }

    public function setCity(?City $city): void
    {
        $this->city = $city;
    }

    private function isOK(): bool
    {
        if (!$this->city instanceof City)
            throw new Exception("Enter city name " );

        return true;
    }

    public function save(): ?Contact
    {
        if ($this->isOK())
            return self::_toBean($this);
        return null;
    }

    public function toArray(): array
    {
        return [
            TOKEN => ($this->token),
            FSTNAME => QString::_get($this->firstname),
            LSTNAME => QString::_get($this->lastname),
            DBIRTH => (int)$this->dayofbirth,
            MBIRTH=> (int)$this->monthofbirth,
            YBIRTH => (int)$this->yearofbirth,
            GENDER => QString::_get($this->gender),
            PHONE => QString::_get($this->phonenumber),
            DESCRIPTION => QString::_get($this->description),
            DATEADD => ($this->dateadded),
            DATEMODIF => ($this->datemodification),
            CITY => $this->city instanceof City ? $this->city->toArray() : null,
            EDUCATION => Education::_listEdu($this)
        ];
    }

    static public function _get(int $criteria, $value): ?Contact
    {
        return match (true) {
            $criteria == Criteria::ID && (int)$value > 0 => self::_toObject(parent::_getOne(self::TABLE, [parent::CID => (int)$value])),
            $criteria == Criteria::TOKEN && !QString::_isNull($value) => self::_toObject(parent::_getOne(self::TABLE, [parent::CTOKEN => trim($value)])),
            $criteria == Criteria::PHONE && !QString::_isNull($value) => self::_toObject(self::_findByPhoneNumber(trim($value))),
            $criteria == Criteria::YBIRTH && (int)$value > 0 => self::_toObject(parent::_getOne(self::TABLE, [parent::YBIRTH => (int)$value])),
            $criteria == Criteria::FSTNAME && !QString::_isNull($value) => self::_toObject(self::_findByName(trim($value))),
            $criteria == Criteria::PROFESSION && !QString::_isNull($value) => self::_toObject(self::_findByProfession(trim($value))), 
            default => null,
        };
    }

    static public function _listCity(?City $city): ?array
    {
        if (!$city instanceof City)
            return null;

        if (!empty($beans = parent::_getAll(ContactDBA::TABLE, [self::CITY => $city->getId()]))) {
            foreach ($beans as $bean)
                if (($item = self::_toObject($bean)) instanceof self)
                    $contacts[] = $item->toArray();
        }

        return $contacts ?? null;
    }

    static public function _year(?Contact $year): ?array
    {
        if (!$year instanceof Contact)
            return null;

        if (!empty($beans = parent::_getAll(ContactDBA::TABLE, [self::YBIRTH => $year->getYearofbirth()]))) {
            foreach ($beans as $bean)
                if (($item = self::_toObject($bean)) instanceof self)
                    $yrs[] = $item->toArray();
        }
        return $yrs ?? null;
    }

    static public function _firstname(?Contact $first): ?array
    {
        if (!$first instanceof Contact)
            return null;

        if (!empty($beans = parent::_getAll(ContactDBA::TABLE, [self::FSTNAME => $first->getFirstname()]))) {
            foreach ($beans as $bean)
                if (($item = self::_toObject($bean)) instanceof self)
                    $frstn[] = $item->toArray();
        }

        return $frstn ?? null;
    }

    static public function _profession(?Contact $prof): ?array
    {
        if (!$prof instanceof Contact)
            return null;

        if (!empty($beans = parent::_getAll(ContactDBA::TABLE, [self::PROFESSION => $prof->getProfession()]))) {
            foreach ($beans as $bean)
                if (($item = self::_toObject($bean)) instanceof self)
                    $profs[] = $item->toArray();
        }

        return $profs ?? null;
    }

    static public function _list(): ?array
    {
        if (!empty($beans = parent::_getAll(self::TABLE, []))) {
            foreach ($beans as $bean)
                if (($item = self::_toObject($bean)) instanceof self)
                    $contacts[] = $item->toArray();
        }
        return $contacts ?? null;
    }

    /* private function mustBePresent(): string
        {
            if (is_null(trim($this->token)))
                throw new Exception('the_token_must_be_entered');
            return true;
        } */

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