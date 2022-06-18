<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Price Entity
 *
 * @property int $id
 * @property int $articleId
 * @property bool|null $isDeleted
 * @property float $sellPrice
 * @property float $tax
 * @property float $netPrice
 * @property float|null $discount1
 * @property float|null $discount2
 * @property string $currencyCode
 * @property \Cake\I18n\FrozenTime $startDate
 * @property \Cake\I18n\FrozenTime|null $endDate
 * @property string|null $priceListId
 * @property string|null $note
 */
class Price extends Entity
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
        'articleId' => true,
        'isDeleted' => true,
        'sellPrice' => true,
        'tax' => true,
        'netPrice' => true,
        'discount1' => true,
        'discount2' => true,
        'currencyCode' => true,
        'startDate' => true,
        'endDate' => true,
        'priceListId' => true,
        'note' => true
    ];
}
