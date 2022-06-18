<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Groupfile Entity
 *
 * @property int $id
 * @property int|null $groupfilepost_id
 * @property string|null $filename
 * @property string|null $filepath
 * @property int|null $size
 * @property \Cake\I18n\FrozenTime $creation_date
 * @property bool $isDeleted
 */
class Groupfile extends Entity
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
        'groupfilepost_id' => true,
        'filename' => true,
        'filepath' => true,
        'size' => true,
        'creation_date' => true,
        'isDeleted' => true
    ];
}
