<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Grouppostfile Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $group_id
 * @property int|null $grouppost_id
 * @property string|null $filepath
 * @property string|null $filename
 * @property int|null $size
 * @property string|null $type
 * @property bool $isDeleted
 * @property \Cake\I18n\FrozenTime $creation_date
 *
 * @property \App\Model\Entity\Group $group
 * @property \App\Model\Entity\Grouppost $grouppost
 */
class Grouppostfile extends Entity
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
        'group_id' => true,
        'grouppost_id' => true,
        'filepath' => true,
        'filename' => true,
        'size' => true,
        'type' => true,
        'isDeleted' => true,
        'creation_date' => true,
        'group' => true,
        'grouppost' => true
    ];
}
