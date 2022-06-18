<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ECourseFixture
 */
class ECourseFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'e_course';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'ID corso eLearning (= ID articolo)', 'precision' => null, 'autoIncrement' => null],
        'isDeleted' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'Flag corso cancellato = TRUE, attivo = FALSE', 'precision' => null],
        'title' => ['type' => 'string', 'length' => 70, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'titolo / nome corso', 'precision' => null, 'fixed' => null],
        'subtitle' => ['type' => 'string', 'length' => 250, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'sottotitolo del corso', 'precision' => null, 'fixed' => null],
        'description' => ['type' => 'text', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'descrizione del corso', 'precision' => null],
        'languageCode' => ['type' => 'string', 'fixed' => true, 'length' => 2, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'codice lingua del corso (ISO 639-2)', 'precision' => null],
        'ownerId' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'ID dell’utente proprietario del corso - insieme a organizationId serve per la fatturazione dei costi o dei guadagni.', 'precision' => null, 'autoIncrement' => null],
        'organizationId' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'ID organizzazione a cui appartiene il corso - NULL se non appartiene a nessuna organizzazione', 'precision' => null, 'autoIncrement' => null],
        'isFree' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'Flag corso Gratuito (True) oppure a pagamento (False)', 'precision' => null],
        'isRestrictedAccess' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'Flag corso ad accesso riservato = TRUE, ad accesso pubblico = FALSE
se ad accesso riservato vedere ACL (Access Control List)', 'precision' => null],
        'isInternal' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'Flag corso Interno = TRUE (solo per utenti collegati a organizzazione), Esterno = FALSE (per chiunque) - ha senso SOLO per corsi collegati a una organizzazione', 'precision' => null],
        'status' => ['type' => 'string', 'fixed' => true, 'length' => 3, 'null' => true, 'default' => 'EDT', 'collate' => 'utf8_general_ci', 'comment' => 'Stato del corso (EDT = Editing, CPL = Complete, REQ = Request, RJT = Rejected, APP = Approved, PUB = Published, BLK = Blocked)', 'precision' => null],
        'isApprovalRequired' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '1', 'comment' => 'Flag per richiesta di approvazione necessaria = TRUE (default), approvazione non necessaria = FALSE', 'precision' => null],
        'createDate' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'Timestamp creazione Corso', 'precision' => null],
        'creatorId' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'ID utente Creatore del Corso', 'precision' => null, 'autoIncrement' => null],
        'lastUpdate' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'Data ultimo aggiornamento', 'precision' => null],
        'matterId' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'ID materia (se applicabile)', 'precision' => null, 'autoIncrement' => null],
        'eCategoryId' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'ID Categoria di eLearning (se applicabile)', 'precision' => null, 'autoIncrement' => null],
        'password' => ['type' => 'string', 'length' => 245, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'eventuale password di accesso (default NULL) - USO FUTURO', 'precision' => null, 'fixed' => null],
        'startDate' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'Data inizio corso - prima il corso non è visibile a nessun utente-studente', 'precision' => null],
        'endDate' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'Data fine corso - dopo la data il corso non è più visibile a nessun utente-studente', 'precision' => null],
        'endSubscriptionDate' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'Data fine iscrizioni al corso - Utile se ha data di inizio e fine - con questi dati garantisco che uno studente abbia il corso a disposizione per un tempo minimo (da endDate a end SubscriptionDate)', 'precision' => null],
        'isObsolete' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'flag corso Obsoleto - da usare coi corsi che hanno endDate - DA VALUTARE', 'precision' => null],
        'isVisible' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '1', 'comment' => 'Flag corso visibile - potrebbe servire per nascondere il corso - DA VALUTARE', 'precision' => null],
        'isOffLine' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'Flag corso OffLine = TRUE, oppure onLine = False (default) - impedisce temporaneamente utilizzo del corso - per manutenzione, verifiche o altro', 'precision' => null],
        'bibliography' => ['type' => 'text', 'length' => 16777215, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Eventuale bibliografia del corso (testo libero) - se ci sono riferimenti a libri posseduti dalla piattaforma, questi sono nella tabella e_course_bibliography', 'precision' => null],
        'xUBInt1' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => 'unsigned bigint libero 1', 'precision' => null, 'autoIncrement' => null],
        'xUBint2' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => 'unsigned bigint libero 2', 'precision' => null, 'autoIncrement' => null],
        'xInt' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => 'Intero libero 1', 'precision' => null, 'autoIncrement' => null],
        'isXCond1' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'condizione libera 1', 'precision' => null],
        'isXCond2' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'condizione libera 2', 'precision' => null],
        'xChar1' => ['type' => 'string', 'fixed' => true, 'length' => 1, 'null' => true, 'default' => '', 'collate' => 'utf8_general_ci', 'comment' => 'indicatore carattere libero (default spazio)', 'precision' => null],
        'xString1' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'stringa libera 1', 'precision' => null, 'fixed' => null],
        'xString2' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'stringa libera 2', 'precision' => null, 'fixed' => null],
        'xString3' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'stringa libera 3', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'fk_e_course_creator_idx' => ['type' => 'index', 'columns' => ['creatorId'], 'length' => []],
            'fk_e_course_e_category1_idx' => ['type' => 'index', 'columns' => ['eCategoryId'], 'length' => []],
            'titolo_in_lingua' => ['type' => 'index', 'columns' => ['languageCode', 'title'], 'length' => []],
            'titolo' => ['type' => 'index', 'columns' => ['title'], 'length' => []],
            'fk_e_course_owner_idx' => ['type' => 'index', 'columns' => ['ownerId'], 'length' => []],
            'fk_e_course_matter1_idx' => ['type' => 'index', 'columns' => ['matterId'], 'length' => []],
            'fk_e_course_organization1_idx' => ['type' => 'index', 'columns' => ['organizationId'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
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
                'title' => 'Lorem ipsum dolor sit amet',
                'subtitle' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'languageCode' => 'Lo',
                'ownerId' => 1,
                'organizationId' => 1,
                'isFree' => 1,
                'isRestrictedAccess' => 1,
                'isInternal' => 1,
                'status' => 'L',
                'isApprovalRequired' => 1,
                'createDate' => 1565259367,
                'creatorId' => 1,
                'lastUpdate' => 1565259367,
                'matterId' => 1,
                'eCategoryId' => 1,
                'password' => 'Lorem ipsum dolor sit amet',
                'startDate' => '2019-08-08',
                'endDate' => '2019-08-08',
                'endSubscriptionDate' => '2019-08-08',
                'isObsolete' => 1,
                'isVisible' => 1,
                'isOffLine' => 1,
                'bibliography' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'xUBInt1' => 1,
                'xUBint2' => 1,
                'xInt' => 1,
                'isXCond1' => 1,
                'isXCond2' => 1,
                'xChar1' => 'L',
                'xString1' => 'Lorem ipsum dolor sit amet',
                'xString2' => 'Lorem ipsum dolor sit amet',
                'xString3' => 'Lorem ipsum dolor sit amet'
            ],
        ];
        parent::init();
    }
}
