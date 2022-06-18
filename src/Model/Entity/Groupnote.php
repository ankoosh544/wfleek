<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Groupnote Entity
 *
 * @property int $post_id
 * @property int|null $group_id
 * @property string|null $post_data
 *
 * @property \App\Model\Entity\Group $group
 * @property \App\Model\Entity\User $user
 */
class Groupnote extends Entity
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
        'post_data' => true,
        'group' => true,
        'user' => true
    ];
}
