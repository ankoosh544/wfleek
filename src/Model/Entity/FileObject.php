<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FileObject Entity
 *
 * @property \Cake\I18n\FrozenTime $marker
 * @property int $cnt
 * @property bool|null $isDeleted
 * @property string|null $displayFileName
 * @property string|null $originalFileName
 * @property string|null $codeExt
 * @property string|null $storeFileName
 * @property string|null $storePath
 * @property string|null $storeServerName
 * @property string|null $storeServerIp
 * @property int|null $storeFileSize
 * @property \Cake\I18n\FrozenTime|null $storeFileDateTime
 * @property int $ownerId
 * @property string|null $checksumId
 * @property string|null $checksumString
 * @property string|null $note
 */
class FileObject extends Entity
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
        'displayFileName' => true,
        'originalFileName' => true,
        'codeExt' => true,
        'storeFileName' => true,
        'storePath' => true,
        'storeServerName' => true,
        'storeServerIp' => true,
        'storeFileSize' => true,
        'storeFileDateTime' => true,
        'ownerId' => true,
        'checksumId' => true,
        'checksumString' => true,
        'note' => true
    ];
}
