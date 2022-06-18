<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProjectMember Entity
 *
 * @property int $id
 * @property int $projectId
 * @property string $memberType
 * @property int $memberId
 * @property int|null $accessLevel
 * @property \Cake\I18n\FrozenTime|null $joinDate
 * @property int|null $sponsorId
 * @property bool|null $isInvitation
 * @property \Cake\I18n\FrozenTime|null $invitationDate
 * @property bool|null $isMembershipRequest
 * @property \Cake\I18n\FrozenTime|null $membershipRequestDate
 * @property bool|null $isBanned
 * @property \Cake\I18n\FrozenTime|null $banDate
 * @property int|null $bannerId
 * @property string|null $banReason
 * @property string|null $note
 * @property int $department_id
 * @property int $designaton_id
 */
class ProjectMember extends Entity
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
        'id' => true,
        'accessLevel' => true,
        'joinDate' => true,
        'sponsorId' => true,
        'isInvitation' => true,
        'invitationDate' => true,
        'isMembershipRequest' => true,
        'membershipRequestDate' => true,
        'isBanned' => true,
        'banDate' => true,
        'bannerId' => true,
        'banReason' => true,
        'note' => true,
        'designaton_id' => true,
        'department_id' => true,
    ];
}
