<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProjectMemberFixture
 */
class ProjectMemberFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'project_member';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'projectId' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'ID progetto', 'precision' => null, 'autoIncrement' => null],
        'memberType' => ['type' => 'string', 'fixed' => true, 'length' => 1, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Tipo membro del progetto - U = User, G = Project', 'precision' => null],
        'memberId' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'ID Membro - in base al tipo
- tipo <U> = Id Utente
- tipo <G> = Id Progetto', 'precision' => null, 'autoIncrement' => null],
        'accessLevel' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => '6', 'comment' => 'Livello di accesso (1 digit da 0 a 9) - DEFAULT = 6
0 = system admin
1 = owner
2 = amministratore
3, 4, 5 = USI FUTURI
6 = utente normale (DEFAULT)
7, 8, 9 = USI FUTURI', 'precision' => null, 'autoIncrement' => null],
        'joinDate' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'Data di adesione al progetto - a seguito di invito o richiesta o adesione autonoma', 'precision' => null],
        'sponsorId' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'ID utente che ha invitato o accettato la richiesta di adesione (x statistica)', 'precision' => null, 'autoIncrement' => null],
        'isInvitation' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '1', 'comment' => 'Flag invito - TRUE = membro invitato nel progetto, in attesa di adesione di utente invitato', 'precision' => null],
        'invitationDate' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'eventuale data di invito ad aderire al progetto', 'precision' => null],
        'isMembershipRequest' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'Flag richiesta di adesione - TRUE = richiesta di adesione in attesa autorizzazione da amministratore del progetto', 'precision' => null],
        'membershipRequestDate' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'eventuale data della richiesta di adesione al progetto', 'precision' => null],
        'isBanned' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'Flag Banned (divieto di far parte del progetto) - TRUE = utente espulso', 'precision' => null],
        'banDate' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'Eventuale data di espulsione', 'precision' => null],
        'bannerId' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'ID utente (admin o owner o sysadm) che bannato utente', 'precision' => null, 'autoIncrement' => null],
        'banReason' => ['type' => 'string', 'length' => 250, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'motivo espulsione', 'precision' => null, 'fixed' => null],
        'note' => ['type' => 'text', 'length' => 16777215, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'eventuali note', 'precision' => null],
        '_indexes' => [
            'project_members' => ['type' => 'index', 'columns' => ['memberType', 'memberId', 'projectId'], 'length' => []],
            'fk_project_member_user1_idx' => ['type' => 'index', 'columns' => ['sponsorId'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['projectId', 'memberType', 'memberId'], 'length' => []],
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
                'memberType' => 'aab1bc6d-6ed5-4bdf-9b09-52c44d674ec6',
                'memberId' => 1,
                'accessLevel' => 1,
                'joinDate' => 1564591405,
                'sponsorId' => 1,
                'isInvitation' => 1,
                'invitationDate' => 1564591405,
                'isMembershipRequest' => 1,
                'membershipRequestDate' => 1564591405,
                'isBanned' => 1,
                'banDate' => 1564591405,
                'bannerId' => 1,
                'banReason' => 'Lorem ipsum dolor sit amet',
                'note' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
            ],
        ];
        parent::init();
    }
}
