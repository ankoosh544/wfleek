<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Leave Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $leavetype
 * @property \Cake\I18n\FrozenTime|null $fromdate
 * @property \Cake\I18n\FrozenTime|null $todate
 * @property string|null $leavereason
 * @property string|null $medical_number
 * @property \Cake\I18n\FrozenTime $creation_date
 * @property string $status
 * @property bool $isDeleted
 * @property bool $isSeen
 *
 * @property \App\Model\Entity\User $user
 */
class Leave extends Entity
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
        'leavetype' => true,
        'fromdate' => true,
        'todate' => true,
        'leavereason' => true,
        'medical_number' => true,
        'creation_date' => true,
        'status' => true,
        'isDeleted' => true,
        'isSeen' => true,
        'user' => true
    ];
}
