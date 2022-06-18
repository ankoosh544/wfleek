<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Clientsexpenditure Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $typeof_transport
 * @property string|null $transportation_file
 * @property string|null $accomodation_hotel_name
 * @property string|null $accomodation_file
 * @property string|null $restaurant_name
 * @property string|null $restaurant_file
 *
 * @property \App\Model\Entity\User $user
 */
class Clientsexpenditure extends Entity
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
        'typeof_transport' => true,
        'transportation_file' => true,
        'accomodation_hotel_name' => true,
        'accomodation_file' => true,
        'restaurant_name' => true,
        'restaurant_file' => true,
        'user' => true
    ];
}
