<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Chatcontact Entity
 *
 * @property int $id
 * @property int $company_id
 * @property int $touser_id
 * @property \Cake\I18n\FrozenTime $creation_date
 * @property int $fromuser_id
 * @property string $status
 * @property \Cake\I18n\FrozenTime $lastseen
 *
 * @property bool $isDeleted
 *
 * @property \App\Model\Entity\User $user
 */
class Chatcontact extends Entity
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
        'touser_id' => true,
        'company_id' => true,
        'creation_date' => true,
        'fromuser_id' => true,
        'status' => true,
        'isDeleted' => true,
        'user' => true
    ];
}
