<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CompaniesUser Entity
 *
 * @property int $company_id
 * @property int $user_id
 * @property int $member_role
 * @property string|null $status
 * @property bool $isDeleted
 *
 *
 * @property \App\Model\Entity\Usercompany $usercompany
 * @property \App\Model\Entity\User $user
 */
class CompaniesUser extends Entity
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
        'member_role' => true,
        'status' => true,
        'usercompany' => true,
        'isDeleted' => true,
        'user' => true
    ];
}
