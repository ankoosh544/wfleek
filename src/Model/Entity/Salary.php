<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Salary Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $company_id
 * @property float|null $net_salary
 * @property float|null $tds
 * @property float|null $da
 * @property float|null $esi
 * @property float|null $hra
 * @property float|null $pf
 * @property float|null $tax
 * @property string|null $month
 *  @property int|null $year
 *
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Company $company
 */
class Salary extends Entity
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
        'net_salary' => true,
        'tds' => true,
        'da' => true,
        'esi' => true,
        'hra' => true,
        'pf' => true,
        'tax' => true,
        'month' => true,
        'year' => true,
        'user' => true,
        'company' => true
    ];
}
