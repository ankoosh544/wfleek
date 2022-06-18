<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VersionsContract Entity
 *
 * @property int $id
 * @property int $project_object_id
 * @property int $contract_id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $listof_members
 * @property string|null $content
 * @property \Cake\I18n\FrozenTime $creation_date
 * @property \Cake\I18n\FrozenTime $acceptance_date
 * @property string|null $contract_filename
 * @property string|null $contract_filepath
 *
 * @property float|null $price
 * @property float|null $tax
 * @property int|null $total_workinghrs
 *
 * @property \App\Model\Entity\ProjectObject $project_object
 * @property \App\Model\Entity\Contract $contract
 */
class VersionsContract extends Entity
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
        'project_object_id' => true,
        'contract_id' => true,
        'title' => true,
        'description' => true,
        'listof_members' => true,
        'content' => true,
        'creation_date' => true,
        'acceptance_date' => true,
        'contract_filename' => true,
        'contract_filepath' => true,
        'price' => true,
        'tax' => true,
        'total_workinghrs' => true,
        'project_object' => true,
        'contract' => true
    ];
}
