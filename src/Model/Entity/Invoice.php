<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Invoice Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $projectId
 * @property int|null $client_id
 * @property string|null $status
 * @property \Cake\I18n\FrozenTime $invoice_date
 * @property \Cake\I18n\FrozenTime|null $due_date
 * @property string|null $description
 * @property string|null $billing_address
 * @property float|null $discount_percentage
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Client $client
 */
class Invoice extends Entity
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
        'projectId' => true,
        'client_id' => true,
        'status' => true,
        'invoice_date' => true,
        'due_date' => true,
        'description' => true,
        'billing_address' => true,
        'discount_percentage' => true,
        'company' => true,
        'client' => true
    ];
}
