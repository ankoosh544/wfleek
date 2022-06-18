<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity
 *
 * @property int $id
 * @property int|null $choosen_company_Id
 * @property bool|null $isDeleted
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string $email
 * @property string|null $email2
 * @property string $langId
 * @property string $username
 * @property string $password
 * @property \Cake\I18n\FrozenDate $passwordExpirationDate
 * @property \Cake\I18n\FrozenTime|null $lastChangePwdTime
 * @property bool|null $isOrganization
 * @property string $nickname
 * @property bool|null $isBlocked
 * @property string|null $blockReason
 * @property string|null $tel
 * @property \Cake\I18n\FrozenTime|null $registrationDate
 * @property \Cake\I18n\FrozenDate|null $expirationDate
 * @property \Cake\I18n\FrozenTime|null $lastUpdate
 * @property string|null $imageFileName
 * @property string|null $imageFilePath
 * @property string|resource|null $image
 * @property string|null $note
 * @property int|null $anagId
 * @property bool|null $isReferral
 * @property int|null $referralPrivateUserId
 * @property int|null $level
 * @property bool|null $isAuthByReferral
 * @property \Cake\I18n\FrozenTime|null $birthday
 * @property string|null $address
 * @property string|null $country
 * @property string|null $state
 * @property int|null $cap
 * @property string|null $gender
 * @property int|null $resetpasswordcode
 * @property \Cake\I18n\FrozenDate|null $resetpassword_expirydate
 * @property string|null $tags
 * @property string|null $profileFilename
 * @property string|null $profileFilepath
 * @property \Cake\I18n\FrozenTime|null $last_login
 * @property string|null $status
 * @property string|null $memberType
 * @property string|null $two_factor_securitycode
 * @property \Cake\I18n\FrozenDate|null $two_factor_securitycode_expirydate
 * @property string|null $businessname
 * @property string|null $tax_code
 * @property string|null $vat_code
 * @property bool|null $isCompany
 * @property string|null $apptokenNumber
 *
 *
 * @property \App\Model\Entity\Comment[] $comments
 * @property \App\Model\Entity\EGivenAnswer[] $e_given_answers
 * @property \App\Model\Entity\ELessonCompleted[] $e_lesson_completed
 * @property \App\Model\Entity\Leave[] $leaves
 * @property \App\Model\Entity\OrganizatioUsersYear[] $organizatio_users_years
 * @property \App\Model\Entity\OrganizationRole[] $organization_roles
 * @property \App\Model\Entity\SchoolTranscript[] $school_transcripts
 * @property \App\Model\Entity\SlRole[] $sl_roles
 * @property \App\Model\Entity\SupportEmail[] $support_emails
 * @property \App\Model\Entity\ECourse[] $e_course
 * @property \App\Model\Entity\Organization[] $organization
 * @property \App\Model\Entity\Role[] $role
 * @property \App\Model\Entity\Subscription[] $subscription
 */
class User extends Entity
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
        'isDeleted' => true,
        'firstname' => true,
        'lastname' => true,
        'email' => true,
        'email2' => true,
        'langId' => true,
        'username' => true,
        'password' => true,
        'passwordExpirationDate' => true,
        'lastChangePwdTime' => true,
        'isOrganization' => true,
        'nickname' => true,
        'isBlocked' => true,
        'blockReason' => true,
        'tel' => true,
        'registrationDate' => true,
        'expirationDate' => true,
        'lastUpdate' => true,
        'imageFileName' => true,
        'imageFilePath' => true,
        'image' => true,
        'note' => true,
        'anagId' => true,
        'isReferral' => true,
        'referralPrivateUserId' => true,
        'level' => true,
        'isAuthByReferral' => true,
        'birthday' => true,
        'address' => true,
        'country' => true,
        'state' => true,
        'cap' => true,
        'gender' => true,
        'resetpasswordcode' => true,
        'resetpassword_expirydate' => true,
        'tags' => true,
        'profileFilename' => true,
        'profileFilepath' => true,
        'last_login' => true,
        'status' => true,
        'memberType' => true,
        'two_factor_securitycode' => true,
        'two_factor_securitycode_expirydate' =>true,
        'businessname' => true,
        'tax_code' => true,
        'vat_code' => true,
        'isCompany' => true,
        'apptokenNumber' => true,
        'comments' => true,
        'e_given_answers' => true,
        'e_lesson_completed' => true,
        'leaves' => true,
        'organizatio_users_years' => true,
        'organization_roles' => true,
        'school_transcripts' => true,
        'sl_roles' => true,
        'support_emails' => true,
        'e_course' => true,
        'organization' => true,
        'role' => true,
        'subscription' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    protected function _setPassword($value)
    {

        if (strlen($value)) {
            $hasher = new DefaultPasswordHasher();
            return $hasher->hash($value);
        }
    }
}
