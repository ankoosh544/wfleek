<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProjectMessageFixture
 */
class ProjectMessageFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'project_message';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'projectId' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'ID Progetto', 'precision' => null, 'autoIncrement' => null],
        'senderId' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'ID utente autore del commento', 'precision' => null, 'autoIncrement' => null],
        'createDate' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => 'timestamp del messaggio - più utenti possono scrivere messaggi su differenti progetti nello stesso momento', 'precision' => null],
        'isDeleted' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'flag messaggio cancellato - se si cancella un padre si devono cancellare tutti i figli', 'precision' => null],
        'text' => ['type' => 'text', 'length' => 16777215, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'testo del messaggio', 'precision' => null],
        'langId' => ['type' => 'string', 'fixed' => true, 'length' => 2, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'ID lingua del messaggio (tbl Language) - lingua usata da utente quando ha scritto il messaggio', 'precision' => null],
        'fatherProjectId' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'ID progetto del messaggio padre', 'precision' => null, 'autoIncrement' => null],
        'fatherSenderId' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'ID sender del messaggio padre', 'precision' => null, 'autoIncrement' => null],
        'fatherCreateDate' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'Creation Date del messaggio padre', 'precision' => null],
        'level' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => 'Livello per gestire visualizzazioni con incolonnamento differente per livello
Default = 0 (Livello iniziale - NON ha padre/previous)
Ogni item che ha padre/previous setta level = padre.level + 1', 'precision' => null, 'autoIncrement' => null],
        'referenceProjectId' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'ID Progetto del messaggio iniziale della conversazione', 'precision' => null, 'autoIncrement' => null],
        'referenceSenderId' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'ID sender del messaggio iniziale della conversazione', 'precision' => null, 'autoIncrement' => null],
        'referenceCreateDate' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'Creation Date del messaggio iniziale della conversazione', 'precision' => null],
        '_indexes' => [
            'fk_project_comment_user1_idx' => ['type' => 'index', 'columns' => ['senderId'], 'length' => []],
            'fk_project_comment_language1_idx' => ['type' => 'index', 'columns' => ['langId'], 'length' => []],
            'FATHER' => ['type' => 'index', 'columns' => ['fatherProjectId', 'fatherSenderId', 'fatherCreateDate'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['projectId', 'senderId', 'createDate'], 'length' => []],
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
                'projectId' => 1,
                'senderId' => 1,
                'createDate' => 1564591430,
                'isDeleted' => 1,
                'text' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'langId' => 'Lo',
                'fatherProjectId' => 1,
                'fatherSenderId' => 1,
                'fatherCreateDate' => 1564591430,
                'level' => 1,
                'referenceProjectId' => 1,
                'referenceSenderId' => 1,
                'referenceCreateDate' => 1564591430
            ],
        ];
        parent::init();
    }
}
