<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProjectMessageAttachmentFixture
 */
class ProjectMessageAttachmentFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'project_message_attachment';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'projectId' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'ID progetto', 'precision' => null, 'autoIncrement' => null],
        'senderId' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'ID sender del messaggio', 'precision' => null, 'autoIncrement' => null],
        'createDate' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => 'timestamp di creazione del messaggio ', 'precision' => null],
        'fileMarker' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'file marker attachment', 'precision' => null],
        'fileCnt' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'counter attachment', 'precision' => null, 'autoIncrement' => null],
        'iconId' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'ID icona da usare per rappresentare il tipo di file - prioritario su icona memorizzata nel record attachment', 'precision' => null, 'autoIncrement' => null],
        'description' => ['type' => 'string', 'length' => 70, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'eventuale descrizione breve allegato', 'precision' => null, 'fixed' => null],
        'note' => ['type' => 'text', 'length' => 16777215, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'eventuali note', 'precision' => null],
        '_indexes' => [
            'fk_project_message_attachment_file_object1_idx' => ['type' => 'index', 'columns' => ['fileMarker', 'fileCnt'], 'length' => []],
            'fk_project_message_attachment_icon1_idx' => ['type' => 'index', 'columns' => ['iconId'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['projectId', 'senderId', 'createDate', 'fileMarker', 'fileCnt'], 'length' => []],
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
                'createDate' => 1564591453,
                'fileMarker' => '2019-07-31 16:44:13',
                'fileCnt' => 1,
                'iconId' => 1,
                'description' => 'Lorem ipsum dolor sit amet',
                'note' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
            ],
        ];
        parent::init();
    }
}
