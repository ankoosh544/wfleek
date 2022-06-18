<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Chatfile Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $touser_id
 * @property int|null $group_id
 * @property string|null $filename
 * @property string|null $filepath
 * @property string|null $type
 * @property int|null $size
 * @property bool $isDeleted
 * @property \Cake\I18n\FrozenTime $creation_date
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Touser $touser
 * @property \App\Model\Entity\Group $group
 */
class Chatfile extends Entity
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
        'user_id' => true,
        'touser_id' => true,
        'group_id' => true,
        'filename' => true,
        'filepath' => true,
        'type' => true,
        'size' => true,
        'isDeleted' => true,
        'creation_date' => true,
        'user' => true,
        'touser' => true,
        'group' => true
    ];
}
