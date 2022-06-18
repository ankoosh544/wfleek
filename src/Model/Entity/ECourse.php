<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ECourse Entity
 *
 * @property int $id
 * @property bool|null $isDeleted
 * @property string $title
 * @property string|null $subtitle
 * @property string|null $description
 * @property string $languageCode
 * @property int $ownerId
 * @property int|null $organizationId
 * @property bool|null $isFree
 * @property bool|null $isRestrictedAccess
 * @property bool|null $isInternal
 * @property string|null $status
 * @property bool|null $isApprovalRequired
 * @property \Cake\I18n\FrozenTime|null $createDate
 * @property int $creatorId
 * @property \Cake\I18n\FrozenTime|null $lastUpdate
 * @property int|null $matterId
 * @property int|null $eCategoryId
 * @property string|null $password
 * @property \Cake\I18n\FrozenDate|null $startDate
 * @property \Cake\I18n\FrozenDate|null $endDate
 * @property \Cake\I18n\FrozenDate|null $endSubscriptionDate
 * @property bool|null $isObsolete
 * @property bool|null $isVisible
 * @property bool|null $isOffLine
 * @property string|null $bibliography
 * @property int|null $xUBInt1
 * @property int|null $xUBint2
 * @property int|null $xInt
 * @property bool|null $isXCond1
 * @property bool|null $isXCond2
 * @property string|null $xChar1
 * @property string|null $xString1
 * @property string|null $xString2
 * @property string|null $xString3
 */
class ECourse extends Entity
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
        'isDeleted' => true,
        'title' => true,
        'subtitle' => true,
        'description' => true,
        'languageCode' => true,
        'ownerId' => true,
        'organizationId' => true,
        'isFree' => true,
        'isRestrictedAccess' => true,
        'isInternal' => true,
        'status' => true,
        'isApprovalRequired' => true,
        'createDate' => true,
        'creatorId' => true,
        'lastUpdate' => true,
        'matterId' => true,
        'eCategoryId' => true,
        'password' => true,
        'startDate' => true,
        'endDate' => true,
        'endSubscriptionDate' => true,
        'isObsolete' => true,
        'isVisible' => true,
        'isOffLine' => true,
        'bibliography' => true,
        'xUBInt1' => true,
        'xUBint2' => true,
        'xInt' => true,
        'isXCond1' => true,
        'isXCond2' => true,
        'xChar1' => true,
        'xString1' => true,
        'xString2' => true,
        'xString3' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
}
