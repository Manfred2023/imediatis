<?php


class Country extends CountryDBA
{
    private ?int $id;
    private string $namefr;
    private string $nameen;
    private int $code;
    private string $alpha2;
    private string $alpha3;
    private int $dialcode;


    public function __construct(
        int $id = NULL,
        string $namefr = NULL,
        string $nameen = NULL,
        int $code = NULL,
        string $alpha2 = NULL,
        string $alpha3 = NULL,
        int $dialcode = NULL
    ) {
        $this->id = $id;
        $this->namefr = $namefr;
        $this->nameen = $nameen;
        $this->code = $code;
        $this->alpha2 = $alpha2;
        $this->alpha3 = $alpha3;
        $this->dialcode = $dialcode;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNamefr(): string
    {
        return $this->namefr;
    }

    public function getNameen(): string
    {
        return $this->nameen;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getAlpha2(): string
    {
        return $this->alpha2;
    }

    public function getAlpha3(): string
    {
        return $this->alpha3;
    }

    public function getDialcode()
    {
        return $this->dialcode;
    }

    public function setNamefr(string $namefr): void
    {
        $this->namefr = $namefr;
    }

    public function setNameen(string $nameen): void
    {
        $this->nameen = $nameen;
    }

    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    public function setAlpha2(string $alpha2): void
    {
        $this->alpha2 = $alpha2;
    }

    public function setAlpha3(string $alpha3): void
    {
        $this->alpha3 = $alpha3;
    }

    public function setDialcode(int $dialcode): void
    {
        $this->dialcode = $dialcode;
    }

    private function isObligatory(): bool
    {
        if (QString::_isNull($this->namefr))
            throw new Exception('namefr_is_required');

        if (QString::_isNull($this->nameen))
            throw new Exception('nameen_is_required');

        if (QString::_isNull($this->code))
            throw new Exception('code_is_required');

        if (QString::_isNull($this->alpha2))
            throw new Exception('code_alpha2_is_required');

        if (strlen(trim($this->alpha2)) != 2)
            throw new Exception('code_alpha2_is_two_characters');

        if (QString::_isNull($this->alpha3))
            throw new Exception('code_alpha3_is_required');

        if (strlen(trim($this->alpha3)) != 3)
            throw new Exception('code_alpha3_is_three_characters');

        if (QString::_isNull($this->dialcode))
            throw new Exception('dial_code_is_required');

        return true;
    }

    public function save(): ?Country
    {
        if ($this->isObligatory())
            return self::_toBean($this);
        return null;
    }

    /**
     * @return array
     */

    public function toArray(): array
    {
        return [
            CNAMEFR => $this->namefr,
            CNAMEEN => $this->nameen,
            CODE => (int)$this->code,
            ALPHA2 => $this->alpha2,
            ALPHA3 => $this->alpha3,
            DIALCODE => (int)$this->dialcode
        ];
    }

    /**
     * return ?Country
     */
    static public function _get(int $criteria, $value): ?Country
    {
        return match (true) {
            $criteria == Criteria::ID && (int)$value > 0 => self::_toObject(parent::_getOne(self::TABLE, [self::CID => (int)$value])),
            $criteria == Criteria::ALPHA2 && !QString::_isNull($value) => self::_toObject(parent::_getOne(self::TABLE, [self::ALPHA2 => trim($value)])),
            $criteria == Criteria::ALPHA3 && !QString::_isNull($value) => self::_toObject(parent::_getOne(self::TABLE, [self::ALPHA3 => trim($value)])),
            $criteria == Criteria::CODE && (int)$value > 0 => self::_toObject(parent::_getOne(self::TABLE, [self::CODE => (int)$value])),
            $criteria == Criteria::OTHER && (int)$value > 0 => self::_toObject(parent::_getOne(self::TABLE, [self::DIALCODE => (int)$value])),
            $criteria == Criteria::NAMEFR && !QString::_isNull($value) => self::_toObject(self::_findByNamefr(trim($value))),
            $criteria == Criteria::NAMEEN && !QString::_isNull($value) => self::_toObject(self::_findByNameen(trim($value))),
            default => null,
        };
    }

    static public function _list(): ?array
    {
        if (!empty($beans = parent::_getAll(self::TABLE, []))) {
            foreach ($beans as $bean)
                if (($item = self::_toObject($bean)) instanceof self)
                    $countries[] = $item->toArray();
        }
        return $countries ?? null;
    }

    
    

    


}
