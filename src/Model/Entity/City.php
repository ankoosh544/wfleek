<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * City Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $region
 * @property string|null $province
 * @property string|null $province_code
 * @property string|null $cadastral_code
 * @property string|null $postcodes
 * @property string|null $country
 */
class City extends Entity
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
        'name' => true,
        'region' => true,
        'province' => true,
        'province_code' => true,
        'cadastral_code' => true,
        'postcodes' => true,
        'country' => true
    ];
}
