<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProjectMessage Entity
 *
 * @property int $projectId
 * @property int $senderId
 * @property \Cake\I18n\FrozenTime $createDate
 * @property bool|null $isDeleted
 * @property string $text
 * @property string $langId
 * @property int|null $fatherProjectId
 * @property int|null $fatherSenderId
 * @property \Cake\I18n\FrozenTime|null $fatherCreateDate
 * @property int|null $level
 * @property int|null $referenceProjectId
 * @property int|null $referenceSenderId
 * @property \Cake\I18n\FrozenTime|null $referenceCreateDate
 */
class ProjectMessage extends Entity
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
        'isDeleted' => true,
        'text' => true,
        'langId' => true,
        'fatherProjectId' => true,
        'fatherSenderId' => true,
        'fatherCreateDate' => true,
        'level' => true,
        'referenceProjectId' => true,
        'referenceSenderId' => true,
        'referenceCreateDate' => true
    ];
}
