<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Organization Entity
 *
 * @property int $id
 * @property int $anagId
 * @property bool|null $isDeleted
 * @property bool $isCompany
 * @property bool|null $isMiur
 * @property \Cake\I18n\FrozenTime|null $createDate
 * @property string|null $imageFileName
 * @property string|null $imageFilePath
 * @property string|null $imageFileServer
 * @property string|resource|null $image
 * @property bool|null $isBlocked
 * @property \Cake\I18n\FrozenTime|null $blockDate
 * @property string|null $blockReason
 * @property int|null $fatherId
 * @property int|null $level
 * @property string|null $note
 */
class Organization extends Entity
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
        'id' => true,
        'anagId' => true,
        'isDeleted' => true,
        'isCompany' => true,
        'isMiur' => true,
        'createDate' => true,
        'imageFileName' => true,
        'imageFilePath' => true,
        'imageFileServer' => true,
        'image' => true,
        'isBlocked' => true,
        'blockDate' => true,
        'blockReason' => true,
        'fatherId' => true,
        'level' => true,
        'note' => true
    ];
}
