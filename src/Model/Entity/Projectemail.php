<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Projectemail Entity
 *
 * @property int $id
 * @property int|null $parentemail_id
 * @property int|null $forwarded_id
 * @property int $fromuser_id
 * @property string|null $subject
 * @property string|null $body
 * @property \Cake\I18n\FrozenTime $creation_date
 * @property \Cake\I18n\FrozenTime $send_date
 * @property bool $isDeleted
 * @property bool $isSent
 * @property bool $isDraft
 * @property bool $isStarred
 * @property string|null $worklable
 * @property bool $isRead
 *
 * @property \App\Model\Entity\Projectemail $projectemail
 */
class Projectemail extends Entity
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
        'parentemail_id' => true,
        'forwarded_id' => true,
        'fromuser_id' => true,
        'subject' => true,
        'body' => true,
        'creation_date' => true,
        'send_date' => true,
        'isDeleted' => true,
        'isSent' => true,
        'isDraft' => true,
        'isStarred' => true,
        'worklable' => true,
        'isRead' => true,
        'projectemail' => true
    ];
}
