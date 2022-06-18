<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Postcommentfile Entity
 *
 * @property int $id
 * @property int|null $post_id
 * @property int|null $comment_id
 * @property int|null $reply_id
 * @property int|null $group_id
 * @property int|null $user_id
 * @property string|null $filepath
 * @property string|null $filename
 * @property bool $isDeleted
 *
 * @property \App\Model\Entity\Post $post
 * @property \App\Model\Entity\Comment $comment
 * @property \App\Model\Entity\Group $group
 * @property \App\Model\Entity\User $user
 */
class Postcommentfile extends Entity
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
        'post_id' => true,
        'comment_id' => true,
        'reply_id' => true,
        'group_id' => true,
        'user_id' => true,
        'filepath' => true,
        'filename' => true,
        'isDeleted' => true,
        'post' => true,
        'comment' => true,
        'group' => true,
        'user' => true
    ];
}
