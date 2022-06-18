<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Invoiceitem Entity
 *
 * @property int $id
 * @property int $itemId
 * @property int $invoiceId
 * @property string|null $name
 * @property string $description
 * @property int $quantity
 * @property int $price
 * @property bool $isDeleted
 *
 * @property \App\Model\Entity\Taskgroup $taskgroup
 */
class Invoiceitem extends Entity
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
        'itemId' => true,
        'invoiceId' => true,
        'name' => true,
        'description' => true,
        'quantity' => true,
        'price' => true,
        'isDeleted' => true,
        'taskgroup' => true
    ];
}
