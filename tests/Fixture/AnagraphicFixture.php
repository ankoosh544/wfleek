<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AnagraphicFixture
 */
class AnagraphicFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'anagraphic';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'ID anagrafica - Autoinc', 'precision' => null, 'autoIncrement' => null],
        'isDeleted' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'Flag record cancellato (=TRUE), default False = non cancellato', 'precision' => null],
        'name1' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Regione Sociale 1 o Cognome (se Privato - persona fisica senza partita IVA)', 'precision' => null, 'fixed' => null],
        'name2' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Regione Sociale 2 o Nome se Privato (persona fisica senza partita IVA) - obbligatorio se Privato', 'precision' => null, 'fixed' => null],
        'codFiscale' => ['type' => 'string', 'length' => 16, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Codice Fiscale - obbligatorio se cliente o fornitore, e privato', 'precision' => null, 'fixed' => null],
        'pIva' => ['type' => 'string', 'length' => 16, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Partita IVA - obbligatorio se cliente o fornitore, e azienda', 'precision' => null, 'fixed' => null],
        'isPhysicalPerson' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'Flag Persona Fisica - indica se azienda è una societa (=TRUE) oppure una persona (=FALSE)', 'precision' => null],
        'isPrivateCitizen' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'Flag Privato Cittadino - indica se si tratta di Privato che ha solo il codice fiscale (=TRUE) oppure no', 'precision' => null],
        'isSchool' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'Flag Scuola o Ente NON scolastico(azienda/privato) - TRUE = Scuola
Per gli enti non scolastici non sono previsti Livello e/o Tipo scuola, Corsi, Materie', 'precision' => null],
        'specialType' => ['type' => 'string', 'fixed' => true, 'length' => 3, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'eventuale classificazione Tipo speciale - usato per record di anagrafica che non sono clienti e non sono fornitori come ad esempio i corrieri. Previsto per raggruppare i record dello stesso tipo.', 'precision' => null],
        'sex' => ['type' => 'string', 'fixed' => true, 'length' => 1, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Sesso (M=maschio, F=femmina) per privati che hanno codice fiscale - serve a verificare il codice fiscale in Italiano - default NULL', 'precision' => null],
        'birthDate' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'Data di Nascita - per privati che hanno codice fiscale - serve a verificare il codice fiscale in Italiano - default NULL', 'precision' => null],
        'birthPlace' => ['type' => 'string', 'length' => 70, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Luogo di Nascita (Comune se in Italia) NON usare se nato fuori Italia (estero) - serve a verificare il codice fiscale in Italiano - default NULL', 'precision' => null, 'fixed' => null],
        'birthProvince' => ['type' => 'string', 'fixed' => true, 'length' => 2, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Sigla Provincia di Nascita (usare sigla provincia per Italia, EE per stato estero) - serve a verificare il codice fiscale in Italiano - default NULL', 'precision' => null],
        'birthCountry' => ['type' => 'string', 'fixed' => true, 'length' => 2, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Nazione di Nascita - per privati che hanno codice fiscale - serve a verificare il codice fiscale in Italiano - default NULL', 'precision' => null],
        'isPIvaVerified' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'Flag Partita IVA verificata - TRUE = verificata, FALSE = da verificare', 'precision' => null],
        'isNonResidentCF' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'Flag Codice Fiscale per stranieri - TRUE = straniero, FALSE = nato in italia', 'precision' => null],
        'pec' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'email certificata (PEC) della società o persona', 'precision' => null, 'fixed' => null],
        'ftp' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'sito ftp della società o persona', 'precision' => null, 'fixed' => null],
        'web' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'sito internet della società o persona', 'precision' => null, 'fixed' => null],
        'isAuthPersonalData' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'Flag Autorizzazione al trattamento dei dati personali - TRUE = Autorizza, FALSE = NON autorizza', 'precision' => null],
        'fatherId' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'Identifica eventuale dipendenza da altra anagrafica - ad esempio un dipartimento che dipende da universita, ma entrambe le anagrafiche possono essere autonome e indipendenti', 'precision' => null, 'autoIncrement' => null],
        'langId' => ['type' => 'string', 'fixed' => true, 'length' => 2, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'ID lingua da usare per comunicazioni', 'precision' => null],
        'note' => ['type' => 'text', 'length' => 16777215, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'eventuali note', 'precision' => null],
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
                'name1' => 'Lorem ipsum dolor sit amet',
                'name2' => 'Lorem ipsum dolor sit amet',
                'codFiscale' => 'Lorem ipsum do',
                'pIva' => 'Lorem ipsum do',
                'isPhysicalPerson' => 1,
                'isPrivateCitizen' => 1,
                'isSchool' => 1,
                'specialType' => 'L',
                'sex' => 'L',
                'birthDate' => '2019-08-12',
                'birthPlace' => 'Lorem ipsum dolor sit amet',
                'birthProvince' => 'Lo',
                'birthCountry' => 'Lo',
                'isPIvaVerified' => 1,
                'isNonResidentCF' => 1,
                'pec' => 'Lorem ipsum dolor sit amet',
                'ftp' => 'Lorem ipsum dolor sit amet',
                'web' => 'Lorem ipsum dolor sit amet',
                'isAuthPersonalData' => 1,
                'fatherId' => 1,
                'langId' => 'Lo',
                'note' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
            ],
        ];
        parent::init();
    }
}
