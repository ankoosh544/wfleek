<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Event Entity
 *
 * @property int $id
 * @property string|null $event_name
 * @property \Cake\I18n\FrozenTime|null $event_startdate
 * @property \Cake\I18n\FrozenTime|null $event_enddate
 * @property string|null $category
 * @property \Cake\I18n\FrozenTime $creation_date
 * @property int $created_by
 * @property bool $isDeleted
 */
class Event extends Entity
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
        'event_name' => true,
        'event_startdate' => true,
        'event_enddate' => true,
        'category' => true,
        'creation_date' => true,
        'created_by' => true,
        'isDeleted' => true
    ];
}
