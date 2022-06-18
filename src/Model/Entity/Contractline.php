<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Contractline Entity
 *
 * @property int $id
 * @property int|null $contract_id
 * @property string|null $grouptitle
 * @property string|null $tasktitle
 * @property string|null $description_task
 * @property float $price
 * @property float $tax_percentage
 *
 * @property \App\Model\Entity\Contract $contract
 */
class Contractline extends Entity
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
        'contract_id' => true,
        'grouptitle' => true,
        'tasktitle' => true,
        'description_task' => true,
        'price' => true,
        'tax_percentage' => true,
        'contract' => true
    ];
}
