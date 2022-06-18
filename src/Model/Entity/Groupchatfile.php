<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Groupchatfile Entity
 *
 * @property int $id
 * @property int $groupchat_id
 * @property int $user_id
 * @property string|null $filename
 * @property string|null $filepath
 * @property string|null $type
 * @property int|null $size
 * @property bool $isDeleted
 * @property \Cake\I18n\FrozenTime $creation_date
 *
 * @property \App\Model\Entity\Chatgroup $chatgroup
 * @property \App\Model\Entity\User $user
 */
class Groupchatfile extends Entity
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
        'groupchat_id' => true,
        'user_id' => true,
        'filename' => true,
        'filepath' => true,
        'type' => true,
        'size' => true,
        'isDeleted' => true,
        'creation_date' => true,
        'chatgroup' => true,
        'user' => true
    ];
}
