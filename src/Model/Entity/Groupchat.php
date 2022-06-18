<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Groupchat Entity
 *
 * @property int $id
 * @property int|null $parentgroupchat_id
 * @property int $group_id
 * @property string|null $content
 * @property \Cake\I18n\FrozenTime $creation_date
 * @property bool $isSeen
 * @property \Cake\I18n\FrozenTime $last_update
 * @property bool $isDeleted
 *
 * @property \App\Model\Entity\Group $group
 * @property \App\Model\Entity\User $user
 */
class Groupchat extends Entity
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
        'parentgroupchat_id' => true,
        'content' => true,
        'creation_date' => true,
        'isSeen' => true,
        'last_update' => true,
        'isDeleted' => true,
        'group' => true,
        'user' => true
    ];
}
