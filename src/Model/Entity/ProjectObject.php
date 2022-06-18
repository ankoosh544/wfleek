<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProjectObject Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property string|null $superCode
 * @property string|null $name
 * @property string|null $description
 * @property \Cake\I18n\FrozenTime|null $startdate
 * @property \Cake\I18n\FrozenTime|null $expirydate
 * @property string|null $description2
 * @property bool $isDeleted
 * @property int|null $creatorId
 * @property \Cake\I18n\FrozenTime|null $createDate
 * @property string|null $visibility
 * @property float|null $price
 * @property float|null $tax
 * @property bool $isSchool
 * @property bool $isRestricted
 * @property int|null $fatherId
 * @property int $level
 * @property bool $isMembershipRequestAllowed
 * @property bool $isInvitationAllowed
 * @property bool $isBanAllowed
 * @property bool $isArchieveAllowed
 * @property string|null $imageFileName
 * @property string|null $imageFilePath
 * @property string|null $imageFileServer
 * @property string|resource|null $image
 * @property string|null $note
 * @property int|null $type
 * @property string $summary_title
 * @property string $summary_description
 * @property string|null $summaryfilepath
 * @property string|null $summaryfilename
 * @property string $member_names
 * @property bool|null $isFuturedProject
 * @property string|null $isPersonal
 * @property string|null $status
 * @property string|null $priority
 * @property int|null $totalgroups
 * @property int|null $total_workinghrs
 *
 *
 *
 *
 */
class ProjectObject extends Entity
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
        'superCode' => true,
        'name' => true,
        'company_id' => true,
        'description' => true,
        'startdate' => true,
        'expirydate' => true,
        'description2' => true,
        'isDeleted' => true,
        'creatorId' => true,
        'createDate' => true,
        'visibility' => true,
        'price' => true,
        'tax' => true,
        'isSchool' => true,
        'isRestricted' => true,
        'fatherId' => true,
        'level' => true,
        'isMembershipRequestAllowed' => true,
        'isInvitationAllowed' => true,
        'isBanAllowed' => true,
        'isArchieveAllowed' => true,
        'imageFileName' => true,
        'imageFilePath' => true,
        'imageFileServer' => true,
        'image' => true,
        'note' => true,
        'type' => true,
        'summary_title' => true,
        'summary_description' => true,
        'summaryfilepath' => true,
        'summaryfilename' => true,
        'member_names' => true,
        'isFuturedProject'=> true,
        'isPersonal' => true,
        'status' => true,
        'priority' => true,
        'totalgroups' => true,
        'total_workinghrs' => true
    ];
}
