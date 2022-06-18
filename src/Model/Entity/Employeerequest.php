<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Employeerequest Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $title
 * @property string|null $request_type
 * @property string|null $worktype
 * @property string $status
 * @property string|null $description
 * @property \Cake\I18n\FrozenTime $fromdate
 * @property \Cake\I18n\FrozenTime|null $todate
 *
 * @property \App\Model\Entity\User $user
 */
class Employeerequest extends Entity
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
        'title' => true,
        'request_type' => true,
        'worktype' => true,
        'status' => true,
        'description' => true,
        'fromdate' => true,
        'todate' => true,
        'user' => true
    ];
}
