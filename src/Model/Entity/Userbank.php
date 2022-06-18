<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Userbank Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $bank_name
 * @property string|null $iban
 * @property string|null $state_bankbranch
 * @property string|null $city_bankbranch
 * @property string|null $province_bankbranch
 * @property bool $isDeleted
 */
class Userbank extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'user_id' => true,
        'bank_name' => true,
        'iban' => true,
        'state_bankbranch' => true,
        'city_bankbranch' => true,
        'province_bankbranch' => true,
        'isDeleted' => true
    ];
}
