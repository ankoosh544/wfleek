<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RepeateShift Entity
 *
 * @property int $id
 * @property int $shift_id
 * @property int $weeks_of_repeat
 * @property string|null $dayname
 * @property \Cake\I18n\FrozenTime|null $endof_repeating_shift
 *
 * @property \App\Model\Entity\Shift $shift
 */
class RepeateShift extends Entity
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
        'shift_id' => true,
        'weeks_of_repeat' => true,
        'dayname' => true,
        'endof_repeating_shift' => true,
        'shift' => true
    ];
}
