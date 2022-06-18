<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Groupfilepost Entity
 *
 * @property int $id
 * @property int|null $group_id
 * @property int|null $user_id
 * @property \Cake\I18n\FrozenTime $creation_date
 * @property bool $isDeleted
 *
 * @property \App\Model\Entity\Group $group
 * @property \App\Model\Entity\User $user
 */
class Groupfilepost extends Entity
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
        'creation_date' => true,
        'isDeleted' => true,
        'group' => true,
        'user' => true
    ];
}
