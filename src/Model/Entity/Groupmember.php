<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Groupmember Entity
 *
 * @property int $id
 * @property int $group_id
 * @property int $user_id
 * @property string|null $member_role
 * @property bool $isDeleted
 * @property \Cake\I18n\FrozenTime|null $creation_date
 *
 * @property \App\Model\Entity\Group $group
 * @property \App\Model\Entity\User $user
 */
class Groupmember extends Entity
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
        'group_id' => true,
        'user_id' => true,
        'member_role' => true,
        'isDeleted' => true,
        'creation_date' => true,
        'group' => true,
        'user' => true
    ];
}
