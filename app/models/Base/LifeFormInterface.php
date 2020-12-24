<?php

namespace App\Models\Base;

use App\Models\Base\PlanetInterface;
use App\Models\Base\EnergyGetterType;

interface LifeFormInterface
{
    /** Самовоспроизводится */
    public function isCanRegenerate(): bool;

    /** Изменять состояние */
    public function isCanChangeState(): bool;

    /** Идентифицируемость */
    public function hasIdentity(): bool;

    /** Получать энергию 
     * 
     * @return [EnergyGetterType]
    */
    public function getEnergyGetterTypes(): array;

    /** Объем*/ 
    public function getVolume(): int;
    
    /** Типы возпроизводимости 
     * 
     * @return [RegenerationType]
    */
    public function getRegenerationTypes(): array ;

    /** Типы изменения состояния 
     * 
     * @return [StateChangeType]
     * 
    */ 
    public function getStateChangeTypes(): array;

    /** Получить идинтификацию */
    public function getIdentity(): IdentityInterface;

}