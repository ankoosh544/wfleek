<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserFixture
 */
class UserFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'user';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'user ID - Autoinc', 'autoIncrement' => true, 'precision' => null],
        'isDeleted' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'flag utente cancellato (non più attivo)', 'precision' => null],
        'firstname' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Nome se una persona o Denominazione 1 nel caso di Scuole/Enti', 'precision' => null, 'fixed' => null],
        'lastname' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Cognome se persona o Denominazione 2 nel caso di Scuole/Enti', 'precision' => null, 'fixed' => null],
        'email' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'email principale - usato per Login (alternativa a username)', 'precision' => null, 'fixed' => null],
        'email2' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'email secondario usato come alternativa per recupero password', 'precision' => null, 'fixed' => null],
        'langId' => ['type' => 'string', 'fixed' => true, 'length' => 2, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'id lingua utente per comunicazioni', 'precision' => null],
        'username' => ['type' => 'string', 'length' => 70, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'username utente/scuola - usato per Login (alternativa a email)', 'precision' => null, 'fixed' => null],
        'password' => ['type' => 'string', 'length' => 245, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'passwordExpirationDate' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'Data di scadenza password', 'precision' => null],
        'lastChangePwdTime' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'timestamp ultimo cambio password', 'precision' => null],
        'isOrganization' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'Flag tipo utente - FALSE = utente normale (Persona fisica), TRUE = utente di tipo Scuola/Azienda
identifica utente SCUOLA o AZIENDA riferimento di studenti/docenti', 'precision' => null],
        'nickname' => ['type' => 'string', 'length' => 70, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'nickname utente / quello che viene visualizzato a video', 'precision' => null, 'fixed' => null],
        'isBlocked' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'Flag utente bloccato (TRUE), NON bloccato (FALSE)', 'precision' => null],
        'blockReason' => ['type' => 'string', 'length' => 200, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Motivo del blocco', 'precision' => null, 'fixed' => null],
        'tel' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'eventuali recapiti telefonici supplementari (oltre a quelli in record indirizzo)', 'precision' => null, 'fixed' => null],
        'registrationDate' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'timestamp di creazione record utente', 'precision' => null],
        'expirationDate' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'data di scadenza utente - NULL = nessuna scadenza', 'precision' => null],
        'lastUpdate' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => 'current_timestamp()', 'comment' => 'timestamp ultimo aggiornamento utente (qualsiasi campo)', 'precision' => null],
        'imageFileName' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'nome file immagine/logo - da usare in alternativa al campo Blob', 'precision' => null, 'fixed' => null],
        'imageFilePath' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Path file immagine/logo - da usare in alternativa al campo Blob', 'precision' => null, 'fixed' => null],
        'image' => ['type' => 'binary', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'immagine/logo utente - da usare in alternativa ai campi FileName e FilePath immagine', 'precision' => null],
        'note' => ['type' => 'text', 'length' => 16777215, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'anagId' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'ID anagrafica con dati per fatturazione - NULL se utente non può ricevere fatture, quindi DEVE avere un referralUserId per poter acquistare (per conto del referral)', 'precision' => null, 'autoIncrement' => null],
        'isReferral' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'Flag utente di riferimento per acquisti di altri utenti (genitore o Azienda/Scuola) se TRUE', 'precision' => null],
        'referralPrivateUserId' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'ID utente di riferimento per acquisti PRIVATI (referral per ENTE è organizationId in tbl organization_user)', 'precision' => null, 'autoIncrement' => null],
        'level' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => 'Livello per gestire visualizzazioni con incolonnamento differente per livello
Default = 0 (Livello iniziale - NON ha padre/previous)
Ogni item che ha padre/previous setta level = padre.level + 1', 'precision' => null, 'autoIncrement' => null],
        'isAuthByReferral' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'Flag autorizzazione acquisti per conto del referral - TRUE = autorizzato, FALSE = non autorizzato (default), quindi occorre chiedere autorizzazione al referral per ogni acquisto', 'precision' => null],
        'birthday' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'address' => ['type' => 'string', 'length' => 250, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'country' => ['type' => 'string', 'length' => 250, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'state' => ['type' => 'string', 'length' => 250, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'cap' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'gender' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'resetpasswordcode' => ['type' => 'integer', 'length' => 6, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tags' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'profileFilename' => ['type' => 'string', 'length' => 225, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'profileFilepath' => ['type' => 'string', 'length' => 225, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'fk_user_language1_idx' => ['type' => 'index', 'columns' => ['langId'], 'length' => []],
            'email2' => ['type' => 'index', 'columns' => ['email2'], 'length' => []],
            'user_password' => ['type' => 'index', 'columns' => ['password', 'email'], 'length' => []],
            'fk_user_anagraphic1_idx' => ['type' => 'index', 'columns' => ['anagId'], 'length' => []],
            'REFERRAL' => ['type' => 'index', 'columns' => ['referralPrivateUserId'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'username_UNIQUE' => ['type' => 'unique', 'columns' => ['username'], 'length' => []],
            'email_UNIQUE' => ['type' => 'unique', 'columns' => ['email'], 'length' => []],
            'nickname_UNIQUE' => ['type' => 'unique', 'columns' => ['nickname'], 'length' => []],
            'fk_user_anagraphic1' => ['type' => 'foreign', 'columns' => ['anagId'], 'references' => ['anagraphic', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_user_language1' => ['type' => 'foreign', 'columns' => ['langId'], 'references' => ['language', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'isDeleted' => 1,
                'firstname' => 'Lorem ipsum dolor sit amet',
                'lastname' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'email2' => 'Lorem ipsum dolor sit amet',
                'langId' => 'Lo',
                'username' => 'Lorem ipsum dolor sit amet',
                'password' => 'Lorem ipsum dolor sit amet',
                'passwordExpirationDate' => '2021-09-18',
                'lastChangePwdTime' => 1631958530,
                'isOrganization' => 1,
                'nickname' => 'Lorem ipsum dolor sit amet',
                'isBlocked' => 1,
                'blockReason' => 'Lorem ipsum dolor sit amet',
                'tel' => 'Lorem ipsum dolor sit amet',
                'registrationDate' => 1631958530,
                'expirationDate' => '2021-09-18',
                'lastUpdate' => 1631958530,
                'imageFileName' => 'Lorem ipsum dolor sit amet',
                'imageFilePath' => 'Lorem ipsum dolor sit amet',
                'image' => 'Lorem ipsum dolor sit amet',
                'note' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'anagId' => 1,
                'isReferral' => 1,
                'referralPrivateUserId' => 1,
                'level' => 1,
                'isAuthByReferral' => 1,
                'birthday' => '2021-09-18 09:48:50',
                'address' => 'Lorem ipsum dolor sit amet',
                'country' => 'Lorem ipsum dolor sit amet',
                'state' => 'Lorem ipsum dolor sit amet',
                'cap' => 1,
                'gender' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'resetpasswordcode' => 1,
                'tags' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'profileFilename' => 'Lorem ipsum dolor sit amet',
                'profileFilepath' => 'Lorem ipsum dolor sit amet'
            ],
        ];
        parent::init();
    }
}
