<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Dailyattendencepdf Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property string|null $month
 * @property string|null $filepath
 * @property string|null $filename
 * @property \Cake\I18n\FrozenTime $creation_date
 *
 * @property \App\Model\Entity\Company $company
 */
class Dailyattendencepdf extends Entity
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
        'company_id' => true,
        'month' => true,
        'filepath' => true,
        'filename' => true,
        'creation_date' => true,
        'company' => true
    ];
}
