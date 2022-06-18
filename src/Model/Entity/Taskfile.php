<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Taskfile Entity
 *
 * @property int $id
 * @property int|null $comment_id
 * @property int $user_id
 * @property int $pid
 * @property int $tid
 * @property string|null $filepath
 * @property string|null $filename
 * @property string|null $type
 * @property int $size
 * @property bool $isDeleted
 * @property \Cake\I18n\FrozenTime $creation_date
 *
 * @property \App\Model\Entity\Comment $comment
 * @property \App\Model\Entity\User $user
 */
class Taskfile extends Entity
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
        'comment_id' => true,
        'user_id' => true,
        'pid' => true,
        'tid' => true,
        'filepath' => true,
        'filename' => true,
        'type' => true,
        'size' => true,
        'isDeleted' => true,
        'creation_date' => true,
        'comment' => true,
        'user' => true
    ];
}
