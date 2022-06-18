<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Grouppost Entity
 *
 * @property int $id
 * @property int|null $group_id
 * @property int|null $user_id
 * @property string|null $post_data
 * @property bool $isDeleted
 * @property \Cake\I18n\FrozenTime|null $creation_date,
 * @property bool $isShared,
 * @property bool $isNote
 *
 *
 * @property \App\Model\Entity\Grouppostfile[] $grouppostfiles
 * @property \App\Model\Entity\Grouppost $grouppost
 * @property \App\Model\Entity\Group $group
 * @property \App\Model\Entity\User $user
 */
class Grouppost extends Entity
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
        'post_data' => true,
        'isDeleted' => true,
        'creation_date' => true,
        'isShared' => true,
        'isNote' => true,
        'grouppostfiles' => true,
        'grouppost' => true,
        'group' => true,
        'user' => true
    ];
}
