<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Registration Entity
 *
 * @property string $email_id
 * @property string|null $title
 * @property string|null $gender
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string|null $password
 * @property \Cake\I18n\FrozenTime|null $date_of_birth
 * @property string|null $validation_code
 * @property \Cake\I18n\FrozenTime|null $validation_expirydate
 * @property \Cake\I18n\FrozenTime $creation_date
 * @property string|null $address
 * @property string|null $city
 * @property string|null $country
 * @property bool $isCompany
 * @property string|null $businessname
 * @property string|null $tax_code
 * @property string|null $vat_code
 *
 */
class Registration extends Entity
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
        'title' => true,
        'gender' => true,
        'firstname' => true,
        'lastname' => true,
        'password' => true,
        'date_of_birth' => true,
        'validation_code' => true,
        'validation_expirydate' => true,
        'creation_date' => true,
        'address' => true,
        'city' => true,
        'country' => true,
        'isCompany' => true,
        'businessname' => true,
        'tax_code' => true,
        'vat_code' => true
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
