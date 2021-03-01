<?php

namespace App\Models\Base;

use App\Models\Base\PlanetInterface;
use App\Models\Base\LifeFormInterface;
use App\Models\EnergyGetterTypes\Base\EnergyGetterType;
use App\Models\StateTypes\Base\StateChangeType;
use App\Models\RegenerationTypes\Base\RegenerationType;
use App\Models\Base\TypeInterface;

abstract class EarthLifeForm implements PlanetInterface, LifeFormInterface, IdentityInterface
{
    protected $name;
    protected $volume;
    protected $isRegenerate;
    protected $isState;
    protected $hasId;

    public function __construct(string $name, int $volume, bool $isRegenerate, bool $isState) 
    {
        $this->name = $name;
        $this->volume = $volume;
        $this->isRegenerate = $isRegenerate;
        $this->isState = $isState;
        $this->hasId = isset($name) ? true : false;
    }

    public function getId(): string
    {
        return 'Я ' . $this->name;
    }

    public function isCanRegenerate(): bool
    {
        return $this->isRegenerate;
    }
    
    public function isCanChangeState(): bool
    {
        return $this->isState;
    }
    
    public function hasIdentity(): bool
    {
        return $this->hasId;
    }

    public function getVolume(): int
    {
       return $this->volume;
    }

    /**
     * Именной конструктор
     *
     * @return IdentityInterface
     */
    public static function getIdentity(string $name, int $volume = 0): IdentityInterface
    {
        return new static($name, $volume, true, true);
    }

    /**
     * Именной конструктор
     *
     * @return IdentityInterface
     */
    public static function getIdentityNotState(string $name, int $volume = 0): IdentityInterface
    {
        return new static($name, $volume, true, false);
    }

    public function getValidatedArrayGetterTypes(array $getterTypes): array
    {
        $energyGetters = [];
        foreach ($getterTypes as $energyGetter) {
            if ($energyGetter instanceof TypeInterface) {
                $energyGetters[] = $energyGetter->getType();
            }
        }

        return $energyGetters;
    }

    public function printValidatedArrayGetterTypes($getterTypes): string
    {
        $arrayGetterTypes = $this->getValidatedArrayGetterTypes($getterTypes);
        return implode(", ", $arrayGetterTypes); 
    }

    public function printFormatRusTrueOrFalse(bool $value): string
    {
       return $value ? 'Да' : 'Нет';
    }

    public function getLifeFormsDescription(): array
    {
        $isRegenerate = $this->printFormatRusTrueOrFalse($this->isCanRegenerate());
        $isState = $this->printFormatRusTrueOrFalse($this->isCanChangeState());
        $hasIdentity = $this->printFormatRusTrueOrFalse($this->hasIdentity());
        
        $energyGettersText = $this->printValidatedArrayGetterTypes($this->getEnergyGetterTypes());
        $stateChangeTypesText = $this->printValidatedArrayGetterTypes($this->getStateChangeTypes());
        $regenerationTypesText = $this->printValidatedArrayGetterTypes($this->getRegenerationTypes());

        $description = [];
        $description[] = $this->getId();
        $description[] = 'Вес: ' . $this->getVolume() . ' кг';
        $description[] = 'Способность к самовоспроизводству: ' . $isRegenerate;
        $description[] = 'Способность к изменению: ' .  $isState;
        $description[] = 'Имеет идентифицируемость: ' .  $hasIdentity;
        $description[] = 'Получает вещества способом(и): ' .  $energyGettersText;
        $description[] = 'Меняет состояние(я): ' .  $stateChangeTypesText;
        $description[] = 'Размножается: ' .  $regenerationTypesText;

        return $description;
    }
    
    public function printLifeFormsDescription(): string
    {
        $description = $this->getLifeFormsDescription();
        $text = implode("; <br>", $description);
        return  '<br>' . $text;
    }

    public function printLifeFormsName(): string
    {
        return  $this->name ;
    }

}