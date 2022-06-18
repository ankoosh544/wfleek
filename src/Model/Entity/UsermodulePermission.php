<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UsermodulePermission Entity
 *
 * @property int $id
 * @property int $designation_id
 * @property int $module_id
 * @property bool $isAccessed
 * @property bool $isRead
 * @property bool $isWrite
 * @property bool $isCreate
 * @property bool $isDelete
 * @property bool $isImport
 * @property bool $isExport
 *
 * @property \App\Model\Entity\Designation $designation
 * @property \App\Model\Entity\Module $module
 */
class UsermodulePermission extends Entity
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
        'designation_id' => true,
        'module_id' => true,
        'isAccessed' => true,
        'isRead' => true,
        'isWrite' => true,
        'isCreate' => true,
        'isDelete' => true,
        'isImport' => true,
        'isExport' => true,
        'designation' => true,
        'module' => true
    ];
}
