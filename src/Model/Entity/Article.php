<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Article Entity
 *
 * @property int $id
 * @property string $type
 * @property bool|null $isDeleted
 * @property string $name
 * @property string|null $description
 * @property bool|null $isVirtualQty
 * @property bool|null $isObsolete
 * @property string $um
 * @property string|null $umPack
 * @property int|null $packQty
 * @property int|null $singleArticleId
 * @property string|null $grp
 * @property string|null $note
 */
class Article extends Entity
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
        'type' => true,
        'isDeleted' => true,
        'name' => true,
        'description' => true,
        'isVirtualQty' => true,
        'isObsolete' => true,
        'um' => true,
        'umPack' => true,
        'packQty' => true,
        'singleArticleId' => true,
        'grp' => true,
        'note' => true
    ];
}
