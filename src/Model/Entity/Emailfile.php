<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Emailfile Entity
 *
 * @property int $id
 * @property int|null $parentemail_id
 * @property int $fromuser_id
 * @property int $touser_id
 * @property string|null $filepath
 * @property string|null $filename
 * @property string|null $type
 * @property int|null $size
 *
 * @property \App\Model\Entity\Fromuser $fromuser
 * @property \App\Model\Entity\Touser $touser
 */
class Emailfile extends Entity
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
        'parentemail_id' => true,
        'fromuser_id' => true,
        'touser_id' => true,
        'filepath' => true,
        'filename' => true,
        'type' => true,
        'size' => true,
        'fromuser' => true,
        'touser' => true
    ];
}
