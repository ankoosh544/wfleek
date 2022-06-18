<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FileObjectFixture
 */
class FileObjectFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'file_object';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'marker' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'Marca temporale (alla creazione settare come il timer di sistema)', 'precision' => null],
        'cnt' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'counter attachment - per risolvere il caso di più allegati creati con lo stesso timer di sistema (da 0 in poi)', 'precision' => null, 'autoIncrement' => null],
        'isDeleted' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'flag record cancellato', 'precision' => null],
        'displayFileName' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'eventuale nome del file da visualizzare - invece di originalFileName', 'precision' => null, 'fixed' => null],
        'originalFileName' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Nome originale del file allegato', 'precision' => null, 'fixed' => null],
        'codeExt' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Estensione del nome file - ricavata dal nome originale del file - serve ad agganciare una estensione esistente per visualizzare icona corrispondente', 'precision' => null, 'fixed' => null],
        'storeFileName' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Nome ridefinito allegato per il salvataggio in area di store', 'precision' => null, 'fixed' => null],
        'storePath' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'path area di store dove è memorizzato il file allegato (con nome ridefinito)', 'precision' => null, 'fixed' => null],
        'storeServerName' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Nome del server dove risiede la store area in cui è memorizzato il file allegato', 'precision' => null, 'fixed' => null],
        'storeServerIp' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'indirizzo IP del server dove risiede la store area in cui è memorizzato il file allegato', 'precision' => null, 'fixed' => null],
        'storeFileSize' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => '-1', 'comment' => 'dimensione del file allegato (se -1 dimensione NON valorizzata)', 'precision' => null, 'autoIncrement' => null],
        'storeFileDateTime' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'Data e ora del file allegato nella store area (dati di sistema)', 'precision' => null],
        'ownerId' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'ID utente proprietario del file (utente che ha creato il file)', 'precision' => null, 'autoIncrement' => null],
        'checksumId' => ['type' => 'string', 'fixed' => true, 'length' => 10, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'algoritmo di checksum utilizzato - NULL = checksum NON utilizzato', 'precision' => null],
        'checksumString' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Checksum del file allegato - decidere quando calcolare il checksum', 'precision' => null, 'fixed' => null],
        'note' => ['type' => 'text', 'length' => 16777215, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'eventuali note sul file allegato', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['marker', 'cnt'], 'length' => []],
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
                'marker' => '2019-07-31 16:42:22',
                'cnt' => 1,
                'isDeleted' => 1,
                'displayFileName' => 'Lorem ipsum dolor sit amet',
                'originalFileName' => 'Lorem ipsum dolor sit amet',
                'codeExt' => 'Lorem ip',
                'storeFileName' => 'Lorem ipsum dolor sit amet',
                'storePath' => 'Lorem ipsum dolor sit amet',
                'storeServerName' => 'Lorem ipsum dolor sit amet',
                'storeServerIp' => 'Lorem ipsum dolor sit amet',
                'storeFileSize' => 1,
                'storeFileDateTime' => '2019-07-31 16:42:22',
                'ownerId' => 1,
                'checksumId' => 'Lorem ip',
                'checksumString' => 'Lorem ipsum dolor sit amet',
                'note' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
            ],
        ];
        parent::init();
    }
}
