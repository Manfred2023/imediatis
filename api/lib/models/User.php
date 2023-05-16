<?php

class User extends UserDBA
{
    private ?int $id;
    private ?string $token;
    private string $email;
    private string $password;
    private ?Contact $contact;

    public function __construct(?int $id = NULL, ?string $token = NULL, string $email = NULL, string $password = NULL, ?Contact $contact = NULL)
    {
        $this->id = $id;
        $this->token = $token;
        $this->email = $email;
        $this->password = $password;
        $this->contact = $contact;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setContact(?Contact $contact): void
    {
        $this->contact = $contact;
    }

    private function isObligatory(): bool
    {
        if (QString::_isNull($this->email))
            throw new Exception('email_is_required');

        if (QString::_isNull($this->password))
            throw new Exception('password_is_required');

        return true;
    }

    public function save(): ?User
    {
        if ($this->isObligatory())
            return self::_toBean($this);
        return null;
    }

    public function delete(): bool
    {
        if ($this->isObligatory()) {
            parent::_toTrash(self::TABLE, $this->id);
            return true;
        }
        return false;
    }

    public function toArray(): array
    {
        return [
            TOKEN => $this->token,
            EMAIL => QString::_get($this->email),
            //PASSWORD => QString::_get($this->password),
            CONTACT => $this->contact instanceof Contact ? $this->contact->toArray() : null,
        ];
    }

    static public function _get(int $criteria, $value): ?User
    {
        return match (true) {
            $criteria == Criteria::ID && (int)$value > 0 => self::_toObject(parent::_getOne(self::TABLE, [parent::CID => (int)$value])),
            $criteria == Criteria::TOKEN && !QString::_isNull($value) => self::_toObject(parent::_getOne(self::TABLE, [parent::CTOKEN => trim($value)])),
            $criteria == Criteria::EMAIL && !QString::_isNull($value) => self::_toObject(self::_findByEmail(trim($value))),
            default => null
        };
    }

    static public function _list(): ?array
    {
        if (!empty($beans = parent::_getAll(self::TABLE, []))) {
            foreach ($beans as $bean)
                if (($item = self::_toObject($bean)) instanceof self)
                    $user[] = $item->toArray();
        }
        return $user ?? null;
    }

}