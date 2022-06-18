<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Onsiteemployee Entity
 *
 * @property int $id
 * @property int $client_id
 * @property int $projectId
 * @property int $work_location_Id
 * @property int $user_id
 * @property \Cake\I18n\FrozenTime $creation_date
 * @property bool $isDeleted
 *
 * @property \App\Model\Entity\Client $client
 */
class Onsiteemployee extends Entity
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
        'client_id' => true,
        'projectId' => true,
        'work_location_Id' => true,
        'user_id' => true,
        'creation_date' => true,
        'isDeleted' => true,
        'client' => true
    ];
}
