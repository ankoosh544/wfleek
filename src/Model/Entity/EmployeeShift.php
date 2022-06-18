<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmployeeShift Entity
 *
 * @property int $id
 * @property int $company_id
 * @property string|null $name
 * @property \Cake\I18n\FrozenTime|null $start_time
 * @property \Cake\I18n\FrozenTime|null $end_time
 * @property bool $isRepeated
 * @property int|null $weeks_to_repeat
 * @property \Cake\I18n\FrozenTime|null $endof_repeating_shift
 * @property bool $isIndefinite
 * @property string|null $note
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\RepeateShift $repeate_shift
 */
class EmployeeShift extends Entity
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
        'name' => true,
        'start_time' => true,
        'end_time' => true,
        'isRepeated' => true,
        'weeks_to_repeat' => true,
        'endof_repeating_shift' => true,
        'isIndefinite' => true,
        'note' => true,
        'company' => true,
        'repeate_shift' => true
    ];
}
