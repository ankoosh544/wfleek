<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ArticleFixture
 */
class ArticleFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'article';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'ID articolo = ID oggetto (Book, Subscription, eCourse)', 'precision' => null, 'autoIncrement' => null],
        'type' => ['type' => 'string', 'fixed' => true, 'length' => 1, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'tipo articolo - B = Book, C = eCourse, S = Subscription, A = altro (default)', 'precision' => null],
        'isDeleted' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'flag articolo cancellato', 'precision' => null],
        'name' => ['type' => 'string', 'length' => 70, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Nome / descrizione breve articolo', 'precision' => null, 'fixed' => null],
        'description' => ['type' => 'string', 'length' => 250, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'descrizione lunga', 'precision' => null, 'fixed' => null],
        'isVirtualQty' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'Flag quantità virtuale (non richiede gestione della giacenza) - TRUE = qta virtuale (es. crediti, GB, multi licenze), FALSE = qta reale (es. licenze eBook)', 'precision' => null],
        'isObsolete' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'Flag articolo obsoleto (non utilizzabile nelle transazioni) - FALSE (default) = articolo utilizzabile da cliente, TRUE = obsoleto', 'precision' => null],
        'um' => ['type' => 'string', 'fixed' => true, 'length' => 3, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'codice unita di misura articolo', 'precision' => null],
        'umPack' => ['type' => 'string', 'fixed' => true, 'length' => 3, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'codice unita di misura confezione/pacchetto', 'precision' => null],
        'packQty' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => 'quantita articolo in confezione, se 1+ è confezione e deve avere UM-Pack - ZERO (default) = non è confezione, e UM-Pack può essere NULL', 'precision' => null, 'autoIncrement' => null],
        'singleArticleId' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'ID Articolo nel Pack', 'precision' => null, 'autoIncrement' => null],
        'grp' => ['type' => 'string', 'fixed' => true, 'length' => 5, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Eventuale gruppo articoli - permette di creare gruppi di articoli per eventuali future necessita statistiche o di selezione per listini prezzi', 'precision' => null],
        'note' => ['type' => 'text', 'length' => 16777215, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'eventuali note articolo', 'precision' => null],
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
                'type' => 'L',
                'isDeleted' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet',
                'isVirtualQty' => 1,
                'isObsolete' => 1,
                'um' => 'L',
                'umPack' => 'L',
                'packQty' => 1,
                'singleArticleId' => 1,
                'grp' => 'Lor',
                'note' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
            ],
        ];
        parent::init();
    }
}
