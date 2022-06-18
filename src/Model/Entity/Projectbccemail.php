<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Projectbccemail Entity
 *
 * @property int $id
 * @property int $email_id
 * @property int $bccuser_id
 * @property int $isDeleted
 *
 * @property \App\Model\Entity\Email $email
 * @property \App\Model\Entity\Bccuser $bccuser
 */
class Projectbccemail extends Entity
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
        'bccuser_id' => true,
        'isDeleted' => true,
        'email' => true,
        'bccuser' => true
    ];
}
