<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrganizationFixture
 */
class OrganizationFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'organization';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'ID organizzazione (istituto scolastico o Azienda) - autoinc', 'precision' => null, 'autoIncrement' => null],
        'anagId' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'ID anagrafica organizzazione - Ogni organizzazione (Ente) ha una anagrafica corispondente', 'precision' => null, 'autoIncrement' => null],
        'isDeleted' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'flag scuola/azienda cancellata', 'precision' => null],
        'isCompany' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'Flag Scuola o Ente NON scolastico/azienda/privato - TRUE = Azienda/privato/Ente NON scolastico, FALSE = Scuola
SOLO per Scuole sono previsti Codici Ministeriali, Livello e/o Tipo scuola, Corsi, Materie', 'precision' => null],
        'isMiur' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'Flag scuola pervenuta da elenco MIUR - rilevante solo per Scuole', 'precision' => null],
        'createDate' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => 'CURRENT_TIMESTAMP', 'comment' => 'timestamp creazione Scuola/Azienda', 'precision' => null],
        'imageFileName' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'nome file immagine/Logo - da usare in alternativa al campo BLOB', 'precision' => null, 'fixed' => null],
        'imageFilePath' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Path file immagine/Logo - da usare in alternativa al campo BLOB', 'precision' => null, 'fixed' => null],
        'imageFileServer' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Server dove memorizzare il file immagine/logo - da usare in alternativa al campo Blob', 'precision' => null, 'fixed' => null],
        'image' => ['type' => 'binary', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'immagine/Logo scuola / ente - da usare in alternativa ai campi FileName e FilePath immagine', 'precision' => null],
        'isBlocked' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'Flag di Blocco - FALSE = non bloccato (default), TRUE = bloccato
impedisce di fare qualsiasi operazione relativa alla scuola/azienda; vale anche per tutti gli utenti collegati', 'precision' => null],
        'blockDate' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'Timestamp di blocco', 'precision' => null],
        'blockReason' => ['type' => 'string', 'length' => 200, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'eventuale motivo del blocco', 'precision' => null, 'fixed' => null],
        'fatherId' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'id organizzazione padre - permette di avere sottoorganizzazioni (es. Universita, dipartimenti)', 'precision' => null, 'autoIncrement' => null],
        'level' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => 'Livello per gestire visualizzazioni con incolonnamento differente per livello
Default = 0 (Livello iniziale - NON ha padre/previous)
Ogni item che ha padre/previous setta level = padre.level + 1', 'precision' => null, 'autoIncrement' => null],
        'note' => ['type' => 'text', 'length' => 16777215, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'note eventuali', 'precision' => null],
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
                'anagId' => 1,
                'isDeleted' => 1,
                'isCompany' => 1,
                'isMiur' => 1,
                'createDate' => 1565259373,
                'imageFileName' => 'Lorem ipsum dolor sit amet',
                'imageFilePath' => 'Lorem ipsum dolor sit amet',
                'imageFileServer' => 'Lorem ipsum dolor sit amet',
                'image' => 'Lorem ipsum dolor sit amet',
                'isBlocked' => 1,
                'blockDate' => 1565259373,
                'blockReason' => 'Lorem ipsum dolor sit amet',
                'fatherId' => 1,
                'level' => 1,
                'note' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
            ],
        ];
        parent::init();
    }
}
