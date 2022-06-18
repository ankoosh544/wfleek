<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Additionaldatauser Entity
 *
 * @property int $user_id
 * @property int $company_id
 * @property int $member_role
 * @property string|null $vat_code
 * @property string|null $tax_code
 *
 *
 * @property \App\Model\Entity\Company $company
 */
class Additionaldatauser extends Entity
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
        'member_role' => true,
        'vat_code' => true,
        'tax_code' => true,
        'company' => true
    ];
}
