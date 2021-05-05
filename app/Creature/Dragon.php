<?php

namespace App\Creature;

class Dragon
{
    private $colour;
    private $name;
    private $health;
    private $attack;
    private $attackMod = 0;
    private $defence;
    private $defenceMod = 0;
    private $luck;
    private $luckMod = 0;
    private $special;
    private $adjective;
    private $initiative = 0;

    public function takeDamage(int $dmg)
    {
        $this->health = $this->health - $dmg;
    }

    public function testLuck(): bool
    {
        return rand(1, 50) < $this->getLuck();
    }

    public function getInitiative(): int
    {
        return $this->initiative;
    }

    public function setInitiative(int $initiative): void
    {
        $this->initiative = $initiative;
    }

    public function getColour(): string
    {
        return $this->colour;
    }

    public function setColour(string $colour): void
    {
        $this->colour = $colour;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAttack(): int
    {
        return rand($this->attack[0], $this->attack[1]) + $this->attackMod;
    }

    public function setAttack(array $attack): void
    {
        $this->attack = $attack;
    }

    public function getHealth(): int
    {
        return $this->health;
    }

    public function setHealth(array $health): void
    {
        $this->health = rand($health[0], $health[1]);
    }

    public function getDefence(): int
    {
        return rand($this->defence[0], $this->defence[1]) + $this->defenceMod;
    }

    public function setDefence(array $defence): void
    {
        $this->defence = $defence;
    }

    public function getLuck(): int
    {
        return $this->luck + $this->luckMod;
    }

    public function setLuck(array $luck): void
    {
        $this->luck = rand($luck[0], $luck[1]);
    }

    public function getSpecial()
    {
        return $this->special;
    }

    public function setSpecial(array $special): void
    {
        $this->special = $special;
    }

    public function getAdjective(): string
    {
        return $this->adjective;
    }

    public function setAdjective(string $adjective): void
    {
        $this->adjective = $adjective;
    }

    public function setAttackMod(int $attackMod): void
    {
        $this->attackMod = $attackMod;
    }

    public function setDefenceMod(int $defenceMod): void
    {
        $this->defenceMod = $defenceMod;
    }

    public function setLuckMod(int $luckMod): void
    {
        $this->luckMod = $luckMod;
    }
}
