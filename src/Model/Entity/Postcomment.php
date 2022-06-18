<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Postcomment Entity
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int|null $group_id
 * @property int|null $post_id
 * @property int|null $user_id
 * @property string|null $comment_data
 * @property bool $isDeleted
 * @property \Cake\I18n\FrozenTime $creation_date
 *
 * @property \App\Model\Entity\ParentPostcomment $parent_postcomment
 * @property \App\Model\Entity\Group $group
 * @property \App\Model\Entity\Post $post
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\ChildPostcomment[] $child_postcomments
 */
class Postcomment extends Entity
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
        'parent_id' => true,
        'group_id' => true,
        'post_id' => true,
        'user_id' => true,
        'comment_data' => true,
        'isDeleted' => true,
        'creation_date' => true,
        'parent_postcomment' => true,
        'group' => true,
        'post' => true,
        'user' => true,
        'child_postcomments' => true
    ];
}
