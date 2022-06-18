<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Group Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $creatorId
 * @property string $name
 * @property string $description
 * @property string|null $group_profileFilepath
 * @property string|null $group_profileFilename
 * @property \Cake\I18n\FrozenTime|null $creation_date
 * @property bool $isDeleted
 *
 * @property \App\Model\Entity\Chatgroup[] $chatgroups
 * @property \App\Model\Entity\Chatgroupsuser[] $chatgroupsusers
 * @property \App\Model\Entity\Groupchatfile[] $groupchatfiles
 * @property \App\Model\Entity\Groupchat[] $groupchats
 */
class Group extends Entity
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
        'creatorId' => true,
        'name' => true,
        'description' => true,
        'group_profileFilepath' => true,
        'group_profileFilename' => true,
        'creation_date' => true,
        'isDeleted' => true,
        'chatgroups' => true,
        'chatgroupsusers' => true,
        'groupchatfiles' => true,
        'groupchats' => true
    ];
}
