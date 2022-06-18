<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Projecttype Entity
 *
 * @property int $id
 * @property int|null $order_number
 * @property string|null $name
 */
class Projecttype extends Entity
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
        'order_number' => true,
        'name' => true
    ];
}
