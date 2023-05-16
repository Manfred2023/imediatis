<?php


class Language extends LanguageDBA
{
    private int $id;
    private string $name;
    private int $writing;
    private int $speaking;
    private int $reading;
    private float $average;
    
    public function __construct(int $id = NULL, string $name = NULL, int $writing = NULL, int $speaking = NULL, int $reading = NULL)
    {
        $this->id = $id;
        $this->name = $name;
        $this->writing = $writing;
        $this->speaking = $speaking;
        $this->reading = $reading;
        $this->average = ($writing + $speaking + $reading) / 3;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getWriting(): int
    {
        return $this->writing;
    }

    public function getSpeaking(): int
    {
        return $this->speaking;
    }

    public function getReading(): int
    {
        return $this->reading;
    }

    public function getAverage(): float
    {
        return $this->average;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setWriting(int $writing): void
    {
        $this->writing = $writing;
    }

    public function setSpeaking(int $speaking): void
    {
        $this->speaking = $speaking;
    }

    public function setReading(int $reading): void
    {
        $this->reading = $reading;
    }


    private function mustbepresent(): bool
    {
        if (QString::_isNull($this->name))
            throw new Exception('name_is_required');

        /* if (Language::_get(Criteria::NAME, (trim($this->name))) instanceof Language)
            throw new Exception('language name duplicated'); */

        return true;
    }

    public function save(): ?Language
    {
        if (!$this->mustbepresent())
            return null;
        return self::_toBean($this);
    }

    public function delete(): bool
    {
        if ($this->mustbepresent()) {
            parent::_toTrash(self::TABLE, $this->id);
            return true;
        }
        return false;
    }

    public function toArray(): array
    {
        return [
            LANNAME => QString::_get($this->name),
            WRITING => (int)$this->writing,
            SPEAKING => (int)$this->speaking,
            READING => (int)$this->reading,
            AVERAGE => (float)$this->average
        ];
    }

    static public function _get(int $criteria, $value): ?Language
    {
        return match (true) {
            $criteria == Criteria::ID && (int)$value > 0 => self::_toObject(parent::_getOne(self::TABLE, [self::CID => (int)$value])),
            $criteria == Criteria::NAME && !QString::_isNull($value) => self::_toObject(self::_findByName(trim($value))),


            default => null,
        };
    }

    static public function _list(): ?array
    {
        if (!empty($beans = parent::_getAll(self::TABLE, []))) {
            foreach ($beans as $bean)
                if (($item = self::_toObject($bean)) instanceof self)
                    $languages[] = $item->toArray();
        }
        return $languages ?? null;
    }
}