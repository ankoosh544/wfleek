<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Projectfile Entity
 *
 * @property int $id
 * @property int $project_id
 * @property int $user_id
 * @property string|null $filename
 * @property string|null $filepath
 * @property \Cake\I18n\FrozenTime $creation_date
 * @property string|null $type
 * @property int|null $size
 * @property bool $isDeleted
 * @property string|null $temp
 *
 * @property \App\Model\Entity\Project $project
 * @property \App\Model\Entity\User $user
 */
class Projectfile extends Entity
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
        'project_id' => true,
        'user_id' => true,
        'filename' => true,
        'filepath' => true,
        'creation_date' => true,
        'type' => true,
        'size' => true,
        'isDeleted' => true,
        'temp' => true,
        'project' => true,
        'user' => true
    ];
}
