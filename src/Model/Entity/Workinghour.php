<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Workinghour Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $company_id
 * @property \Cake\I18n\FrozenTime|null $start_time
 * @property \Cake\I18n\FrozenTime|null $end_time
 * @property string|null $description
 *
 *
 * @property \App\Model\Entity\User $user
 */
class Workinghour extends Entity
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
        'start_time' => true,
        'end_time' => true,
        'description' => true,
        'user' => true
    ];
}
