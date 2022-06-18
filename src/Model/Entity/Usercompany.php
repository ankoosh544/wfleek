<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Usercompany Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $company_user
 * @property string|null $name
 * @property string|null $description
 * @property string|null $address
 * @property string|null $country
 * @property string|null $city
 * @property string|null $province
 * @property int|null $postal_code
 * @property string|null $email
 * @property int|null $phone_number
 * @property int|null $mobile_number
 * @property string|null $bank_name
 * @property string|null $state_bankbranch
 * @property string|null $province_bankbranch
 * @property string|null $city_bankbranch
 * @property string|null $iban
 * @property string|null $website
 * @property string|null $company_logoFilepath
 * @property string|null $company_logoFilename
 * @property string|null $businessname
 * @property string|null $fiscal_code
 * @property string|null $vat_code
 * @property string|null $sdi_code
 * @property string|null $pec_mail
 * @property int|null $entrance_qr_code
 * @property string|null $entrance_qr_code_filepath
 * @property string|null $entrance_qr_code_filename
 * @property int|null $exit_qr_code
 * @property string|null $exit_qr_code_filepath
 * @property string|null $exit_qr_code_filename
 *
 * @property \App\Model\Entity\User $user
 */
class Usercompany extends Entity
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
        'user_id' => true,
        'company_user' => true,
        'name' => true,
        'description' => true,
        'address' => true,
        'country' => true,
        'city' => true,
        'province' => true,
        'postal_code' => true,
        'email' => true,
        'phone_number' => true,
        'mobile_number' => true,
        'bank_name' => true,
        'state_bankbranch' => true,
        'province_bankbranch' => true,
        'city_bankbranch' => true,
        'iban' => true,
        'website' => true,
        'company_logoFilepath' => true,
        'company_logoFilename' => true,
        'user' => true,
        'businessname' => true,
        'fiscal_code' => true,
        'vat_code' => true,
        'sdi_code' => true,
        'pec_mail' => true,
        'entrance_qr_code' => true,
        'entrance_qr_code_filepath' => true,
        'entrance_qr_code_filename' => true,
        'exit_qr_code' => true,
        'exit_qr_code_filepath' => true,
        'exit_qr_code_filename' => true,
    ];
}
