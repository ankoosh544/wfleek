<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Touseremail Entity
 *
 * @property int $id
 * @property int $email_id
 * @property int $touser_id
 * @property int $isDeleted
 *
 * @property \App\Model\Entity\Projectemail $projectemail
 * @property \App\Model\Entity\User $user
 */
class Touseremail extends Entity
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
        'email_id' => true,
        'touser_id' => true,
        'isDeleted' => true,
        'projectemail' => true,
        'user' => true
    ];
}
