<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Appointment Entity
 *
 * @property int $id
 * @property int $company_id
 * @property int $candidate_id
 * @property int $companymember_id
 * @property \Cake\I18n\FrozenTime $datetime
 * @property string|null $title
 * @property string|null $subject
 * @property int $isDeleted
 *
 * @property \App\Model\Entity\Candidate $candidate
 * @property \App\Model\Entity\Companymember $companymember
 */
class Appointment extends Entity
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
        'candidate_id' => true,
        'companymember_id' => true,
        'datetime' => true,
        'title' => true,
        'subject' => true,
        'isDeleted' => true,
        'candidate' => true,
        'companymember' => true
    ];
}
