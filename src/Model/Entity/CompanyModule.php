<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CompanyModule Entity
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property bool $isNotify
 *
 * @property \App\Model\Entity\Company $company
 */
class CompanyModule extends Entity
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
        'name' => true,
        'isNotify' => true,
        'company' => true
    ];
}
