<?php


class City extends CityDBA
{
    private ?int $id;
    private ?string $token;
    private string $name;
    private ?Country $country;


    public function __construct(int $id = NULL, string $token = NULL, string $name = NULL, ?Country $country = NULL  )
    {
        $this->id = $id;
        $this->token = $token;
        $this->name = $name;
        $this->country = $country;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getcountry(): ?Country
    {
        return $this->country;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setCountry(?Country $country): void
    {
        $this->country = $country;
    }



    private function ToHave(): bool
    {
        if (QString::_isNull($this->name))
            throw new Exception("Town's name is required!");
        return true;
    }

    public function save(): City
    {
        if (!$this->ToHave())
            return null;
        return self::_toBean($this);
    }

    public function delete(): bool
    {
        if ($this->ToHave()) {
            parent::_toTrash(self::TABLE, $this->id);
            return true;
        }
        return false;
    }

    public function toArray(): array
    {
        return [
            TOKEN => $this->token,
            CITYNAME => QString::_get($this->name),
            COUNTRY => $this->country instanceof COUNTRY ? $this->country->toArray() : null,
        ];
    }

    static public function _get(int $criteria, $value): ?City
    {
        return match (true) {
            $criteria == Criteria::ID && (int)$value > 0 => self::_toObject(parent::_getOne(self::TABLE, [parent::CID => (int)$value])),
            $criteria == Criteria::TOKEN && !QString::_isNull($value) => self::_toObject(parent::_getOne(self::TABLE, [parent::CTOKEN => trim($value)])),
            $criteria == Criteria::NAME && !QString::_isNull($value) => self::_toObject(self::_findByName(trim($value))),

            default => null,
        };
    }

    static public function _list(): ?array
    {
        if (!empty($beans = parent::_getAll(self::TABLE, []))) {
            foreach ($beans as $bean)
                if (($item = self::_toObject($bean)) instanceof self)
                    $city[] = $item->toArray();
        }
        return $city ?? null;
    }

}
