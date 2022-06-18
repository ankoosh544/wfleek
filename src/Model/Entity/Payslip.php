<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Payslip Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $company_id
 * @property string|null $month
 * @property int|null $year
 * @property string|null $payslip_filename
 * @property string|null $payslip_filepath
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Company $company
 */
class Payslip extends Entity
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
        'user_id' => true,
        'company_id' => true,
        'month' => true,
        'year' => true,
        'payslip_filename' => true,
        'payslip_filepath' => true,
        'user' => true,
        'company' => true
    ];
}
