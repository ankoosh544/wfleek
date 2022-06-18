<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Anagraphic Entity
 *
 * @property int $id
 * @property bool|null $isDeleted
 * @property string $name1
 * @property string|null $name2
 * @property string|null $codFiscale
 * @property string|null $pIva
 * @property bool|null $isPhysicalPerson
 * @property bool|null $isPrivateCitizen
 * @property bool|null $isSchool
 * @property string|null $specialType
 * @property string|null $sex
 * @property \Cake\I18n\FrozenDate|null $birthDate
 * @property string|null $birthPlace
 * @property string|null $birthProvince
 * @property string|null $birthCountry
 * @property bool|null $isPIvaVerified
 * @property bool|null $isNonResidentCF
 * @property string|null $pec
 * @property string|null $ftp
 * @property string|null $web
 * @property bool|null $isAuthPersonalData
 * @property int|null $fatherId
 * @property string $langId
 * @property string|null $note
 */
class Anagraphic extends Entity
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
        'isDeleted' => true,
        'name1' => true,
        'name2' => true,
        'codFiscale' => true,
        'pIva' => true,
        'isPhysicalPerson' => true,
        'isPrivateCitizen' => true,
        'isSchool' => true,
        'specialType' => true,
        'sex' => true,
        'birthDate' => true,
        'birthPlace' => true,
        'birthProvince' => true,
        'birthCountry' => true,
        'isPIvaVerified' => true,
        'isNonResidentCF' => true,
        'pec' => true,
        'ftp' => true,
        'web' => true,
        'isAuthPersonalData' => true,
        'fatherId' => true,
        'langId' => true,
        'note' => true
    ];
}
