<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PriceFixture
 */
class PriceFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'price';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'ID Prezzo', 'precision' => null, 'autoIncrement' => null],
        'articleId' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'Id articolo', 'precision' => null, 'autoIncrement' => null],
        'isDeleted' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'flag record cancellato', 'precision' => null],
        'sellPrice' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'Prezzo di vendita al pubblico - NON scontato'],
        'tax' => ['type' => 'decimal', 'length' => 5, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '% IVA da applicare al prezzo netto / inclusa nel prezzo di vendita'],
        'netPrice' => ['type' => 'decimal', 'length' => 16, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'Prezzo Netto - calcolato - sellPrice / (1 + %tax)'],
        'discount1' => ['type' => 'decimal', 'length' => 5, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => '0.00', 'comment' => 'Sconto 1'],
        'discount2' => ['type' => 'decimal', 'length' => 5, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => '0.00', 'comment' => 'Sconto 2'],
        'currencyCode' => ['type' => 'string', 'fixed' => true, 'length' => 3, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Codice ISO Valuta del prezzo', 'precision' => null],
        'startDate' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'Data inizio validità prezzo (se NULL usare data attuale)', 'precision' => null],
        'endDate' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'data fine validita prezzo (se NULL non ha scadenza)', 'precision' => null],
        'priceListId' => ['type' => 'string', 'fixed' => true, 'length' => 2, 'null' => true, 'default' => '00', 'collate' => 'utf8_general_ci', 'comment' => 'ID listino (default "00" = listino generale)', 'precision' => null],
        'note' => ['type' => 'text', 'length' => 16777215, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
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
                'articleId' => 1,
                'isDeleted' => 1,
                'sellPrice' => 1.5,
                'tax' => 1.5,
                'netPrice' => 1.5,
                'discount1' => 1.5,
                'discount2' => 1.5,
                'currencyCode' => 'L',
                'startDate' => '2019-08-08 10:16:20',
                'endDate' => '2019-08-08 10:16:20',
                'priceListId' => 'Lo',
                'note' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
            ],
        ];
        parent::init();
    }
}
