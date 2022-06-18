<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShiftSchedule Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $department_id
 * @property int|null $user_id
 * @property int|null $shift_id
 * @property \Cake\I18n\FrozenTime|null $scheduledshift_startdate
 * @property \Cake\I18n\FrozenTime|null $scheduledshift_enddate
 * @property bool $isAcceptExtrahrs
 * @property bool $isPublish
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Department $department
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Shift $shift
 */
class ShiftSchedule extends Entity
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
        'department_id' => true,
        'user_id' => true,
        'shift_id' => true,
        'scheduledshift_startdate' => true,
        'scheduledshift_enddate' => true,
        'isAcceptExtrahrs' => true,
        'isPublish' => true,
        'company' => true,
        'department' => true,
        'user' => true,
        'shift' => true
    ];
}
