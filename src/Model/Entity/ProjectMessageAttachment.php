<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProjectMessageAttachment Entity
 *
 * @property int $projectId
 * @property int $senderId
 * @property \Cake\I18n\FrozenTime $createDate
 * @property \Cake\I18n\FrozenTime $fileMarker
 * @property int $fileCnt
 * @property int $iconId
 * @property string|null $description
 * @property string|null $note
 */
class ProjectMessageAttachment extends Entity
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
        'iconId' => true,
        'description' => true,
        'note' => true
    ];
}
