<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Groupposttagmember Entity
 *
 * @property int $id
 * @property int|null $group_id
 * @property int|null $post_id
 * @property int|null $user_id
 * @property int|null $comment_id
 * @property int|null $reply_id
 * @property bool $isPost
 * @property bool $isComment
 * @property bool $isReply
 *
 * @property \App\Model\Entity\Group $group
 * @property \App\Model\Entity\Post $post
 * @property \App\Model\Entity\User $user
 */
class Groupposttagmember extends Entity
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
        'comment_id' => true,
        'reply_id' => true,
        'isPost' => true,
        'isComment' => true,
        'isReply' => true,
        'group' => true,
        'post' => true,
        'user' => true
    ];
}
