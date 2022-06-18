<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Chatgroup Entity
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $group_id
 * @property int $creator
 * @property \Cake\I18n\FrozenTime $creation_date
 * @property string|null $groupimagepath
 * @property string|null $groupimagename
 *
 * @property \App\Model\Entity\User $user
 */
class Chatgroup extends Entity
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
        'name' => true,
        'group_id' => true,
        'creator' => true,
        'creation_date' => true,
        'groupimagepath' => true,
        'groupimagepath' => true,
        'user' => true
    ];
}
