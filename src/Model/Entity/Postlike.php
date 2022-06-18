<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Postlike Entity
 *
 * @property int $id
 * @property int|null $group_id
 * @property int|null $post_id
 * @property int|null $user_id
 * @property bool $isLiked
 * @property bool $isDeleted
 *
 * @property \App\Model\Entity\Group $group
 * @property \App\Model\Entity\Post $post
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Postlike[] $postlikes
 */
class Postlike extends Entity
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
        'post_id' => true,
        'user_id' => true,
        'isLiked' => true,
        'isDeleted' => true,
        'group' => true,
        'post' => true,
        'user' => true,
        'postlikes' => true
    ];
}
