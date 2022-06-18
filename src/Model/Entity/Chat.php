<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Chat Entity
 *
 * @property int $id
 * @property int|null $chatgroup_id
 * @property int|null $parentchat_id
 * @property int $fromuser_id
 * @property int $touser_id
 * @property string|null $content
 * @property \Cake\I18n\FrozenTime $creation_date
 * @property \Cake\I18n\FrozenTime $last_update
 * @property bool $isSeen
 * @property bool $isDeleted
 * @property \Cake\I18n\FrozenTime $lastseen
 *
 * @property \App\Model\Entity\Chatgroup $chatgroup
 * @property \App\Model\Entity\User $fromuser
 * @property \App\Model\Entity\Touser $tousers
 */
class Chat extends Entity
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
        'chatgroup_id' => true,
        'parentchat_id' => true,
        'fromuser_id' => true,
        'touser_id' => true,
        'content' => true,
        'creation_date' => true,
        'last_update' => true,
        'isSeen' => true,
        'isDeleted' => true,
        'lastseen' => true,
        'chatgroup' => true,
        'fromuser' => true,
        'tousers ' => true
    ];
}
