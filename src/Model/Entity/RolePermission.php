<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RolePermission Entity
 *
 * @property int $designation_id
 * @property int $company_id
 * @property int $usermodule_id
 * @property \Cake\I18n\FrozenTime $creation_date
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\UsermodulePermission $usermodulepermission
 * @property \App\Model\Entity\Designation $designation
 */
class RolePermission extends Entity
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
        'company_id' => true,
        'usermodule_id' => true,
        'creation_date' => true,
        'company' => true,
        'usermodulepermission' => true,
        'designation' => true
    ];
}
