<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CourseProposal Entity
 *
 * @property int $id
 * @property int|null $organizationId
 * @property int|null $priceMin
 * @property int|null $priceMax
 */
class CourseProposal extends Entity
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
        'organizationId' => true,
        'priceMin' => true,
        'priceMax' => true
    ];
}
