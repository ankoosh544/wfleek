<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Notification Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $module_id
 * @property string|null $module_action
 * @property int|null $module_action_id
 * @property string|null $module_action_title
 * @property string|null $module_action_description
 * @property int $fromuser_id
 * @property int $touser_id
 * @property \Cake\I18n\FrozenTime $creation_date
 * @property bool|null $isDeleted
 * @property bool|null $isSeen
 *
 * @property \App\Model\Entity\User $fromuser
 * @property \App\Model\Entity\User $touser
 * @property \App\Model\Entity\Action $action
 */
class Notification extends Entity
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
        'module_id' => true,
        'module_action' => true,
        'module_action_id' => true,
        'fromuser_id' => true,
        'touser_id' => true,
        'creation_date' => true,
        'isDeleted' => true,
        'isSeen' => true,
        'fromuser' => true,
        'touser' => true,
        'action' => true
    ];
}
