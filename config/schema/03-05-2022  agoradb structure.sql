-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2022 at 09:58 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agoradb`
--

-- --------------------------------------------------------

--
-- Table structure for table `additionaldatausers`
--

CREATE TABLE `additionaldatausers` (
  `user_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `member_role` bigint(20) NOT NULL,
  `vat_code` varchar(255) DEFAULT NULL,
  `tax_code` varchar(255) DEFAULT NULL,
  `employee_contract_type` varchar(255) DEFAULT NULL,
  `contract_filepath` varchar(255) DEFAULT NULL,
  `contract_filename` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` bigint(20) NOT NULL COMMENT 'ID indirizzo sede - Autoinc',
  `anagId` bigint(20) NOT NULL COMMENT 'ID anagrafica a cui indirizzo si riferisce',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag indirizzo cancellato',
  `name1` varchar(100) NOT NULL COMMENT 'Ragione Sociale o Cognome e Nome - per Sede Legale è UGUALE a quello in Anagrafica',
  `name2` varchar(100) DEFAULT NULL COMMENT 'Ragione Sociale riga 2 - se necessaria',
  `address1` varchar(70) NOT NULL COMMENT 'Indirizzo - riga 1',
  `address2` varchar(70) DEFAULT NULL COMMENT 'Indirizzo - riga supplementare se necessaria (es. per località)',
  `city` varchar(70) NOT NULL COMMENT 'citta o comune',
  `zip` varchar(15) NOT NULL COMMENT 'CAP (10 char per supportare la codifica di tutti gli stati europei) - in alcune nazioni può essere lungo anche 15 char',
  `province` varchar(45) DEFAULT NULL COMMENT 'Provincia (in alcuni stati non è richiesta, a volte è richiesta per esteso)',
  `countryId` char(2) NOT NULL COMMENT 'ID countri (ISO 3166-1)',
  `isRegisteredOffice` tinyint(1) DEFAULT 0 COMMENT 'Flag Sede Legale - DEVE esserci sempre e deve essere SOLO UNA per ogni anagrafica - per i privati è la residenza - per le scuole è la sede della direzione',
  `isBillingAddress` tinyint(1) DEFAULT 0 COMMENT 'Falg indirizzo di Fatturazione - ci possono essere più sedi di fatturazione - di solito coincide con la sede legale',
  `isAdministrativeHeadquarters` tinyint(1) DEFAULT 0 COMMENT 'Flag sede amministrativa - destinazione di default per invio fatture e documenti amministrativi',
  `isDeliveryAddress` tinyint(1) DEFAULT 0 COMMENT 'Flag indirizzo di Spedizione - ci possono essere più indirizzi di spedizione',
  `isOperationalSeat` tinyint(1) DEFAULT 0 COMMENT 'Flag sede Operativa',
  `tel` varchar(45) DEFAULT NULL COMMENT 'telefono della sede',
  `fax` varchar(45) DEFAULT NULL COMMENT 'fax della sede',
  `email` varchar(80) DEFAULT NULL COMMENT 'email generica della sede (se diversa da quella in anagrafica)',
  `pec` varchar(255) DEFAULT NULL,
  `sdi` varchar(255) DEFAULT NULL,
  `skype` varchar(80) DEFAULT NULL COMMENT 'indirizzo skype della sede (es. per videoconferenze in sala runioni)',
  `isObsolete` tinyint(1) DEFAULT 0 COMMENT 'Flag indirizzo obsoleto (da non usare più)',
  `note` mediumtext DEFAULT NULL COMMENT 'Note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Indirizzi di una anagrafica - permette di gestire più indirizzi per la stessa anagrafica - sede legale (obbligatoria e solo una, indirizzi di fatturazione, sedi amministrative, sedi operative e sedi di destinazione merce';

-- --------------------------------------------------------

--
-- Table structure for table `address_contact`
--

CREATE TABLE `address_contact` (
  `addressId` bigint(20) NOT NULL COMMENT 'ID indirizzo sede',
  `contactId` bigint(20) NOT NULL COMMENT 'ID contatto',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'flag record cancellato',
  `note` mediumtext DEFAULT NULL COMMENT 'note eventuali'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contatti della sede - permette anche di associare più sedi allo stesso contatto';

-- --------------------------------------------------------

--
-- Table structure for table `anagraphic`
--

CREATE TABLE `anagraphic` (
  `id` bigint(20) NOT NULL COMMENT 'ID anagrafica - Autoinc',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag record cancellato (=TRUE), default False = non cancellato',
  `name1` varchar(100) NOT NULL COMMENT 'Regione Sociale 1 o Cognome (se Privato - persona fisica senza partita IVA)',
  `name2` varchar(100) DEFAULT NULL COMMENT 'Regione Sociale 2 o Nome se Privato (persona fisica senza partita IVA) - obbligatorio se Privato',
  `codFiscale` varchar(16) DEFAULT NULL COMMENT 'Codice Fiscale - obbligatorio se cliente o fornitore, e privato',
  `pIva` varchar(16) DEFAULT NULL COMMENT 'Partita IVA - obbligatorio se cliente o fornitore, e azienda',
  `isPhysicalPerson` tinyint(1) DEFAULT 0 COMMENT 'Flag Persona Fisica - indica se azienda è una societa (=TRUE) oppure una persona (=FALSE)',
  `isPrivateCitizen` tinyint(1) DEFAULT 0 COMMENT 'Flag Privato Cittadino - indica se si tratta di Privato che ha solo il codice fiscale (=TRUE) oppure no',
  `isSchool` tinyint(1) DEFAULT 0 COMMENT 'Flag Scuola o Ente NON scolastico(azienda/privato) - TRUE = Scuola\nPer gli enti non scolastici non sono previsti Livello e/o Tipo scuola, Corsi, Materie',
  `specialType` char(3) DEFAULT NULL COMMENT 'eventuale classificazione Tipo speciale - usato per record di anagrafica che non sono clienti e non sono fornitori come ad esempio i corrieri. Previsto per raggruppare i record dello stesso tipo.',
  `sex` char(1) DEFAULT NULL COMMENT 'Sesso (M=maschio, F=femmina) per privati che hanno codice fiscale - serve a verificare il codice fiscale in Italiano - default NULL',
  `birthDate` date DEFAULT NULL COMMENT 'Data di Nascita - per privati che hanno codice fiscale - serve a verificare il codice fiscale in Italiano - default NULL',
  `birthPlace` varchar(70) DEFAULT NULL COMMENT 'Luogo di Nascita (Comune se in Italia) NON usare se nato fuori Italia (estero) - serve a verificare il codice fiscale in Italiano - default NULL',
  `birthProvince` char(2) DEFAULT NULL COMMENT 'Sigla Provincia di Nascita (usare sigla provincia per Italia, EE per stato estero) - serve a verificare il codice fiscale in Italiano - default NULL',
  `birthCountry` char(2) DEFAULT NULL COMMENT 'Nazione di Nascita - per privati che hanno codice fiscale - serve a verificare il codice fiscale in Italiano - default NULL',
  `isPIvaVerified` tinyint(1) DEFAULT 0 COMMENT 'Flag Partita IVA verificata - TRUE = verificata, FALSE = da verificare',
  `isNonResidentCF` tinyint(1) DEFAULT 0 COMMENT 'Flag Codice Fiscale per stranieri - TRUE = straniero, FALSE = nato in italia',
  `pec` varchar(100) DEFAULT NULL COMMENT 'email certificata (PEC) della società o persona',
  `ftp` varchar(100) DEFAULT NULL COMMENT 'sito ftp della società o persona',
  `web` varchar(100) DEFAULT NULL COMMENT 'sito internet della società o persona',
  `isAuthPersonalData` tinyint(1) DEFAULT 0 COMMENT 'Flag Autorizzazione al trattamento dei dati personali - TRUE = Autorizza, FALSE = NON autorizza',
  `fatherId` bigint(20) DEFAULT NULL COMMENT 'Identifica eventuale dipendenza da altra anagrafica - ad esempio un dipartimento che dipende da universita, ma entrambe le anagrafiche possono essere autonome e indipendenti',
  `langId` char(2) NOT NULL COMMENT 'ID lingua da usare per comunicazioni',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Anagrafica generale - contiene i dati fiscali di clienti, fornitori, corrieri. NON contiene i contatti\nID ZERO = Piattaforma';

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) NOT NULL,
  `company_id` bigint(20) DEFAULT NULL,
  `candidate_id` bigint(11) NOT NULL,
  `companymember_id` bigint(11) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `title` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` bigint(20) NOT NULL COMMENT 'ID articolo = ID oggetto (Book, Subscription, eCourse)',
  `type` char(1) NOT NULL COMMENT 'tipo articolo - B = Book, C = eCourse, S = Subscription, A = altro (default)',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'flag articolo cancellato',
  `name` varchar(70) NOT NULL COMMENT 'Nome / descrizione breve articolo',
  `description` varchar(250) DEFAULT NULL COMMENT 'descrizione lunga',
  `isVirtualQty` tinyint(1) DEFAULT 0 COMMENT 'Flag quantità virtuale (non richiede gestione della giacenza) - TRUE = qta virtuale (es. crediti, GB, multi licenze), FALSE = qta reale (es. licenze eBook)',
  `isObsolete` tinyint(1) DEFAULT 0 COMMENT 'Flag articolo obsoleto (non utilizzabile nelle transazioni) - FALSE (default) = articolo utilizzabile da cliente, TRUE = obsoleto',
  `um` char(3) NOT NULL COMMENT 'codice unita di misura articolo',
  `umPack` char(3) DEFAULT NULL COMMENT 'codice unita di misura confezione/pacchetto',
  `packQty` int(11) DEFAULT 0 COMMENT 'quantita articolo in confezione, se 1+ è confezione e deve avere UM-Pack - ZERO (default) = non è confezione, e UM-Pack può essere NULL',
  `singleArticleId` bigint(20) DEFAULT NULL COMMENT 'ID Articolo nel Pack',
  `grp` char(5) DEFAULT NULL COMMENT 'Eventuale gruppo articoli - permette di creare gruppi di articoli per eventuali future necessita statistiche o di selezione per listini prezzi',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note articolo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Articoli - contiene tutti gli oggetti che possono essere venduti e acquistati\n';

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id` bigint(20) NOT NULL COMMENT 'id autore',
  `firstname` varchar(70) NOT NULL,
  `lastname` varchar(70) NOT NULL,
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag autore cancellato',
  `birthdate` varchar(50) DEFAULT NULL COMMENT 'Data di nascita - Data completa o solo Anno\nformato previsto AAAA/MM/GG oppure AAAA',
  `birthPlace` varchar(200) DEFAULT NULL COMMENT 'Luogo di Nascita',
  `deathDate` varchar(50) DEFAULT NULL COMMENT 'Data di morte o solo Anno\nformato previsto AAAA/MM/GG oppure AAAA',
  `deathPlace` varchar(200) DEFAULT NULL COMMENT 'Luogo di Morte',
  `bibliography` longtext DEFAULT NULL COMMENT 'Eventuale bibliografia autore - senza link con tabella book',
  `note` mediumtext DEFAULT NULL COMMENT 'note autore'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='elenco Autori dei Libri - contiene anche gli utenti autori che hanno pubblicato qualcosa solo sulla piattaforma\nContiene info autore es. data di nascita, di morte, nazionalità, note bibliografiche, altro';

-- --------------------------------------------------------

--
-- Table structure for table `author_external_link`
--

CREATE TABLE `author_external_link` (
  `id` bigint(20) NOT NULL COMMENT 'ID link info autore',
  `authorId` bigint(20) NOT NULL COMMENT 'id autore a cui è riferito il link',
  `text` varchar(250) NOT NULL COMMENT 'Testo da visualizzare per il link (URL) di informazioni supplementari su un sito esterno, ad esempio quello di enciclopedia TRECCANI',
  `url` varchar(255) NOT NULL COMMENT 'link (URL) di informazioni supplementari su un sito esterno, ad esempio quello di enciclopedia TRECCANI',
  `countryId` char(2) DEFAULT NULL COMMENT 'id country del link - se NULL link applicabile a + country'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='link esterni a info autore che possono essere differenti per ogni country\n\nes in Italia usare link a TRECCANI, in Francia un link differente\npermette + link per ogni autore\n';

-- --------------------------------------------------------

--
-- Table structure for table `author_favourite`
--

CREATE TABLE `author_favourite` (
  `userId` bigint(20) NOT NULL,
  `authorId` bigint(20) NOT NULL,
  `isFavourite` tinyint(1) NOT NULL DEFAULT 1,
  `createDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `lastUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `author_info_lang`
--

CREATE TABLE `author_info_lang` (
  `authorId` bigint(20) NOT NULL COMMENT 'ID Autore',
  `langId` char(2) NOT NULL,
  `biography` longtext NOT NULL COMMENT 'testo biografia',
  `info1` longtext DEFAULT NULL,
  `info2` longtext DEFAULT NULL,
  `info3` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Informazioni autore in lingua';

-- --------------------------------------------------------

--
-- Table structure for table `author_profession`
--

CREATE TABLE `author_profession` (
  `authorId` bigint(20) NOT NULL COMMENT 'id autore',
  `professionId` int(11) NOT NULL COMMENT 'id professione',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note sulla professione autore'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='elenco professioni per ogni autore';

-- --------------------------------------------------------

--
-- Table structure for table `awaiting_registration`
--

CREATE TABLE `awaiting_registration` (
  `email` char(100) NOT NULL COMMENT 'email (pk)',
  `lastname` varchar(100) NOT NULL COMMENT 'cognome o ragione sociale azienda/scuola (obbligatorio)',
  `firstname` varchar(100) DEFAULT NULL COMMENT 'nome o ragione sociale 2 (opzionale se azienda/scuola))',
  `username` varchar(70) NOT NULL COMMENT 'username',
  `passwd` varchar(245) NOT NULL COMMENT 'password',
  `nickname` varchar(70) NOT NULL COMMENT 'nickname (se non fornito settare = username)',
  `birthdate` date DEFAULT NULL COMMENT 'data di nascita (NULL per aziende/scuole)',
  `gender` char(1) NOT NULL DEFAULT 'O',
  `userLocaleCode` varchar(10) DEFAULT NULL COMMENT 'Codice di Localizzazione - Lingua [+ country [+ variante] ]\nes. it, en, it_IT, fr_FR, de_DE',
  `isOrganization` tinyint(1) DEFAULT 0 COMMENT 'Flag persona fisica = FALSE, o istituto/azienda = TRUE',
  `guestRegistrationDate` timestamp NULL DEFAULT current_timestamp() COMMENT 'Timestamp di richiesta registrazione',
  `isValidationMailSent` tinyint(1) DEFAULT 0 COMMENT 'Flag - mail di conferma registrazione inviata = TRUE, non ancora inviata = FALSE',
  `validationMailDate` timestamp NULL DEFAULT NULL COMMENT 'Data di invio mail di conferma registrazione utente',
  `validationTag` varchar(100) NOT NULL COMMENT 'Tag di validazione utente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='elenco utenti in attesa di conferma registrazione\n\nLa registrazione richiede:\n- nome o ragione sociale\n- cognome o ragione sociale 2 - opzionale\n- flag persona fisica/Azienda\n- email\n- password\n- username\n- nickname\n';

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `id` int(11) NOT NULL COMMENT 'ID banca',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag record Cancellato - default FALSE',
  `abiCode` char(5) NOT NULL COMMENT 'Codice ABI (Associazione Bancaria Italiana - codice banca)',
  `cabCode` char(5) NOT NULL COMMENT 'Codice CAB (Codice di Avviamento Bancario - codice Agenzia)',
  `description` varchar(70) NOT NULL COMMENT 'Descrizione Banca-Agenzia',
  `location` varchar(70) DEFAULT NULL COMMENT 'eventuale località agenzia',
  `bicCode` varchar(15) DEFAULT NULL COMMENT 'Codice BIC (Business Identifier Code) aka SWIFT - Necessario per transazioni internazionali'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Anagrafica Banche di Clienti e Fornitori';

-- --------------------------------------------------------

--
-- Table structure for table `banned_ip`
--

CREATE TABLE `banned_ip` (
  `ip` char(40) NOT NULL COMMENT 'ip address (contiene stringhe di indirizzi IPv4 di 15 char e IPv6 di 39 char)',
  `banTime` timestamp NULL DEFAULT current_timestamp() COMMENT 'Data/ora del blocco ip',
  `isBanned` tinyint(1) DEFAULT 1 COMMENT 'Flag indirizzo vietato\n- TRUE = vietato (default)\n- FALSE = non vientato (settato ad eventuale release del blocco',
  `releaseTime` timestamp NULL DEFAULT NULL COMMENT 'timestamp del momento in cui viene riammesso ip bannato',
  `ip4` varchar(45) DEFAULT NULL COMMENT 'Indirizzo esteso espresso come IPv4 (se possibile) (nel formato nnn.nnn.nnn.nnn)',
  `ip6` varchar(45) DEFAULT NULL COMMENT 'Indirizzo esteso espresso come IPv6 (nel format xxxx:xxxx:xxxx:xxxx:xxxx:xxxx:xxxx:xxxx)',
  `note` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl indirizzi IP vietati\nGli ip bannato possono poi essere sbloccati, anche senza cancellare il record';

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` bigint(20) NOT NULL COMMENT 'ID libro/eBook (= ID article)',
  `isbn` varchar(13) DEFAULT NULL COMMENT 'code ISBN (13 char) -  NULL se libro/lavoro messo a disposizione per uso esclusivo della Piattaforma, VALORIZZATO se libro commerciabile',
  `issueNumber` varchar(5) DEFAULT NULL COMMENT 'numero edizione (da 2 a 5 char) - usato per riviste e periodici',
  `isDeleted` tinyint(1) DEFAULT 0,
  `title` varchar(70) NOT NULL COMMENT 'Titolo breve (per visualizzazione info generali) - titolo lungo in tbl book_info_lang',
  `author` varchar(70) NOT NULL COMMENT 'autori libro (per visualizzazione info generali)',
  `langId` char(2) NOT NULL COMMENT 'Id lingua in cui è scritto il libro',
  `isPrintedBook` tinyint(1) DEFAULT 0 COMMENT 'Flag Libro Stampato o formato Elettronico - FALSE = eBook, TRUE = Stampato (tradizionale)',
  `brandId` int(11) NOT NULL COMMENT 'Id marchio (es. Penguin, Paravia, Mondadori) - aka Casa Editrice/Editore',
  `categoryId` int(11) DEFAULT NULL COMMENT 'id categoria',
  `editionYear` int(11) DEFAULT NULL COMMENT 'Anno Edizione',
  `editionPlace` varchar(70) DEFAULT NULL,
  `editionNumber` tinyint(3) NOT NULL COMMENT 'numero Edizione',
  `volNum` char(1) DEFAULT 'U' COMMENT 'numero del volume - U = volume Unico, 1 = primo anno, 2 = secondo anno, 3 = terzo anno',
  `destinationId` char(2) DEFAULT NULL COMMENT 'ID destinazione (es. Varia, Scuola Secondaria 2 grado biennio, Secondaria 2 grado triennio, universita, ecc)',
  `bookGenderId` int(11) DEFAULT NULL COMMENT 'Id Genere del Libro',
  `isPublished` tinyint(1) DEFAULT 0 COMMENT 'Flag libro pubblicato = disponibile al pubblico generico, TRUE = disponibile a tutti, FALSE (default) = disponibile solo per uso interno (ente o proprietario)',
  `publisherUrl` varchar(255) DEFAULT NULL COMMENT 'eventuale link (URL) alla pagina del libro sul sito web editore',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note libro',
  `numPages` smallint(5) DEFAULT 0 COMMENT 'numero totale di pagine - per calcolare la percentuale delle pagine lette',
  `matterAreaId` int(11) DEFAULT NULL COMMENT 'ID area materia',
  `isSalable` tinyint(1) DEFAULT 1 COMMENT 'Flag Libro vendibile - TRUE (default) = vendibile, FALSE = NON vendibile\n(non vendibile se eliminato dal listino editore)',
  `catalogStatus` char(2) DEFAULT 'CT' COMMENT 'Stato libro nel Catalogo Editore\nZZ = non presente nel catalogo editore/cancellato da editore ==> NON vendibile\nFC = Fuori Catalogo\nCT = a Catalogo (default)\nNN = Novità di catalogo',
  `lastEditorUpdate` timestamp NULL DEFAULT NULL COMMENT 'Timestamp ultimo aggiornamento da Editore (es da carico listino editore)',
  `lastUpdate` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Timestamp ultimo aggiornamento record',
  `isBibliography` tinyint(1) DEFAULT 0 COMMENT 'Flag per identificare libri aggiunti solo come riferimento per Bibliografie di corsi di eLearning\nLibro non esistente nella piattaforma, che però può essere completato o acquistato successivamente (con reset del flag)\nse TRUE = libro inserito solo per riferimento della bibliografia\nse FALSE = libro normale\nSolo la piattaforma può cambiare il flag quando acquista il libro',
  `loaderId` bigint(20) DEFAULT NULL COMMENT 'ID del loader (utente / sistema / algoritmo) che ha caricato i dati del libro in tbl',
  `isVerified` tinyint(1) DEFAULT 0 COMMENT 'Flag libro caricato verificato - TRUE = verificato, FALSE (default) = da verificare\ni libri NON verificati sono visibili solo da parte del loader, se è un utente',
  `isSystemLoader` tinyint(1) DEFAULT 0 COMMENT 'Flag per identiface il caricamento fatto da systema (con algoritmo o utente tipo operatore) - TRUE = da systema, FALSE (default) = da utente generico',
  `isXCond` tinyint(1) DEFAULT 0 COMMENT 'Flag per usi futuri',
  `xString` varchar(45) DEFAULT NULL COMMENT 'per usi futuri',
  `xInt` int(11) DEFAULT NULL COMMENT 'extra int - usi futuri',
  `xDateTime` datetime DEFAULT NULL COMMENT 'extra Date Time - usi futuri'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='elenco libri pubblicati dagli editori o da utenti Autori della piattaforma\n\nContiene libri novita, a catalogo, fuori catalogo + libri vecchi non vendibili di cui la piattaforma possiede la licenza\ne libri di proprieta degli utenti sia comprati dalla piattaforma sia caricati con upload.\nQuando acquisto un libro duplicare il record e assegnare il nuovo record al nuovo proprietario - ci possono essere piu libri con stesso ISBN di propreta di vari utenti/anagrafiche.\n\n';

-- --------------------------------------------------------

--
-- Table structure for table `book_author`
--

CREATE TABLE `book_author` (
  `bookId` bigint(20) NOT NULL COMMENT 'id libro',
  `authorId` bigint(20) NOT NULL COMMENT 'id autore',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note su autore relative al libro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Autori per ogni libro';

-- --------------------------------------------------------

--
-- Table structure for table `book_code`
--

CREATE TABLE `book_code` (
  `bookId` bigint(20) NOT NULL COMMENT 'id Libro/pubblicazione',
  `codeType` varchar(45) NOT NULL COMMENT 'tipo di codice del libro\nes. \nISSN\nISSN-L\nDOI\nONIX\nASIN',
  `codeValue` varchar(45) NOT NULL COMMENT 'valore del tipo di codice',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Codici supplementari per codifica libri\nstruttura come dizionario\nChiave (type) / Valore (code)';

-- --------------------------------------------------------

--
-- Table structure for table `book_cover`
--

CREATE TABLE `book_cover` (
  `bookId` bigint(20) NOT NULL COMMENT 'ID libro / pubblicazione',
  `originalFileName` varchar(255) NOT NULL COMMENT 'Nome originale del file della copertina',
  `storeFileName` varchar(255) DEFAULT NULL COMMENT 'Nome ridefinito della cover image per il salvataggio in area di store\n- si consiglia uso di id come nome file',
  `storePath` varchar(255) DEFAULT NULL COMMENT 'path area di store dove è memorizzata la cover (con nome ridefinito)',
  `storeServerName` varchar(255) DEFAULT NULL COMMENT 'Nome del server dove risiede la store area in cui è memorizzata la cover',
  `storeServerIp` varchar(45) DEFAULT NULL COMMENT 'indirizzo IP del server dove risiede la store area in cui è memorizzata la cover',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note',
  `lastUpdate` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Timestamp ultimo aggiornamento record',
  `checksumId` char(10) DEFAULT NULL COMMENT 'ID algoritmo di checksum utilizzato (NULL = checksum non utilizzato)',
  `checksumString` varchar(255) DEFAULT NULL COMMENT 'checksum del file secondo agoritmo usato (NULL = no checksum used)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Copertine di libri / pubblicazioni\nOgni edizione di un libro ha una sola copertina, Edizioni diverse hanno anche isbn diverso.';

-- --------------------------------------------------------

--
-- Table structure for table `book_extra_selection`
--

CREATE TABLE `book_extra_selection` (
  `bookId` bigint(20) NOT NULL COMMENT 'ID libro',
  `ssdAreaId` int(11) DEFAULT NULL COMMENT 'eventuale ID area SSD - se è relativo ad una specifica area SSD',
  `ssdId` int(11) DEFAULT NULL COMMENT 'eventuale ID settore Scentifico-Didattico - se è relativo ad un SSD specifico',
  `teachingAreaId` bigint(20) DEFAULT NULL COMMENT 'eventuale ID Area di insegnamento (facolta per universita, indirizzo per SS2) - se è relativo ad una facoltà/indirizzo specifico\n',
  `schoolLevelId` char(3) DEFAULT NULL COMMENT 'eventuale ID livello di scuola - se è relativo ad uno specifico livello di scuola (es Scuola Primaria, Secondaria di grado 1, ecc)',
  `schoolTypeId` int(11) DEFAULT NULL COMMENT 'eventuale ID Tipo di scuola (per country) - se è relativo ad un tipo di scuola specifico'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Informazioni di classificazione extra per selezionare i libri con vari algoritmi';

-- --------------------------------------------------------

--
-- Table structure for table `book_file`
--

CREATE TABLE `book_file` (
  `bookId` bigint(20) NOT NULL COMMENT 'ID eBook',
  `seq` int(11) NOT NULL DEFAULT 0 COMMENT 'Numero di versione del file - parte da ZERO (default)',
  `feature` varchar(245) DEFAULT NULL COMMENT 'Eventuali Caratteristiche file PDF (versione, utente proprietario, o altro)',
  `originalFileName` varchar(255) DEFAULT NULL COMMENT 'Nome originale del file eBook',
  `fileType` varchar(5) DEFAULT NULL COMMENT 'Tipo di file - es. PDF, EPUB, MOBI, ecc - USO FUTURO',
  `storeFileName` varchar(255) DEFAULT NULL COMMENT 'Nome ridefinito del file per il salvataggio in area di store',
  `storePath` varchar(255) DEFAULT NULL COMMENT 'Path area di store dove è memorizzato il file con nome ridefinito',
  `storeServerName` varchar(255) DEFAULT NULL COMMENT 'Nome del server dove risiede la store area in cui è memorizzato il file eBook',
  `storeServerIp` varchar(255) DEFAULT NULL COMMENT 'Indirizzo ip del server dove risiede la store area in cui è memorizzato il file eBook - in alternativa a storeServerName',
  `isMissed` tinyint(1) DEFAULT 0 COMMENT 'Flag file non disponibile (default FALSE)',
  `storeFileSize` int(11) DEFAULT -1 COMMENT 'dimensione in byte del file nella store area (-1 se dimensione non valorizzata)',
  `storeFileDateTime` datetime DEFAULT NULL COMMENT 'Data e Ora del file memorizzato nella store area',
  `checksumId` char(10) DEFAULT NULL COMMENT 'ID algoritmo di Checksum utilizzato (NULL = Nessum checksum usato)',
  `checksumString` varchar(255) DEFAULT NULL COMMENT 'Checksum del file secondo algortimo usato (NULL = no checksum used)',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note',
  `isXCond` tinyint(1) DEFAULT 0 COMMENT 'flag - uso futuro',
  `xInt` int(11) DEFAULT NULL COMMENT 'Int - uso futuro',
  `xString` varchar(255) DEFAULT NULL COMMENT 'Stranga - uso futuro',
  `xDateTime` datetime DEFAULT NULL COMMENT 'xDateTime - uso futuro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='file fisico eBook. ';

-- --------------------------------------------------------

--
-- Table structure for table `book_gender`
--

CREATE TABLE `book_gender` (
  `id` int(11) NOT NULL COMMENT 'ID genere',
  `superCode` char(252) DEFAULT NULL COMMENT 'codice genere superiore = [ superCode padre + / + ] ID in formato stringa (IDX con Duplicati VIETATI) max 12 livelli',
  `note` mediumtext DEFAULT NULL COMMENT 'note',
  `fatherId` int(11) DEFAULT NULL COMMENT 'eventuale ID genere padre',
  `level` int(11) DEFAULT 0 COMMENT 'Livello per gestire visualizzazioni con incolonnamento differente per livello\nDefault = 0 (Livello iniziale - NON ha padre/previous)\nOgni item che ha padre/previous setta level = padre.level + 1',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'flag Genere cancellato'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='elenco generi dei libri\n\nStruttura ad albero per gestire anche sottogeneri di livello N (Max 12 livelli)';

-- --------------------------------------------------------

--
-- Table structure for table `book_gender_lang`
--

CREATE TABLE `book_gender_lang` (
  `id` int(11) NOT NULL COMMENT 'id genere libro',
  `langId` char(2) NOT NULL COMMENT 'id lingua',
  `name` varchar(100) NOT NULL COMMENT 'nome genere in lingua',
  `description` varchar(245) DEFAULT NULL COMMENT 'descrizione'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='nomi dei generi dei libri in lingua\n';

-- --------------------------------------------------------

--
-- Table structure for table `book_info_lang`
--

CREATE TABLE `book_info_lang` (
  `bookId` bigint(20) NOT NULL COMMENT 'id book (id interno)',
  `langId` char(2) NOT NULL COMMENT 'id lingua',
  `title` varchar(250) DEFAULT NULL COMMENT 'titolo lungo (se titolo breve diverso/contratto)',
  `subtitle` varchar(250) DEFAULT NULL COMMENT 'sottotitolo - eventuale',
  `collection` varchar(250) DEFAULT NULL COMMENT 'collana - eventuale',
  `serie` varchar(250) DEFAULT NULL COMMENT 'serie - se il libro appartiene ad una serie',
  `summary` longtext DEFAULT NULL COMMENT 'sommario',
  `note1` longtext DEFAULT NULL,
  `note2` longtext DEFAULT NULL,
  `note3` longtext DEFAULT NULL,
  `note4` longtext DEFAULT NULL,
  `note5` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='book Extra info in lingua';

-- --------------------------------------------------------

--
-- Table structure for table `book_liked_viewed`
--

CREATE TABLE `book_liked_viewed` (
  `bookId` bigint(20) NOT NULL,
  `userId` bigint(20) NOT NULL,
  `liked` tinyint(1) DEFAULT NULL,
  `view` tinyint(1) DEFAULT NULL,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `book_rating`
--

CREATE TABLE `book_rating` (
  `bookId` bigint(20) NOT NULL COMMENT 'ID libro',
  `userId` bigint(20) NOT NULL COMMENT 'ID utente',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag record cancellato',
  `rating` int(11) DEFAULT 0 COMMENT 'rating del libro (es. 0 = min, 5 = max)',
  `createDate` timestamp NULL DEFAULT current_timestamp() COMMENT 'data di rating del libro',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note o spiegazione del rating assegnato'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='valutazione libri con indicatore numerico (tipo stelline)';

-- --------------------------------------------------------

--
-- Table structure for table `book_review`
--

CREATE TABLE `book_review` (
  `bookId` bigint(20) NOT NULL COMMENT 'ID book',
  `userId` bigint(20) NOT NULL COMMENT 'ID user',
  `createDate` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Data/ora di creazione recensione',
  `langId` char(2) NOT NULL COMMENT 'ID lingua della recensione - da tbl Language - usare Lingua del Locale come proposta',
  `text` longtext NOT NULL COMMENT 'Testo Recensione - Mandatory',
  `isPublished` tinyint(1) DEFAULT 0 COMMENT 'Flag recensione Pubblicata/in Bozza - TRUE = pubblicata, FALSE = in Bozza',
  `publishDate` datetime DEFAULT NULL COMMENT 'timestamp ultimo aggiornamento recensione',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag Recensioen cancellata - TRUE = cancellata, FALSE = attiva (default)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Recensioni sui libri/pubblicazioni - Possibile solo UNA singola recensione per ogni utente';

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL COMMENT 'id marchio',
  `publisherId` int(11) NOT NULL COMMENT 'Id editore che possiede il marchio',
  `code` char(10) DEFAULT NULL COMMENT 'codice marchio usato da editore',
  `name` varchar(70) NOT NULL COMMENT 'nome marchio',
  `webSite` varchar(250) DEFAULT NULL COMMENT 'indirizzo (URL) del sito web del marchio',
  `note` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Marchi di ogni editore - esempio: editore Pearson, marchio Paramond, marchio Addison-Wesley';

-- --------------------------------------------------------

--
-- Table structure for table `campaign`
--

CREATE TABLE `campaign` (
  `id` bigint(20) NOT NULL COMMENT 'ID campagna',
  `name` varchar(200) NOT NULL COMMENT 'nome campagna di marketing',
  `description` mediumtext DEFAULT NULL COMMENT 'Descrizione campagna',
  `startDate` date DEFAULT NULL COMMENT 'Data iniziale (primo giorno valido) della campagna marketing',
  `endDate` date DEFAULT NULL COMMENT 'Data finale (ultimo giorno valido) della campagna marketing',
  `createDate` timestamp NULL DEFAULT current_timestamp() COMMENT 'Timestamp di creazione della campagna',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag campagna cancellata',
  `isPublished` tinyint(1) DEFAULT 0 COMMENT 'Flag campagna pubblicata - campagna approvata ',
  `publishDate` timestamp NULL DEFAULT NULL COMMENT 'Data di pubblicazione con orario (timestamp)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TODO\n\n\nDEFINIRE TABELLA\n\ncampagne di marketing (sconti / offerte / promozioni)';

-- --------------------------------------------------------

--
-- Table structure for table `campaign_target`
--

CREATE TABLE `campaign_target` (
  `campaignId` bigint(20) NOT NULL COMMENT 'id campagna',
  `itemKey` varchar(70) NOT NULL COMMENT 'target property key',
  `itemValue` varchar(250) NOT NULL COMMENT 'target property value',
  `description` tinytext DEFAULT NULL COMMENT 'descrizione target campagna'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Target della campagna - possono essere più di uno\nesempio:\nLibri,\ncategorie,\ncorsi eLearning\n';

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL COMMENT 'id categoria',
  `superCode` char(252) DEFAULT NULL COMMENT 'codice gruppo superiore = [ superCode padre + / + ] ID in formato stringa (IDX con Duplicati VIETATI) max 12 livelli',
  `note` mediumtext DEFAULT NULL,
  `fatherId` int(11) DEFAULT NULL COMMENT 'eventuale ID Categoria padre',
  `level` int(11) DEFAULT 0 COMMENT 'Livello per gestire visualizzazioni con incolonnamento differente per livello\nDefault = 0 (Livello iniziale - NON ha padre/previous)\nOgni item che ha padre/previous setta level = padre.level + 1',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag Categoria cancellata'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Categorie dei libri\n\nStruttura ad albero per gestire anche sottocategorie di livello N';

-- --------------------------------------------------------

--
-- Table structure for table `category_lang`
--

CREATE TABLE `category_lang` (
  `id` int(11) NOT NULL COMMENT 'ID categoria',
  `langId` char(2) NOT NULL COMMENT 'id lingua',
  `name` varchar(150) NOT NULL COMMENT 'nome categoria in lingua',
  `description` varchar(245) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='nomi categorie in lingua';

-- --------------------------------------------------------

--
-- Table structure for table `chatcontacts`
--

CREATE TABLE `chatcontacts` (
  `id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `touser_id` bigint(20) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `fromuser_id` bigint(20) NOT NULL,
  `status` char(1) DEFAULT 'A',
  `lastseen` datetime DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `chatfiles`
--

CREATE TABLE `chatfiles` (
  `id` bigint(20) NOT NULL,
  `chat_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `touser_id` bigint(20) NOT NULL,
  `filename` varchar(250) DEFAULT NULL,
  `filepath` varchar(250) DEFAULT NULL,
  `type` varchar(250) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `chatgroups`
--

CREATE TABLE `chatgroups` (
  `id` bigint(20) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `group_id` bigint(20) DEFAULT NULL,
  `creator` bigint(20) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `groupimagepath` varchar(250) DEFAULT NULL,
  `groupimagename` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `chatgroupsusers`
--

CREATE TABLE `chatgroupsusers` (
  `id` bigint(20) NOT NULL,
  `group_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` bigint(20) NOT NULL,
  `parentchat_id` bigint(20) DEFAULT NULL,
  `chatgroup_id` bigint(20) DEFAULT NULL,
  `fromuser_id` bigint(20) NOT NULL,
  `touser_id` bigint(20) NOT NULL,
  `content` varchar(250) DEFAULT NULL,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `last_update` datetime DEFAULT NULL,
  `isSeen` tinyint(1) NOT NULL DEFAULT 0,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  `lastseen` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `checksum`
--

CREATE TABLE `checksum` (
  `id` char(10) NOT NULL COMMENT 'ID algoritmo del metodo di checksum\nes. CRC32, MD2, MD4, MD5, SHA1, SHA256, SHA384, SHA512',
  `description` varchar(250) DEFAULT NULL COMMENT 'descrizione del metodo di calcolo del checksum',
  `keySize` int(11) NOT NULL COMMENT 'lunghezza del checksum generato',
  `maxFileSize` bigint(20) DEFAULT 0 COMMENT 'dimensione massima del file per algoritmo di checksum - 0 = nessun limite',
  `isEnabled` tinyint(1) DEFAULT 0 COMMENT 'Flag Algoritmo Utilizzabile = TRUE, non utilizzabile = FALSE (default)',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag record cancellato'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Elenco algoritmi di checksum dei file';

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `region` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `province_code` char(2) DEFAULT NULL,
  `cadastral_code` char(4) DEFAULT NULL,
  `postcodes` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `countryId` char(2) NOT NULL,
  `regionId` int(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'id regione nella country - per Italia codice usare codice ISTAT',
  `provinceId` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID provincia nella country - per Italia codice usare codice ISTAT',
  `id` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'id comune nella provincia - per Italia codice usare codice ISTAT',
  `name` varchar(70) NOT NULL COMMENT 'nome comune/città',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag comune cessato (default FALSE)',
  `note` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Elenco Comuni (Città)';

-- --------------------------------------------------------

--
-- Table structure for table `clientsideemployees`
--

CREATE TABLE `clientsideemployees` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `work_type` char(4) DEFAULT NULL,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `accomodation_type` varchar(150) DEFAULT NULL,
  `accomodation_proof` varchar(250) DEFAULT NULL,
  `transportation_type` varchar(150) DEFAULT NULL,
  `transportation_proof` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `clifor`
--

CREATE TABLE `clifor` (
  `anagId` bigint(20) NOT NULL COMMENT 'ID anagrafica associata (PK con cliforType)',
  `cliforType` char(1) NOT NULL COMMENT 'Flag Tipo record - C = Cliente, F = Fornitore (PK con anagId)',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag record cancellato - default FALSE',
  `paymentId` char(6) DEFAULT NULL COMMENT 'Codice Pagamento - in Tbl Payment',
  `monthExcluded1` varchar(2) DEFAULT NULL COMMENT 'Primo Mese di esclusione pagamento - indicare il mese in cifre: 1=gennaio, ..., 12 = dicembre. Qualsiasi altro valore non esclude un mese',
  `monthExcluded2` varchar(2) DEFAULT NULL COMMENT 'Secondo Mese di esclusione pagamento - indicare il mese in cifre: 1=gennaio, ..., 12 = dicembre. Qualsiasi altro valore non esclude un mese',
  `nextDayOnExpiration` varchar(2) DEFAULT NULL COMMENT 'Giorno successivo per scadenza pagamento - indicare il giorno in cifre: 1, 2, ..., 28, 29, 30, 31. Qualsiasi altro valore non sposta la scadenza',
  `transportationId` char(2) DEFAULT NULL COMMENT 'Mezzo di trasporto - usare tabella codificata a programma, oppure aggiungere tbl mezzi di trasporto',
  `courierId` bigint(20) DEFAULT NULL COMMENT 'eventuale ID Corriere in anagrafica (usare ID anagrafica)',
  `chargesId` char(2) DEFAULT NULL COMMENT 'oneri di spedizione (porto assegnato = paga chi riceve, porto franco = paga chi spedisce) - usare tbl codificata a programma',
  `goodsAppearenceId` char(2) DEFAULT NULL COMMENT 'Aspetto esteriore dei beni - usare tabella codificata a programma, oppure aggiungere tbl aspetto esteriore dei beni',
  `vatCodeExempt` char(6) DEFAULT NULL COMMENT 'eventuale Codice IVA esente - link con tbl codici IVA (se Cliente è esente da IVA)',
  `authorizationNumber` varchar(8) DEFAULT NULL COMMENT 'Numero di autorizzazione per esenzione IVA (se Cliente è esente da IVA)',
  `authorizationDate` date DEFAULT NULL COMMENT 'Data autorizzazione per esenzione IVA (se Cliente è esente da IVA)',
  `vatExemptionProtocol` varchar(8) DEFAULT NULL COMMENT 'Protocollo di Esenzione IVA (se Cliente è esente da IVA)',
  `langId` char(2) NOT NULL COMMENT 'Codice lingua da usare per comunicazioni - prioritario rispetto a quello in anagrafica (default copiare quello in anagrafica)',
  `currencyCode` char(3) NOT NULL COMMENT 'Codice Valuta (ISO 4217) - default quello in tbl config',
  `priceListId` char(2) DEFAULT NULL COMMENT 'ID listino da usare - se previsto uso listini - default NULL = listino di default',
  `discount1` decimal(5,2) DEFAULT 0.00 COMMENT 'Sconto 1',
  `discount2` decimal(5,2) DEFAULT 0.00 COMMENT 'Sconto 2',
  `creditLimit` decimal(15,5) DEFAULT 0.00000 COMMENT 'ammontare del fido - per clienti cifra massima di acquisto permessa con pagamento differito - per fornitori fido concesso alla piattaforma',
  `supplierType` char(1) DEFAULT NULL COMMENT 'eventuale tipo di fornitore - uso futuro - eventuale link con tbl tipi fornitore',
  `isSuspendedOrder` tinyint(1) DEFAULT 0 COMMENT 'Flag per sospendere la possibilità di fare ordini (per eventuale motivazione usare campo note) - TRUE = sospeso',
  `companyBankId` int(11) NOT NULL COMMENT 'ID banca della piattaforma da usare per rapporti con clifor (include anche CC)',
  `currentAccountNumber` varchar(20) DEFAULT NULL COMMENT 'numero di conto corrente alternativo (della piattaforma) per rapporti con clifor',
  `companyABI` char(5) DEFAULT NULL COMMENT 'codice ABI alternativo (della piattaforma) per rapporti con clifor',
  `companyCAB` char(5) DEFAULT NULL COMMENT 'codice CAB alternativo (della piattaforma) per rapporti con clifor',
  `isPriority` tinyint(1) DEFAULT 0 COMMENT 'Flag per indicare la priorità di uso dei dati di CC, ABI, CAB indicati per il clifor, piuttosto che quelli indicati nel record di anagrafica banche azienda indicato dal CompanyBankId - TRUE = usa dati indicati, FALSE = usa dati in tbl company_bank',
  `bankId` int(11) DEFAULT NULL COMMENT 'ID banca del Cliente-Fornitore (FORSE non è sempre obbligatorio)',
  `iban` char(4) DEFAULT NULL COMMENT 'parte iniziale del codice IBAN (primi 4 caratteri)',
  `bban` varchar(30) DEFAULT NULL COMMENT 'codice BBAN',
  `isObsolete` tinyint(1) DEFAULT 0 COMMENT 'Flag record Obsoleto - quando un clifor cambia Denominazione e quella vecchia continua ad esistere ma non deve più essere usata - TRUE = obsoleto da non usare',
  `grouping` char(6) DEFAULT NULL COMMENT 'eventuale codice alfanumerico per raggruppamento clienti e fornitori - principalmente per usi statistici',
  `isPrivateCitizen` tinyint(1) DEFAULT 0 COMMENT 'Flag di cliente privato - fatturare su CF (quando anagrafica è di un consulente fornitore, ma il cliente è privato e vuole la fattura sul CF e non sulla partita IVA)',
  `note` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Clienti (persone/aziende/scuole) e Fornitori';

-- --------------------------------------------------------

--
-- Table structure for table `clifor_group`
--

CREATE TABLE `clifor_group` (
  `id` char(6) NOT NULL COMMENT 'ID gruppo clifor',
  `description` varchar(45) DEFAULT NULL COMMENT 'descrizione gruppo clifor',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag gruppo clifor cancellato (se TRUE)',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Gruppi clifor per poter classificare in gruppi clienti e fornitori per motivi statistici o simili - USO FUTURO';

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) NOT NULL,
  `project_id` bigint(20) DEFAULT NULL,
  `taskId` bigint(20) NOT NULL,
  `comment_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) NOT NULL,
  `content` text DEFAULT NULL,
  `last_update` datetime DEFAULT current_timestamp(),
  `creation_date` datetime NOT NULL,
  `isSeen` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `companies_user`
--

CREATE TABLE `companies_user` (
  `company_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `department_id` bigint(20) NOT NULL,
  `member_role` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `company_bank`
--

CREATE TABLE `company_bank` (
  `id` int(11) NOT NULL COMMENT 'ID banca (della piattaforma)',
  `isDeleted` tinyint(1) DEFAULT 0,
  `abiCode` char(5) NOT NULL COMMENT 'Codice ABI (Associazione Bancaria Italiana - codice banca)',
  `cabCode` char(5) NOT NULL COMMENT 'Codice CAB (Codice Avviamento Bancario - codice agenzia)',
  `description` varchar(70) NOT NULL COMMENT 'Descrizione Banca-Agenzia',
  `location` varchar(70) DEFAULT NULL COMMENT 'Eventuale località agenzia',
  `bicCode` varchar(15) DEFAULT NULL COMMENT 'Codice BIC (Business Identifier Code) aka SWIFT - Necessario per transazioni internazionali'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Anagrafica Banche della piattaforma (tabella separata da quella delle banche dei clienti/fornitori)';

-- --------------------------------------------------------

--
-- Table structure for table `company_modules`
--

CREATE TABLE `company_modules` (
  `id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `isNotify` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `itemKey` varchar(70) NOT NULL COMMENT 'property Key',
  `itemValue` varchar(255) NOT NULL COMMENT 'property value',
  `description` tinytext DEFAULT NULL COMMENT 'property description'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='dati di configurazione\nMappa di valori (coppie K,V)\nLIMITARE la possibilità di modificare i dati';

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` bigint(20) NOT NULL COMMENT 'ID contatto - Autoinc',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag record cancellato',
  `description` varchar(100) NOT NULL COMMENT 'Descrizione del contatto (obbligatoria) (es. ruolo in azienda)',
  `title` varchar(10) DEFAULT NULL COMMENT 'eventuale titolo del contatto (Sig., Dott. Ing., Sig.ra, ...)',
  `firstname` varchar(100) DEFAULT NULL COMMENT 'Nome',
  `lastname` varchar(100) DEFAULT NULL COMMENT 'Cognome',
  `sex` char(1) DEFAULT NULL COMMENT 'sesso - M = maschio, F = femmina',
  `birthdate` date DEFAULT NULL COMMENT 'data di nascita',
  `birthPlace` varchar(70) DEFAULT NULL COMMENT 'Luogo di Nascita',
  `birthProvince` char(2) DEFAULT NULL COMMENT 'Sigla provincia di nascita',
  `birthCountry` char(2) DEFAULT NULL COMMENT 'Sigla nazione di nascita - (usare cod ISO 3166-1)',
  `isPrivateAddress` tinyint(1) DEFAULT 0 COMMENT 'Flag indirizzo privato del contatto (se utilizzato) - TRUE = indirizzo privato (default FALSE)',
  `address` varchar(70) DEFAULT NULL COMMENT 'indirizzo contatto - se diverso dalla sede a cui è associato (es. indirizzo privato oppure indirizzo del consulente che fa da contatto)',
  `place` varchar(70) DEFAULT NULL COMMENT 'Localita',
  `city` varchar(70) DEFAULT NULL COMMENT 'citta',
  `zip` varchar(15) DEFAULT NULL COMMENT 'CAP',
  `tel` varchar(45) DEFAULT NULL COMMENT 'telefono fisso',
  `cell` varchar(45) DEFAULT NULL COMMENT 'cellulare',
  `fax` varchar(45) DEFAULT NULL COMMENT 'fax',
  `email` varchar(80) DEFAULT NULL COMMENT 'email',
  `skype` varchar(80) DEFAULT NULL COMMENT 'skype',
  `web` varchar(80) DEFAULT NULL COMMENT 'sito web',
  `pec` varchar(80) DEFAULT NULL COMMENT 'email certificata del contatto (non quella aziendale)',
  `isAuthPersonalData` tinyint(1) DEFAULT 0 COMMENT 'Flag di Autorizzazione al trattamento dei dati personali (TRUE = autorizza)',
  `langId` char(2) NOT NULL COMMENT 'Id lingua usata dal contatto',
  `lastUpdate` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'timestamp ultimo aggiornamento record',
  `note` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Anagrafica contatti - contiene i contatti degli indirizzi delle anagrafiche';

-- --------------------------------------------------------

--
-- Table structure for table `contractlines`
--

CREATE TABLE `contractlines` (
  `id` bigint(20) NOT NULL,
  `contract_id` bigint(20) DEFAULT NULL,
  `grouptitle` text DEFAULT NULL,
  `tasktitle` text DEFAULT NULL,
  `description_task` mediumtext DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `tax_percentage` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `id` bigint(20) NOT NULL,
  `project_object_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `listof_members` text DEFAULT NULL,
  `content` mediumtext DEFAULT NULL,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `acceptance_date` datetime DEFAULT current_timestamp(),
  `contract_filename` varchar(255) DEFAULT NULL,
  `contract_filepath` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `tax` decimal(5,2) DEFAULT NULL,
  `total_workinghrs` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` char(2) NOT NULL COMMENT 'ID country (ISO 3166-1)',
  `euroId` char(2) NOT NULL COMMENT 'ID country secondo le specifiche Europee\n(come ISO 3166-1 tranne Grecia(GR) =>> EL, Regno unito(GB) =>> UK)\nEuropa = EU',
  `isEnabled` tinyint(1) DEFAULT 0 COMMENT 'flag abilitazione uso piattaforma in Country',
  `isBlocked` tinyint(1) DEFAULT 0 COMMENT 'Flag Blocco uso piattaforma in Country - prioritario su flag Enabled',
  `isEurope` tinyint(1) DEFAULT 0 COMMENT 'flag di appartenenza Country a Unione Europea (per la libera circolazione delle merci)',
  `isShengen` tinyint(1) DEFAULT 0 COMMENT 'Flag di adesione agli accordi di Shengen pa la libera circolazione delle persone',
  `note` mediumtext DEFAULT NULL,
  `currencyCode` char(3) DEFAULT NULL COMMENT 'Currency Code (ISO 4217) utilizzato nella country - dovrebbe essere già contenuto nella localizzazione Java',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'flag country cancellata'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Country in cui può operare la piattaforma';

-- --------------------------------------------------------

--
-- Table structure for table `country_property`
--

CREATE TABLE `country_property` (
  `countryId` char(2) NOT NULL COMMENT 'ID Country',
  `itemKey` varchar(70) NOT NULL COMMENT 'key proprietà',
  `itemValue` varchar(250) NOT NULL COMMENT 'valore proprietà - se NULL eliminare la property',
  `description` tinytext DEFAULT NULL COMMENT 'descrizione proprietà',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'flag record cancellato - Deve Seguire flag isDeleted di tbl Country'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Elenco proprieta specifiche della country\n\nstruttra Chiave / Valore';

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `id` bigint(20) NOT NULL COMMENT 'id coupon',
  `campaignId` bigint(20) NOT NULL COMMENT 'id campagna di marketing',
  `userId` bigint(20) NOT NULL COMMENT 'userId a cui è legato il coupon',
  `code` varchar(45) NOT NULL COMMENT 'codice coupon UNICO',
  `startDate` datetime DEFAULT NULL COMMENT 'Data inizio periodo di validità del coupon',
  `endDate` datetime DEFAULT NULL COMMENT 'Data fine periodo di validità del coupon',
  `price` decimal(10,2) DEFAULT NULL COMMENT 'eventuale Prezzo del prodotto - Prioritario rispetto a quello della campagna',
  `discount` decimal(5,2) DEFAULT NULL COMMENT 'eventuale Sconto sul prodotto - Prioritario rispetto a quello della campagna',
  `assignmentDate` timestamp NULL DEFAULT current_timestamp() COMMENT 'Timestamp di assegnazione Coupon a utente',
  `isUsed` tinyint(1) DEFAULT 0 COMMENT 'Flag coupon utilizzato',
  `dateOfUse` timestamp NULL DEFAULT NULL COMMENT 'data di utilizzo del coupon (timestamp)',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag coupon cancellato',
  `isBlocked` tinyint(1) DEFAULT 0 COMMENT 'Flag di coupon bloccato',
  `blockDate` timestamp NULL DEFAULT NULL COMMENT 'data di blocco del coupon',
  `blockReason` varchar(245) DEFAULT NULL COMMENT 'motivazione del blocco del coupon',
  `isCanceled` tinyint(1) DEFAULT 0 COMMENT 'Flag coupon annullato',
  `cancelDate` timestamp NULL DEFAULT NULL COMMENT 'Data di annullamento del counpon',
  `cancelReason` varchar(245) DEFAULT NULL COMMENT 'Motivazione annullamento coupon',
  `note` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Coupon per utente legato alla campagna marketing';

-- --------------------------------------------------------

--
-- Table structure for table `course_matter`
--

CREATE TABLE `course_matter` (
  `matterId` bigint(20) NOT NULL COMMENT 'ID materia',
  `courseId` bigint(20) NOT NULL COMMENT 'ID corso',
  `module` char(1) NOT NULL DEFAULT 'U' COMMENT 'modulo materia per materia divise in moduli - "U" = modulo unico (default)\nes.\nmodulo 1, modulo 2\noppure\nmodulo A, modulo B',
  `isOptional` tinyint(1) DEFAULT 0 COMMENT 'Flag materia del corso - Opzionale = TRUE, Obbligatoria = FALSE',
  `years` varchar(6) DEFAULT NULL COMMENT 'anni del corso in cui viene insegnata la materia\n\nes.\nNULL = a scelta dello studente (x universita)\n1 = solo primo anno\n2 = solo secondo anno\n12 = primo e secondo anno\n345 = triennio SS2\n6 = sesto anno',
  `isDeleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Elenco Materie/Insegnamenti del Corso di studi';

-- --------------------------------------------------------

--
-- Table structure for table `course_section`
--

CREATE TABLE `course_section` (
  `courseId` bigint(20) NOT NULL COMMENT 'id corso',
  `sectionId` varchar(45) NOT NULL COMMENT 'ID sezione - Empty String = unica sezione\nes.\nA,B,C,...',
  `isPartialTime` tinyint(1) DEFAULT 0 COMMENT 'Flag corso a tempo parziale (part-time) = TRUE, a tempo pieno (full-time) = FALSE (default)',
  `isEvening` tinyint(1) DEFAULT 0 COMMENT 'Flag corso serale = TRUE, diurno = FALSE (default)',
  `note` mediumtext DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='sezioni in cui è diviso il corso\nne esiste almeno una\n\nA,B,C,...\ndiurno/serale\npart-time/full-time';

-- --------------------------------------------------------

--
-- Table structure for table `degree_class`
--

CREATE TABLE `degree_class` (
  `id` int(11) NOT NULL COMMENT 'id classe di laurea',
  `code` varchar(20) NOT NULL COMMENT 'codice classe di laurea\nesempio\nL-01, LM-18, L-36',
  `name` varchar(100) NOT NULL COMMENT 'nome classe di laurea\nesempi\n- per LM18 - Lauree Magistrali in Informatica\n- per L31 - Lauree in Scienze e Tecnologie Informatiche',
  `typeId` int(11) NOT NULL COMMENT 'id tipo classe di laurea',
  `countryId` char(2) NOT NULL COMMENT 'id country dove è definita la classe di laurea',
  `note` mediumtext DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='elenco classi di laurea per country';

-- --------------------------------------------------------

--
-- Table structure for table `degree_class_type`
--

CREATE TABLE `degree_class_type` (
  `id` int(11) NOT NULL COMMENT 'ID tipo li laurea',
  `code` varchar(20) DEFAULT NULL COMMENT 'tipo (codice) della classe di laurea\nesempio ITA\nL = Laurea Triennale\nLM = Laurea Magistrale',
  `note` mediumtext DEFAULT NULL COMMENT 'nome tipo classe di laurea',
  `isced` char(2) NOT NULL COMMENT 'ID livello scuola - SS1, SS2, UNI',
  `schoolLevelId` char(3) NOT NULL COMMENT 'ID livello scuola - SS1, SS2, UNI',
  `isDeleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tipi delle classi dei corsi di studi per country\n\n- SS1 - Licenza Media\n- SS2 - Diploma\n- UNI - Laurea Triennale / Bachelor\n- UNI - Laurea Magistrale / Graduation\n- UNI - Master\n- UNI - Dottorato / Doctoral\n';

-- --------------------------------------------------------

--
-- Table structure for table `degree_class_type_lang`
--

CREATE TABLE `degree_class_type_lang` (
  `id` int(11) NOT NULL,
  `langId` char(2) NOT NULL,
  `name` varchar(100) NOT NULL COMMENT 'nome tipo classe di laurea in lingua\n\nesempio\nit - Laurea Triennale\nen - Bechelor Degree',
  `description` varchar(245) DEFAULT NULL COMMENT 'descrizione'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='nomi delle classi dei corsi di studi in lingua';

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `schoolId` bigint(20) NOT NULL COMMENT 'ID scuola/Azienda',
  `code` char(10) NOT NULL COMMENT 'Codice del reparto della scuola/azienda (PK + id scuola)',
  `anagId` bigint(20) NOT NULL,
  `name` varchar(45) NOT NULL COMMENT 'nome reparto',
  `note` mediumtext DEFAULT NULL COMMENT 'note',
  `isXCond1` tinyint(1) DEFAULT 0 COMMENT 'condizione libera 1',
  `isXCond2` tinyint(1) DEFAULT 0 COMMENT 'condizione libera 2',
  `xInt` int(11) DEFAULT 0 COMMENT 'intero libero 1',
  `xString` varchar(45) DEFAULT NULL COMMENT 'stringa libera 1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Reparti/Dipartimenti di azienda/scuola';

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) NOT NULL,
  `department_id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `desktop_object`
--

CREATE TABLE `desktop_object` (
  `userId` bigint(20) NOT NULL COMMENT 'ID utente (owner del desktop)\n',
  `itemId` int(11) NOT NULL COMMENT 'numero progressivo del file\nOgni owner ha una propria numerazione progressiva di file (da 1 in poi, ZERO significa NESSUNO)\n',
  `displayName` varchar(255) DEFAULT NULL COMMENT 'eventuale nome del file da visualizzare',
  `isFolder` tinyint(1) DEFAULT 0 COMMENT 'Flag Folder = TRUE, File = FALSE (default) - solo gli oggetti Folder possono contenere altri oggetti',
  `iconId` int(11) NOT NULL COMMENT 'ID icona da usare per rappresentare il tipo di file - prioritario su icona memorizzata nel record attachment',
  `upperFolderUserId` bigint(20) DEFAULT NULL COMMENT 'ID cartella superiore (userId + itemId)\nvalorizzato se ha un cartella superiore che lo contiene',
  `upperFolderItemId` int(11) DEFAULT NULL COMMENT 'itemId cartella superiore (userId + itemId)\nvalorizzato se ha un cartella superiore che lo contiene',
  `level` int(11) DEFAULT 0 COMMENT 'Livello oggetto per gestire gli oggetti in una cartella\nDefault = 0 (Livello iniziale - NON ha previous)\nOgni oggetto ha una cartella superiore (padre) setta level = padre.level + 1\nMax 255 livelli',
  `createTime` timestamp NULL DEFAULT current_timestamp() COMMENT 'Timestamp di creazione oggetto',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag oggetto Cancellato (nel cestino) = TRUE, attivo = FALSE\nLa cancellazione di un Folder esegue la cancellazione di tutto il contenuto',
  `lastUpdate` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Timestamp ultimo aggiornamento',
  `fileObjId` timestamp NULL DEFAULT NULL COMMENT 'ID file - Marca temporale - settare a NULL se oggetto è un Folder',
  `fileObjCnt` bigint(20) DEFAULT NULL COMMENT 'ID file- Counter - settare a NULL se oggetto è un Folder',
  `content` mediumtext DEFAULT NULL COMMENT 'Testo per appunti (file virtuale) - alternativo a fileObj[ID/Cnt] - req Alessandro del 13/05/2018',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Elenco oggetti nel desktop utente\n\nStruttra cartelle con Flag folder (=TRUE) e upperFolderId + upperFolderSequence\n';

-- --------------------------------------------------------

--
-- Table structure for table `destination`
--

CREATE TABLE `destination` (
  `id` char(2) NOT NULL COMMENT 'Codice destino\nes. EL = elementari, MD = medie, SS = superiori, SB = superiori biennio, ST = superiori triennio, B1 = superiori primo biennio, B2 superiori secondo biennio, A5 = superiori quinto anno, TS = Istituto Tecnico Superiore, UU = Universita\n',
  `code` varchar(45) DEFAULT NULL COMMENT 'eventuale codice',
  `note` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Destini dei marchi - esempio: Università, Varia, Superiori Biennio, Superiori Triennio, Scuola Primaria, Scuola Materna';

-- --------------------------------------------------------

--
-- Table structure for table `destination_lang`
--

CREATE TABLE `destination_lang` (
  `id` char(2) NOT NULL COMMENT 'ID destinazione',
  `langId` char(2) NOT NULL COMMENT 'ID lingua',
  `name` varchar(100) NOT NULL COMMENT 'nome destinazione in lingua',
  `description` varchar(245) DEFAULT NULL COMMENT 'eventuale descrizione destinazione in lingua'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `device`
--

CREATE TABLE `device` (
  `id` char(50) NOT NULL COMMENT 'ID device - codice preso da device \ndecidere cosa usare',
  `userId` bigint(20) NOT NULL COMMENT 'id utente associato al device',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'flag record cancellato',
  `description` varchar(100) DEFAULT NULL COMMENT 'Descrizione del device',
  `isBlocked` tinyint(1) DEFAULT 0 COMMENT 'Flag device Bloccato/Non utilizzabile = TRUE, nessun problema = FALSE',
  `blockTime` timestamp NULL DEFAULT NULL COMMENT 'Timestamp del Blocco',
  `blockReason` varchar(245) DEFAULT NULL,
  `registrationDate` timestamp NULL DEFAULT current_timestamp() COMMENT 'Data di primo utilizzo (registrazione) del device sulla piattaforma\nusare CURRENT_TIMESTAMP',
  `registrationUserId` bigint(20) DEFAULT NULL COMMENT 'ID utente che ha registrato il device la prima volta che questo è stato utilizzato con la piattaforma',
  `lastUpdate` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Timestamp ultimo utlizzo',
  `lastUserId` bigint(20) DEFAULT NULL COMMENT 'ID utente cha ha usato per ultimo il device',
  `lastChangeUserDate` timestamp NULL DEFAULT NULL COMMENT 'Data ultimo cambio ID utente utilizzatore',
  `note` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='lista device di ogni utente per lettura ebook';

-- --------------------------------------------------------

--
-- Table structure for table `discipline`
--

CREATE TABLE `discipline` (
  `id` int(11) NOT NULL COMMENT 'ID SSD',
  `code` char(20) DEFAULT NULL COMMENT 'per Italia codice SSD assegnato dal ministero - NULL se non ha codice ministeriale',
  `superCode` char(252) DEFAULT NULL COMMENT 'codice gruppo superiore = [ superCode padre + / + ] ID in formato stringa (IDX con Duplicati VIETATI) max 12 livelli',
  `type` char(1) NOT NULL COMMENT 'Tipo - A = Area, M = Macrosettore, C = Settore Concorsuale, S = Settore Scientifico-Didattico (SSD), D = Disciplina, T = Materia, L = Modulo',
  `affinity1` varchar(45) DEFAULT NULL COMMENT 'Codici Affini livello 1 - da usare per tipo S (SSD)',
  `affinity2` varchar(45) DEFAULT NULL COMMENT 'Codici Affini livello 2 - da usare per tipo S (SSD)',
  `countryId` char(2) DEFAULT NULL COMMENT 'ID country in cui è definito - se NULL vale per tutte le countries',
  `fatherId` int(11) DEFAULT NULL COMMENT 'ID padre (per raggruppamenti di discipline in SSD, (Settori Concorsuali), Macro settori, Aree',
  `level` int(11) DEFAULT 0 COMMENT 'Livello per gestire visualizzazioni con incolonnamento differente per livello\nDefault = 0 (Livello iniziale - NON ha padre/previous)\nOgni item che ha padre/previous setta level = padre.level + 1',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag record cancellato'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Discipline di insegnamento\nOrganizzate in Settori Scientifico-Didattici / (Settori Concorsuali) / Macro Settori / Aree\nprobabilmente esiste unica classificazione per tutte le countries\n\nItalia\n- UNI - SSD come definiti da MIUR\n\nOrganizzate a livelli\n';

-- --------------------------------------------------------

--
-- Table structure for table `discipline_lang`
--

CREATE TABLE `discipline_lang` (
  `id` int(11) NOT NULL COMMENT 'ID SSD',
  `langId` char(2) NOT NULL COMMENT 'ID Lingua',
  `name` varchar(150) NOT NULL COMMENT 'nome del Settore Scientifico-Didattico (SSD) in lingua',
  `description` varchar(245) DEFAULT NULL COMMENT 'descrizione ssd'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='nomi e descrizioni in lingua per Aree, Macrosettori, (Settori Concorsuali), SSD, Discipline, Materie, Moduli';

-- --------------------------------------------------------

--
-- Table structure for table `document_type`
--

CREATE TABLE `document_type` (
  `id` char(2) NOT NULL COMMENT 'ID tipo documento\nesempio\nFT = Fattura di vendita\nFA = Fattura di Acquisto\nNC = Nota di Accredito\nND = Nota Debito\naltro...',
  `code` varchar(45) DEFAULT NULL COMMENT 'eventuale codice',
  `note` mediumtext DEFAULT NULL COMMENT 'note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tipi di documento\nFattura\nNota di Accredito\naltro...\n';

-- --------------------------------------------------------

--
-- Table structure for table `document_type_lang`
--

CREATE TABLE `document_type_lang` (
  `id` char(2) NOT NULL COMMENT 'ID tipo documento',
  `langId` char(2) NOT NULL COMMENT 'ID lingua nome documento',
  `name` varchar(100) NOT NULL COMMENT 'Nome documento in lingua',
  `description` varchar(245) DEFAULT NULL COMMENT 'descrizione'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='nome in lingua del tipo documento';

-- --------------------------------------------------------

--
-- Table structure for table `emailfiles`
--

CREATE TABLE `emailfiles` (
  `id` bigint(20) NOT NULL,
  `email_id` bigint(20) NOT NULL,
  `parentemail_id` bigint(20) DEFAULT NULL,
  `forwarded_id` bigint(20) DEFAULT NULL,
  `fromuser_id` bigint(20) NOT NULL,
  `touser_id` bigint(20) NOT NULL,
  `filepath` varchar(250) DEFAULT NULL,
  `filename` varchar(250) DEFAULT NULL,
  `type` varchar(250) DEFAULT NULL,
  `size` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employeerequests`
--

CREATE TABLE `employeerequests` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `request_type` varchar(150) DEFAULT NULL,
  `worktype` varchar(250) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'N',
  `description` varchar(250) DEFAULT NULL,
  `fromdate` datetime NOT NULL,
  `todate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employeesdailyworkflow`
--

CREATE TABLE `employeesdailyworkflow` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `status` varchar(150) DEFAULT NULL,
  `fromdate` datetime DEFAULT NULL,
  `todate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employee_shifts`
--

CREATE TABLE `employee_shifts` (
  `id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `isRepeated` tinyint(1) NOT NULL DEFAULT 0,
  `weeks_to_repeat` int(11) DEFAULT NULL,
  `endof_repeating_shift` datetime DEFAULT NULL,
  `isIndefinite` tinyint(1) NOT NULL DEFAULT 0,
  `note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `epictasks_projecttasks`
--

CREATE TABLE `epictasks_projecttasks` (
  `epictask_id` bigint(20) NOT NULL,
  `projecttask_id` bigint(20) NOT NULL,
  `projectId` bigint(20) UNSIGNED NOT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) NOT NULL,
  `event_name` varchar(280) DEFAULT NULL,
  `event_startdate` datetime DEFAULT NULL,
  `event_enddate` datetime DEFAULT NULL,
  `category` text DEFAULT NULL,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `event_alert`
--

CREATE TABLE `event_alert` (
  `marker` datetime NOT NULL COMMENT 'ID evento - time marker',
  `ownerType` char(1) NOT NULL COMMENT 'ID evento - tipo di owner evento (owner del calendario)\nU = utente, G = Gruppo, P = Piattaforma (con ownerId = 0), T = Timeline (per lezioni di eLearning)',
  `ownerId` bigint(20) NOT NULL COMMENT 'ID Evento - ID owner evento (id utente, id gruppo, id Timeline di eLearning, usare 0 se Piattaforma)',
  `guestId` bigint(20) NOT NULL COMMENT 'ID utente invitato (che ha aderito)',
  `wakeupTime` datetime NOT NULL COMMENT 'Data e Ora alert',
  `text` varchar(100) DEFAULT NULL COMMENT 'Messaggio di testo',
  `mmFileName` varchar(255) DEFAULT NULL COMMENT 'nome file multimediale',
  `mmFilePath` varchar(255) DEFAULT NULL COMMENT 'path del file multimediale',
  `mmFileServer` varchar(255) DEFAULT NULL COMMENT 'Server area di store dove è memorizzato il file multimediale'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Elenco di Alert per evento - potrebbe non essercene nessuno oppure molti';

-- --------------------------------------------------------

--
-- Table structure for table `event_attachment`
--

CREATE TABLE `event_attachment` (
  `marker` datetime NOT NULL COMMENT 'ID evento - time marker',
  `ownerType` char(1) NOT NULL COMMENT 'ID evento - tipo di owner evento (owner del calendario)',
  `ownerId` bigint(20) NOT NULL COMMENT 'ID Evento - ID owner evento (id utente, id gruppo, id Timeline di eLearning, usare 0 se Piattaforma)',
  `fileMarker` datetime NOT NULL COMMENT 'ID temporale attachment',
  `fileCnt` bigint(20) NOT NULL COMMENT 'Counter attachment',
  `iconId` int(11) NOT NULL COMMENT 'ID icona da usare per rappresentare il tipo di file - prioritario su icona memorizzata nel record attachment',
  `description` varchar(70) DEFAULT NULL COMMENT 'descrizione breve',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Link tra i gli eventi (di utente, gruppo, piattaforma, timeline) e i file allegati';

-- --------------------------------------------------------

--
-- Table structure for table `event_object`
--

CREATE TABLE `event_object` (
  `marker` datetime NOT NULL COMMENT 'ID evento - time marker (usare valore systemTimer) - tutti gli eventi ripetuti da uno specifico evento, settano il reference Id = event Id evento originale',
  `ownerType` char(1) NOT NULL COMMENT 'ID evento - tipo di owner evento (owner del calendario)\nU = utente, G = Gruppo, P = Piattaforma (con ownerId = 0), T = Timeline (per lezioni di eLearning)',
  `ownerId` bigint(20) NOT NULL COMMENT 'ID Evento - ID owner evento (id utente, id gruppo, id Timeline di eLearning, usare 0 se Piattaforma)',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag evento cancellato = TRUE, non cancellato = FALSE\nse un evento viene cancellato devono essere eliminati anche gli attachment relativi',
  `isCreatedByPlatform` tinyint(1) DEFAULT 0 COMMENT 'Flag evento creato dalla piattaforma = TRUE, da utente = FALSE (default)',
  `creatorId` bigint(20) DEFAULT NULL COMMENT 'ID utente creatore evento (settare a NULL se creato dalla piattaforma)',
  `isPublic` tinyint(1) DEFAULT 0 COMMENT 'Flag evento pubblico = TRUE, privato = FALSE (default)',
  `title` varchar(100) DEFAULT NULL COMMENT 'oggetto / titolo evento',
  `iconId` int(11) DEFAULT NULL COMMENT 'Eventuale icona evento (simbolo tipo emoticon o simile)\nriferirsi a tabella delle icone',
  `description` tinytext DEFAULT NULL COMMENT 'descrizione evento',
  `place` varchar(200) DEFAULT NULL COMMENT 'luogo evento',
  `startDate` date NOT NULL COMMENT 'data di inizio evento',
  `startTime` time NOT NULL COMMENT 'ora di inizio evento',
  `dateType` char(1) DEFAULT 'D' COMMENT 'tipo di startDate - D = data normale (g+ m+ a), M = mese+anno (no giorno), Y = solo Anno.\n(se manca un dato prendere il valore 1)',
  `isBc` tinyint(1) DEFAULT 0 COMMENT 'Flag per data Avanti Cristo (B.C.) - TRUE = Data B.C., FALSE (default) data Dopo Cristo',
  `endDate` date NOT NULL COMMENT 'Data di fine evento',
  `endTime` time NOT NULL COMMENT 'Ora di fine evento',
  `isRepeating` tinyint(1) DEFAULT 0 COMMENT 'Flag ripetizione evento - FALSE = evento occasionale, TRUE = evento ripetitivo',
  `repetitionType` char(1) DEFAULT NULL COMMENT 'Tipo di ripetizione - SOLO x eventi che si ripetono\nY = annuale, M = mensile, W = settimanale, D = giornaliera, H = oraria\nper ripetizioni Y e M usare il giorno precedente se il giorno previsto non esiste\nNULL = evento NON ripetitivo',
  `referenceMarker` datetime DEFAULT NULL COMMENT 'reference ID - time marker - tutti gli eventi ripetuti da uno specifico evento, settano il reference Id = event Id evento originale',
  `referenceOwnerType` char(1) DEFAULT NULL COMMENT 'reference ID - tipo di owner evento (owner del calendario)\nU = utente, G = Gruppo, P = Piattaforma (con ownerId = 0), T = Timeline (per lezioni di eLearning)',
  `referenceOwnerId` bigint(20) DEFAULT NULL COMMENT 'reference ID - ID owner evento (id utente, id gruppo, id Timeline di eLearning, usare 0 se Piattaforma)',
  `endRepetitionDate` date DEFAULT NULL COMMENT 'data di fine ripetizione evento - NULL evento senza fine ripetizione o non ripetibile',
  `isAuto` tinyint(1) DEFAULT 0 COMMENT 'Flag - evento generato automaticamente da sistema dopo il verificarsi di evento ripetitivo\nTRUE = evento generato automaticamente, FALSE = evento singolo NON generato da sistema',
  `isAllDayLong` tinyint(1) DEFAULT 0 COMMENT 'Flag durata evento per tutto il giorno (24 ore) - TRUE = tutto il giorno quindi ignora data/ora, FALSE = durata limitata definita dai campi di inizio e fine',
  `lastUpdate` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Timestamp ultimo aggiornamento',
  `note` mediumtext DEFAULT NULL COMMENT 'note evento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Elenco eventi (privati e pubblici) da visualizzare in calendari di utenti e gruppi)\nNON possono creare più eventi dello stesso owner con lo stesso timestamp';

-- --------------------------------------------------------

--
-- Table structure for table `event_sharing`
--

CREATE TABLE `event_sharing` (
  `marker` datetime NOT NULL COMMENT 'ID evento - time marker',
  `ownerType` char(1) NOT NULL COMMENT 'ID evento - tipo di owner evento (owner del calendario)\nU = utente, G = Gruppo, P = Piattaforma (con ownerId = 0), T = Timeline (per lezioni di eLearning)',
  `ownerId` bigint(20) NOT NULL COMMENT 'ID Evento - ID owner evento (id utente, id gruppo, id Timeline di eLearning, usare 0 se Piattaforma)',
  `guestId` bigint(20) NOT NULL COMMENT 'ID utente invitato',
  `invitationTime` timestamp NULL DEFAULT current_timestamp() COMMENT 'Data/Ora invito (timestamp creazione record invito)',
  `expirationDate` date DEFAULT NULL COMMENT 'eventuale Data limite per adesione a evento (NULL = nessuna data limite)',
  `isProcessed` tinyint(1) DEFAULT 0 COMMENT 'Flag risposta invito - TRUE = risposta data, FALSE = risposta NON data',
  `isJoined` tinyint(1) DEFAULT 0 COMMENT 'Flag adesione - TRUE = guest ha aderito, FALSE = non aderito',
  `joinDate` timestamp NULL DEFAULT NULL COMMENT 'timestamp di adesione - resta NULL se utente non aderisce'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Condivisione degli eventi\ngestisce inviti e adesioni\nI creatori di un evento aderiscono automaticamente';

-- --------------------------------------------------------

--
-- Table structure for table `exchange_rate`
--

CREATE TABLE `exchange_rate` (
  `currencyCode` char(3) NOT NULL COMMENT 'Codice Valuta (ISO 4217)',
  `checkDate` date NOT NULL COMMENT 'Data verifica Cambio',
  `exchangeValue` decimal(11,5) NOT NULL COMMENT 'valore cambio rispetto a 1 nella valuta di riferimento per operazioni in valuta',
  `exchangeValueBuy` decimal(11,5) NOT NULL COMMENT 'valore cambio rispetto a 1 nella valuta di riferimento per acquistare la valuta',
  `exchangeValueSell` decimal(11,5) NOT NULL COMMENT 'valore cambio rispetto a 1 nella valuta di riferimento per vendre la valuta',
  `lastUpdate` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Timestamp ultimo aggiornamento',
  `updateUserId` bigint(20) DEFAULT NULL COMMENT 'Id utente che ha eseguito ultimo aggiornamento sul record (NULL = aggiornamento con procedura automatica da piattaforma)',
  `extraDate` date DEFAULT NULL COMMENT 'Extra Date',
  `extraValue` decimal(11,5) DEFAULT NULL COMMENT 'Extra Value'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Cambi Valuta rispetto alla valuta di riferimento (EUR)\nEs.\nEUR/USD = Tasso\nUSD = EUR * Tasso\nEUR = USD / Tasso';

-- --------------------------------------------------------

--
-- Table structure for table `e_answers`
--

CREATE TABLE `e_answers` (
  `id` bigint(20) NOT NULL,
  `e_question_id` bigint(20) NOT NULL,
  `type` char(1) NOT NULL COMMENT 'A = Risposta aperta; M = Scelta multipla; R = Risposta multipla',
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `e_category`
--

CREATE TABLE `e_category` (
  `id` bigint(20) NOT NULL COMMENT 'ID categoria (PK autoinc)',
  `superCode` char(252) DEFAULT NULL COMMENT 'codice gruppo superiore = [ superCode padre + / + ] ID in formato stringa (IDX con Duplicati VIETATI) max 12 livelli',
  `name` varchar(255) NOT NULL COMMENT 'nome gruppo di eLearning',
  `code` char(45) DEFAULT NULL COMMENT 'eventuale codice',
  `parent_id` bigint(20) DEFAULT NULL COMMENT 'ID eGroup padre',
  `lft` bigint(20) DEFAULT NULL,
  `rght` bigint(20) DEFAULT NULL,
  `level` int(11) DEFAULT 0 COMMENT 'Livello per gestire visualizzazioni con incolonnamento differente per livello\nDefault = 0 (Livello iniziale - NON ha padre/previous)\nOgni item che ha padre/previous setta level = padre.level + 1\nMax 255 livelli',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag eGroup cancellato',
  `organizationId` bigint(20) DEFAULT NULL COMMENT 'ID organizzazione a cui si riferisce la categoria (è visibile ai membri della organizzazione) - se NULL è visibile a tutti gli utenti',
  `departmentId` char(10) DEFAULT NULL,
  `isInternal` tinyint(1) DEFAULT 0 COMMENT 'Flag categoria Interna = TRUE (categoria visibile solo a utenti collegati a organizzazione), Esterna = FALSE (per chiunque) - ha senso SOLO per categorie collegate a una organizzazione'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='categorie dei corsi di eLearning\nStruttura ad albero che permette sottocategorie';

-- --------------------------------------------------------

--
-- Table structure for table `e_course`
--

CREATE TABLE `e_course` (
  `id` bigint(20) NOT NULL COMMENT 'ID corso eLearning (= ID articolo)',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag corso cancellato = TRUE, attivo = FALSE',
  `title` varchar(70) NOT NULL COMMENT 'titolo / nome corso',
  `subtitle` varchar(250) DEFAULT NULL COMMENT 'sottotitolo del corso',
  `description` tinytext DEFAULT NULL COMMENT 'descrizione del corso',
  `languageCode` char(2) NOT NULL COMMENT 'codice lingua del corso (ISO 639-2)',
  `ownerId` bigint(20) NOT NULL COMMENT 'ID dell’utente proprietario del corso - insieme a organizationId serve per la fatturazione dei costi o dei guadagni.',
  `organizationId` bigint(20) DEFAULT NULL COMMENT 'ID organizzazione a cui appartiene il corso - NULL se non appartiene a nessuna organizzazione',
  `isFree` tinyint(1) DEFAULT 0 COMMENT 'Flag corso Gratuito (True) oppure a pagamento (False)',
  `isRestrictedAccess` tinyint(1) DEFAULT 0 COMMENT 'Flag corso ad accesso riservato = TRUE, ad accesso pubblico = FALSE\nse ad accesso riservato vedere ACL (Access Control List)',
  `isInternal` tinyint(1) DEFAULT 0 COMMENT 'Flag corso Interno = TRUE (solo per utenti collegati a organizzazione), Esterno = FALSE (per chiunque) - ha senso SOLO per corsi collegati a una organizzazione',
  `status` char(3) DEFAULT 'EDT' COMMENT 'Stato del corso (EDT = Editing, CPL = Complete, REQ = Request, RJT = Rejected, APP = Approved, PUB = Published, BLK = Blocked)',
  `isApprovalRequired` tinyint(1) DEFAULT 1 COMMENT 'Flag per richiesta di approvazione necessaria = TRUE (default), approvazione non necessaria = FALSE',
  `createDate` timestamp NULL DEFAULT current_timestamp() COMMENT 'Timestamp creazione Corso',
  `creatorId` bigint(20) NOT NULL COMMENT 'ID utente Creatore del Corso',
  `lastUpdate` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Data ultimo aggiornamento',
  `matterId` bigint(20) DEFAULT NULL COMMENT 'ID materia (se applicabile)',
  `eCategoryId` bigint(20) DEFAULT NULL COMMENT 'ID Categoria di eLearning (se applicabile)',
  `password` varchar(245) DEFAULT NULL COMMENT 'eventuale password di accesso (default NULL) - USO FUTURO',
  `startDate` date DEFAULT NULL COMMENT 'Data inizio corso - prima il corso non è visibile a nessun utente-studente',
  `endDate` date DEFAULT NULL COMMENT 'Data fine corso - dopo la data il corso non è più visibile a nessun utente-studente',
  `endSubscriptionDate` date DEFAULT NULL COMMENT 'Data fine iscrizioni al corso - Utile se ha data di inizio e fine - con questi dati garantisco che uno studente abbia il corso a disposizione per un tempo minimo (da endDate a end SubscriptionDate)',
  `isObsolete` tinyint(1) DEFAULT 0 COMMENT 'flag corso Obsoleto - da usare coi corsi che hanno endDate - DA VALUTARE',
  `isVisible` tinyint(1) DEFAULT 1 COMMENT 'Flag corso visibile - potrebbe servire per nascondere il corso - DA VALUTARE',
  `isOffLine` tinyint(1) DEFAULT 0 COMMENT 'Flag corso OffLine = TRUE, oppure onLine = False (default) - impedisce temporaneamente utilizzo del corso - per manutenzione, verifiche o altro',
  `bibliography` mediumtext DEFAULT NULL COMMENT 'Eventuale bibliografia del corso (testo libero) - se ci sono riferimenti a libri posseduti dalla piattaforma, questi sono nella tabella e_course_bibliography',
  `xUBInt1` bigint(20) DEFAULT 0 COMMENT 'unsigned bigint libero 1',
  `xUBint2` bigint(20) DEFAULT 0 COMMENT 'unsigned bigint libero 2',
  `xInt` int(11) DEFAULT 0 COMMENT 'Intero libero 1',
  `isXCond1` tinyint(1) DEFAULT 0 COMMENT 'condizione libera 1',
  `isXCond2` tinyint(1) DEFAULT 0 COMMENT 'condizione libera 2',
  `xChar1` char(1) DEFAULT '' COMMENT 'indicatore carattere libero (default spazio)',
  `xString1` varchar(45) DEFAULT NULL COMMENT 'stringa libera 1',
  `xString2` varchar(45) DEFAULT NULL COMMENT 'stringa libera 2',
  `xString3` varchar(45) DEFAULT NULL COMMENT 'stringa libera 3'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Corsi di E-Learning\n';

-- --------------------------------------------------------

--
-- Table structure for table `e_course_acl`
--

CREATE TABLE `e_course_acl` (
  `eCourseId` bigint(20) NOT NULL COMMENT 'id corso di eLearning',
  `memberType` char(1) NOT NULL COMMENT 'Tipo di membro ACL - U = utente, G = Gruppo',
  `memberId` bigint(20) NOT NULL COMMENT 'id utente/gruppo',
  `isDeny` tinyint(1) DEFAULT 0 COMMENT 'Flag di divieto di acceso al corso - FALSE = accesso permesso - TRUE = accesso Vietato per utente/gruppo (nel caso il membro faccia parte di un gruppo autorizzato, ma non debba cmq avere accesso)',
  `accessLevel` int(11) DEFAULT 6 COMMENT 'Livello di accesso (1 digit da 0 a 9) - DEFAULT = 6\n0 = system admin\n1 = owner\n2 = amministratore\n3 = editor\n4, 5 = USI FUTURI\n6 = utente normale (DEFAULT)\n7, 8, 9 = USI FUTURI\n',
  `isRestricted` tinyint(1) DEFAULT 0 COMMENT 'flag per eventuali entry di sistema che non devono essere gestibili dagli utenti ma solo dalla piattaforma (USO FUTURO)\nTRUE = Gestibile solo dalla piattaforma (forse nascosto agli utenti)\nFALSE = Normale, visibile a tutti',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Access Control List del corso di eLearning\nPermette di definire il livello di accesso o di vietare accesso nel caso il membro faccia parte di un gruppo autorizzato';

-- --------------------------------------------------------

--
-- Table structure for table `e_course_attachment`
--

CREATE TABLE `e_course_attachment` (
  `eCourseId` bigint(20) NOT NULL COMMENT 'Id corso di eLearning',
  `fileMarker` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'ID temporale attachment',
  `fileCnt` bigint(20) NOT NULL COMMENT 'Counter attachment',
  `iconId` int(11) NOT NULL COMMENT 'ID icona da usare per rappresentare il tipo di file - prioritario su icona del file',
  `description` varchar(70) DEFAULT NULL COMMENT 'eventuale descrizione breve allegato',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Link tra corsi di eLearning e file allegati (molti a molti)';

-- --------------------------------------------------------

--
-- Table structure for table `e_course_bibliography`
--

CREATE TABLE `e_course_bibliography` (
  `eCourseId` bigint(20) NOT NULL COMMENT 'ID corso',
  `bookId` bigint(20) NOT NULL COMMENT 'ID Book',
  `text` varchar(250) DEFAULT NULL COMMENT 'eventuale testo da visualizzare come descrizione'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Bibliografia dei corsi - tabella per associazione Libro-Corso';

-- --------------------------------------------------------

--
-- Table structure for table `e_course_references`
--

CREATE TABLE `e_course_references` (
  `e_course_id` bigint(20) NOT NULL,
  `sort_number` bigint(20) NOT NULL,
  `is_book` tinyint(1) NOT NULL DEFAULT 0,
  `weblink` varchar(255) DEFAULT NULL,
  `weblink_placeholder` varchar(255) DEFAULT NULL,
  `weblink_open_in_a_new_window` tinyint(1) NOT NULL DEFAULT 1,
  `book_authors` varchar(255) DEFAULT NULL,
  `book_title` varchar(255) DEFAULT NULL,
  `book_publishing_place` varchar(255) DEFAULT NULL,
  `book_publishing_year` char(4) DEFAULT NULL,
  `last_update` datetime NOT NULL,
  `creation_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `e_course_user`
--

CREATE TABLE `e_course_user` (
  `eCourseId` bigint(20) NOT NULL COMMENT 'id corso',
  `userId` bigint(20) NOT NULL COMMENT 'id utente iscritto al corso',
  `subscriptionDate` timestamp NULL DEFAULT current_timestamp() COMMENT 'data di iscrizione al corso',
  `expirationDate` date DEFAULT NULL COMMENT 'Data di eventuale scadenza iscrizione al corso\nper Corsi scolastici in relazione alla qualifiche di Studente o corsi simili',
  `isExpired` tinyint(1) DEFAULT 0 COMMENT 'Flag iscrizione al corso scaduta = TRUE, attiva = FALSE\nper corso legati ad anno scolastico (specialmente Scuola Secondaria)',
  `isPurchased` tinyint(1) DEFAULT 0 COMMENT 'Flag corso acquistato = TRUE, iscritto gratuitamente da scuola/piattaforma = FALSE',
  `purchaseDate` timestamp NULL DEFAULT NULL COMMENT 'Data di acquisto del corso\nusare CURRENT_TIMESTAMP',
  `purchasePrice` decimal(10,2) DEFAULT 0.00 COMMENT 'Prezzo pagato per il corso',
  `purchaseDiscount1` decimal(5,2) DEFAULT 0.00 COMMENT 'sconto 1 su acquisto',
  `purchaseDiscount2` decimal(5,2) DEFAULT 0.00 COMMENT 'sconto 2 su acquisto',
  `couponUsed` varchar(20) DEFAULT NULL COMMENT 'eventuale coupon usato',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag studente cancellato',
  `isBanned` tinyint(1) DEFAULT 0 COMMENT 'Flag studente bannato (default FALSE)',
  `banDate` date DEFAULT NULL COMMENT 'eventuale data di espulsione',
  `isBlocked` tinyint(1) DEFAULT 0 COMMENT 'Flag di blocco accesso al corso per utente - se dovesse nascere esigenza di impedire ad un utente di fruire del corso',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note',
  `isXCond1` tinyint(1) DEFAULT 0 COMMENT 'Flag 1 per usi futuri',
  `isXCond2` tinyint(1) DEFAULT 0 COMMENT 'Flag 2 per usi futuri',
  `xString` varchar(45) DEFAULT NULL COMMENT 'extra String per usi futuri',
  `xDouble` double DEFAULT NULL COMMENT 'campo double per usi futuri'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Lista degli iscritti ad un corso.\nIndica se utente ha acquistato il corso (e le condizioni di acquisto applicate + eventuale coupon) e eventuale scadenza.\nPer i corsi scolastici è possibile che un utente bocciato venga reiscritto allo stesso corso (anno successivo)';

-- --------------------------------------------------------

--
-- Table structure for table `e_course_years`
--

CREATE TABLE `e_course_years` (
  `id` bigint(20) NOT NULL,
  `e_course_id` bigint(20) NOT NULL,
  `year` char(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Associa i corsi agli anni di manifesto degli studi (iscrizione dello studente)';

-- --------------------------------------------------------

--
-- Table structure for table `e_dictionary`
--

CREATE TABLE `e_dictionary` (
  `id` bigint(20) NOT NULL COMMENT 'ID E-Dizionario = ID corso',
  `name` varchar(200) DEFAULT NULL COMMENT 'eventuale nome dizionario',
  `description` tinytext DEFAULT NULL COMMENT 'eventuale descrizione dizionario',
  `languageId` char(2) NOT NULL COMMENT 'ID lingua del dizionario - default = id lingua in uso da utente che crea il dizionario - la lingua può essere modificata successivamente e si possono creare vari dizionari con varie lingue per ogni corso/lezione',
  `isVisible` tinyint(1) DEFAULT 0 COMMENT 'Flag dizionario visibile a tutti gli utenti del corso (TRUE) oppure solo agli Editor+Creatore (FALSE - default)',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag dizionario cancellato'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Dizionario per corsi di eLearning\nIl dizionario è associato ad un corso.\nEventuali dizionari orfani (non associati ne a corsi) devono essere eliminati';

-- --------------------------------------------------------

--
-- Table structure for table `e_dictionary_attachment`
--

CREATE TABLE `e_dictionary_attachment` (
  `eDictionaryId` bigint(20) NOT NULL COMMENT 'ID dizionario (di un corso di eLearning)',
  `dKey` varchar(100) NOT NULL COMMENT 'Key della voce del dizionario',
  `fileMarker` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'ID temporale attachment',
  `fileCnt` bigint(20) NOT NULL COMMENT 'Counter attachment',
  `isKey` tinyint(1) NOT NULL COMMENT 'Flag che identifica se allegato è associato alla Key (TRUE) oppure al Value (FALSE) della voce',
  `iconId` int(11) NOT NULL COMMENT 'ID icona da usare per rappresentare il tipo di file - prioritario su icona memorizzata nel record attachment',
  `description` varchar(70) DEFAULT NULL COMMENT 'eventuale descrizione breve allegato',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Link tra le voci del dizionario del corso (Key e Value) e file a (es. file audio per la pronuncia)';

-- --------------------------------------------------------

--
-- Table structure for table `e_dictionary_item`
--

CREATE TABLE `e_dictionary_item` (
  `eDictionaryId` bigint(20) NOT NULL COMMENT 'ID dizionario al quale appartengono le voci',
  `dKey` varchar(100) NOT NULL COMMENT 'Chiave item dizionario',
  `dValue` tinytext NOT NULL COMMENT 'testo item dizionario',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag chiave cancellata',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Voci del dizionario';

-- --------------------------------------------------------

--
-- Table structure for table `e_forum`
--

CREATE TABLE `e_forum` (
  `id` bigint(20) NOT NULL COMMENT 'ID Forum di eLearning = ID Lezione',
  `name` varchar(245) DEFAULT NULL COMMENT 'eventuale nome / oggetto del forum',
  `isStudentAttachmentBlocked` tinyint(1) DEFAULT 0 COMMENT 'Flag per bloccare invio di allegati da parte di tutti gli studenti (iscritti al corso) - vale per il forum e sono esclusi i docenti (in ACL quelli con accesso Editor o superiore) - default FALSE = invio allegati abilitato',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag Forum cancellato (se TRUE il forum non è più utilizzabile)',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note al messaggio - used by platform'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Blog di messaggi postati e letti da tutti i partecipanti al corso/lezione (studenti iscritti + docenti)\nUsare solo 1 singolo forum per ogni lezione/corso';

-- --------------------------------------------------------

--
-- Table structure for table `e_given_answers`
--

CREATE TABLE `e_given_answers` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `question_id` bigint(20) NOT NULL,
  `given_answer` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL,
  `creation_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `e_lesson`
--

CREATE TABLE `e_lesson` (
  `id` bigint(20) NOT NULL COMMENT 'id lezione (PK + AI)',
  `eCourseId` bigint(20) NOT NULL COMMENT 'id Corso a cui appartiene la lezione',
  `isDraft` tinyint(1) DEFAULT 1 COMMENT 'Flag in preparazione - TRUE = lezione in Preparazione (Bozza), FALSE = lezione completa',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag lezione cancellata (nel cestino) - TRUE = Cancellata, FALSE = attiva',
  `type` char(1) NOT NULL DEFAULT 'T' COMMENT 'T = Testo; V = Videolezione',
  `title` varchar(250) NOT NULL COMMENT 'Titolo / nome della lezione',
  `description` text DEFAULT NULL COMMENT 'eventuale descrizione della lezione',
  `sortNumber` tinyint(3) DEFAULT 0 COMMENT 'numero lezione per ordinamento lezioni - max 255 lezioni per corso',
  `text` longtext DEFAULT NULL COMMENT 'testo della lezione - in alternativa su può allegare un file (pdf o altro) che contiene la lezione - DA LEGGERE COL READER',
  `createDate` timestamp NULL DEFAULT current_timestamp() COMMENT 'data di creazione lezione\nusare CURRENT_TIMESTAMP',
  `creatorId` bigint(20) NOT NULL COMMENT 'ID utente creatore della lezione',
  `lastUpdate` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'data ultimo aggiornamento lezione'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Lezioni dei corsi di E-Learning\n\nStati Lezione\n1. Bozza - in preparazione\n2. Completa\n3. Cancellata (nel cestino)\n\nLe lezioni possono essere recuperate dal cestino solo se il corso non è stato pubblicato (è in stato Bozza o Completo)';

-- --------------------------------------------------------

--
-- Table structure for table `e_lesson_attachment`
--

CREATE TABLE `e_lesson_attachment` (
  `eLessonId` bigint(20) NOT NULL COMMENT 'ID lezione di eLearning',
  `fileMarker` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'ID temporale attachment',
  `fileCnt` bigint(20) NOT NULL COMMENT 'Counter attachment',
  `file_object_code` varchar(255) NOT NULL,
  `isLessonText` tinyint(1) DEFAULT 0 COMMENT 'Flag che identifica il testo della lezione - default ZERO = allegato normale, NON testo della lezione)\nAttachment usato come testo della lezione dovrebbe essere solo di tipo PDF, da leggere col Reader - in alternativa al campo Text della lezione',
  `iconId` int(11) NOT NULL COMMENT 'ID icona da usare per rappresentare il tipo di file - prioritario su icona memorizzata nel record attachment',
  `description` varchar(70) DEFAULT NULL COMMENT 'eventuale descrizione breve allegato',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Link tra lezione di eLearning e file (molti a molti) - solo uno tra gli allegati può essere il testo della lezione\nDovrebbe esserci solo un allegato alla lezione che costituisce il testo della lezione';

-- --------------------------------------------------------

--
-- Table structure for table `e_lesson_completed`
--

CREATE TABLE `e_lesson_completed` (
  `e_lesson_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `completion_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `e_lesson_e_topics`
--

CREATE TABLE `e_lesson_e_topics` (
  `e_topic_id` bigint(20) NOT NULL,
  `e_lesson_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `e_lesson_user_attachment`
--

CREATE TABLE `e_lesson_user_attachment` (
  `eCourseId` bigint(20) NOT NULL COMMENT 'ID corso di eLearning',
  `userId` bigint(20) NOT NULL COMMENT 'id utente iscritto al corso',
  `eLessonId` bigint(20) NOT NULL COMMENT 'id lezione di eLearning',
  `id` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'ID temporale attachment',
  `cnt` bigint(20) NOT NULL COMMENT 'Counter attachment',
  `iconId` int(11) NOT NULL COMMENT 'ID icona da usare per rappresentare il tipo di file - prioritario su icona memorizzata nel record attachment',
  `description` varchar(70) DEFAULT NULL COMMENT 'descrizione breve degli appunti dello studente sulla lezione',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='file degli appunti dello studente sulla lezione\nLink tra stato della lezione per lo stedente del corso e file degli appunti';

-- --------------------------------------------------------

--
-- Table structure for table `e_lesson_user_status`
--

CREATE TABLE `e_lesson_user_status` (
  `eCourseId` bigint(20) NOT NULL,
  `userId` bigint(20) NOT NULL,
  `eLessonId` bigint(20) NOT NULL COMMENT 'ID Lezione di eLearning',
  `isComplete` tinyint(1) DEFAULT 0 COMMENT 'Flag lezione completata - utente lo setta per indicare cha ha già studiato la lezione',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='stato della lezione per lo studente';

-- --------------------------------------------------------

--
-- Table structure for table `e_log`
--

CREATE TABLE `e_log` (
  `eCourseId` bigint(20) NOT NULL COMMENT 'id corso',
  `temporal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'timestamp del cambio di stato di corso/lezione - usare lo stesso timestamp per tutti i record della stesso evento',
  `seq` smallint(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'numero di sequenza dei record per le registrazioni che richiedono più record - partire da 1',
  `userId` bigint(20) NOT NULL COMMENT 'id utente che ha provocato il cambio di stato (ZERO = da programma)',
  `progId` varchar(45) DEFAULT NULL COMMENT 'ID programma/funzione che ha causato il cambio di stato',
  `changeTime` datetime DEFAULT NULL COMMENT 'Data e Ora del cambio stato',
  `courseField` varchar(45) DEFAULT NULL COMMENT 'ID campo del corso',
  `courseValuePre` varchar(255) DEFAULT NULL COMMENT 'valore precedente del campo del corso',
  `courseValuePost` varchar(255) DEFAULT NULL COMMENT 'valore successivo del campo del corso',
  `eLessonId` bigint(20) DEFAULT NULL COMMENT 'eventuale id lezione coinvolta nel cambio di stato del corso',
  `lessonField` varchar(45) DEFAULT NULL COMMENT 'id campo della lezione',
  `lessonValuePre` varchar(255) DEFAULT NULL COMMENT 'valore precedente del campo della lezione',
  `lessonValuePost` varchar(255) DEFAULT NULL COMMENT 'valore successivo del campo della lezione'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Log dei cambi stato di corsi e lezioni di eLearning\nUn cambio stato può essere descritto da più record se cambiano vari campi';

-- --------------------------------------------------------

--
-- Table structure for table `e_message`
--

CREATE TABLE `e_message` (
  `eForumId` bigint(20) NOT NULL COMMENT 'Id forum a cui appartiene il messaggio',
  `senderId` bigint(20) NOT NULL COMMENT 'ID utente mittente',
  `createDate` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'data ora di creazione del messaggio',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag messaggio cancellato',
  `year` char(4) DEFAULT NULL COMMENT 'anno del messaggio - USO FUTURO - set = anno di creationDate',
  `subject` varchar(200) DEFAULT NULL COMMENT 'oggetto del messaggio',
  `text` tinytext DEFAULT NULL COMMENT 'testo del messaggio',
  `initialSubject` varchar(200) DEFAULT NULL COMMENT 'oggetto del messaggio iniziale per tracciare le conversazioni - per documentazione',
  `initialForumId` bigint(20) DEFAULT NULL COMMENT 'ID del messaggio iniziale per tracciare le conversazioni (eForunId)',
  `initialSenderId` bigint(20) DEFAULT NULL COMMENT 'ID del messaggio iniziale per tracciare le conversazioni (senderId)',
  `initialDate` timestamp NULL DEFAULT NULL COMMENT 'ID del messaggio iniziale per tracciare le conversazioni (createDate)',
  `prevForumId` bigint(20) DEFAULT NULL COMMENT 'ID messaggio precedente in conversazione (eForumId)',
  `prevSenderId` bigint(20) DEFAULT NULL COMMENT 'ID messaggio precedente in conversazione (senderId)',
  `prevDate` timestamp NULL DEFAULT NULL COMMENT 'ID messaggio precedente in conversazione (createDate)',
  `level` int(11) DEFAULT 0 COMMENT 'Livello del messaggio per gestire le conversazioni (risposte a messaggi precedenti)\nDefault = 0 (Livello iniziale - NON ha previous)\nOgni messaggio che ha padre setta level = padre.level + 1\nMax 255 livelli'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Messaggi dei forum di eLearning.\nLa tabella prevede la possibilità di creare delle conversazioni tra gli utenti del blog\n';

-- --------------------------------------------------------

--
-- Table structure for table `e_message_attachment`
--

CREATE TABLE `e_message_attachment` (
  `eForumId` bigint(20) NOT NULL COMMENT 'ID eMessage - ID forum a cui appartiene il messaggio',
  `senderId` bigint(20) NOT NULL COMMENT 'ID eMessage - ID utente che ha scritto il messaggio',
  `createDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'ID eMessage - timer di creazione del messaggio',
  `fileMarker` datetime NOT NULL COMMENT 'file ID - time marker attachment',
  `fileCnt` bigint(20) NOT NULL COMMENT 'file ID - Counter attachment',
  `iconId` int(11) NOT NULL COMMENT 'ID icona da usare per rappresentare il tipo di file - prioritario su icona memorizzata nel record attachment',
  `descr` varchar(70) DEFAULT NULL COMMENT 'descrizione breve allegato',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuale nota'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Link tra i messaggi nel Forum e gli allegati';

-- --------------------------------------------------------

--
-- Table structure for table `e_questions`
--

CREATE TABLE `e_questions` (
  `id` bigint(20) NOT NULL,
  `e_quiz_id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `order_number` int(11) NOT NULL DEFAULT 1,
  `last_update` datetime NOT NULL,
  `creation_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `e_quizzes`
--

CREATE TABLE `e_quizzes` (
  `id` bigint(20) NOT NULL,
  `lesson_id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `last_update` datetime NOT NULL,
  `creation_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `e_request`
--

CREATE TABLE `e_request` (
  `eCourseId` bigint(20) NOT NULL COMMENT 'ID corso di eLearning',
  `temporal` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'timestamp della richiesta di approvazione del corso (PK con id corso)',
  `isProcessed1` tinyint(1) DEFAULT 0 COMMENT 'flag richiesta processata = TRUE, da esaminare = FALSE (default)',
  `isApproved1` tinyint(1) DEFAULT 0 COMMENT 'flag esito richiesta esaminata - Approvato = TRUE, non approvato = FALSE (default) ',
  `examDate` timestamp NULL DEFAULT NULL COMMENT 'Timestamp del primo esame della richiesta con Approvazione/Rigetto del corso',
  `examinerId` bigint(20) DEFAULT NULL COMMENT 'ID esaminatore della richiesta',
  `evaluation` mediumtext DEFAULT NULL COMMENT 'valutazione del corso',
  `isVerified` tinyint(1) DEFAULT 0 COMMENT 'Flag verifica approvazione richiesta, da parte del supervisore - Verificata = TRUE, da verificare = FALSE (default)',
  `isApproved2` tinyint(1) DEFAULT 0 COMMENT 'Flag approvazione del corso da parte del supervisore - Approvato = TRUE, Respinto = FALSE (default)',
  `verifyDate` timestamp NULL DEFAULT NULL COMMENT 'Timestamp della verifica da parte del supervisore',
  `supervisorId` bigint(20) DEFAULT NULL COMMENT 'ID supervisore',
  `evaluationFinal` mediumtext DEFAULT NULL COMMENT 'valutazione finale del supervisore',
  `reason` varchar(255) DEFAULT NULL COMMENT 'motivo del rifiuto/autorizzazione a pubblicare il corso - visibile a autore, compilata da esaminatore e modificabile dal supervisore',
  `note` mediumtext DEFAULT NULL COMMENT 'note',
  `isXCond1` tinyint(1) DEFAULT 0 COMMENT 'flag libero 1',
  `isXCond2` tinyint(1) DEFAULT 0 COMMENT 'flag libero 2',
  `xChar` char(1) DEFAULT '' COMMENT 'indicatore carattere libero (default spazio)',
  `xDouble` double DEFAULT NULL COMMENT 'double libero',
  `xInt` int(11) DEFAULT NULL COMMENT 'intero libero',
  `xString` varchar(45) DEFAULT NULL COMMENT 'testo libero'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Richieste di approvazione corsi di eLearning\nper rispettare le specifiche Vision2000 ci sono 2 livelli di valutazione, un esaminatore ed un supervisore';

-- --------------------------------------------------------

--
-- Table structure for table `e_timeline`
--

CREATE TABLE `e_timeline` (
  `id` bigint(20) NOT NULL COMMENT 'ID E-Timeline = ID lezione',
  `name` varchar(200) DEFAULT NULL COMMENT 'eventuale nome timeline',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag timeline cancellata',
  `description` tinytext DEFAULT NULL COMMENT 'eventuale descrizione timeline',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Timeline per lezioni di eLearning\nEventuali oggetti timeline orfani (non associati a lezioni) devono essere eliminati';

-- --------------------------------------------------------

--
-- Table structure for table `e_topics`
--

CREATE TABLE `e_topics` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL DEFAULT current_timestamp(),
  `creation_date` datetime NOT NULL,
  `e_course_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `e_user_awaiting`
--

CREATE TABLE `e_user_awaiting` (
  `eCourseId` bigint(20) NOT NULL COMMENT 'id corso',
  `userId` bigint(20) NOT NULL COMMENT 'id utente iscritto al corso in attesa di verifica del pagamento',
  `subscriptionDate` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'data di iscrizione al corso',
  `isPaymentVerified` tinyint(1) DEFAULT 0 COMMENT 'Flag pagamento verificato= TRUE, in attesa di verifica = FALSE',
  `purchaseDate` timestamp NULL DEFAULT NULL COMMENT 'Data di acquisto del corso\nusare CURRENT_TIMESTAMP',
  `purchasePrice` decimal(10,2) DEFAULT 0.00 COMMENT 'Prezzo pagato per il corso',
  `purchaseDiscount1` decimal(5,2) DEFAULT 0.00 COMMENT 'sconto 1 su acquisto',
  `purchaseDiscount2` decimal(5,2) DEFAULT 0.00 COMMENT 'sconto 2 su acquisto',
  `couponUsed` varchar(20) DEFAULT NULL COMMENT 'eventuale coupon usato',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note',
  `isXCond1` tinyint(1) DEFAULT 0 COMMENT 'Flag 1 per usi futuri',
  `isXCond2` tinyint(1) DEFAULT 0 COMMENT 'Flag 2 per usi futuri',
  `xString` varchar(45) DEFAULT NULL COMMENT 'extra String per usi futuri',
  `xDouble` double DEFAULT NULL COMMENT 'campo double per usi futuri'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Lista degli utenti che si sono iscritti ad un corso a pagamento, ma la verifica del pagamento è ancora in corso';

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` int(11) NOT NULL COMMENT 'id faq',
  `faqCategoryId` int(11) NOT NULL COMMENT 'id categoria faq',
  `relevance` int(11) DEFAULT 0 COMMENT 'grado di rilevanza - 0 = NON rilevante',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag FAQ cancellata',
  `note` mediumtext DEFAULT NULL COMMENT 'note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Elenco domande frequenti';

-- --------------------------------------------------------

--
-- Table structure for table `faq_category`
--

CREATE TABLE `faq_category` (
  `id` int(11) NOT NULL COMMENT 'id categoria FAQ',
  `superCode` char(252) DEFAULT NULL COMMENT 'codice gruppo superiore = [ superCode padre + / + ] ID in formato stringa (IDX con Duplicati VIETATI) max 12 livelli',
  `relevance` int(11) DEFAULT 0 COMMENT 'Grado di rilevanza - 0 = NON rilevante',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag categoria FAQ cancellata (TRUE) o non cancellata (FALSE - default)',
  `note` mediumtext DEFAULT NULL COMMENT 'Descrizione categoria FAQ',
  `fatherId` int(11) DEFAULT NULL COMMENT 'id categoria padre',
  `level` int(11) DEFAULT 0 COMMENT 'Livello per gestire visualizzazioni con incolonnamento differente per livello\nDefault = 0 (Livello iniziale - NON ha padre/previous)\nOgni item che ha padre/previous setta level = padre.level + 1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Categoria/Sottocategorie FAQ - le domande possono essere raggruppate in categorie';

-- --------------------------------------------------------

--
-- Table structure for table `faq_category_lang`
--

CREATE TABLE `faq_category_lang` (
  `id` int(11) NOT NULL COMMENT 'id categoria FAQ',
  `langId` char(2) NOT NULL COMMENT 'id lingua categoria faq',
  `name` varchar(100) NOT NULL COMMENT 'nome categoria faq in lingua',
  `description` varchar(245) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='nome categoria FAQ in lingua';

-- --------------------------------------------------------

--
-- Table structure for table `faq_lang`
--

CREATE TABLE `faq_lang` (
  `id` int(11) NOT NULL COMMENT 'id faq',
  `langId` char(2) NOT NULL COMMENT 'id lingua faq',
  `question` tinytext NOT NULL COMMENT 'teso domanda in lingua',
  `answer` mediumtext NOT NULL COMMENT 'testo risposta in lingua'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Testo Domande e Risposte frequenti (FAQ) in lingua';

-- --------------------------------------------------------

--
-- Table structure for table `favoriteposts`
--

CREATE TABLE `favoriteposts` (
  `post_id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `file_extension`
--

CREATE TABLE `file_extension` (
  `code` char(10) NOT NULL COMMENT 'codice estensione (es. per immagini - JPG, JPEG, GIF, PNG, ecc.)',
  `fileTypeId` char(5) DEFAULT NULL COMMENT 'ID tipo file (es. Image, Video, Audio, ecc.) - se NULL estensione sconosciuta',
  `iconId` int(11) DEFAULT NULL COMMENT 'ID icona da usare per il tipo di file - se NOT Null prioritaria su ID icona del file_type',
  `description` varchar(245) DEFAULT NULL COMMENT 'eventuale descrizione',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='estensioni file per tipo (es. Tipo IMAGE = jpg, jpeg, gif, png, ecc.)';

-- --------------------------------------------------------

--
-- Table structure for table `file_object`
--

CREATE TABLE `file_object` (
  `marker` datetime NOT NULL COMMENT 'Marca temporale (alla creazione settare come il timer di sistema)',
  `cnt` bigint(20) NOT NULL COMMENT 'counter attachment - per risolvere il caso di più allegati creati con lo stesso timer di sistema (da 0 in poi)',
  `code` varchar(255) NOT NULL COMMENT 'time()-cnt',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'flag record cancellato',
  `displayFileName` varchar(255) DEFAULT NULL COMMENT 'eventuale nome del file da visualizzare - invece di originalFileName',
  `originalFileName` varchar(255) DEFAULT NULL COMMENT 'Nome originale del file allegato',
  `codeExt` varchar(10) DEFAULT NULL COMMENT 'Estensione del nome file - ricavata dal nome originale del file - serve ad agganciare una estensione esistente per visualizzare icona corrispondente',
  `storeFileName` varchar(255) DEFAULT NULL COMMENT 'Nome ridefinito allegato per il salvataggio in area di store',
  `storePath` varchar(255) DEFAULT NULL COMMENT 'path area di store dove è memorizzato il file allegato (con nome ridefinito)',
  `storeServerName` varchar(255) DEFAULT NULL COMMENT 'Nome del server dove risiede la store area in cui è memorizzato il file allegato',
  `storeServerIp` varchar(45) DEFAULT NULL COMMENT 'indirizzo IP del server dove risiede la store area in cui è memorizzato il file allegato',
  `storeFileSize` int(11) DEFAULT -1 COMMENT 'dimensione del file allegato (se -1 dimensione NON valorizzata)',
  `storeFileDateTime` datetime DEFAULT NULL COMMENT 'Data e ora del file allegato nella store area (dati di sistema)',
  `ownerId` bigint(20) NOT NULL COMMENT 'ID utente proprietario del file (utente che ha creato il file)',
  `checksumId` char(10) DEFAULT NULL COMMENT 'algoritmo di checksum utilizzato - NULL = checksum NON utilizzato',
  `checksumString` varchar(255) DEFAULT NULL COMMENT 'Checksum del file allegato - decidere quando calcolare il checksum',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note sul file allegato'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Elenco file utente - allegati a messaggi / eventi / oggetti di eLearning e del Desktop utente (scrivania personale) - Permette di memorizzare un file solo una volta e di agganciarlo a vari oggetti (lezioni, messaggi, eventi) più volte';

-- --------------------------------------------------------

--
-- Table structure for table `file_type`
--

CREATE TABLE `file_type` (
  `id` char(5) NOT NULL COMMENT 'codice del tipo di file (es. IMAGE, PDF, TXT, VIDEO, AUDIO, ecc.)',
  `code` varchar(45) DEFAULT NULL COMMENT 'eventuale codice',
  `iconId` int(11) DEFAULT NULL COMMENT 'ID icona del tipo file (es. Immagini) - da usare come default se file_extension non ha ID icona associata',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tipi (classe) di file (es. IMAGE, PDF, TXT, VIDEO, AUDIO, ecc.)';

-- --------------------------------------------------------

--
-- Table structure for table `file_type_lang`
--

CREATE TABLE `file_type_lang` (
  `id` char(5) NOT NULL COMMENT 'Id tipo file (immagine, audio, video, ecc.)',
  `langId` char(2) NOT NULL COMMENT 'Id lingua',
  `name` varchar(45) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='nome dei tipi di file in lingua (es. Images, Immagini, ecc.)';

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `project_id` bigint(20) UNSIGNED DEFAULT NULL,
  `task_id` bigint(20) DEFAULT NULL,
  `creation_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `general_auth`
--

CREATE TABLE `general_auth` (
  `id` int(11) NOT NULL COMMENT 'ID record - ci deve essere SOLO UN RECORD',
  `isBuyEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazioen BUYER - si possono fare acquisti',
  `isEditEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione EDITOR - si possono creare e modificare Corsi di eLearning ed eBook',
  `isPublishEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione PUBLISHER - si possono pubblicare (rendere disponibili a utenti) eBook e Corsi di eLearning (per uso Interno ed Esterno)',
  `isBookULEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione BOOK-ULOADER - si può fare UpLoad di eBook in libreria personale o di Organizzazione',
  `isBookDLEnable` tinyint(1) DEFAULT 1 COMMENT 'Autorizzazione BOOK-DOWNLOADER - si può fare DownLoad di eBook da libreria personale o di Organizzazione',
  `isPurchasedBookDLEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione BOOK-DLOADER-BUY - si può fare il download di libri propri acquistati dalla piattaforma (questa azione blocca la rivendita, se prevista, alla piattaforma come usato)',
  `isUploadedBookDLEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione BOOK-DLOADER-UPLOAD - si può fare il download di libri propri caricati con upload',
  `isCreatedBookDLEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione BOOK-DLOADER-CREATE - si può fare il download di libri propri creati',
  `isFileULEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione FILE-ULOADER - si può fare upload di file (NO eBook) nel desktop personale (o di Organizzazione)',
  `isFileDLEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione FILE-DLOADER - si può fare il download di file (NO eBook) dal desktop personale (o di Organizzazione)',
  `isBookWREnableIN` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione BOOK-WRITE-IN - si possono gestire (creare e pubblicare) eBook per uso INTERNO',
  `isBookWREnableOUT` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione BOOK-WRITE-OUT - si possono gestire (creare e pubblicare) eBook per uso ESTERNO',
  `isLearnWREnableIN` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione LEARN-WRITE-IN - si possono gestire (creare e pubblicare) cordi di eLearning per uso INTERNO',
  `isLearnWREnableOUT` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione LEARN-WRITE-OUT - si possono gestire (creare e pubblicare) cordi di eLearning per uso ESTERNO',
  `isBookRDEnableIN` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione BOOK-READ-IN - si possono prendere in prestito eBook INTERNI',
  `loanStrategyIdIN` int(11) DEFAULT NULL COMMENT 'ID Strategia di prestito Interna - da usare per prestito eBook INTERNO (da Ente a utenti Interni)',
  `isBookRDEnableOUT` tinyint(1) DEFAULT 1 COMMENT 'Autorizzazione BOOK-READ-OUT - si possono prendere in prestito eBook ESTERNI',
  `loanStrategyIdOUT` int(11) DEFAULT NULL COMMENT 'ID Strategia Esterna - da usare per prestito eBook ESTERNO (da Piattaforma a utenti)',
  `isLearnRDEnableIN` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione LEARN-READ-IN - può iscriversi a corsi di eLearning INTERNI (per utenti interni di Organizzazione)',
  `isLearnRDEnableOUT` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione LEARN-READ-OUT - può iscriversi a corsi di eLearning ESTERNI (per tutti gli utenti della piattaforma)',
  `isInternalUserEnable` tinyint(1) DEFAULT 0 COMMENT 'Abilitazione ad averre utenti Interni - valido solo per Enti',
  `isResaleEnabled` tinyint(1) DEFAULT 0 COMMENT 'Abilitazione alla rivendita di eBook alla piattaforma come usato (se prevista)',
  `isSurveyCreator` tinyint(1) DEFAULT 0 COMMENT 'Abilitazione a creare Sondaggi',
  `isReviewer` tinyint(1) DEFAULT 1 COMMENT 'Abilitazione a scrivere Recensioni sui libri',
  `isEventAttachmentEnabled` tinyint(1) DEFAULT 1 COMMENT 'Abilitazione ad allegare file agli eventi',
  `isGroupCreationEnabled` tinyint(1) DEFAULT 1 COMMENT 'Abilitazione a creare Gruppi',
  `isGroupCommentEnabled` tinyint(1) DEFAULT 1 COMMENT 'Abilitazione a scrivere commenti sui gruppi',
  `isGroupMexAttachmentEnabled` tinyint(1) DEFAULT 1 COMMENT 'Abilitazione a allegare file ai Messaggi/Comment che scrive sui gruppi',
  `isXAuth1` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione Libera 1',
  `isXAuth2` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione Libera 2',
  `isXAuth3` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione Libera 3',
  `isXAuth4` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione Libera 4',
  `isXAuth5` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione Libera 5'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Permessi/Autorizzazioni generali della piattaforma (indica quali funzioni sono permesse nella piattaforma)';

-- --------------------------------------------------------

--
-- Table structure for table `groupchatfiles`
--

CREATE TABLE `groupchatfiles` (
  `id` bigint(20) NOT NULL,
  `group_id` bigint(20) NOT NULL,
  `groupchat_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `filename` varchar(250) DEFAULT NULL,
  `filepath` varchar(250) DEFAULT NULL,
  `type` varchar(250) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `groupchats`
--

CREATE TABLE `groupchats` (
  `id` bigint(20) NOT NULL,
  `parentgroupchat_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) NOT NULL,
  `group_id` bigint(20) NOT NULL,
  `content` varchar(250) DEFAULT NULL,
  `creation_date` datetime NOT NULL,
  `isSeen` tinyint(1) NOT NULL DEFAULT 0,
  `last_update` datetime DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `groupfileposts`
--

CREATE TABLE `groupfileposts` (
  `id` bigint(20) NOT NULL,
  `group_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `groupfiles`
--

CREATE TABLE `groupfiles` (
  `id` bigint(20) NOT NULL,
  `groupfilepost_id` bigint(20) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `size` bigint(20) DEFAULT NULL,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `groupmembers`
--

CREATE TABLE `groupmembers` (
  `id` bigint(20) NOT NULL,
  `group_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `member_role` char(1) DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `groupnotes`
--

CREATE TABLE `groupnotes` (
  `post_id` bigint(20) NOT NULL,
  `group_id` bigint(20) DEFAULT NULL,
  `post_data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `grouppostfiles`
--

CREATE TABLE `grouppostfiles` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `group_id` bigint(20) DEFAULT NULL,
  `grouppost_id` bigint(20) DEFAULT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `size` bigint(20) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `groupposts`
--

CREATE TABLE `groupposts` (
  `id` bigint(20) NOT NULL,
  `group_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `post_data` varchar(255) DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `last_update` datetime DEFAULT NULL,
  `isShared` tinyint(1) NOT NULL DEFAULT 0,
  `isNote` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `groupposttagmembers`
--

CREATE TABLE `groupposttagmembers` (
  `id` bigint(20) NOT NULL,
  `group_id` bigint(20) DEFAULT NULL,
  `post_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `comment_id` bigint(20) DEFAULT NULL,
  `reply_id` bigint(20) DEFAULT NULL,
  `isPost` tinyint(1) NOT NULL DEFAULT 0,
  `isComment` tinyint(1) NOT NULL DEFAULT 0,
  `isReply` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `creatorId` bigint(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `group_profileFilepath` varchar(255) DEFAULT NULL,
  `group_profileFilename` varchar(255) DEFAULT NULL,
  `group_backgroundimagepath` varchar(255) DEFAULT NULL,
  `group_backgroundimagename` varchar(255) DEFAULT NULL,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `group_connector`
--

CREATE TABLE `group_connector` (
  `groupId` bigint(20) NOT NULL COMMENT 'ID gruppo',
  `schoolId` bigint(20) DEFAULT NULL COMMENT 'ID Scuola - ( se associato a organizzazione - istituto principale di riferimento o Sede legale/principale universita)',
  `teachingAreaId` bigint(20) DEFAULT NULL COMMENT 'ID area di insegnamento (UNI-Facolta, SS2-indirizzo)',
  `courseId` bigint(20) DEFAULT NULL COMMENT 'ID Corso di Studi (Laurea UNI, indirizzo SS2)',
  `courseSectionId` varchar(45) DEFAULT NULL COMMENT 'sezione del corso',
  `matterId` bigint(20) DEFAULT NULL COMMENT 'ID materia del corso',
  `courseYear` char(1) DEFAULT NULL COMMENT 'Anno di corso (primo, secondo, terzo, ...) - Classe per SS1-SS2 - NULL= qualsiasi anno',
  `eCourseId` bigint(20) DEFAULT NULL COMMENT 'ID corso di eLearning - se gruppo del corso di eLearning'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='connettore Gruppo-Ambiente scolastico (con tutti i campi valorizzati), oppure con una orgaizzazione';

-- --------------------------------------------------------

--
-- Table structure for table `group_member`
--

CREATE TABLE `group_member` (
  `groupId` bigint(20) NOT NULL COMMENT 'ID gruppo',
  `memberType` char(1) NOT NULL COMMENT 'Tipo membro del gruppo - U = User, G = Group',
  `memberId` bigint(20) NOT NULL COMMENT 'ID Membro - in base al tipo\n- tipo <U> = Id Utente\n- tipo <G> = Id Gruppo',
  `accessLevel` int(11) DEFAULT 6 COMMENT 'Livello di accesso (1 digit da 0 a 9) - DEFAULT = 6\n0 = system admin\n1 = owner\n2 = amministratore\n3, 4, 5 = USI FUTURI\n6 = utente normale (DEFAULT)\n7, 8, 9 = USI FUTURI',
  `joinDate` timestamp NULL DEFAULT NULL COMMENT 'Data di adesione al gruppo - a seguito di invito o richiesta o adesione autonoma',
  `sponsorId` bigint(20) DEFAULT NULL COMMENT 'ID utente che ha invitato o accettato la richiesta di adesione (x statistica)',
  `isInvitation` tinyint(1) DEFAULT 1 COMMENT 'Flag invito - TRUE = membro invitato nel gruppo, in attesa di adesione di utente invitato',
  `invitationDate` timestamp NULL DEFAULT NULL COMMENT 'eventuale data di invito ad aderire al gruppo',
  `isMembershipRequest` tinyint(1) DEFAULT 0 COMMENT 'Flag richiesta di adesione - TRUE = richiesta di adesione in attesa autorizzazione da amministratore del gruppo',
  `membershipRequestDate` timestamp NULL DEFAULT NULL COMMENT 'eventuale data della richiesta di adesione al gruppo',
  `isBanned` tinyint(1) DEFAULT 0 COMMENT 'Flag Banned (divieto di far parte del gruppo) - TRUE = utente espulso',
  `banDate` timestamp NULL DEFAULT NULL COMMENT 'Eventuale data di espulsione',
  `bannerId` bigint(20) DEFAULT NULL COMMENT 'ID utente (admin o owner o sysadm) che bannato utente',
  `banReason` varchar(250) DEFAULT NULL COMMENT 'motivo espulsione',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='membri per gruppo - permette di definire il livello di accesso o di vietare accesso nel caso il membro faccia parte di un gruppo autorizzato';

-- --------------------------------------------------------

--
-- Table structure for table `group_message`
--

CREATE TABLE `group_message` (
  `groupId` bigint(20) NOT NULL COMMENT 'ID Gruppo',
  `senderId` bigint(20) NOT NULL COMMENT 'ID utente autore del commento',
  `createDate` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'timestamp del messaggio - più utenti possono scrivere messaggi su differenti gruppi nello stesso momento',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'flag messaggio cancellato - se si cancella un padre si devono cancellare tutti i figli',
  `text` mediumtext NOT NULL COMMENT 'testo del messaggio',
  `langId` char(2) NOT NULL COMMENT 'ID lingua del messaggio (tbl Language) - lingua usata da utente quando ha scritto il messaggio',
  `fatherGroupId` bigint(20) DEFAULT NULL COMMENT 'ID gruppo del messaggio padre',
  `fatherSenderId` bigint(20) DEFAULT NULL COMMENT 'ID sender del messaggio padre',
  `fatherCreateDate` timestamp NULL DEFAULT NULL COMMENT 'Creation Date del messaggio padre',
  `level` int(11) DEFAULT 0 COMMENT 'Livello per gestire visualizzazioni con incolonnamento differente per livello\nDefault = 0 (Livello iniziale - NON ha padre/previous)\nOgni item che ha padre/previous setta level = padre.level + 1',
  `referenceGroupId` bigint(20) DEFAULT NULL COMMENT 'ID Gruppo del messaggio iniziale della conversazione',
  `referenceSenderId` bigint(20) DEFAULT NULL COMMENT 'ID sender del messaggio iniziale della conversazione',
  `referenceCreateDate` timestamp NULL DEFAULT NULL COMMENT 'Creation Date del messaggio iniziale della conversazione'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Messaggi del gruppo\nSolo i membri del gruppo e gli operatori possono vedere i messaggi del gruppo';

-- --------------------------------------------------------

--
-- Table structure for table `group_message_attachment`
--

CREATE TABLE `group_message_attachment` (
  `groupId` bigint(20) NOT NULL COMMENT 'ID gruppo',
  `senderId` bigint(20) NOT NULL COMMENT 'ID sender del messaggio',
  `createDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'timestamp di creazione del messaggio ',
  `fileMarker` datetime NOT NULL COMMENT 'file marker attachment',
  `fileCnt` bigint(20) NOT NULL COMMENT 'counter attachment',
  `iconId` int(11) NOT NULL COMMENT 'ID icona da usare per rappresentare il tipo di file - prioritario su icona memorizzata nel record attachment',
  `description` varchar(70) DEFAULT NULL COMMENT 'eventuale descrizione breve allegato',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Allegati al messaggio del gruppo';

-- --------------------------------------------------------

--
-- Table structure for table `group_message_favorite`
--

CREATE TABLE `group_message_favorite` (
  `groupId` bigint(20) NOT NULL COMMENT 'ID grp message (id gruppo)',
  `senderId` bigint(20) NOT NULL COMMENT 'ID grp message (ID sender)',
  `createDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'ID grp message (message creation date)',
  `userId` bigint(20) NOT NULL COMMENT 'ID utente che ha selezionato il messaggio come preferito',
  `isSystem` tinyint(1) DEFAULT 0 COMMENT 'Flag preferenza settata dal sistema (operatore) che user non può rimuovere - default FALSE - USO FUTURO',
  `favoriteDate` timestamp NULL DEFAULT current_timestamp() COMMENT 'Timestamp di quando il messaggio viene selezionato come preferito'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='messaggi di gruppo preferiti da utente - se utente toglie la preferenza al messaggio, eliminare il record - tenere conto dello stato di cancellazione (flag isDeleted) del messaggio di gruppo';

-- --------------------------------------------------------

--
-- Table structure for table `group_object`
--

CREATE TABLE `group_object` (
  `id` bigint(20) NOT NULL COMMENT 'ID gruppo',
  `superCode` char(252) DEFAULT NULL COMMENT 'codice gruppo superiore = [ superCode padre + / + ] ID in formato stringa (IDX con Duplicati VIETATI) max 12 livelli',
  `name` varchar(120) NOT NULL COMMENT 'Nome del gruppo',
  `description` varchar(245) DEFAULT NULL COMMENT 'descrizione del gruppo',
  `description2` varchar(245) DEFAULT NULL COMMENT 'descrizione 2 gruppo',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag gruppo Chiuso/Cancellato - TRUE = cancellato, FALSE = attivo',
  `creatorId` bigint(20) NOT NULL COMMENT 'ID user creatore del gruppo (Alla creazione del gruppo, il creatore è anche amministratore)',
  `createDate` timestamp NULL DEFAULT current_timestamp() COMMENT 'timestamp di creazione del gruppo',
  `visibility` char(1) DEFAULT 'P' COMMENT 'Indicatore visibilità - P = pubblico, V = privato, S = Segreto, E = E-Learning',
  `isSchool` tinyint(1) DEFAULT 0 COMMENT 'Flag gruppo scolastico/istituzionale - TRUE = scolastico, FALSE = normale (default)',
  `isRestricted` tinyint(1) DEFAULT 0 COMMENT 'Flag gruppo ad accesso riservato - USO FUTURO - si potrebbe usare per i gruppi gestiti dal programma che non devono essere visibili agli utenti normali, ma solo agli utenti (admin/operatori) autorizzati della piattaforma',
  `fatherId` bigint(20) DEFAULT NULL COMMENT 'id gruppo padre - se not NULL il gruppo è un sottogruppo',
  `level` int(11) DEFAULT 0 COMMENT 'Livello per gestire visualizzazioni con incolonnamento differente per livello\nDefault = 0 (Livello iniziale - NON ha padre/previous)\nOgni item che ha padre/previous setta level = padre.level + 1',
  `isMembershipRequestAllowed` tinyint(1) DEFAULT 1 COMMENT 'Flag richiesta di adesione permessa - TRUE = gli utenti non membri possono richiedere adesione al gruppo, FALSE = NON è permesso chiedere di aderire al gruppo (Solo gli utenti possono chiedere di aderire, NON i gruppi)',
  `isInvitationAllowed` tinyint(1) DEFAULT 1 COMMENT 'Flag gruppo con invito utenti permesso - TRUE = si possono invitare utenti nel gruppo, FALSE = NON è permesso invitare utenti nel gruppo (Solo gli utenti possono essere invitati, NON i gruppi)',
  `isBanAllowed` tinyint(1) DEFAULT 1 COMMENT 'Flag gruppo con espulsione membri ammessa - TRUE = espulsione ammessa, FALSE = espulsione NON permessa (eventualmente per gruppi scolastici o simili)\nSolo i membri utenti possono essere espulsi, NON i gruppi\nEspulsione = inserimento utente in ACL con flag DENY settato',
  `imageFileName` varchar(255) DEFAULT NULL COMMENT 'Nome file immagine/logo - da usare in alternativa al campo Blob',
  `imageFilePath` varchar(255) DEFAULT NULL COMMENT 'Path file immagine/logo - da usare in alternativa al campo Blob',
  `imageFileServer` varchar(255) DEFAULT NULL COMMENT 'Server dove memorizzare il file immagine/logo - da usare in alternativa al campo Blob',
  `image` blob DEFAULT NULL COMMENT 'immagine/logo gruppo - da usare in alternativa ai campi FileName, FilePath, FileServer immagine',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Gruppi e Sottogruppi applicazione (con fatherId NON nullo)\n(parola group riservata)\n\nOgni gruppo può avere SOLO un amministratore (che può essere un utente diverso dal creatore, ma nominato dal creatore';

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` bigint(20) NOT NULL,
  `holiday_name` varchar(250) DEFAULT NULL,
  `holiday_date` datetime NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `icon`
--

CREATE TABLE `icon` (
  `id` int(11) NOT NULL COMMENT 'id icona',
  `iconTypeId` int(11) NOT NULL COMMENT 'ID tipologia icona',
  `isReserved` tinyint(1) DEFAULT 0 COMMENT 'Flag - icona riservata - TRUE = Riservata non visibile a utente, FALSE (default) = utilizzabile da utente',
  `isSystem` tinyint(1) DEFAULT 0 COMMENT 'Flag icona di sistema - NON si possono cancellare per nessun motivo in quanto sono usate nel codice',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'flag record cancellato',
  `fileName` varchar(255) NOT NULL COMMENT 'Nome del file icona',
  `filePath` varchar(255) DEFAULT '' COMMENT 'Path del file icona (nel folder delle icone - come definito nella tbl di configurazione) - default = stringa vuota',
  `note` mediumtext DEFAULT NULL COMMENT 'note eventuali'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='icone di sistema usate per eventi, e altro\nicone fornite da piattaforma non personalizzabili da utente';

-- --------------------------------------------------------

--
-- Table structure for table `icon_type`
--

CREATE TABLE `icon_type` (
  `id` int(11) NOT NULL COMMENT 'id tipologia icona',
  `code` varchar(45) DEFAULT NULL COMMENT 'eventuale codice',
  `defaultIconId` int(11) DEFAULT NULL COMMENT 'ID icon di default per il tipo - settare la prima icona creata per il tipo - modificabile in seguito',
  `extension` varchar(45) DEFAULT NULL,
  `note` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tipologie di icone ';

-- --------------------------------------------------------

--
-- Table structure for table `icon_type_lang`
--

CREATE TABLE `icon_type_lang` (
  `id` int(11) NOT NULL COMMENT 'id tipologia icona',
  `langId` char(2) NOT NULL COMMENT 'ID lingua',
  `name` varchar(100) NOT NULL COMMENT 'nome tipologia icona in lingua',
  `description` varchar(245) DEFAULT NULL COMMENT 'descrizione tipologia icona in lingua'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='nomi e descrizioni tipologia icone in lingua';

-- --------------------------------------------------------

--
-- Table structure for table `industry`
--

CREATE TABLE `industry` (
  `id` int(11) NOT NULL COMMENT 'id settore',
  `superCode` char(252) DEFAULT NULL COMMENT 'codice gruppo superiore = [ superCode padre + / + ] ID in formato stringa (IDX con Duplicati VIETATI) max 12 livelli',
  `code` char(12) DEFAULT NULL COMMENT 'Codice secondo specifica ATECO 2007 (Istat) derivata dalla NACE REV2 (Eurostat) - Se definito da utente settare a NULL',
  `parentCode` char(12) DEFAULT NULL COMMENT 'Codice Padre (livello superiore) - secondo specifica ATECO 2007 (Istat) derivata dalla NACE REV2 (Eurostat) - se settore definito da utente potrebbe essere NULL',
  `refISIC` char(12) DEFAULT NULL COMMENT 'Riferimento alla specifica di classificazione delle Nazioni Unite - International Standard Industrial Classification of All Economic Activities (ISIC), Revision 4',
  `isUserDefined` tinyint(1) DEFAULT 0 COMMENT 'Flag Settore di attività definito da utente - deafule FALSE = da tabelle ATECO, NACE, ISIC (se TRUE non visualizzare per altre organizzazioni)',
  `fatherId` int(11) DEFAULT NULL COMMENT 'eventuale ID settore industriale padre',
  `level` int(11) DEFAULT 0 COMMENT 'Livello per gestire visualizzazioni con incolonnamento differente per livello\nDefault = 0 (Livello iniziale - NON ha padre/previous)\nOgni item che ha padre/previous setta level = padre.level + 1',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note',
  `xChar10x` char(10) DEFAULT NULL COMMENT 'char10 libero',
  `isXCond1` tinyint(1) DEFAULT 0 COMMENT 'flag libero 1',
  `xString` varchar(45) DEFAULT NULL COMMENT 'stringa di testo libero'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Settore di Attività/Settore industriale (uso statistico)\n- seguire specifiche ATECO 2007 (Istat) e NACE REV 2 (Eurostat) e ISIC REV 4\n\nesempi\n- Istruzione\n- bancario\n- assicurazioni\n- editoriale\n- media\n- enti pubblici\n- viaggi e trasporti';

-- --------------------------------------------------------

--
-- Table structure for table `industry_lang`
--

CREATE TABLE `industry_lang` (
  `id` int(11) NOT NULL COMMENT 'ID settore industriale / Settore di attività',
  `langId` char(2) NOT NULL COMMENT 'ID lingua',
  `description` varchar(245) NOT NULL COMMENT 'Descrizione Settore di attività in lingua (secondo specifiche ATECO 2007 derivate dalla NACE REV 2 di eurostat) - oppure descrizione utente',
  `inclusion` mediumtext DEFAULT NULL COMMENT 'Inclusioni 1 (this item includes)',
  `inclusion2` mediumtext DEFAULT NULL COMMENT 'Inclusioni 2 (this item also includes)',
  `exclusion` mediumtext DEFAULT NULL COMMENT 'Esclusioni (this item excludes)',
  `ruling` mediumtext DEFAULT NULL COMMENT 'decisioi di classificazione (aka regolamentazione)',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali ulteriori note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='nomi dei settori industriali (di attivita) in lingua';

-- --------------------------------------------------------

--
-- Table structure for table `invoiceitems`
--

CREATE TABLE `invoiceitems` (
  `id` bigint(20) NOT NULL,
  `itemId` bigint(20) NOT NULL,
  `invoiceId` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) NOT NULL,
  `company_id` bigint(20) DEFAULT NULL,
  `projectId` bigint(20) DEFAULT NULL,
  `client_id` bigint(20) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'Invia',
  `invoice_date` datetime NOT NULL DEFAULT current_timestamp(),
  `due_date` datetime DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `billing_address` varchar(255) DEFAULT NULL,
  `discount_percentage` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `isced_level`
--

CREATE TABLE `isced_level` (
  `id` char(2) NOT NULL COMMENT 'id livello isced (0-8)',
  `name` varchar(45) NOT NULL COMMENT 'nome livello isced',
  `note` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='elenco livelli ISCED 2011\n\n0 = Pre-Primary\n1 = Primary\n2 = Lower Secondary\n3 = Upper Secondary\n4 = Vocational ???\n5 = Technical ???\n6 = Bechelor / Graduation\n7 = Master\n8 = Doctoral';

-- --------------------------------------------------------

--
-- Table structure for table `iva_code`
--

CREATE TABLE `iva_code` (
  `id` char(6) NOT NULL COMMENT 'ID codice IVA',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'flag record cancellato (se true)',
  `countryId` char(2) NOT NULL COMMENT 'ID Country in cui si applica il codice IVA (secondo la legislazione della country)',
  `description` varchar(45) NOT NULL COMMENT 'Descrizione codice IVA',
  `ivaPerc` decimal(5,2) NOT NULL COMMENT 'Percentuale IVA',
  `nonDeductiblePerc` decimal(5,2) NOT NULL COMMENT 'Percentuale IVA indetraibile',
  `isIvaFree` tinyint(1) DEFAULT 0 COMMENT 'Indicatore codice IVA Esente (se TRUE), o non esente se FALSE (default)',
  `isIvaPlafond` tinyint(1) DEFAULT 0 COMMENT 'Indicatore Codice IVA Plafond (se TRUE) - default false',
  `isGift` tinyint(1) DEFAULT 0 COMMENT 'Indicatore Tipo Omaggio (se TRUE)',
  `isNonDeductible` tinyint(1) DEFAULT 0 COMMENT 'Indicatore Codice IVA indetraibile (se TRUE)',
  `isXCond1` tinyint(1) DEFAULT 0 COMMENT 'Indicatore libero 1',
  `isXCond2` tinyint(1) DEFAULT 0 COMMENT 'Indicatore libero 2',
  `isXCond3` tinyint(1) DEFAULT 0 COMMENT 'Indicatore libero 3'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabella codici IVA\nPotrebbero esserci Codici IVA particolari per uno stato, quindi deve essere agganciata anche alla nazione';

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `id` char(2) NOT NULL COMMENT 'Language Code (ISO 639-2)',
  `isEnabled` tinyint(1) DEFAULT 0 COMMENT 'Flag abilitazione utilizzo lingua',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag record cancellato',
  `note` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Lingue supportate dalla piattaforma';

-- --------------------------------------------------------

--
-- Table structure for table `lc_annotation`
--

CREATE TABLE `lc_annotation` (
  `userId` bigint(20) NOT NULL COMMENT 'ID utente',
  `bookId` bigint(20) NOT NULL COMMENT 'ID eBook',
  `seq` int(11) NOT NULL COMMENT 'Numero di versione file ebook (se ce ne sono 1+)',
  `idTime` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'ID annotazione per Utente/eBook - uso timestamp per generare automaticamente una valore alla creazione record che deve essere unico SOLO SE legato a UserId e BookId',
  `pageNumber` int(11) NOT NULL COMMENT 'numero di pagina in eBook',
  `sideLeft` double NOT NULL COMMENT 'coordinata X annotazione',
  `top` double NOT NULL COMMENT 'coordinata Y annotazione',
  `pageLeft` double NOT NULL COMMENT 'coordinata X inizio pagina - top-left corner',
  `pageTop` double NOT NULL COMMENT 'coordinata Y inizio pagina - top-left corner',
  `pageHeight` double NOT NULL COMMENT 'Altezza pagina',
  `pageWidth` double NOT NULL COMMENT 'Larghezza pagina',
  `zoom` double NOT NULL COMMENT 'fattore di zoom',
  `title` varchar(150) NOT NULL COMMENT 'titolo annotazione - se non inserita da utente prendere i primi 150 char del testo annotazione e usarli come titolo',
  `text` mediumtext NOT NULL COMMENT 'testo annotazione'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='LearnChance - Annotazioni utente su ebook';

-- --------------------------------------------------------

--
-- Table structure for table `lc_hand_write`
--

CREATE TABLE `lc_hand_write` (
  `userId` bigint(20) NOT NULL COMMENT 'ID utente',
  `bookId` bigint(20) NOT NULL COMMENT 'ID eBook',
  `seq` int(11) NOT NULL COMMENT 'Numero di versione file ebook (se ce ne sono 1+)',
  `pointIdTime` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'ID punto del disegno a mano libera per Utente/eBook - uso timestamp per generare automaticamente un valore alla creazione record che deve essere unico SOLO SE legato a UserId e BookId',
  `lineId` char(20) NOT NULL COMMENT 'ID Linea di cui fa parte il punto\nSettato col primo punto e uguale per tutti i punti della linea\nInserire pointIdTime convertito in stringa col formato "YYYYMMDDHHMMSS" se possibile, \naltrimenti "YYYY-MM-DD HH:MM:SS"',
  `pageNumber` int(11) NOT NULL COMMENT 'numero di pagina in eBook',
  `sideLeft` double NOT NULL COMMENT 'coordinata X punto',
  `top` double NOT NULL COMMENT 'coordinata Y punto',
  `pageLeft` double NOT NULL COMMENT 'coordinata X inizio pagina - top-left corner',
  `pageTop` double NOT NULL COMMENT 'coordinata Y inizio pagina - top-left corner',
  `pageHeight` double NOT NULL COMMENT 'altezza pagina',
  `pageWidth` double NOT NULL COMMENT 'larghezza pagina',
  `zoom` double NOT NULL COMMENT 'fattore di zoom'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='LearnChance - Disegni a mano libera utente su ebook';

-- --------------------------------------------------------

--
-- Table structure for table `lc_selection`
--

CREATE TABLE `lc_selection` (
  `userId` bigint(20) NOT NULL COMMENT 'ID utente',
  `bookId` bigint(20) NOT NULL COMMENT 'ID eBook',
  `seq` int(11) NOT NULL COMMENT 'Numero di versione file ebook (se ce ne sono 1+)',
  `idTime` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'ID evidenziazione per Utente/eBook - uso timestamp per generare automaticamente una valore alla creazione record che deve essere unico SOLO SE legato a UserId e BookId',
  `idSelectionGroup` char(20) NOT NULL COMMENT 'cosa rappresenta ? - testo selezionato',
  `pageNumber` int(11) NOT NULL COMMENT 'numero di pagina in eBook',
  `sideLeft` double NOT NULL COMMENT 'cosa rappresenta ? - coordinata selezione',
  `sideRight` double NOT NULL COMMENT 'cosa rappresenta ? - coordinata selezione',
  `top` double NOT NULL COMMENT 'cosa rappresenta ? - coordinata selezione',
  `bottom` double NOT NULL COMMENT 'cosa rappresenta ? - coordinata selezione',
  `height` double NOT NULL COMMENT 'cosa rappresenta ? - altezza selezione --> RIDONDANTE = abs(top - bottom)',
  `width` double NOT NULL COMMENT 'cosa rappresenta ? - larghezza selezione--> RIDONDANTE = abs(sideLeft - sideRight)',
  `pageLeft` double NOT NULL COMMENT 'coordinata X inizio pagina - top-left corner',
  `pageTop` double NOT NULL COMMENT 'coordinata Y inizio pagina - top-left corner',
  `pageRight` double NOT NULL COMMENT 'coordinata X fine pagina - bottom-right corner',
  `pageBottom` double NOT NULL COMMENT 'coordinata Y fine pagina - bottom-right corner',
  `pageHeight` double NOT NULL COMMENT 'cosa rappresenta ? - altezza pagina --> RIDONDANTE = abs(pageTop - pageBottom)',
  `pageWidth` double NOT NULL COMMENT 'cosa rappresenta ? - larghezza pagina --> RIDONDANTE = abs(pageLeft - pageRight)',
  `zoom` double NOT NULL COMMENT 'fattore di zoom',
  `color` varchar(10) NOT NULL COMMENT 'codice colore (stile CSS ?)',
  `alpha` double NOT NULL COMMENT 'valore canale Alpha colore (Trasparenza)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='LearnChance - Evidenziazioni utente su ebook';

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `company_id` bigint(20) DEFAULT NULL,
  `leavetype` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `fromdate` datetime DEFAULT NULL,
  `todate` datetime DEFAULT NULL,
  `leavereason` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  `medical_number` varchar(11) DEFAULT NULL,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` char(1) CHARACTER SET latin1 NOT NULL DEFAULT 'N',
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  `isSeen` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `library`
--

CREATE TABLE `library` (
  `id` bigint(20) NOT NULL COMMENT 'ID Libreria (PK + type) - Corrisponde a ID <U>tente o ID O<R>ganizzazione + Tipo (U,R) - in caso di Libreria della Piattaforma usare Tipo = P e ID possibilmente ZERO o un valore diverso se ci possono essere più librerie differenti della piattaforma',
  `type` char(1) NOT NULL COMMENT 'Tipo libreria (PK + id) - U = Utente, R = Organizzazione, P = Piattaforma',
  `name` varchar(45) NOT NULL COMMENT 'Nome Libreria (es. dip. Informatica, reparto sviluppo, reparto amministrazione)',
  `description` varchar(245) DEFAULT NULL COMMENT 'nome/descrizione della libreria',
  `superCode` char(254) DEFAULT NULL COMMENT 'codice gruppo superiore = [ superCode padre + / + ] ID in formato stringa (IDX con Duplicati VIETATI)\n(superCode = ID + Type , quindi 21 char) - supporta max 11 livelli',
  `loanStrategyId` int(11) DEFAULT NULL COMMENT 'ID strategia di prestito da applicare ai prestiti della libreria - NULL per librerie personali degli utenti',
  `schoolTypeId` int(11) DEFAULT NULL COMMENT 'eventuale ID Tipo di scuola (per country) - se la libreria è relativa ad un tipo di scuola specifico',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag libreria cancellata (default FALSE = libreria attiva)',
  `fatherId` bigint(20) DEFAULT NULL COMMENT 'ID libreria padre (id + type) - permette di avere sottolibrerie (es di università e di facoltà - dove la facoltà è una organizzazione)',
  `fatherType` char(1) DEFAULT NULL COMMENT 'Father (ID + Type)',
  `level` int(11) DEFAULT 0 COMMENT 'Livello per gestire visualizzazioni con incolonnamento differente per livello\nDefault = 0 (Livello iniziale - NON ha padre/previous)\nOgni item che ha padre/previous setta level = padre.level + 1',
  `isQtyManaged` tinyint(1) DEFAULT 1 COMMENT 'Flag gestione delle quantità - TRUE (default) = Gestita nella libreria, FALSE = Gestita dalla libreria padre',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note',
  `schoolLevelId` char(3) DEFAULT NULL COMMENT 'ID livello di scuola - se la libreria è relativa ad uno specifico livello di scuola (es Scuola Primaria, Secondaria di grado 1, ecc)',
  `teachingAreaId` bigint(20) DEFAULT NULL COMMENT 'eventuale ID Area di insegnamento (facolta per universita, indirizzo per SS2) - se la libreria è relativa ad una facoltà/indirizzo specifico',
  `ssdAreaId` int(11) DEFAULT NULL COMMENT 'eventuale ID area SSD - se la libreria è relativa ad una specifica area SSD',
  `ssdId` int(11) DEFAULT NULL COMMENT 'eventuale ID settore Scentifico-Didattico - se la libreria è relativa ad un SSD specifico',
  `isXCond1` tinyint(1) DEFAULT 0 COMMENT 'flag libero 1',
  `isXCond2` tinyint(1) DEFAULT 0 COMMENT 'flag libero 2',
  `isXCond3` tinyint(1) DEFAULT 0 COMMENT 'flag libero 3',
  `xInt1` int(11) DEFAULT NULL COMMENT 'Intero libero 1',
  `xInt2` int(11) DEFAULT NULL COMMENT 'Intero libero 2',
  `xBigint1` bigint(20) DEFAULT NULL COMMENT 'Bigint libero 1',
  `xBigint2` bigint(20) DEFAULT NULL COMMENT 'Bigint libero 2',
  `xString1` varchar(45) DEFAULT NULL COMMENT 'Stringa libera 1',
  `xString2` varchar(45) DEFAULT NULL COMMENT 'Stringa libera 2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Libreria';

-- --------------------------------------------------------

--
-- Table structure for table `library_book`
--

CREATE TABLE `library_book` (
  `libraryId` bigint(20) NOT NULL COMMENT 'ID libreria',
  `libraryType` char(1) NOT NULL COMMENT 'Tipo libreria (PK + id) - U = Utente, R = Organizzazione, P = Piattaforma',
  `bookId` bigint(20) NOT NULL COMMENT 'id libro',
  `defaultSeq` int(11) DEFAULT 0 COMMENT 'id del file PDF (SEQ) da usare per default per la libreria, nel caso ci ne siano più versioni di file',
  `ownerId` bigint(20) DEFAULT 0 COMMENT 'ID utente proprietario del libro - ZERO = proprietà della piattaforma',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'flag record cancellato - segue flag tbl book se libro cancellato',
  `totalQty` int(11) DEFAULT 0 COMMENT 'totale qta posseduta dalla libreria - per i libri presi in prestito la qta deve essere 1',
  `lentQty` int(11) DEFAULT 0 COMMENT 'quantita prestata a utenti (Interni se libreria utente) - ricavabile anche da lista prestiti in essere (count su tbl loan)',
  `minAvailableQty` int(11) DEFAULT 0 COMMENT 'Qta minima disponibile per prestiti - soglia minima (indicazione per automatizzare gli acquisti - usare SOLO per libreria della piataforma)',
  `bookedQty` int(11) DEFAULT 0 COMMENT 'qta prenotata per prestiti utente - ricavabile con Count su tbl reservation di prenotazioni attive/non scadute o cancellate',
  `committedQty` int(11) DEFAULT 0 COMMENT 'Totale Qta impegnata per ordini di vendita a cliente\nDa modificare alla creazione-INC / evasione-DEC di un ordine di vendita\n- usare SOLO per libreria della piattaforma',
  `isDownloadable` tinyint(1) DEFAULT 0 COMMENT 'Flag download ebook permesso - TRUE = DL permesso, FALSE = DL vietato (default)',
  `lastDownloadDate` timestamp NULL DEFAULT NULL COMMENT 'data e ora ultimo download eseguito',
  `xQty1` int(11) DEFAULT 0 COMMENT 'extra qta 1 - uso futuro',
  `xQty2` int(11) DEFAULT 0 COMMENT 'extra qta 2 - uso futuro',
  `xQty3` int(11) DEFAULT 0 COMMENT 'extra qta 3 - uso futuro',
  `isCond1` tinyint(1) DEFAULT 0 COMMENT 'extra flag 1 - uso futuro',
  `isCond2` tinyint(1) DEFAULT 0 COMMENT 'extra flag 2 - uso futuro',
  `isCond3` tinyint(1) DEFAULT 0 COMMENT 'extra flag 3 - uso futuro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Libri della Libreria (di piattaforma e di utente) - contiene solo i libri di proprietà';

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `libraryId` bigint(20) NOT NULL COMMENT 'ID sorgente del prestito',
  `libraryType` char(1) NOT NULL COMMENT 'Tipo libreria - U = Utente, R = Organizzazione, P = Piattaforma',
  `bookId` bigint(20) NOT NULL COMMENT 'ID libro',
  `userId` bigint(20) NOT NULL COMMENT 'ID utente che ha ricevuto il prestito',
  `issueDate` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Data di inizio prestito',
  `expectedReturnDate` date DEFAULT NULL COMMENT 'Data prevista per rientro da prestito (DA RICALCOLARE dopo ogni estensione)',
  `sellPrice` decimal(10,2) DEFAULT NULL COMMENT 'Prezzo di vendita ebook al pubblico a inizio prestito',
  `payedAmount` decimal(10,2) DEFAULT NULL COMMENT 'importo pagato per prestito ed estensioni comprate espresso nella valuta di riferimento',
  `numExtensionUsed` int(11) DEFAULT 0 COMMENT 'numero di estensioni usate per il prestito (default = 0)',
  `mapReadPages` binary(200) DEFAULT NULL COMMENT 'Mappa di bit per le pagine lette - max 1600 pagine',
  `loanStrategyId` int(11) NOT NULL COMMENT 'ID Strategia da usare per il libro - settata a inizio noleggio'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Elenco libri prestati a utente\ncrea il record al momento del prestito\nRappresenta lo storico dei prestiti a utente';

-- --------------------------------------------------------

--
-- Table structure for table `loan_closed`
--

CREATE TABLE `loan_closed` (
  `libraryId` bigint(20) NOT NULL COMMENT 'ID sorgente del prestito',
  `libraryType` char(1) NOT NULL COMMENT 'Tipo libreria - U = Utente, R = Organizzazione, P = Piattaforma',
  `bookId` bigint(20) NOT NULL COMMENT 'ID libro',
  `userId` bigint(20) NOT NULL COMMENT 'ID utente',
  `issueDate` datetime NOT NULL COMMENT 'Data di inizio prestito',
  `expectedReturnDate` date NOT NULL COMMENT 'Data prevista per rientro da prestito',
  `returnDate` datetime NOT NULL COMMENT 'Data di avvenuta restituzione',
  `numExtensionUsed` int(11) NOT NULL COMMENT 'numero di estensioni usate per il prestito (default = 0)',
  `action` char(1) NOT NULL COMMENT 'Motivo della chiusura del prestito\nR = Libro restituito da utente\nX = restituzione automatica a fine prestito (fatta da sistema)\nD = prestito annullato da sistema + motivo',
  `description` varchar(70) DEFAULT NULL,
  `closingDate` timestamp NULL DEFAULT current_timestamp() COMMENT 'Timestamp creazione record - passaggio prestito a storico prestiti conclusi',
  `loanStrategyId` int(11) DEFAULT NULL COMMENT 'ID strategia usata per il prestito (NO Foreign key)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Storico libri prestati a utente\ncrea il record al momento del prestito\n';

-- --------------------------------------------------------

--
-- Table structure for table `loan_strategy`
--

CREATE TABLE `loan_strategy` (
  `id` int(11) NOT NULL COMMENT 'ID strategia di prestito (autoinc)',
  `code` char(10) NOT NULL COMMENT 'codice identificativo della strategia',
  `description` varchar(245) DEFAULT NULL COMMENT 'eventuale descrizione strategia',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag strategia cancellata',
  `isEnabled` tinyint(1) DEFAULT 0 COMMENT 'Flag strategia abilitata (default FALSE = NON abilitata)',
  `isSystem` tinyint(1) DEFAULT 0 COMMENT 'Flag strategia di Sistema - non si puo eliminare ne disattivare',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note strategia',
  `schoolId` bigint(20) DEFAULT NULL COMMENT 'eventuale ID scuola/azienda se strategia di prestito specifica per scuola/azienda',
  `teachingAreaId` bigint(20) DEFAULT NULL COMMENT 'eventuale ID area di insegnamento - se strategia di prestito specifica per Area di insegnamento',
  `schoolLevelId` char(3) DEFAULT NULL COMMENT 'eventuale ID livello scuola - se strategia di prestito specifica per livello scuola (es. SS1, SS2)',
  `schoolTypeId` int(11) DEFAULT NULL COMMENT 'eventuale ID tipo di scuola - se strategia di prestito specifica per tipo di scuola',
  `ssdAreaId` int(11) DEFAULT NULL COMMENT 'eventuale ID area SSD - se strategia di prestito specifica per Area SSD (non dovrebbe essere mai utilizzata)',
  `ssdId` int(11) DEFAULT NULL COMMENT 'eventuale ID SSD - se strategia di prestito specifica per SSD (non dovrebbe essere mai utlizzata)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Strategie di prestito - DEVE esistere almeno una strategia da agganciare alle librerie';

-- --------------------------------------------------------

--
-- Table structure for table `loan_strategy_item`
--

CREATE TABLE `loan_strategy_item` (
  `strategyId` int(11) NOT NULL COMMENT 'ID strategia di prestito',
  `itemKey` varchar(70) NOT NULL COMMENT 'KEY proprietà',
  `itemValue` varchar(245) NOT NULL COMMENT 'Valore proprietà - se NULL eliminare la property',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuale nota item'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='caratteristiche della singola strategia di prestito (mappa Key, Value)';

-- --------------------------------------------------------

--
-- Table structure for table `loan_strategy_lang`
--

CREATE TABLE `loan_strategy_lang` (
  `id` int(11) NOT NULL COMMENT 'ID strategia di prestito',
  `langId` char(2) NOT NULL COMMENT 'ID lingua per nome/descrizione strategia in lingua',
  `name` varchar(100) NOT NULL COMMENT 'nome strategia di prestito in lingua (es. Studenti Uni, Gratis, Prestito Generico)',
  `description` varchar(245) DEFAULT NULL COMMENT 'eventuale descrizione della strategia in lingua',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='nomi e descrizioni strategia di prestito in lingua';

-- --------------------------------------------------------

--
-- Table structure for table `log_app`
--

CREATE TABLE `log_app` (
  `temporal` timestamp NOT NULL DEFAULT current_timestamp(),
  `action` char(10) NOT NULL COMMENT 'ID azione (da lista azioni previste - creare tabella anche solo a programma)',
  `userId` bigint(20) DEFAULT NULL COMMENT 'ID utente che ha eseguito/tentato azione\n- NULL se utente non loggato',
  `isResultOk` tinyint(1) DEFAULT 0 COMMENT 'Flag esito azione utente/guest\n- TRUE = operazione riuscita senza errori\n- FALSE = operazione NON completata (default)',
  `resultMessage` varchar(255) DEFAULT NULL COMMENT 'Messaggio esito azione (se applicabile)\n- incluso eventuale errore',
  `remoteAddr` varchar(255) DEFAULT NULL,
  `remoteHost` varchar(255) DEFAULT NULL,
  `remotePort` varchar(255) DEFAULT NULL,
  `requestURL` varchar(255) DEFAULT NULL,
  `queryString` varchar(255) DEFAULT NULL,
  `method` varchar(255) DEFAULT NULL,
  `protocol` varchar(255) DEFAULT NULL,
  `scheme` varchar(255) DEFAULT NULL,
  `requestedSessionId` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='LOG degli eventi applicazione sui quali si devono eseguire query da menu\nI restanti eventi vanno tracciati nel log standard';

-- --------------------------------------------------------

--
-- Table structure for table `mail_message`
--

CREATE TABLE `mail_message` (
  `temporal` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'data ora di creazione del messaggio',
  `senderId` bigint(20) NOT NULL COMMENT 'ID utente mittente',
  `year` char(4) DEFAULT NULL COMMENT 'anno del messaggio',
  `subject` varchar(200) DEFAULT NULL COMMENT 'oggetto del messaggio',
  `text` text DEFAULT NULL COMMENT 'testo del messaggio',
  `initialSubject` varchar(200) DEFAULT NULL COMMENT 'oggetto del messaggio iniziale per tracciare le conversazioni - per documentazione',
  `initialTemporal` timestamp NULL DEFAULT NULL COMMENT 'Timestamp del messaggio iniziale per tracciare le conversazioni',
  `initialSenderId` bigint(20) DEFAULT NULL COMMENT 'ID sender iniziale per tracciare le conversazioni',
  `prevTemporal` timestamp NULL DEFAULT NULL COMMENT 'Temporal ID messaggio precedente in conversazione',
  `prevSenderId` bigint(20) DEFAULT NULL COMMENT 'ID sender messaggio precedente in conversazione',
  `level` int(11) DEFAULT 0 COMMENT 'Livello del messaggio per gestire le conversazioni (risposte a messaggi precedenti)\nDefault = 0 (Livello iniziale - NON ha previous)\nOgni messaggio che ha padre setta level = padre.level + 1\nUsare eventuali valori negativi per messaggi speciali da piattaforma - DA VALUTARE',
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Messaggi di mail interna da utente a 1+ utente/gruppo\n';

-- --------------------------------------------------------

--
-- Table structure for table `mail_message_attachment`
--

CREATE TABLE `mail_message_attachment` (
  `temporal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'ID messaggio - time marker del messaggio di mail',
  `senderId` bigint(20) NOT NULL COMMENT 'ID messaggio - id utente sender del messaggio di mail',
  `fileMarker` datetime NOT NULL COMMENT 'file ID - time marker',
  `fileCnt` bigint(20) NOT NULL COMMENT 'File ID - counter',
  `iconId` int(11) NOT NULL COMMENT 'ID icona da usare per rappresentare il tipo di file - prioritario su icona memorizzata nel record attachment',
  `descr` varchar(70) DEFAULT NULL COMMENT 'eventuale descrizione breve allegato',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Link tra mail message e attachment (molti a molti)';

-- --------------------------------------------------------

--
-- Table structure for table `mail_receiver`
--

CREATE TABLE `mail_receiver` (
  `temporal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'temporal del messaggio',
  `senderId` bigint(20) NOT NULL COMMENT 'id utente che è mittente del messaggio',
  `receiverId` bigint(20) NOT NULL COMMENT 'id utente che è destinatario del messaggio',
  `recipientType` char(1) DEFAULT NULL COMMENT 'Tipo di recipient che identifica il destinatario - U = Utente, G = Gruppo, B = entrambi (utente + gruppo), NULL = NON valutato (default)\nPER USI FUTURI - permette di tracciare se il destinatario è stato inserito in modo esplicito (come utente) e/o implicito (come membro di un gruppo)',
  `isRead` tinyint(1) DEFAULT 0 COMMENT 'Flag messaggio Letto dal destinatario – TRUE = letto, FALSE = NON letto (default) - usare FALSE per visualizzare notifica new mex'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='elenco utenti destinatari del messaggio di mail interna\n- utenti recipient\n- gruppi esplosi in lista utenti\nDA USARE per invio messaggi\nNON contiene il modo di invio (TO,CC,BCC) perchè lo stesso messaggio inviato in più modi viene consegnato solo una volta.\n';

-- --------------------------------------------------------

--
-- Table structure for table `mail_recipient`
--

CREATE TABLE `mail_recipient` (
  `temporal` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'temporal del messaggio',
  `senderId` bigint(20) NOT NULL COMMENT 'id utente che è mittente del messaggio',
  `seq` int(11) NOT NULL COMMENT 'numero progressivo di recipient per il mode',
  `mode` char(1) NOT NULL DEFAULT 'T' COMMENT 'modalita di invio al recipient: T = TO (default), C = CC, B = BCC',
  `recipientType` char(1) NOT NULL COMMENT 'Flag tipo di recipient - TRUE = gruppo, FALSE = utente (default)',
  `recipientId` bigint(20) NOT NULL COMMENT 'id destinatario del messaggio nel campo TO/CC/BCC (id utente OR id gruppo)',
  `isRead` tinyint(1) NOT NULL DEFAULT 0,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Elenco destinatari (utenti e gruppi) del messaggio di mail interna\nda visualizzare in elenco destinatari del messaggio';

-- --------------------------------------------------------

--
-- Table structure for table `matter`
--

CREATE TABLE `matter` (
  `id` bigint(20) NOT NULL COMMENT 'id materia (PK + AI)',
  `superCode` char(252) DEFAULT NULL COMMENT 'codice materia superiore = [ superCode padre + / + ] ID in formato stringa (IDX con Duplicati VIETATI) max 12 livelli',
  `code` char(20) DEFAULT NULL COMMENT 'eventuale codice materia se predefinita da direttive ministeriali (es. MIUR-SS2)',
  `name` varchar(200) DEFAULT NULL COMMENT 'nome materia/insegnamento o nome modulo',
  `ssdId` int(11) DEFAULT NULL COMMENT 'ID SSD a cui appartiene la materia (se applicabile)',
  `schoolId` bigint(20) DEFAULT NULL COMMENT 'ID Scuola dove è stata definita la materia (se applicabile)',
  `fatherId` bigint(20) DEFAULT NULL COMMENT 'ID materia padre se il padre è materia composta',
  `level` int(11) DEFAULT 0 COMMENT 'Livello per gestire visualizzazioni con incolonnamento differente per livello\nDefault = 0 (Livello iniziale - NON ha padre/previous)\nOgni item che ha padre/previous setta level = padre.level + 1',
  `isDeleted` tinyint(1) DEFAULT 0,
  `countryId` char(2) DEFAULT NULL COMMENT 'Eventuale codice country se la materia si riferisce solo ad una specifica country',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Lista Materie e moduli materia per scuola\n\nLe materie/insegnamenti che sono composti da moduli NON sono associati al settore didattico\n\n';

-- --------------------------------------------------------

--
-- Table structure for table `matter_lang`
--

CREATE TABLE `matter_lang` (
  `id` bigint(20) NOT NULL COMMENT 'ID materia (matterId)',
  `langId` char(2) NOT NULL COMMENT 'id lingua',
  `name` varchar(100) NOT NULL COMMENT 'nome materia in lingua',
  `description` varchar(245) DEFAULT NULL COMMENT 'eventuale descrizione in lingua'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='nome area materia in lingua';

-- --------------------------------------------------------

--
-- Table structure for table `measure_unit`
--

CREATE TABLE `measure_unit` (
  `code` char(3) NOT NULL,
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag record cancellato',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='unita di misura';

-- --------------------------------------------------------

--
-- Table structure for table `measure_unit_lang`
--

CREATE TABLE `measure_unit_lang` (
  `code` char(3) NOT NULL COMMENT 'codice unita di misura',
  `langId` char(2) NOT NULL COMMENT 'ID lingua',
  `um` varchar(10) NOT NULL COMMENT 'nome unita di misura in lingua (es. pz, pcs, num, GB, copie)',
  `description` varchar(245) DEFAULT NULL COMMENT 'eventuale descrizione in lingua unita di misura'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='unita di misura in ligua';

-- --------------------------------------------------------

--
-- Table structure for table `menu_acl`
--

CREATE TABLE `menu_acl` (
  `menuItemId` char(10) NOT NULL COMMENT 'ID menu item',
  `userId` bigint(20) NOT NULL COMMENT 'ID utente destinatario autorizzazione',
  `roleId` int(11) NOT NULL COMMENT 'ID ruolo',
  `isDeny` tinyint(1) DEFAULT 0 COMMENT 'Flag uso menu item - TRUE = Uso NEGATO, FALSE = uso permesso'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Menu Item Access Control List \n\ndefinisce quali item di menu sono usabili o NON usabili per ruolo o per utente\n\n';

-- --------------------------------------------------------

--
-- Table structure for table `menu_item`
--

CREATE TABLE `menu_item` (
  `id` char(10) NOT NULL COMMENT 'id funzione menu',
  `moduleId` char(3) NOT NULL COMMENT 'id menu',
  `superCode` char(252) DEFAULT NULL COMMENT 'codice gruppo superiore = [ superCode padre + / + ] ID in formato stringa (IDX con Duplicati VIETATI) max 12 livelli',
  `note` mediumtext DEFAULT NULL COMMENT 'descrizione menu item',
  `fatherId` char(10) DEFAULT NULL COMMENT 'se NULL è item di primo livello',
  `level` int(11) DEFAULT 0 COMMENT 'Livello per gestire visualizzazioni con incolonnamento differente per livello\nDefault = 0 (Livello iniziale - NON ha padre/previous)\nOgni item che ha padre/previous setta level = padre.level + 1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='voci menu';

-- --------------------------------------------------------

--
-- Table structure for table `menu_item_lang`
--

CREATE TABLE `menu_item_lang` (
  `id` char(10) NOT NULL COMMENT 'id funzione menu',
  `langId` char(2) NOT NULL,
  `name` varchar(100) NOT NULL COMMENT 'voce menu in lingua',
  `description` varchar(245) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='voci menu in lingua';

-- --------------------------------------------------------

--
-- Table structure for table `menu_module`
--

CREATE TABLE `menu_module` (
  `id` char(3) NOT NULL COMMENT 'ID modulo menu',
  `code` varchar(45) DEFAULT NULL COMMENT 'eventuale codice',
  `note` mediumtext DEFAULT NULL COMMENT 'descrizione modulo menu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='moduli menu';

-- --------------------------------------------------------

--
-- Table structure for table `menu_module_lang`
--

CREATE TABLE `menu_module_lang` (
  `id` char(3) NOT NULL,
  `langId` char(2) NOT NULL,
  `name` varchar(70) NOT NULL COMMENT 'Nome modulo menu in lingua',
  `description` varchar(245) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='nomi moduli menu in lingua';

-- --------------------------------------------------------

--
-- Table structure for table `movement`
--

CREATE TABLE `movement` (
  `storageId` bigint(20) NOT NULL COMMENT 'magazzino da movimentare (id Storage/Libreria)',
  `storageType` char(1) NOT NULL COMMENT 'magazzino da movimentare (tipo di Storage/Libreria - User/Org/Platform))',
  `storageNum` char(2) NOT NULL COMMENT 'magazzino da movimentare (num Storage/Libreria)',
  `articleId` bigint(20) NOT NULL COMMENT 'ID articolo da movimentare',
  `orderYear4` char(4) NOT NULL COMMENT 'ID documento che origina il movimento (id anno)',
  `orderCountryId` char(2) NOT NULL COMMENT 'ID documento che origina il movimento (id country)',
  `orderTypeId` char(2) NOT NULL COMMENT 'ID documento che origina il movimento (tipo ordine)',
  `orderNumDoc` bigint(20) NOT NULL COMMENT 'ID documento che origina il movimento (numero documento)',
  `movDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'data registrazione movimento',
  `isBackTransfer` tinyint(1) DEFAULT 0 COMMENT 'Flag operazione di Storno Qta (se TRUE), oppure operazione normale (FALSE default)',
  `causalId` char(10) NOT NULL COMMENT 'Causale del movimento - identifica se Carico/Scarico su QTA totale/Qta Prestata',
  `doc2Num` varchar(30) DEFAULT NULL COMMENT 'numero documento 2',
  `orderItem` int(11) NOT NULL COMMENT 'numero riga documento ordine',
  `doc2Date` varchar(30) DEFAULT NULL COMMENT 'data documento 2',
  `doc2TypeId` char(2) DEFAULT NULL COMMENT 'ID tipo documento 2',
  `offsetStorageId` bigint(20) DEFAULT NULL COMMENT 'ID Magazzino contropartita (ID storage)',
  `offsetStorageType` char(1) DEFAULT NULL COMMENT 'ID Magazzino contropartita (ID tipo)',
  `offsetStorageNum` char(2) DEFAULT NULL COMMENT 'ID Magazzino contropartita (num storage)',
  `offsetCliforId` bigint(20) DEFAULT NULL COMMENT 'ID Cli/For contropartita (anagId)',
  `offsetCliforType` char(1) DEFAULT NULL COMMENT 'ID Cli/For contropartita (cliforType)',
  `artDescription` varchar(250) DEFAULT NULL COMMENT 'Descrizione articolo',
  `um` char(3) NOT NULL COMMENT 'unita di misura',
  `multiplier` decimal(10,5) DEFAULT 1.00000 COMMENT 'moltiplicatore',
  `qty` decimal(15,5) NOT NULL COMMENT 'quantita movimentata',
  `unitPriceCurrency` decimal(16,6) NOT NULL COMMENT 'prezzo unitario in valuta',
  `articleDiscount1` decimal(5,2) DEFAULT 0.00 COMMENT 'sconto 1 su articolo',
  `articleDiscount2` decimal(5,2) DEFAULT 0.00 COMMENT 'sconto 2 su articolo',
  `amount` decimal(16,6) NOT NULL COMMENT 'Importo totale movimento',
  `ivaCodeId` char(6) NOT NULL COMMENT 'codice IVA',
  `amountCurrency` decimal(16,6) NOT NULL COMMENT 'Importo totale movimento in valuta',
  `exchangeRate` decimal(11,5) DEFAULT 1.00000 COMMENT 'valore del cambio applicato alla creazione documento ordine',
  `currencyCode` char(3) NOT NULL COMMENT 'Codice Valuta'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='movimenti di magazzino';

-- --------------------------------------------------------

--
-- Table structure for table `news_channel`
--

CREATE TABLE `news_channel` (
  `id` int(11) NOT NULL COMMENT 'id canale news',
  `code` varchar(45) DEFAULT NULL COMMENT 'eventuale codice',
  `note` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Canali news';

-- --------------------------------------------------------

--
-- Table structure for table `news_channel_lang`
--

CREATE TABLE `news_channel_lang` (
  `id` int(11) NOT NULL COMMENT 'id canale news',
  `langId` char(2) NOT NULL,
  `name` varchar(250) NOT NULL COMMENT 'nome canale news in lingua',
  `description` varchar(245) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='nomi canali news in lingua';

-- --------------------------------------------------------

--
-- Table structure for table `news_internal`
--

CREATE TABLE `news_internal` (
  `id` bigint(20) NOT NULL COMMENT 'ID news',
  `statusId` char(2) NOT NULL COMMENT 'ID stato news',
  `schoolId` bigint(20) DEFAULT NULL COMMENT 'ID scuola - valorizzato per news pubblicate dalla scuola (visibili solo agli utenti della scuola)',
  `title` varchar(150) DEFAULT NULL COMMENT 'titolo news',
  `subtitle` varchar(250) DEFAULT NULL,
  `text` varchar(2048) DEFAULT NULL COMMENT 'testo news',
  `channelId` int(11) NOT NULL COMMENT 'ID canale news',
  `createDate` timestamp NULL DEFAULT current_timestamp() COMMENT 'timestamp di creazione news',
  `isArchived` tinyint(1) DEFAULT 0 COMMENT 'Flag news Archiviata\n- TRUE = news Archiviata da almeno un utente\n- FALSE = news non archiviata da nessuno (default)',
  `isExpired` tinyint(1) DEFAULT 0 COMMENT 'Flag scadenza anticipata (settato da Admin)\n- TRUE = news dichiarata scaduta\n- FALSE = segue la scadenza normale in expirationDate',
  `expirationDate` datetime DEFAULT NULL COMMENT 'data di scadenza news - NULL = nessuna scadenza\ndopo la quale ELIMINARE la news SOLO SE flag "archived" = FALSE',
  `note` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='news interne pubblicate dalla scuola (Visibili solo agli utenti associati alla scuola) e/o dalla piattaforma (visibili a tutti gli utenti)\nGli operatori possono vedere le news di tutte le scuole';

-- --------------------------------------------------------

--
-- Table structure for table `news_status`
--

CREATE TABLE `news_status` (
  `id` char(2) NOT NULL COMMENT 'id stato news\nDF = Draft / Bozza\nAP = Approved / Approvata\nPU = Published / Pubblicata\nCN = Canceled / Cancellata',
  `isDraft` tinyint(1) DEFAULT 1 COMMENT 'Flag news in stato Draft (Bozza)\n- TRUE = in editing/Bozza (default)\n- FALSE = Editing Terminato',
  `isApproved` tinyint(1) DEFAULT 0 COMMENT 'Flag news Approvata\n- TRUE = approvata e pronta per pubblicazione\n- FALSE = in attesa di approvazione (default)',
  `isPublished` tinyint(1) DEFAULT 0 COMMENT 'Flag news Pubblicata\n- TRUE = pubblicata\n- FALSE = in attesa di pubblicazione (default)',
  `isCanceled` tinyint(1) DEFAULT 0 COMMENT 'Flag news Cancellata\n- TRUE = cancellata\n- FALSE = attiva (default)',
  `note` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Stati delle news\n- Bozza / Draft\n- Approvata / Approved\n- Pubblicata / Published\n- Annullata / Canceled';

-- --------------------------------------------------------

--
-- Table structure for table `news_status_lang`
--

CREATE TABLE `news_status_lang` (
  `id` char(2) NOT NULL,
  `langId` char(2) NOT NULL,
  `name` varchar(45) NOT NULL COMMENT 'nome stato in lingua',
  `description` varchar(245) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Nomi stati news in lingua';

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `userId` bigint(20) NOT NULL COMMENT 'ID utente destinatario della notifica',
  `screenType` char(1) NOT NULL COMMENT 'tipo di elenco notifiche di destinazione (es. normale, hoots)',
  `objectType` char(1) NOT NULL COMMENT 'Tipo di oggetto a cui si riferisce la notifica - Abbonamento, Amicizia, Corso di eLearning, Campagna Marketing, Gruppo, Like su Messaggi, Pack eBook studente, Prenotazioni, fine Prestito, fine spazio Cloud, TAG',
  `objectId` bigint(20) NOT NULL COMMENT 'ID oggetto a cui si riferisce la notifica',
  `objectDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Timestamp di creazione oggetto a cui si riferisce la notifica - usare ZERO se non applicabile',
  `title` varchar(100) DEFAULT NULL COMMENT 'titolo della notifica (eventuale)',
  `text` varchar(245) DEFAULT NULL COMMENT 'testo della notifica (eventuale)',
  `createDate` timestamp NULL DEFAULT current_timestamp() COMMENT 'Timestamp di creazione della notifica',
  `type` char(3) DEFAULT '' COMMENT 'Tipo di notifica per oggetto (es. numero di Like - raggruppabili con counter, pubblicazione approvata - non raggruppabili) - default = space',
  `isRead` tinyint(1) DEFAULT 0 COMMENT 'Flag notifica letta (se TRUE) o non letta (default)',
  `readDate` timestamp NULL DEFAULT NULL COMMENT 'Timestamp di lettura della notifica',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag notifica cancellata',
  `isXCond1` tinyint(1) DEFAULT 0 COMMENT 'Flag libero 1',
  `isXCond2` tinyint(1) DEFAULT 0 COMMENT 'Flag libero 2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Notifiche di tutti i tipi agli utenti ';

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) NOT NULL,
  `company_id` bigint(20) DEFAULT NULL,
  `module_id` bigint(20) DEFAULT NULL,
  `module_action` varchar(255) DEFAULT NULL,
  `module_action_id` bigint(20) DEFAULT NULL,
  `module_action_title` varchar(255) DEFAULT NULL,
  `module_action_description` varchar(255) DEFAULT NULL,
  `fromuser_id` bigint(20) NOT NULL,
  `touser_id` bigint(20) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `isDeleted` tinyint(1) DEFAULT 0,
  `isSeen` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notification_settings`
--

CREATE TABLE `notification_settings` (
  `id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `module_id` bigint(20) NOT NULL,
  `isAccessed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `onsiteemployees`
--

CREATE TABLE `onsiteemployees` (
  `id` bigint(20) NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `projectId` bigint(20) NOT NULL,
  `work_location_Id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `orderYear4` char(4) NOT NULL COMMENT 'Anno ordine (4 char - es. 2017)',
  `countryId` char(2) NOT NULL COMMENT 'ID country',
  `orderTypeId` char(2) NOT NULL COMMENT 'codice tipo ordine',
  `orderNum` bigint(20) NOT NULL COMMENT 'ID Ordine - progressivo annuale',
  `itemId` int(11) NOT NULL COMMENT 'ID riga ordine',
  `status` char(1) DEFAULT 'N' COMMENT 'Stato riga (es. N = non evasa, P = parzialmente Evasa, E = evasa totale)',
  `productType` char(1) NOT NULL COMMENT 'Tipo di Articolo (X, D, o come tipo articolo)\n<B>ook, <S>ubscription, <E>learning, <X> = prodotto non codificato (servizi o altro), <D> solo descrizione',
  `productCode` bigint(20) DEFAULT NULL COMMENT 'ID articolo o NULL se articolo non codificato o descrizione libera',
  `singleProductId` bigint(20) DEFAULT NULL COMMENT 'ID articolo singolo (per articoli in confezione o pack), NULL se descrizione libera o articolo non codificato',
  `productXCode` varchar(70) DEFAULT NULL COMMENT 'Codice alfanumerico articolo se necessario (es. ISBN per libri, codice abbonamento)',
  `productDescription` varchar(250) DEFAULT NULL COMMENT 'Descrizione Articolo o descrizione libera (es. Titolo per libri, Nome abbonamento, Titolo corso eLearning)',
  `qty` decimal(15,5) NOT NULL COMMENT 'quantita articolo',
  `processedQty` decimal(15,5) DEFAULT 0.00000 COMMENT 'Quantita evasa',
  `unitNetPrice` decimal(16,6) NOT NULL COMMENT 'prezzo unitario netto',
  `ivaCodeId` char(6) DEFAULT NULL COMMENT 'Codice IVA - NULL se descrizione libera',
  `unitPrice` decimal(16,6) NOT NULL,
  `discount1` decimal(5,2) DEFAULT 0.00 COMMENT 'sconto1 articolo - applicato alla singola riga',
  `discount2` decimal(5,2) DEFAULT 0.00 COMMENT 'sconto2 articolo - applicato alla singola riga',
  `um` char(3) DEFAULT NULL COMMENT 'Unita di musura (prendere quella nel record articolo) - es. pezzi (pz), numero (n.) - NULL per descrizione libera',
  `unConversionFactor` decimal(15,5) DEFAULT 1.00000 COMMENT 'Fattore di conversione UM (es. quanti libri in un pacco) - dovrebbe essere = packQty in tbl article'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Righe Ordini\nSono agganciate alla tbl article';

-- --------------------------------------------------------

--
-- Table structure for table `order_object`
--

CREATE TABLE `order_object` (
  `year4` char(4) NOT NULL COMMENT 'Anno ordine (4 digit)',
  `countryId` char(2) NOT NULL COMMENT 'ID country (come da tabella order_prog)',
  `typeId` char(2) NOT NULL COMMENT 'Tipo Ordine\nSP = Purchase - ordine di acquisto a fornitore\nCS = Sell - ordine di vendita a Cliente\nRQ = Request - richiesta utente\nSR = Ordine di Resa a Fornitore\nCR = Ordine di resa da cliente\nCP = Ordine di acquisto da Cliente (libri usati)',
  `numDoc` bigint(20) NOT NULL COMMENT 'Numero Ordine - usare tbl order_prog per recuperare il numero ordine da usare alla creazione ordine',
  `statusId` char(2) NOT NULL COMMENT 'ID Stato Ordine\n',
  `anagId` bigint(20) NOT NULL COMMENT 'ID Anagrafica - con cliforType identifica Cliente/Fornitore - Fornitore con type = <P>urchase (acquisto) - Cliente con type = <S>ell (vendita) oppure <R>equest (richiesta)',
  `cliforType` char(1) NOT NULL COMMENT 'Tipo Cliente/Fornitore - con ID Anagrafica identifica se Cliente o Fornitore - Fornitore con type = <P>urchase (acquisto) - Cliente con type = <S>ell (vendita) oppure <R>equest (richiesta)',
  `orderingUserId` bigint(20) DEFAULT NULL COMMENT 'ID utente che effettua l''ordine - rilevante se la fattura deve essere intestata al referral - NULL se non applicabile',
  `docDate` timestamp NULL DEFAULT current_timestamp() COMMENT 'data documento - inserimento/creazione Ordine/Richiesta (proporre/usare CURRENT_TIMESTAMP)',
  `approveDate` timestamp NULL DEFAULT NULL COMMENT 'Data conferma Ordine - per Richieste = creationDate',
  `orderApprovedByUserId` bigint(20) DEFAULT NULL COMMENT 'ID utente (tra gli operatori) che ha approvato ordine - NULL se non applicabile o in attesa di approvazione',
  `transmitDate` timestamp NULL DEFAULT NULL COMMENT 'Timestamp di trasmissione ordine (es. a fornitore) oppure di spedizione (inizio evasione)',
  `lastUpdate` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'timestamp ultima modifica ordine',
  `lastUserUpdate` bigint(20) DEFAULT NULL COMMENT 'ID utente che ha modificato per ultimo l''ordine - NULL se non applicabile - usare numeri negativi per identificare le procedure di programma che operano sull''ordine in modo automatico - DA DEFINIRE',
  `deliveryStatus` char(1) DEFAULT 'N' COMMENT 'Stato evasione ordine - P = Parziale, T = Totale,  N = NON Evaso',
  `deliveryMode` varchar(150) DEFAULT NULL COMMENT 'modalita di consegna - se applicabile (NO per acquisto abbonamenti)\nes. Download Telematico, Spedizione',
  `note` mediumtext DEFAULT NULL COMMENT 'note ordine',
  `afterNote` mediumtext DEFAULT NULL COMMENT 'Note sul processo Ordine/Richiesta - NON trasmettere a fornitore - usare per motivo Annullamento Ordine',
  `currencyCode` char(3) NOT NULL COMMENT 'Codice Currency in cui sono espressi gli importi (intero ordine)',
  `discount1` decimal(5,2) DEFAULT 0.00 COMMENT 'sconto1 intero ordine\napplicare questo sconto al prezzo (anche se scontato) di ogni riga',
  `discount2` decimal(5,2) DEFAULT 0.00 COMMENT 'sconto2 (intero ordine) da applicare dopo sconto1 (stesse regole di applicazione di sconto1)',
  `requestYear` char(4) DEFAULT NULL COMMENT 'Request ID (year) - richiesta utente che ha generato ordine',
  `requestCountryId` char(2) DEFAULT NULL COMMENT 'Request ID (countryId) - richiesta utente che ha generato ordine',
  `requestTypeId` char(2) DEFAULT NULL COMMENT 'Request ID (orderTypeId) - richiesta utente che ha generato ordine',
  `requestNum` bigint(20) DEFAULT NULL COMMENT 'Request ID (orderNumber) - richiesta utente che ha generato ordine',
  `isRequestProcessed` tinyint(1) DEFAULT 0 COMMENT 'Flag Richiesta utente di acquisto libro processata = TRUE, da processare = FALSE\napplicabile solo a tipo Ordine = R (Request) - richiesta acquisto libro da utente',
  `isRequestApproved` tinyint(1) DEFAULT 0 COMMENT 'Flag richiesta utente di acquisto libro Approvata = TRUE oppure Respinta = FALSE\napplicabile solo a tipo Ordine = R (Request) - richiesta acquisto libro da utente',
  `requestApprovedByUserId` bigint(20) DEFAULT NULL COMMENT 'ID utente (tra gli operatori) che ha approvato la richiesta di acquisto - NULL se non applicabile o in attesa di approvazione',
  `storageId` bigint(20) DEFAULT NULL COMMENT 'Magazzino di destinazione - ID',
  `storageType` char(1) DEFAULT NULL COMMENT 'Magazzino di destinazione - Tipo',
  `storageProg` char(2) DEFAULT NULL COMMENT 'Magazzino di destinazione - Progressivo',
  `storageIdFrom` bigint(20) DEFAULT NULL COMMENT 'Magazzino di partenza - ID (NULL se non applicabile)',
  `storageTypeFrom` char(1) DEFAULT NULL COMMENT 'Magazzino di partenza - Tipo (NULL se non applicabile)',
  `storageProgFrom` char(2) DEFAULT NULL COMMENT 'Magazzino di partenza - Progressivo (NULL se non applicabile)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Ordini Utente e Fornitore,\nRichieste dli libri da Utente\n(parola Order riservata)';

-- --------------------------------------------------------

--
-- Table structure for table `order_prog`
--

CREATE TABLE `order_prog` (
  `year4` char(4) NOT NULL COMMENT 'anno a cui si riferisce il progressivo',
  `countryId` char(2) NOT NULL COMMENT 'ID country di ordinante (es. scuola per studente, sede legale per azienda, indirizzo residenza per privato)',
  `typeId` char(2) NOT NULL COMMENT 'id tipo ordine',
  `prog` bigint(20) DEFAULT 0 COMMENT 'numero progressivo tipo ordine per anno in corso',
  `lastUpdate` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Timestamp ultimo aggiornamento record - data/ora ultimo progressivo generato'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Progressivi numerazione Ordini per Tipo per Anno\nRD w Lock, INC, WR w unlock - se no err usare prog come numero ordine\nSE non esiste record anno/tipo creare record con prog = 1';

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `id` char(2) NOT NULL COMMENT 'ID stato ordine\nI = inserted\nA = approved\nT = transmitted\nD = delivered (evasione parziale o totale)\nC = canceled',
  `note` mediumtext DEFAULT NULL COMMENT 'note',
  `isApproved` tinyint(1) DEFAULT 0 COMMENT 'Flag ordine approvato (pronto per trasmissione e successiva evasione)',
  `isTransmitted` tinyint(1) DEFAULT 0 COMMENT 'Flag ordine trasmesso a fornitore o a magazzino per evasione',
  `isCanceled` tinyint(1) DEFAULT 0 COMMENT 'ordine annullato per problemi di evasione o altro',
  `isDelivered` tinyint(1) DEFAULT 0 COMMENT 'Flag stato evasione - TRUE = Evaso -FALSE = non evaso\nper evasione totale/parziale controllare Ordine'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Stati Ordine\n- INSERITO\n- APPROVATO\n- TRASMESSO\n- EVASO\n- ANNULLATO';

-- --------------------------------------------------------

--
-- Table structure for table `order_status_lang`
--

CREATE TABLE `order_status_lang` (
  `id` char(2) NOT NULL COMMENT 'ID stato Ordine',
  `langId` char(2) NOT NULL COMMENT 'ID lingua nome stato ordine',
  `name` varchar(45) NOT NULL COMMENT 'nome stato ordine in lingua',
  `description` varchar(245) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='nome stato ordine in lingua';

-- --------------------------------------------------------

--
-- Table structure for table `order_type`
--

CREATE TABLE `order_type` (
  `id` char(2) NOT NULL COMMENT 'id tipo ordine',
  `isSupplier` tinyint(1) DEFAULT 0 COMMENT 'Flag tipo ordine per Cliente o per Fornitore\n- TRUE = per Fornitore,\n- FALSE = per Cliente (default)',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'flag record cancellato',
  `qtyModifier` char(1) NOT NULL COMMENT 'Flag modificatore qty articolo [ - (meno) = Decremento, + (più) = Incremento ]',
  `note` mediumtext DEFAULT NULL COMMENT 'nome tipo ordine'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tipi Ordine\n\nPO = Purchase Order - ordine di acquisto a fornitore\nSO = Sell Order - ordine di vendita a utente\nQR = Request - richiesta utente\nRS = Resa a Fornitore\nRC = Resa da cliente\nPU = Purchase Used - acquisto da Cliente di libri usati\n';

-- --------------------------------------------------------

--
-- Table structure for table `order_type_lang`
--

CREATE TABLE `order_type_lang` (
  `id` char(2) NOT NULL COMMENT 'ID tipo ordine',
  `langId` char(2) NOT NULL COMMENT 'ID lingua',
  `name` varchar(45) NOT NULL COMMENT 'nome tipo ordine in lingua',
  `description` varchar(245) DEFAULT NULL COMMENT 'descrizione tipo ordine in lingua'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='nomi tipi ordine in lingua';

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `id` bigint(20) NOT NULL COMMENT 'ID organizzazione (istituto scolastico o Azienda) - autoinc',
  `anagId` bigint(20) NOT NULL COMMENT 'ID anagrafica organizzazione - Ogni organizzazione (Ente) ha una anagrafica corispondente',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'flag scuola/azienda cancellata',
  `isCompany` tinyint(1) NOT NULL COMMENT 'Flag Scuola o Ente NON scolastico/azienda/privato - TRUE = Azienda/privato/Ente NON scolastico, FALSE = Scuola\nSOLO per Scuole sono previsti Codici Ministeriali, Livello e/o Tipo scuola, Corsi, Materie',
  `isMiur` tinyint(1) DEFAULT 0 COMMENT 'Flag scuola pervenuta da elenco MIUR - rilevante solo per Scuole',
  `createDate` timestamp NULL DEFAULT current_timestamp() COMMENT 'timestamp creazione Scuola/Azienda',
  `imageFileName` varchar(255) DEFAULT NULL COMMENT 'nome file immagine/Logo - da usare in alternativa al campo BLOB',
  `imageFilePath` varchar(255) DEFAULT NULL COMMENT 'Path file immagine/Logo - da usare in alternativa al campo BLOB',
  `imageFileServer` varchar(255) DEFAULT NULL COMMENT 'Server dove memorizzare il file immagine/logo - da usare in alternativa al campo Blob',
  `image` blob DEFAULT NULL COMMENT 'immagine/Logo scuola / ente - da usare in alternativa ai campi FileName e FilePath immagine',
  `isBlocked` tinyint(1) DEFAULT 0 COMMENT 'Flag di Blocco - FALSE = non bloccato (default), TRUE = bloccato\nimpedisce di fare qualsiasi operazione relativa alla scuola/azienda; vale anche per tutti gli utenti collegati',
  `blockDate` timestamp NULL DEFAULT NULL COMMENT 'Timestamp di blocco',
  `blockReason` varchar(200) DEFAULT NULL COMMENT 'eventuale motivo del blocco',
  `fatherId` bigint(20) DEFAULT NULL COMMENT 'id organizzazione padre - permette di avere sottoorganizzazioni (es. Universita, dipartimenti)',
  `level` int(11) DEFAULT 0 COMMENT 'Livello per gestire visualizzazioni con incolonnamento differente per livello\nDefault = 0 (Livello iniziale - NON ha padre/previous)\nOgni item che ha padre/previous setta level = padre.level + 1',
  `note` mediumtext DEFAULT NULL COMMENT 'note eventuali'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl Enti/organizzazioni (scuola/azienda)\nCreare record quando utente dichiara di essere un ENTE\nusata per aggancio\n- lista utenti interni\n- News Interne\n- gruppi della scuola/azienda\n- corsi di eLearning\n- condizioni di vendita eCorsi a utenti Interni\n\n';

-- --------------------------------------------------------

--
-- Table structure for table `organization_industry`
--

CREATE TABLE `organization_industry` (
  `organizationId` bigint(20) NOT NULL COMMENT 'ID organizzazione (Azienda/Scuola)',
  `industryId` int(11) NOT NULL COMMENT 'ID Settore di attività (Settore industriale)',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note - da usare in caso di settore definito da utente per propria organizzazione'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Settori di Attività (Settori Industriali) organizzazione';

-- --------------------------------------------------------

--
-- Table structure for table `organization_roles`
--

CREATE TABLE `organization_roles` (
  `id` bigint(20) NOT NULL,
  `organization_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `department_code` char(10) CHARACTER SET utf8 DEFAULT NULL,
  `e_category_id` bigint(20) DEFAULT NULL,
  `role` varchar(30) NOT NULL COMMENT 'AMMINISTRATORE;RESPONSABILE_DIPARTIMENTO;RESPONSABILE_CORSO_DI_STUDI',
  `assignment_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `organization_user`
--

CREATE TABLE `organization_user` (
  `organizationId` bigint(20) NOT NULL COMMENT 'ID Organizzazione (Istituto scolastico / Azienda)',
  `userId` bigint(20) NOT NULL COMMENT 'ID utente',
  `departmentCode` char(10) DEFAULT NULL COMMENT 'Codice dipartimento/reparto',
  `e_category_id` bigint(20) DEFAULT NULL COMMENT 'Corso di laurea',
  `departmentRoleCode` char(10) DEFAULT NULL COMMENT 'Codice del ruolo nel reparto azienda/scuola - ALTERNATIVO a departmentRoleName - USO FUTURO',
  `departmentRoleName` varchar(100) DEFAULT NULL COMMENT 'ruolo utente nel reparto/dipartimento azienda/scuola',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'flag record cancellato',
  `isStudent` tinyint(1) DEFAULT 0 COMMENT 'Flag Studente = TRUE (oppure utente utilizzatore generico per azienda)',
  `isTeacher` tinyint(1) DEFAULT 0 COMMENT 'Flag Docente = TRUE (oppure Editor per azienda)',
  `isAdmin` tinyint(1) DEFAULT 0 COMMENT 'Flag Admin della scuola/azienda = TRUE, utente normale = FALSE (default)',
  `isDisabled` tinyint(1) DEFAULT 0 COMMENT 'Flag utente scolastico abilitato = FALSE, oppure DISabilitato = TRUE (se disabilitato per qualche motivo - motivazione in note)\n',
  `disabledReason` varchar(245) DEFAULT NULL COMMENT 'Motivo della disabilitazione',
  `requestDate` timestamp NULL DEFAULT current_timestamp() COMMENT 'Data della richiesta di associazione Utente-Istituto',
  `isConfirmed` tinyint(1) DEFAULT 0 COMMENT 'utente scolastico TRUE = confermato, FALSE = NON confermato',
  `confirmationDate` date DEFAULT NULL COMMENT 'Data conferma associazione Utente-Istituto da parte di istituto\nse NULL associazione NON confermata',
  `confirmedBy` bigint(20) DEFAULT NULL COMMENT 'ID utente cha ha confermato associazione utente-istituto',
  `isExpired` tinyint(1) DEFAULT 0 COMMENT 'Flag associazione utente-scuola Scaduta = TRUE, attiva = FALSE (default) - da usare per escludere utenti senza scadenza o non scaduti - se TRUE è prioritario su expirationDate',
  `expirationDate` date DEFAULT NULL COMMENT 'Data di scadenza associazione con istituto - per eliminare gli studenti a fine corso\nse NULL non ha scadenza (Docenti + personale non docente della scuola - se previsto)',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note + causa della disabilitazione (by School or Operator)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Utente legato a Scuola/Azienda (Studente / Docenti / Dipendente non docente / altro)\n\nLa Scuola conferma associazione Utente-Scuola\nesempio\nun docente può essere anche studente se si iscrive ad un corso di Dottorato,\nstessa cosa per un impiegato in segreteria\n';

-- --------------------------------------------------------

--
-- Table structure for table `organization_user_auth`
--

CREATE TABLE `organization_user_auth` (
  `organizationId` bigint(20) NOT NULL COMMENT 'ID organizzazione',
  `userId` bigint(20) NOT NULL COMMENT 'ID utente',
  `isManager` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione MANAGER - può delegare autorizzazioni possedute ad altri utenti interni',
  `isDelegationEnabled` tinyint(1) DEFAULT 0 COMMENT 'Flag autorizzazione a delegare il ruolo di manager - può trasferire il ruolo di manager a utenti interni',
  `isBuyEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazioen BUYER - può fare acquisti',
  `isEditEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione EDITOR - può creare e modificare Corsi di eLearning ed eBook',
  `isPublishEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione PUBLISHER - può pubblicare (rendere disponibili a utenti) eBook e Corsi di eLearning (per uso Interno ed Esterno - ove funzione abilitata)',
  `isBookULEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione BOOK-ULOADER - può fare UpLoad di eBook in libreria personale o di organizzazione',
  `isBookDLEnable` tinyint(1) DEFAULT 1 COMMENT 'Autorizzazione BOOK-DOWNLOADER - può fare DownLoad di eBook da libreria personale o di organizzazione',
  `isPurchasedBookDLEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione BOOK-DLOADER-BUY - può fare il download di libri propri acquistati dalla piattaforma (questa azione blocca la rivendita, se prevista, alla piattaforma come usato)',
  `isUploadedBookDLEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione BOOK-DLOADER-UPLOAD - può fare il download di libri propri caricati con upload',
  `isCreatedBookDLEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione BOOK-DLOADER-CREATE - può fare il download di libri propri creati',
  `isFileULEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione FILE-ULOADER - può fare upload di file (NO eBook) nel desktop personale (o di organizzazione)',
  `isFileDLEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione FILE-DLOADER - può fare il download di file (NO eBook) dal desktop personale (o di organizzazione)',
  `isBookWREnableIN` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione BOOK-WRITE-IN - può gestire (creare e pubblicare) eBook per uso INTERNO',
  `isBookWREnableOUT` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione BOOK-WRITE-OUT - può gestire (creare e pubblicare) eBook per uso ESTERNO',
  `isLearnWREnableIN` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione LEARN-WRITE-IN - può gestire (creare e pubblicare) cordi di eLearning per uso INTERNO',
  `isLearnWREnableOUT` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione LEARN-WRITE-OUT - può gestire (creare e pubblicare) cordi di eLearning per uso ESTERNO',
  `isBookRDEnableIN` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione BOOK-READ-IN - può prendere in prestito eBook INTERNI',
  `loanStrategyIdIN` int(11) DEFAULT NULL COMMENT 'ID Strategia di prestito Interna - da usare per prestito eBook INTERNO (da Ente a utenti Interni)',
  `isBookRDEnableOUT` tinyint(1) DEFAULT 1 COMMENT 'Autorizzazione BOOK-READ-OUT - può prendere in prestito eBook ESTERNI',
  `loanStrategyIdOUT` int(11) DEFAULT NULL COMMENT 'ID Strategia Esterna - da usare per prestito eBook ESTERNO (da Piattaforma a utenti)',
  `isLearnRDEnableIN` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione LEARN-READ-IN - può iscriversi a corsi di eLearning INTERNI (per utenti interni di organizzazione)',
  `isLearnRDEnableOUT` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione LEARN-READ-OUT - può iscriversi a corsi di eLearning ESTERNI (per tutti gli utenti della piattaforma)',
  `isInternalUserEnable` tinyint(1) DEFAULT 0 COMMENT 'Abilitazione ad averre utenti Interni - valido solo per Enti',
  `isResaleEnabled` tinyint(1) DEFAULT 0 COMMENT 'Abilitazione alla rivendita di eBook alla piattaforma come usato (se prevista)',
  `isSurveyCreator` tinyint(1) DEFAULT 0 COMMENT 'Abilitazione a creare Sondaggi',
  `isReviewer` tinyint(1) DEFAULT 1 COMMENT 'Abilitazione a scrivere Recensioni sui libri',
  `isEventAttachmentEnabled` tinyint(1) DEFAULT 1 COMMENT 'Abilitazione ad allegare file agli eventi',
  `isGroupCreationEnabled` tinyint(1) DEFAULT 1 COMMENT 'Abilitazione a creare Gruppi',
  `isGroupCommentEnabled` tinyint(1) DEFAULT 1 COMMENT 'se TRUE può scrivere commenti sui gruppi',
  `isGroupMexAttachmentEnabled` tinyint(1) DEFAULT 1 COMMENT 'Abilitazione a allegare file ai Messaggi/Comment che scrive sui gruppi',
  `isXAuth1` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione Libera 1',
  `isXAuth2` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione Libera 2',
  `isXAuth3` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione Libera 3',
  `isXAuth4` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione Libera 4',
  `isXAuth5` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione Libera 5'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='permessi/Autorizzazioni membro organizzazione';

-- --------------------------------------------------------

--
-- Table structure for table `organizatio_users_years`
--

CREATE TABLE `organizatio_users_years` (
  `organization_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `year` varchar(9) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `code` char(6) NOT NULL COMMENT 'ID Pagamento (codice definito da utente)',
  `isDeleted` tinyint(1) DEFAULT 0,
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='anagrafica Pagamenti - contiene tutti i tipi di pagamento previsti';

-- --------------------------------------------------------

--
-- Table structure for table `payment_lang`
--

CREATE TABLE `payment_lang` (
  `code` char(6) NOT NULL COMMENT 'Codice pagamento (PK con langId)',
  `langId` char(2) NOT NULL COMMENT 'ID lingua (PK con code)',
  `name` varchar(45) NOT NULL COMMENT 'nome pagamento in lingua',
  `description` varchar(245) DEFAULT NULL COMMENT 'descrizione pagamento in lingua'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payslips`
--

CREATE TABLE `payslips` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `company_id` bigint(20) DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `payslip_filename` varchar(255) DEFAULT NULL,
  `payslip_filepath` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `postcommentfiles`
--

CREATE TABLE `postcommentfiles` (
  `id` bigint(20) NOT NULL,
  `post_id` bigint(20) DEFAULT NULL,
  `comment_id` bigint(20) DEFAULT NULL,
  `reply_id` bigint(20) DEFAULT NULL,
  `group_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `postcommentlikes`
--

CREATE TABLE `postcommentlikes` (
  `id` bigint(20) NOT NULL,
  `comment_id` bigint(20) DEFAULT NULL,
  `post_id` bigint(20) DEFAULT NULL,
  `reply_id` bigint(20) DEFAULT NULL,
  `group_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `isLiked` tinyint(1) NOT NULL DEFAULT 1,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  `isReply` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `postcomments`
--

CREATE TABLE `postcomments` (
  `id` bigint(20) NOT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `group_id` bigint(20) DEFAULT NULL,
  `post_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `comment_data` varchar(255) DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `postlikes`
--

CREATE TABLE `postlikes` (
  `id` bigint(20) NOT NULL,
  `group_id` bigint(20) DEFAULT NULL,
  `post_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `isLiked` tinyint(1) NOT NULL DEFAULT 1,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `prefixed_course`
--

CREATE TABLE `prefixed_course` (
  `id` bigint(20) NOT NULL COMMENT 'ID corso di laurea',
  `name` varchar(150) NOT NULL COMMENT 'nome corso ',
  `numberOfYears` int(11) DEFAULT 0 COMMENT 'lunghezza del corso in anni - ZERO = lunghezza non determinata (es. dottorato o simile)',
  `teachingAreaId` bigint(20) NOT NULL COMMENT 'ID Facolta (UNI) o Indirizzo di specializzazione (SS2) del corso',
  `degreeClassId` int(11) NOT NULL COMMENT 'id classe di laurea del corso',
  `isDeleted` tinyint(1) DEFAULT 0,
  `note` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Corsi di Studio prefissati per country\n\n- SS2 - corsi di specializzazione\n\nesempi\n- Lic.Artistico - Biennio Comune\n- Lic.Artistico - Design\n- Lic.Artistico - Grafica\n- Lic.Artistico - Scenografia\n';

-- --------------------------------------------------------

--
-- Table structure for table `prefixed_course_matter`
--

CREATE TABLE `prefixed_course_matter` (
  `courseId` bigint(20) NOT NULL COMMENT 'ID Corso di specializzazione (SS2) in country',
  `matterId` bigint(20) NOT NULL COMMENT 'ID Materia in country',
  `note` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Elenco Materie/Insegnamenti per Corso di studi';

-- --------------------------------------------------------

--
-- Table structure for table `prefixed_teaching_area`
--

CREATE TABLE `prefixed_teaching_area` (
  `id` bigint(20) NOT NULL COMMENT 'ID area di insegnamento (Facolta, Tipo di scuola)',
  `name` varchar(150) NOT NULL COMMENT 'nome area',
  `countryId` char(2) NOT NULL COMMENT 'ID country',
  `schoolLevelId` char(3) NOT NULL COMMENT 'Livello scuola (Pre-Primary, Primary, Lower Seconadary, Upper Secondary, University)',
  `isDeleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Elenco aree di insegnamento per livello per country\n\nITALIA\n- UNI Facolta\n- SS2 Tipo Scuola\n- SS1 tipo unico\n\nesempi\n- UNI - scienze MM.FF.NN.\n- UNI - Medicina e Chirurgia\n- UNI - Economia\n- SS2 - Liceo Artistico\n- SS2 - Liceo Classico\n- SS2 - Ist.Tec. Amm.Fin.Marketing\n- SS2 - Ist.Tec. Turismo\n- SS2 - Ist.Tec. Informatica e TLC\n- SS2 - Ist.Prof.Serv.Agricoltura\n- SS2 - Ist.Prof.Prod.Industriali e Artigianali\n- SS1 - scuola medie\n';

-- --------------------------------------------------------

--
-- Table structure for table `preloaded_school`
--

CREATE TABLE `preloaded_school` (
  `code` varchar(45) NOT NULL COMMENT 'Codice Ministeriale Istituto/Plesso (ITA 10 char) oppure UUI4 se non esiste codice ministeriale - da settare con caricamento di massa dati ministeriali',
  `name` varchar(100) NOT NULL COMMENT 'Denominazione scuola - da settare con caricamento di massa dati ministeriali',
  `referenceCode` varchar(45) NOT NULL COMMENT 'Codice istituto principale o di riferimento - se isituto è quello principale allora settare = code - da settare con caricamento di massa dati ministeriali',
  `istatCodeRegion` int(11) DEFAULT NULL COMMENT 'Codice ISTAT Regione Italia - da settare con caricamento di massa dati ministeriali',
  `istatCodeProvince` int(11) DEFAULT NULL COMMENT 'Codice ISTAT Provincia Italia - da settare con caricamento di massa dati ministeriali',
  `istatCodeCity` int(11) DEFAULT NULL COMMENT 'Codice ISTAT Comune Italia - da settare con caricamento di massa dati ministeriali',
  `schoolLevelId` char(3) NOT NULL COMMENT 'ID livello scuola - classificazione usata dal ministero',
  `address` varchar(70) NOT NULL COMMENT 'indirizzo della scuola',
  `zip` varchar(10) NOT NULL COMMENT 'CAP',
  `tel` varchar(45) DEFAULT NULL COMMENT 'telefono',
  `fax` varchar(45) DEFAULT NULL COMMENT 'fax',
  `email` varchar(80) DEFAULT NULL COMMENT 'email',
  `pec` varchar(80) DEFAULT NULL COMMENT 'email certificata',
  `web` varchar(80) DEFAULT NULL COMMENT 'sito internet',
  `isStateSchool` tinyint(1) DEFAULT 1 COMMENT 'Flag scuola statale (TRUE) o paritaria (FALSE) - da settare con caricamento di massa dati ministeriali',
  `isUsed` tinyint(1) DEFAULT 0 COMMENT 'Flag di scuola iscritta alla piattaforma (TRUE) - settato quando la scuola si iscrive fornendo il codice ministeriale',
  `updateDate` datetime DEFAULT NULL COMMENT 'Data/ora aggiornamento - deve essere lo stesso per tutti i record aggiornati con lo stesso aggiornamento del MIUR',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag scuola cancellata - settare a TRUE se non è presente in aggiornamento del MIUR'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Lista Istituti Scolastici fornita dal ministero MIUR';

-- --------------------------------------------------------

--
-- Table structure for table `price`
--

CREATE TABLE `price` (
  `id` bigint(20) NOT NULL COMMENT 'ID Prezzo',
  `articleId` bigint(20) NOT NULL COMMENT 'Id articolo',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'flag record cancellato',
  `sellPrice` decimal(10,2) NOT NULL COMMENT 'Prezzo di vendita al pubblico - NON scontato',
  `tax` decimal(5,2) NOT NULL COMMENT '% IVA da applicare al prezzo netto / inclusa nel prezzo di vendita',
  `netPrice` decimal(16,6) NOT NULL COMMENT 'Prezzo Netto - calcolato - sellPrice / (1 + %tax)',
  `discount1` decimal(5,2) DEFAULT 0.00 COMMENT 'Sconto 1',
  `discount2` decimal(5,2) DEFAULT 0.00 COMMENT 'Sconto 2',
  `currencyCode` char(3) NOT NULL COMMENT 'Codice ISO Valuta del prezzo',
  `startDate` datetime NOT NULL COMMENT 'Data inizio validità prezzo (se NULL usare data attuale)',
  `endDate` datetime DEFAULT NULL COMMENT 'data fine validita prezzo (se NULL non ha scadenza)',
  `priceListId` char(2) DEFAULT '00' COMMENT 'ID listino (default "00" = listino generale)',
  `note` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Prezzi per Corsi, Books e per tutti gli Abbonamenti\nPermette di definire prezzi da applicare in futuro (tramite startDate)\nNETTO = sellPrice / (1 + tax/100)\nIVA = NETTO * (tax/100)';

-- --------------------------------------------------------

--
-- Table structure for table `price_list`
--

CREATE TABLE `price_list` (
  `id` char(2) NOT NULL COMMENT 'ID listino prezzi - 00 = listino generale (di default)',
  `description` varchar(245) NOT NULL COMMENT 'descrizione listino',
  `isSystem` tinyint(1) DEFAULT 0 COMMENT 'Flag listino di sistema (se TRUE) oppure definito da utente (se FALSE) - il listino di sistema NON può essere eliminato ne disabilitato',
  `isEnabled` tinyint(1) DEFAULT 0 COMMENT 'Flag listino abilitato (TRUE) o non abilitato (FALSE - default) ',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag listino cancellato (se TRUE)',
  `currencyCode` char(3) NOT NULL COMMENT 'Codice Valuta in cui sono espressi i prezzi del listino',
  `priceWithIva` tinyint(1) NOT NULL COMMENT 'Flag che indica se i prezzi del listino includono IVA (TRUE) oppure no (FALSE)',
  `validityDate` date DEFAULT NULL COMMENT 'Data limite listino dopo la quale il listino perde velidità, se NULL non ha limite',
  `startingList` char(2) DEFAULT NULL COMMENT 'ID listino di partenza (dal quale sono stati presi i prezzi), se NULL non esiste listino di partenza',
  `associatedList` char(2) DEFAULT NULL COMMENT 'ID listino associato (es. listini associati: in Euro con IVA e senza IVA), se NULL non ha listino associato',
  `countryId` char(2) DEFAULT NULL COMMENT 'ID country a cui si applica il listino - se NULL si applica a qualsiasi country',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Listini Prezzi';

-- --------------------------------------------------------

--
-- Table structure for table `privacy_desktop`
--

CREATE TABLE `privacy_desktop` (
  `ownerId` bigint(20) NOT NULL COMMENT 'ID utente (owner del desktop)',
  `itemId` int(11) NOT NULL COMMENT 'numero progressivo del file\nOgni owner ha una propria numerazione progressiva di file (da 1 in poi)\n',
  `id` int(11) NOT NULL COMMENT 'ID record per owner',
  `friendId` bigint(20) NOT NULL COMMENT 'ID amico soggetto alle regole della privacy per accesso alle info protette'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='set regole di accesso nominative per desktop';

-- --------------------------------------------------------

--
-- Table structure for table `privacy_event`
--

CREATE TABLE `privacy_event` (
  `eventMarker` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'ID evento - time marker',
  `eventOwnerType` char(1) NOT NULL COMMENT 'ID evento - tipo di owner',
  `eventOwnerId` bigint(20) NOT NULL COMMENT 'ID eventio - ID owner',
  `id` int(11) NOT NULL COMMENT 'ID record per owner',
  `friendId` bigint(20) NOT NULL COMMENT 'ID amico soggetto alle regole della privacy per accesso alle info protette'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='set regole di accesso nominative per eventi';

-- --------------------------------------------------------

--
-- Table structure for table `privacy_group_message`
--

CREATE TABLE `privacy_group_message` (
  `groupId` bigint(20) NOT NULL COMMENT 'ID gruppo',
  `senderId` bigint(20) NOT NULL COMMENT 'ID utente autore del messaggio (chi lo ha inviato)',
  `createDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'timestamp di creazione del messaggio',
  `id` int(11) NOT NULL COMMENT 'ID record per owner',
  `friendId` bigint(20) NOT NULL COMMENT 'ID amico soggetto alle regole della privacy per accesso alle info protette'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='set regole di accesso nominative per commenti owner sui gruppi';

-- --------------------------------------------------------

--
-- Table structure for table `privacy_lc_annotation`
--

CREATE TABLE `privacy_lc_annotation` (
  `userId` bigint(20) NOT NULL,
  `bookId` bigint(20) NOT NULL,
  `seq` int(11) NOT NULL COMMENT 'Numero di versione del file (se ce ne sono 1+)',
  `idTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id` int(11) NOT NULL COMMENT 'ID record per owner',
  `friendId` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='set regole di accesso nominative per annotazioni sui libri (LearnChance)';

-- --------------------------------------------------------

--
-- Table structure for table `privacy_setting`
--

CREATE TABLE `privacy_setting` (
  `ownerId` bigint(20) NOT NULL COMMENT 'ID proprietario delle informazioni Protette',
  `isPrivacySetDesktop` tinyint(1) DEFAULT 0 COMMENT 'Flag Privacy attiva o no per Desktop\n- TRUE = privacy Attiva\n- FALSE = privacy NON attiva (default) - info visibili a tutti',
  `isProtectedVisibleDesktop` tinyint(1) DEFAULT 1 COMMENT 'Flag info Protette visibili ad amici (scelta utente)\n- TRUE = abilitata – amici vedono info Protette\n- FALSE = disabilitata - dati visibili solo per owner (default)',
  `isEnabledAclDesktop` tinyint(1) DEFAULT 0 COMMENT 'Flag abilitazione visibilità amici con ACL\n- TRUE = abilitata (con uso tbl supplementare)\n- FALSE = disabilitata (default)',
  `isDenyAclDesktop` tinyint(1) DEFAULT 0 COMMENT 'Flag tipo di ACL\n- TRUE = Deny – amici in ACL NON vedono info\n- FALSE = Allow – amici in ACL vedono info\n',
  `descrDesktop` varchar(200) DEFAULT NULL COMMENT 'descrizione Privacy Desktop',
  `isPrivacySetEvent` tinyint(1) DEFAULT 0 COMMENT 'Flag Privacy attiva o no per Event\n- TRUE = privacy Attiva\n- FALSE = privacy NON attiva (default) - info visibili a tutti',
  `isProtectedVisibleEvent` tinyint(1) DEFAULT 1 COMMENT 'Flag info Protette visibili ad amici (scelta utente)\n- TRUE = abilitata – amici vedono info Protette\n- FALSE = disabilitata - dati visibili solo per owner (default)',
  `isEnabledAclEvent` tinyint(1) DEFAULT 0 COMMENT 'Flag abilitazione visibilità amici con ACL\n- TRUE = abilitata (con uso tbl supplementare)\n- FALSE = disabilitata (default)',
  `isDenyAclEvent` tinyint(1) DEFAULT 0 COMMENT 'Flag tipo di ACL\n- TRUE = Deny – amici in ACL NON vedono info\n- FALSE = Allow – amici in ACL vedono info\n',
  `descrEvent` varchar(200) DEFAULT NULL COMMENT 'descrizione Privacy Event',
  `isPrivacySetLearnChance` tinyint(1) DEFAULT 0 COMMENT 'Flag Privacy attiva o no per LearnChance\n- TRUE = privacy Attiva\n- FALSE = privacy NON attiva (default) - info visibili a tutti',
  `isProtectedVisibleLearnChance` tinyint(1) DEFAULT 1 COMMENT 'Flag info Protette visibili ad amici (scelta utente)\n- TRUE = abilitata – amici vedono info Protette\n- FALSE = disabilitata - dati visibili solo per owner (default)',
  `isEnabledAclLCAnnotation` tinyint(1) DEFAULT 0 COMMENT 'LearnChance - Annotation\nFlag abilitazione visibilità amici con ACL\n- TRUE = abilitata (con uso tbl supplementare)\n- FALSE = disabilitata (default)',
  `isDenyAclLCAnnotation` tinyint(1) DEFAULT 0 COMMENT 'Flag tipo di ACL\n- TRUE = Deny – amici in ACL NON vedono info\n- FALSE = Allow – amici in ACL vedono info\n',
  `descrLearnChance` varchar(200) DEFAULT NULL COMMENT 'descrizione Privacy LearnChance',
  `isPrivacySetComment` tinyint(1) DEFAULT 0 COMMENT 'Flag Privacy attiva o no per GroupComment\n- TRUE = privacy Attiva\n- FALSE = privacy NON attiva (default) - info visibili a tutti',
  `isProtectedVisibleComment` tinyint(1) DEFAULT 1 COMMENT 'Flag info Protette visibili ad amici (scelta utente)\n- TRUE = abilitata – amici vedono info Protette\n- FALSE = disabilitata - dati visibili solo per owner (default)',
  `isEnabledAclComment` tinyint(1) DEFAULT 0 COMMENT 'Flag abilitazione visibilità amici con ACL\n- TRUE = abilitata (con uso tbl supplementare)\n- FALSE = disabilitata (default)',
  `isDenyAcl_copy1` tinyint(1) DEFAULT 0 COMMENT 'Flag tipo di ACL\n- TRUE = Deny – amici in ACL NON vedono info\n- FALSE = Allow – amici in ACL vedono info\n',
  `isDenyAclComment` varchar(200) DEFAULT NULL COMMENT 'descrizione Privacy ',
  `isPrivacySetSurvey` tinyint(1) DEFAULT 0 COMMENT 'Flag Privacy attiva o no per Survey\n- TRUE = privacy Attiva\n- FALSE = privacy NON attiva (default) - info visibili a tutti',
  `isProtectedVisibleSurvey` tinyint(1) DEFAULT 1 COMMENT 'Flag info Protette visibili ad amici (scelta utente)\n- TRUE = abilitata – amici vedono info Protette\n- FALSE = disabilitata - dati visibili solo per owner (default)',
  `isEnabledAclSurvey` tinyint(1) DEFAULT 0 COMMENT 'Flag abilitazione visibilità amici con ACL\n- TRUE = abilitata (con uso tbl supplementare)\n- FALSE = disabilitata (default)',
  `isDenyAclSurvey` tinyint(1) DEFAULT 0 COMMENT 'Flag tipo di ACL\n- TRUE = Deny – amici in ACL NON vedono info\n- FALSE = Allow – amici in ACL vedono info\n',
  `descrSurvey` varchar(200) DEFAULT NULL COMMENT 'descrizione Privacy Survey',
  `isPrivacySetExtra1` tinyint(1) DEFAULT 0 COMMENT 'uso futuro\nFlag Privacy attiva o no per Extra1\n- TRUE = privacy Attiva\n- FALSE = privacy NON attiva (default) - info visibili a tutti',
  `isProtectedVisibleExtra1` tinyint(1) DEFAULT 1 COMMENT 'uso futuro\nFlag info Protette visibili ad amici (scelta utente)\n- TRUE = abilitata – amici vedono info Protette\n- FALSE = disabilitata - dati visibili solo per owner (default)',
  `isEnabledAclExtra1` tinyint(1) DEFAULT 0 COMMENT 'uso futuro\nFlag abilitazione visibilità amici con ACL\n- TRUE = abilitata (con uso tbl supplementare)\n- FALSE = disabilitata (default)',
  `isDenyAclExtra1` tinyint(1) DEFAULT 0 COMMENT 'Flag tipo di ACL\n- TRUE = Deny – amici in ACL NON vedono info\n- FALSE = Allow – amici in ACL vedono info\n',
  `descrExtra1` varchar(200) DEFAULT NULL COMMENT 'descrizione Privacy Extra1',
  `isPrivacySetExtra2` tinyint(1) DEFAULT 0 COMMENT 'uso futuro\nFlag Privacy attiva o no per Extra2\n- TRUE = privacy Attiva\n- FALSE = privacy NON attiva (default) - info visibili a tutti',
  `isProtectedVisibleExtra2` tinyint(1) DEFAULT 1 COMMENT 'uso futuro\nFlag info Protette visibili ad amici (scelta utente)\n- TRUE = abilitata – amici vedono info Protette\n- FALSE = disabilitata - dati visibili solo per owner (default)',
  `isEnabledAclExtra2` tinyint(1) DEFAULT 0 COMMENT 'uso futuro\nFlag abilitazione visibilità amici con ACL\n- TRUE = abilitata (con uso tbl supplementare)\n- FALSE = disabilitata (default)',
  `isDenyAclExtra2` tinyint(1) DEFAULT 0 COMMENT 'Flag tipo di ACL\n- TRUE = Deny – amici in ACL NON vedono info\n- FALSE = Allow – amici in ACL vedono info\n',
  `descrExtra2` varchar(200) DEFAULT NULL COMMENT 'descrizione Privacy Extra2',
  `isPrivacySetExtra3` tinyint(1) DEFAULT 0 COMMENT 'uso futuro\nFlag Privacy attiva o no per Extra3\n- TRUE = privacy Attiva\n- FALSE = privacy NON attiva (default) - info visibili a tutti',
  `isProtectedVisibleExtra3` tinyint(1) DEFAULT 1 COMMENT 'uso futuro\nFlag info Protette visibili ad amici (scelta utente)\n- TRUE = abilitata – amici vedono info Protette\n- FALSE = disabilitata - dati visibili solo per owner (default)',
  `isEnabledAclExtra3` tinyint(1) DEFAULT 0 COMMENT 'uso futuro\nFlag abilitazione visibilità amici con ACL\n- TRUE = abilitata (con uso tbl supplementare)\n- FALSE = disabilitata (default)',
  `isDenyAclExtra3` tinyint(1) DEFAULT 0 COMMENT 'Flag tipo di ACL\n- TRUE = Deny – amici in ACL NON vedono info\n- FALSE = Allow – amici in ACL vedono info\n',
  `descrExtra3` varchar(200) DEFAULT NULL COMMENT 'descrizione Privacy Extra3',
  `isPrivacySetExtra4` tinyint(1) DEFAULT 0 COMMENT 'uso futuro\nFlag Privacy attiva o no per Extra4\n- TRUE = privacy Attiva\n- FALSE = privacy NON attiva (default) - info visibili a tutti',
  `isProtectedVisibleExtra4` tinyint(1) DEFAULT 1 COMMENT 'uso futuro\nFlag info Protette visibili ad amici (scelta utente)\n- TRUE = abilitata – amici vedono info Protette\n- FALSE = disabilitata - dati visibili solo per owner (default)',
  `isEnabledAclExtra4` tinyint(1) DEFAULT 0 COMMENT 'uso futuro\nFlag abilitazione visibilità amici con ACL\n- TRUE = abilitata (con uso tbl supplementare)\n- FALSE = disabilitata (default)',
  `isDenyAclExtra4` tinyint(1) DEFAULT 0 COMMENT 'Flag tipo di ACL\n- TRUE = Deny – amici in ACL NON vedono info\n- FALSE = Allow – amici in ACL vedono info\n',
  `descrExtra4` varchar(200) DEFAULT NULL COMMENT 'descrizione Privacy Extra4'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Definisce strategia di gestione Privacy per alcune categorie di informazioni';

-- --------------------------------------------------------

--
-- Table structure for table `privacy_survey`
--

CREATE TABLE `privacy_survey` (
  `surveyId` bigint(20) NOT NULL COMMENT 'ID sondaggio',
  `creatorId` bigint(20) NOT NULL COMMENT 'ID creatore del sondaggio - può essere un utente normale oppure un utente operatore della piattaforma per sondaggi Globali',
  `id` int(11) NOT NULL COMMENT 'ID record per owner',
  `friendId` bigint(20) NOT NULL COMMENT 'ID amico soggetto alle regole della privacy per accesso alle info protette'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='set regole di accesso nominative per sondaggi';

-- --------------------------------------------------------

--
-- Table structure for table `privacy_user`
--

CREATE TABLE `privacy_user` (
  `ownerId` bigint(20) NOT NULL COMMENT 'ID proprietario informazione',
  `id` int(11) NOT NULL COMMENT 'ID record per owner',
  `infoTypeId` char(45) NOT NULL COMMENT 'ID tipo info utente',
  `friendId` bigint(20) NOT NULL COMMENT 'ID amico soggetto alle regole della privacy per accesso alle info protette'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='set regole di accesso nominative per info owner protette';

-- --------------------------------------------------------

--
-- Table structure for table `privacy_user_setting`
--

CREATE TABLE `privacy_user_setting` (
  `ownerId` bigint(20) NOT NULL COMMENT 'ID proprietario delle informazioni Protette',
  `infoTypeId` char(45) NOT NULL COMMENT 'ID tipo info utente',
  `isPrivacySet` tinyint(1) DEFAULT 0 COMMENT 'Flag Privacy attiva o no per il tipo di informazione utente\n- TRUE = privacy Attiva\n- FALSE = privacy NON attiva (default) - info visibili a tutti',
  `isProtectedVisible` tinyint(1) DEFAULT 1 COMMENT 'Flag info Protette visibili ad amici (scelta utente)\n- TRUE = abilitata – amici vedono info Protette\n- FALSE = disabilitata - dati visibili solo per owner (default)',
  `isEnabledAcl` tinyint(1) DEFAULT 0 COMMENT 'Flag abilitazione visibilità amici con ACL\n- TRUE = abilitata (con uso tbl supplementare)\n- FALSE = disabilitata (default)',
  `isDenyAcl` tinyint(1) DEFAULT 0 COMMENT 'Flag tipo di ACL\n- TRUE = Deny – amici in ACL NON vedono info\n- FALSE = Allow – amici in ACL vedono info\n',
  `descr` varchar(200) DEFAULT NULL COMMENT 'descrizione Privacy del tipo di informazione utente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Definisce strategia di gestione Privacy per i vari tipi di informazioni utente';

-- --------------------------------------------------------

--
-- Table structure for table `profession`
--

CREATE TABLE `profession` (
  `id` int(11) NOT NULL COMMENT 'id professione',
  `note` mediumtext DEFAULT NULL COMMENT 'note',
  `code` varchar(45) DEFAULT NULL COMMENT 'eventuale codice per raggruppamento professioni',
  `isXCond1` tinyint(1) DEFAULT 0 COMMENT 'flag libero 1',
  `isXCond2` tinyint(1) DEFAULT 0 COMMENT 'flag libero 2',
  `isXCond3` tinyint(1) DEFAULT 0 COMMENT 'flag libero 3',
  `xChar1` char(1) DEFAULT '' COMMENT 'indicatore carattere libero 1',
  `xChar2` char(1) DEFAULT '' COMMENT 'indicatore carattere libero 2',
  `xString` varchar(45) DEFAULT NULL COMMENT 'stringa testo libero 1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='elenco professioni per Autori';

-- --------------------------------------------------------

--
-- Table structure for table `profession_lang`
--

CREATE TABLE `profession_lang` (
  `id` int(11) NOT NULL,
  `langId` char(2) NOT NULL,
  `name` varchar(100) NOT NULL COMMENT 'nome professione in lingua',
  `description` varchar(245) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='nomi professioni in lingua';

-- --------------------------------------------------------


--
-- Table structure for table `projectbccemails`
--

CREATE TABLE `projectbccemails` (
  `id` bigint(20) NOT NULL,
  `email_id` bigint(20) NOT NULL,
  `bccuser_id` bigint(20) NOT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `projectccemails`
--

CREATE TABLE `projectccemails` (
  `id` bigint(20) NOT NULL,
  `email_id` bigint(20) NOT NULL,
  `ccuser_id` bigint(20) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `projectemail`
--

CREATE TABLE `projectemail` (
  `id` bigint(20) NOT NULL,
  `parentemail_id` bigint(20) DEFAULT NULL,
  `rootmail_id` bigint(20) DEFAULT NULL,
  `forwarded_id` bigint(20) DEFAULT NULL,
  `fromuser_id` bigint(20) NOT NULL,
  `subject` text DEFAULT NULL,
  `body` varchar(500) DEFAULT NULL,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `send_date` datetime NOT NULL DEFAULT current_timestamp(),
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  `isSent` tinyint(1) NOT NULL DEFAULT 0,
  `isDraft` tinyint(1) NOT NULL DEFAULT 0,
  `isStarred` tinyint(1) NOT NULL DEFAULT 0,
  `worklable` char(1) DEFAULT NULL,
  `isRead` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `projectfiles`
--

CREATE TABLE `projectfiles` (
  `id` bigint(20) NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `filename` varchar(250) DEFAULT NULL,
  `filepath` varchar(250) DEFAULT NULL,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `type` varchar(250) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  `temp` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `projecttasks`
--

CREATE TABLE `projecttasks` (
  `id` bigint(20) NOT NULL,
  `project_id` bigint(20) UNSIGNED DEFAULT NULL,
  `referred_taskId` bigint(20) DEFAULT NULL,
  `creatorId` bigint(20) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `tax_percentage` decimal(5,2) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'T',
  `category` varchar(255) DEFAULT NULL,
  `type` char(2) NOT NULL DEFAULT 'TS',
  `isApproved` tinyint(1) NOT NULL DEFAULT 0,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  `startdate` datetime DEFAULT current_timestamp(),
  `expiration_date` datetime DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `isFuturedTask` tinyint(1) NOT NULL DEFAULT 0,
  `status_updatedby` bigint(20) DEFAULT NULL,
  `priority` char(1) DEFAULT NULL,
  `index_number` int(11) DEFAULT NULL,
  `isEpic` tinyint(1) NOT NULL DEFAULT 0,
  `ishaveAnalyst` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `projecttypes`
--

CREATE TABLE `projecttypes` (
  `id` int(11) NOT NULL,
  `order_number` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `project_member`
--

CREATE TABLE `project_member` (
  `id` bigint(20) NOT NULL,
  `projectId` bigint(20) UNSIGNED NOT NULL,
  `memberId` bigint(20) DEFAULT NULL,
  `accessLevel` int(11) DEFAULT NULL,
  `joinDate` datetime DEFAULT current_timestamp(),
  `sponsorId` bigint(20) NOT NULL DEFAULT 0,
  `isInvitation` tinyint(1) NOT NULL DEFAULT 1,
  `invitationDate` datetime DEFAULT NULL,
  `isMembershipRequest` tinyint(1) NOT NULL DEFAULT 0,
  `membershipRequestDate` datetime DEFAULT NULL,
  `isBanned` tinyint(1) DEFAULT 0,
  `banDate` datetime DEFAULT NULL,
  `bannerId` bigint(20) NOT NULL DEFAULT 0,
  `banReason` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `department_id` bigint(20) NOT NULL,
  `designation_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_object`
--

CREATE TABLE `project_object` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) DEFAULT NULL,
  `superCode` varchar(252) DEFAULT NULL,
  `name` varchar(120) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `startdate` datetime DEFAULT NULL,
  `expirydate` datetime DEFAULT NULL,
  `description2` varchar(245) DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  `creatorId` bigint(20) UNSIGNED DEFAULT NULL,
  `createDate` datetime DEFAULT current_timestamp(),
  `visibility` char(1) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `isSchool` tinyint(1) NOT NULL DEFAULT 0,
  `isRestricted` tinyint(1) NOT NULL DEFAULT 0,
  `fatherId` bigint(20) UNSIGNED DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `isMembershipRequestAllowed` tinyint(1) NOT NULL DEFAULT 0,
  `isInvitationAllowed` tinyint(1) NOT NULL DEFAULT 0,
  `isBanAllowed` tinyint(1) NOT NULL DEFAULT 0,
  `isArchieveAllowed` tinyint(1) NOT NULL DEFAULT 0,
  `imageFileName` varchar(255) DEFAULT NULL,
  `imageFilePath` varchar(255) DEFAULT NULL,
  `imageFileServer` varchar(255) DEFAULT NULL,
  `image` binary(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `type` char(1) DEFAULT NULL,
  `summary_title` varchar(255) DEFAULT NULL,
  `summary_description` text DEFAULT NULL,
  `summaryfilepath` varchar(255) DEFAULT NULL,
  `summaryfilename` varchar(255) DEFAULT NULL,
  `isFuturedProject` tinyint(1) NOT NULL DEFAULT 0,
  `isPersonal` char(1) DEFAULT NULL,
  `status` char(1) DEFAULT 'A',
  `priority` char(1) DEFAULT 'H',
  `totalgroups` int(11) DEFAULT NULL,
  `total_workinghours` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `countryId` char(2) NOT NULL COMMENT 'id country',
  `regionId` int(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'id regione nella country',
  `id` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'id provincia nella country',
  `name` varchar(70) NOT NULL,
  `tag` varchar(45) DEFAULT NULL COMMENT 'Sigla provincia (Targa)',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'flag provincia cessata (default FALSE)',
  `note` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Elenco province';

-- --------------------------------------------------------

--
-- Table structure for table `publisher`
--

CREATE TABLE `publisher` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL COMMENT 'nome editore / casa editrice',
  `webSite` varchar(250) DEFAULT NULL COMMENT 'Indirizzo (URL) sito web editore',
  `note` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Editori / Case Editrici';

-- --------------------------------------------------------

--
-- Table structure for table `region`
--

CREATE TABLE `region` (
  `countryId` char(2) NOT NULL COMMENT 'ID country della regione',
  `id` int(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID regione nella country',
  `name` varchar(70) NOT NULL COMMENT 'nome regione',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag regione cessata (default FALSE)',
  `note` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Elenco Regioni (IT/FR/GB) / Regionen (DE) / Stati (USA) / Cantoni (CH)\n\nOgni regione ha altre divisioni: \n- (IT) Provincie+Comuni\n- (FR) Dipartimenti+Arrodisment+Cantoni\n- (GB) County+District\n- (CH) Distretti\n\nvedere il sito \nhttp://www.fedre.org/it/content/elenco-delle-regioni\nvedere elenco comuni (GB-municipality/district), (FR-commune)';

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `email_id` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `date_of_birth` datetime DEFAULT NULL,
  `validation_code` varchar(255) DEFAULT NULL,
  `validation_expirydate` datetime DEFAULT NULL,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `isCompany` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `repeate_shifts`
--

CREATE TABLE `repeate_shifts` (
  `id` bigint(20) NOT NULL,
  `shift_id` bigint(20) NOT NULL,
  `weeks_of_repeat` int(11) NOT NULL,
  `dayname` varchar(255) DEFAULT NULL,
  `endof_repeating_shift` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `libraryId` bigint(20) NOT NULL COMMENT 'ID libreria',
  `libraryType` char(1) NOT NULL COMMENT 'Tipo libreria - U = Utente, R = Organizzazione, P = Piattaforma',
  `bookId` bigint(20) NOT NULL COMMENT 'ID libro',
  `userId` bigint(20) NOT NULL COMMENT 'id utente che ha prenotato il libro',
  `requestDate` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Data della prenotazione',
  `endDate` date DEFAULT NULL COMMENT 'Data di fine attesa / Annullamento prenotazione (indicata da utente)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Prenotazioni Libri (se libro non disponibile per il prestito al momento della richiesta utente)';

-- --------------------------------------------------------

--
-- Table structure for table `reservation_closed`
--

CREATE TABLE `reservation_closed` (
  `libraryId` bigint(20) NOT NULL COMMENT 'ID libreria',
  `libraryType` char(1) NOT NULL COMMENT 'Tipo libreria - U = Utente, R = Organizzazione, P = Piattaforma',
  `bookId` bigint(20) NOT NULL COMMENT 'ID libro',
  `userId` bigint(20) NOT NULL COMMENT 'ID utente che ha prenotato il libro',
  `requestDate` datetime NOT NULL COMMENT 'Data della prenotazione',
  `endDate` date NOT NULL COMMENT 'Data di fine attesa / Annullamento prenotazione (impostata da utente)',
  `action` char(1) NOT NULL COMMENT 'Motivo della chiusura della prenotazione\nP = Libro Prestato\nX = prenotazione scaduta (oltre il termine fissato da utente)\nC = prenotazione cancellata da utente\nD = prenotazione cancellata da sistema + motivo',
  `description` varchar(70) DEFAULT NULL COMMENT 'motivo in caso di cancellazione da parte del sistema',
  `closingDate` timestamp NULL DEFAULT current_timestamp() COMMENT 'Timestamp creazione record - passaggio prenotazione a storico prenotazione chiuse'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Archivio Prenotazioni chiuse (soddisfatte o cancellate)';

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL COMMENT 'ID Ruolo',
  `name` varchar(45) NOT NULL COMMENT 'nome ruolo - deve essere unico per ogni organizationId - varie organizzazioni possono definire e usare uno stesso nome ruolo',
  `organizationId` bigint(20) DEFAULT NULL COMMENT 'eventuale ID organizzazione  - se il ruolo afferisce a una specifica organizzazione, NULL (default) se il ruolo è generico (applicabile a qualsiasi utente, sia privato sia di organizzazione)',
  `description` varchar(100) DEFAULT NULL,
  `isUser` tinyint(1) DEFAULT 0 COMMENT 'utilizzatore piattaforma',
  `isOperator` tinyint(1) DEFAULT 0 COMMENT 'gestore piattaforma',
  `isDeveloper` tinyint(1) DEFAULT 0 COMMENT 'sviluppatore',
  `isSetup` tinyint(1) DEFAULT 0 COMMENT 'utente per setup iniziale - modifica e caricamento tabelle di configurazione',
  `isAdmin` tinyint(1) DEFAULT 0 COMMENT 'admin della piattaforma - NON ha vincoli sulle operazioni possibili e può vedere tutto',
  `isCompanyReader` tinyint(1) DEFAULT 0 COMMENT 'Flag utente speciale Azienda - Reader',
  `isCompanyEditor` tinyint(1) DEFAULT 0 COMMENT 'Flag utente speciale Azienda - Editor',
  `isCompanyMaster` tinyint(1) DEFAULT 0 COMMENT 'Flag utente speciale Azienda - Master',
  `isSchoolStudent` tinyint(1) DEFAULT 0 COMMENT 'Flag utente speciale Scuola - Studente',
  `isSchoolTeacher` tinyint(1) DEFAULT 0 COMMENT 'Flag utente speciale Scuola - Docente',
  `isSchoolMaster` tinyint(1) DEFAULT 0 COMMENT 'Flag utente speciale Scuola - Master',
  `isXCond1` tinyint(1) DEFAULT 0,
  `isXCond2` tinyint(1) DEFAULT 0 COMMENT 'condizione libero 2',
  `isXCond3` tinyint(1) DEFAULT 0 COMMENT 'condizione libero 3',
  `xChar10x1` char(10) DEFAULT NULL COMMENT 'char 10 libero 2',
  `xChar10x2` char(10) DEFAULT NULL COMMENT 'char 10 libero 2',
  `xString1` varchar(45) DEFAULT NULL COMMENT 'stringa libero 2',
  `xString2` varchar(45) DEFAULT NULL COMMENT 'stringa libero 2',
  `xChar1` char(1) DEFAULT NULL COMMENT 'carattere libero 2',
  `xChar2` char(2) DEFAULT NULL COMMENT 'carattere libero 1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Elenco Ruoli utente nella piattaforma\n\nUSER - utente utlizzatore della piattaforma\nOPERATOR - operatore\nADMIN - operatore admin\nDEVELOP - Sviluppatore\nSETUP - utente per modifica parametri di configurazione';

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `designation_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `usermodule_id` bigint(20) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE `salaries` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `net_salary` decimal(10,2) DEFAULT NULL,
  `tds` decimal(5,2) DEFAULT NULL,
  `da` decimal(5,2) DEFAULT NULL,
  `esi` decimal(5,2) DEFAULT NULL,
  `hra` decimal(5,2) DEFAULT NULL,
  `pf` decimal(5,2) DEFAULT NULL,
  `tax` decimal(5,2) DEFAULT NULL,
  `month` varchar(250) DEFAULT NULL,
  `year` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `saved_exchange_rate`
--

CREATE TABLE `saved_exchange_rate` (
  `currencyCode` char(3) NOT NULL COMMENT 'codice valuta (ISO 4217)',
  `checkDate` date NOT NULL COMMENT 'data verifica cambio',
  `refCurrencyCode` char(3) NOT NULL COMMENT 'codice valuta di riferimento al momento di archiviazione record',
  `updateDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Timestamp di quando il dato è stato aggiornato',
  `updateUserId` bigint(20) NOT NULL COMMENT 'ID utente che ha aggiornato il dato',
  `exchangeValue` decimal(11,5) NOT NULL COMMENT 'valore cambio rispetto a 1 nella valuta di riferimento per operazioni in valuta',
  `exchangeValueBuy` decimal(11,5) NOT NULL COMMENT 'valore cambio rispetto a 1 nella valuta di riferimento per acquistare la valuta',
  `exchangeValueSell` decimal(11,5) NOT NULL COMMENT 'valore cambio rispetto a 1 nella valuta di riferimento per vendere la valuta',
  `extraDate` date DEFAULT NULL COMMENT 'Data libera',
  `extraValue` decimal(11,5) DEFAULT NULL COMMENT 'valore libero'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Storico cambi Valuta / Tassi di Cambio rispetto alla valuta di riferimento ';

-- --------------------------------------------------------

--
-- Table structure for table `school_course`
--

CREATE TABLE `school_course` (
  `id` bigint(20) NOT NULL COMMENT 'ID corso di studi',
  `name` varchar(150) NOT NULL COMMENT 'nome corso',
  `description` tinytext DEFAULT NULL COMMENT 'descrizione corso',
  `langCode` char(2) NOT NULL COMMENT 'Codice lingua (ISO 639) del corso',
  `numberOfYears` int(11) DEFAULT 0 COMMENT 'lunghezza del corso in anni - 0 = lunghezza non significativa',
  `yearsMap` varchar(8) DEFAULT NULL COMMENT 'Obbligatorio per SS2 e SS1\nmappa degli anni di corso (come vengono chiamati gli anni) - da usare per mappare le materie anno di corso a quelle dello studente\nes. \nSS2 - Biennio = 12\nSS2 - Triennio = 345\nUNI - Laurea Triennale = 123\nUNI - Laurea Magistrale = 12\nUNI - corsi semestrali = 1',
  `creationYear` year(4) DEFAULT NULL COMMENT 'anno di creazione corso di laurea',
  `dismissionYear` year(4) DEFAULT NULL COMMENT 'anno di dismissione del corso di laurea',
  `teachingAreaId` bigint(20) NOT NULL COMMENT 'Facolta/indirizzo a cui appartiene il corso',
  `degreeClassId` int(11) NOT NULL COMMENT 'ID classe di laurea',
  `note` mediumtext DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Corsi di Studio della scuola\nSOLO per ambiente scolastico\n\n- UNI - Corsi di Laurea\n- SS2 - corsi di specializzazione\n- SS1 - corso unico\n\nesempi SS2\n- Lic.Artistico - Biennio\n- Lic.Artistico - Design\n- Lic.Artistico - Grafica\n- Lic.Artistico - Scenografia\n';

-- --------------------------------------------------------

--
-- Table structure for table `school_data`
--

CREATE TABLE `school_data` (
  `schoolId` bigint(20) NOT NULL COMMENT 'ID istituto',
  `code` char(36) NOT NULL COMMENT 'Codice Ministeriale Istituto/Plesso (ITA 10 char) oppure un codice di tipo UUID4 (36 char) se non esiste codice ministeriale - da settare con caricamento di massa dati ministeriali',
  `referenceCode` char(36) NOT NULL COMMENT 'Codice istituto principale o di riferimento - se isituto è quello principale allora settare = code - da settare con caricamento di massa dati ministeriali',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag record cancellato - DEVE essere settato come il flag isDeleted della tbl school',
  `istatCodeRegion` int(2) UNSIGNED ZEROFILL DEFAULT NULL COMMENT 'Codice ISTAT Regione Italia - da settare con caricamento di massa dati ministeriali',
  `istatCodeProvince` int(3) UNSIGNED ZEROFILL DEFAULT NULL COMMENT 'Codice ISTAT Provincia Italia - da settare con caricamento di massa dati ministeriali',
  `istatCodeCity` int(3) UNSIGNED ZEROFILL DEFAULT NULL COMMENT 'Codice ISTAT Comune Italia - da settare con caricamento di massa dati ministeriali',
  `isStateSchool` tinyint(1) DEFAULT 1 COMMENT 'Flag scuola statale (TRUE) o paritaria/privata (FALSE) - da settare con caricamento di massa dati ministeriali',
  `schoolTypeId` int(11) DEFAULT NULL COMMENT 'ID tipo scuola - potrebbero averlo solo le sedi principali '
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Dati Istituti Scolastici e Atenei, NON per aziende';

-- --------------------------------------------------------

--
-- Table structure for table `school_e_condition`
--

CREATE TABLE `school_e_condition` (
  `schoolId` bigint(20) NOT NULL COMMENT 'id scuola / Ente',
  `description` varchar(100) NOT NULL COMMENT 'Descrizione accordo con la scuola',
  `publicationCost` decimal(10,2) NOT NULL COMMENT 'Costo applicato dalla piattaforma alla scuola per la pubblicazione di corsi NON Gratis',
  `specialPrice` decimal(10,2) DEFAULT NULL COMMENT 'Prezzo speciale definito dalla scuola/ente per gli utenti associati - NON può essere inferiore al costo di pubblicazione\nPRIORITARIO sullo Sconto',
  `discount` decimal(5,2) DEFAULT 0.00 COMMENT 'Sconto riservato agli utenti associati alla scuola/ente\nil prezzo scontato NON può essere INFERIORE al costo di pubblicazione\nlo sconto si applica al prezzo di listino (tabella price)',
  `startDate` date DEFAULT NULL COMMENT 'Data di inizio validità accordo per il costo di pubblicazione della Scuola/Ente',
  `endDate` date DEFAULT NULL COMMENT 'Data di fine validità accordo per il costo di pubblicazione della Scuola/Ente\ndeve essere successiva alla startDate',
  `note` mediumtext DEFAULT NULL COMMENT 'Note',
  `isDeleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Condizioni economiche particolari dei corsi di eLearning per gli utenti Interni (quelli associati alla scuola/azienda)\nApplicabile SOLO ai corsi con schoolOwnerId = ID scuola';

-- --------------------------------------------------------

--
-- Table structure for table `school_level`
--

CREATE TABLE `school_level` (
  `id` char(3) NOT NULL COMMENT 'ID livello scuola',
  `note` mediumtext DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Livelli della scuola\n\nSM0 - Materna\nSP0 - Elementare\nSS1 - Media\nSS2 - Superiore\nUNI - Universita\n';

-- --------------------------------------------------------

--
-- Table structure for table `school_level_lang`
--

CREATE TABLE `school_level_lang` (
  `id` char(3) NOT NULL,
  `langId` char(2) NOT NULL,
  `name` varchar(100) NOT NULL COMMENT 'Nome livello scuola in lingua',
  `descr` varchar(245) DEFAULT NULL COMMENT 'Descrizione'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='nome livello scuola in lingua';

-- --------------------------------------------------------

--
-- Table structure for table `school_teaching_area`
--

CREATE TABLE `school_teaching_area` (
  `id` bigint(20) NOT NULL COMMENT 'ID teaching area',
  `schoolId` bigint(20) NOT NULL COMMENT 'ID istituto scolastico',
  `departmentCode` char(10) NOT NULL,
  `code` bigint(20) DEFAULT NULL COMMENT 'ID area insegnamento se predefinita da direttive ministeriali (es. teaching_area MIUR-SS2)',
  `name` varchar(150) NOT NULL COMMENT 'Nome Facolta (UNI) / Indirizzo (SS2)',
  `note` mediumtext DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Area di insegnamento - (facolta per universita, indirizzo per SS2)\n\nper UNI sono le Facolta\nMedicina, \nMM.FF.NN., \nEconomia, \nGiurisprudenza\n\nper SS2 sono gli indirizzi di specializzazione\nLiceo Artistico, \nIst.Tec. Economico Turismo, \nIst.Tec. Trasporti e Logistica, \nIst.Tec. Informatica e TLC, \nIst.Prof. Servizi Socio-Sanitari, \nIst.Prof. Produzioni Industriali e Artigianali\n\nper SS1 indirizzo unico \nscuola media\n';

-- --------------------------------------------------------

--
-- Table structure for table `school_transcripts`
--

CREATE TABLE `school_transcripts` (
  `user_id` bigint(20) NOT NULL,
  `organization_id` bigint(20) NOT NULL,
  `e_course_id` bigint(20) NOT NULL,
  `is_without_mark` tinyint(1) NOT NULL DEFAULT 0,
  `mark` varchar(255) DEFAULT NULL,
  `exam_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Libretto scolastico';

-- --------------------------------------------------------

--
-- Table structure for table `school_type`
--

CREATE TABLE `school_type` (
  `id` int(11) NOT NULL COMMENT 'id tipo scuola',
  `countryId` char(2) NOT NULL COMMENT 'id country in cui è definito il tipo istituto',
  `name` varchar(100) NOT NULL COMMENT 'nome tipo istituto come definito nella country',
  `schoolLevelId` char(3) NOT NULL COMMENT 'id livello istituto (SS2, UNI, ...)',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag record cancellato (TRUE) o attivo (FALSE - default)',
  `note` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tipo di scuola per country\n\ninformazione MIUR legata ad ogni scuola\n\nesempio per ITALIA\n- scuola infanzia\n- scuola primaria\n- istituto comprensivo\n- istituto superiore\n- ist.tec. geometri\n- ist.tec. commerciale\n- ist magistrale\n- ist.prof. industria e artigianato\n- ist prof agricoltura e ambiente\n- ist.tec. commerciale e geometri\n- ist.prof. serv. alberghieri e ristorazione\n- lic scientifico\n- lic classico\n- centro territoriale\n';

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `company_id` bigint(20) DEFAULT NULL,
  `two_factor_authentication` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shift_schedules`
--

CREATE TABLE `shift_schedules` (
  `id` bigint(20) NOT NULL,
  `company_id` bigint(20) DEFAULT NULL,
  `department_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `shift_id` bigint(20) DEFAULT NULL,
  `scheduledshift_startdate` datetime DEFAULT NULL,
  `scheduledshift_enddate` datetime DEFAULT NULL,
  `isAcceptExtrahrs` tinyint(1) NOT NULL DEFAULT 0,
  `isPublish` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sl_roles`
--

CREATE TABLE `sl_roles` (
  `user_id` bigint(20) NOT NULL,
  `category` char(1) NOT NULL,
  `level` int(11) NOT NULL,
  `country_id` char(5) NOT NULL,
  `isBlocked` tinyint(1) NOT NULL DEFAULT 0,
  `blockReason` varchar(255) DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  `blockDate` datetime DEFAULT NULL,
  `deleteDate` datetime DEFAULT NULL,
  `note` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ssd`
--

CREATE TABLE `ssd` (
  `id` int(11) NOT NULL COMMENT 'ID SSD',
  `code` char(20) DEFAULT NULL COMMENT 'per Italia codice SSD assegnato dal ministero - NULL se non ha codice ministeriale',
  `countryId` char(2) DEFAULT NULL COMMENT 'ID country in cui è definito SSD - se NULL il Settore Scientifico Didattico vale per tutte le countries',
  `ssdContestId` int(11) NOT NULL COMMENT 'ID settore concorsuale SSD',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag record cancellato'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Settori Scientifico-Didattici di insegnamento per country\n\nItalia\n- UNI - SSD come definiti da MIUR\n\n';

-- --------------------------------------------------------

--
-- Table structure for table `ssd_area`
--

CREATE TABLE `ssd_area` (
  `id` int(11) NOT NULL COMMENT 'ID area SSD',
  `code` char(20) NOT NULL COMMENT 'codice area SSD (la stessa valida per qualsiasi country)',
  `countryId` char(2) DEFAULT NULL COMMENT 'ID country in cui è definita Area SSD - se NULL vale per tutte le countries',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'flag Area SSD cancellata',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Elenco aree SSD\ndovrebbero essere le stesse per tutte le country';

-- --------------------------------------------------------

--
-- Table structure for table `ssd_area_lang`
--

CREATE TABLE `ssd_area_lang` (
  `id` int(11) NOT NULL COMMENT 'Id area SSD',
  `langId` char(2) NOT NULL COMMENT 'id lingua',
  `name` varchar(150) NOT NULL COMMENT 'nome area SSD in lingua',
  `description` varchar(245) DEFAULT NULL COMMENT 'eventuale descrizione'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='nome aree ssd in lingua';

-- --------------------------------------------------------

--
-- Table structure for table `ssd_contest`
--

CREATE TABLE `ssd_contest` (
  `id` int(11) NOT NULL COMMENT 'ID settore concorsuale SSD',
  `code` char(20) NOT NULL COMMENT 'Codice settore concorsuale',
  `ssdMacroId` int(11) NOT NULL COMMENT 'ID Macro settore SSD',
  `countryId` char(2) DEFAULT NULL COMMENT 'ID country in cui è definito settore concorsuale SSD - se NULL vale per tutte le countries',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag record cancellato',
  `note` mediumtext DEFAULT NULL COMMENT 'note eventuali'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Settori Concorsuali per Macro settore SSD\ndovrebbero essere diversi per ogni country';

-- --------------------------------------------------------

--
-- Table structure for table `ssd_contest_lang`
--

CREATE TABLE `ssd_contest_lang` (
  `id` int(11) NOT NULL COMMENT 'Id settore concorsuale SSD',
  `langId` char(2) NOT NULL COMMENT 'id lingua',
  `name` varchar(150) NOT NULL COMMENT 'nome settore concorsuale SSD in lingua',
  `description` varchar(245) DEFAULT NULL COMMENT 'eventuale descrizione'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='nome settore concorsuale ssd in lingua';

-- --------------------------------------------------------

--
-- Table structure for table `ssd_lang`
--

CREATE TABLE `ssd_lang` (
  `id` int(11) NOT NULL COMMENT 'ID SSD',
  `langId` char(2) NOT NULL COMMENT 'ID Lingua',
  `name` varchar(150) NOT NULL COMMENT 'nome del Settore Scientifico-Didattico (SSD) in lingua',
  `descr` varchar(245) DEFAULT NULL COMMENT 'descrizione ssd'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='nomi SSD in lingua';

-- --------------------------------------------------------

--
-- Table structure for table `ssd_macro`
--

CREATE TABLE `ssd_macro` (
  `id` int(11) NOT NULL COMMENT 'ID macro settore SSD (1+ macro settore per area)',
  `code` char(20) NOT NULL COMMENT 'Codice Macro settore SSD',
  `ssdAreaId` int(11) NOT NULL,
  `countryId` char(2) DEFAULT NULL COMMENT 'ID country in cui è definito Macrosettore SSD - se NULL vale per tutte le countries',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag record cancellato',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Macro settori in cui sono divise le aree SSD\ndovrebbero essere gli stessi per tutte le countries';

-- --------------------------------------------------------

--
-- Table structure for table `ssd_macro_lang`
--

CREATE TABLE `ssd_macro_lang` (
  `id` int(11) NOT NULL COMMENT 'Id macro settore SSD',
  `langId` char(2) NOT NULL COMMENT 'id lingua',
  `name` varchar(150) NOT NULL COMMENT 'nome macro settore SSD in lingua',
  `description` varchar(245) DEFAULT NULL COMMENT 'eventuale descrizione'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='nome macro settore ssd in lingua';

-- --------------------------------------------------------

--
-- Table structure for table `storage`
--

CREATE TABLE `storage` (
  `id` bigint(20) NOT NULL COMMENT 'ID Magazzino/Libreria (PK + type) - Corrisponde a ID <U>tente o ID O<R>ganizzazione + Tipo (U,R,P) - in caso di Libreria della Piattaforma usare Tipo = P e ID ZERO',
  `type` char(1) NOT NULL COMMENT 'Tipo libreria (PK + id) - U = Utente, R = Organizzazione, P = Piattaforma',
  `prog` char(2) NOT NULL COMMENT 'Numero di Magazzino per utente/Organizzazione/Piattaforma - default "000" - da usare se ci possono essere più magazzini riferiti ad una unica entità (utente, organizzazione, la piattaforma)\nusare numerazione con digit numerici (es. 000, 001, 002, ... , 998, 999)',
  `name` varchar(45) NOT NULL COMMENT 'Nome Libreria (es. dip. Informatica, reparto sviluppo, reparto amministrazione)',
  `description` varchar(245) DEFAULT NULL COMMENT 'nome/descrizione della libreria',
  `superCode` char(254) DEFAULT NULL COMMENT 'codice gruppo superiore = [ superCode padre + / + ] ID in formato stringa (IDX con Duplicati VIETATI)\n(superCode = ID + Type + prog , quindi 23 char) - supporta max 11 livelli',
  `loanStrategyId` int(11) DEFAULT NULL COMMENT 'ID strategia di prestito da applicare ai prestiti della libreria',
  `schoolTypeId` int(11) DEFAULT NULL COMMENT 'eventuale ID Tipo di scuola (per country) - se la libreria è relativa ad un tipo di scuola specifico',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag libreria cancellata (default FALSE = libreria attiva)',
  `fatherId` bigint(20) DEFAULT NULL COMMENT 'ID magazzino/libreria padre (id + type + prog) - permette di avere sottolibrerie (es di universita e di facolta)',
  `fatherType` char(1) DEFAULT NULL COMMENT 'Father (ID + Type + prog)',
  `fatherProg` char(2) DEFAULT NULL COMMENT 'Father (ID + Type + prog)',
  `level` int(11) DEFAULT 0 COMMENT 'Livello per gestire visualizzazioni con incolonnamento differente per livello\nDefault = 0 (Livello iniziale - NON ha padre/previous)\nOgni item che ha padre/previous setta level = padre.level + 1',
  `isQtyManaged` tinyint(1) DEFAULT 1 COMMENT 'Flag gestione delle quantità - TRUE (default) = Gestita nella libreria, FALSE = Gestita dalla libreria padre',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note',
  `schoolLevelId` char(3) DEFAULT NULL COMMENT 'eventuale link a Livello di scuola - se il magazzino/libreria si riferisce ad un livello specifico',
  `teachingAreaId` bigint(20) DEFAULT NULL COMMENT 'eventuale link a Area di Insegnamento - se Magazzino/Libreria relativo ad una specifica area di insegnamento',
  `disciplineId` int(11) DEFAULT NULL COMMENT 'eventuale link a SSD (o Area, Macrosettore, o materia/modulo) - se il magazzino/libreria deve avere un riferimento specifico',
  `iconId` int(11) DEFAULT NULL COMMENT 'eventuale icona da utilizzare per il magazzino/libreria (da tbl icons) - NULL se utilizza icona di default',
  `isXCond1` tinyint(1) DEFAULT 0 COMMENT 'flag libero 1',
  `isXCond2` tinyint(1) DEFAULT 0 COMMENT 'flag libero 2',
  `isXCond3` tinyint(1) DEFAULT 0 COMMENT 'flag libero 3',
  `xInt1` int(11) DEFAULT NULL COMMENT 'Intero libero 1',
  `xInt2` int(11) DEFAULT NULL COMMENT 'Intero libero 2',
  `xBigint1` bigint(20) DEFAULT NULL COMMENT 'Bigint libero 1',
  `xBigint2` bigint(20) DEFAULT NULL COMMENT 'Bigint libero 2',
  `xString1` varchar(45) DEFAULT NULL COMMENT 'Stringa libera 1',
  `xString2` varchar(45) DEFAULT NULL COMMENT 'Stringa libera 2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Deposito/Magazzino/Libreria\nContenitore per articoli di un utente o organizzazione oppure un dipartimento di organizzazione oppure (principalmente) la piattaforma';

-- --------------------------------------------------------

--
-- Table structure for table `storage_item`
--

CREATE TABLE `storage_item` (
  `storageId` bigint(20) NOT NULL COMMENT 'ID magazzino (di utente o organizzazione, o della piattaforma se = ZERO)',
  `storageType` char(1) NOT NULL COMMENT 'Tipo magazzino (di utente o organizzazione) (PK + id) - U = Utente, R = Organizzazione, P = Piattaforma',
  `storageProg` char(2) NOT NULL COMMENT 'progressivo magazzino di storage',
  `articleId` bigint(20) NOT NULL COMMENT 'ID articolo',
  `defaultPdfSeq` int(11) DEFAULT 0 COMMENT 'usare solo per eBook - id del file PDF (SEQ) da usare per default per la libreria, nel caso ci ne siano più versioni di file pdf associati',
  `ownerId` bigint(20) DEFAULT 0 COMMENT 'usare solo per eBook ID utente proprietario del libro - ZERO = proprietà della piattaforma\nnel caso di organizzazione proprietaria, occorre aggiungere il campo TIPO (Utente, oRganizzazione, Piattaforma)',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'usare solo per ebook - flag record cancellato - segue flag tbl book se libro cancellato',
  `totalQty` decimal(15,5) DEFAULT 0.00000 COMMENT 'totale qta posseduta - i Crediti potrebbero avere un valore non intero',
  `lentQty` decimal(15,5) DEFAULT 0.00000 COMMENT 'usare solo per ebook - quantita prestata a utenti (Interni se libreria utente) - ricavabile anche da lista prestiti in essere (count su tbl loan) - i Crediti potrebbero avere un valore non intero',
  `minAvailableQty` decimal(15,5) DEFAULT 0.00000 COMMENT 'Qta minima disponibile - soglia minima - i Crediti potrebbero avere un valore non intero',
  `bookedQty` decimal(15,5) DEFAULT 0.00000 COMMENT 'usare solo per ebook - qta prenotata per prestiti utente - ricavabile con Count su tbl reservation di prenotazioni attive/non scadute o cancellate - tipo conformato al tipo delle altre qta',
  `committedQty` decimal(15,5) DEFAULT 0.00000 COMMENT 'qta impegnata - eventuale uso di crediti impegnati - i Crediti potrebbero avere un valore non intero\nTotale Qta impegnata per ordini di vendita a cliente\nDa modificare alla creazione-INC / evasione-DEC di un ordine di vendita\n- usare SOLO per libreria della piattaforma',
  `isDownloadable` tinyint(1) DEFAULT 0 COMMENT 'usare solo per ebook - Flag download ebook permesso - TRUE = DL permesso, FALSE = DL vietato (default)',
  `lastDownloadDate` timestamp NULL DEFAULT NULL COMMENT 'usare solo per ebook - data e ora ultimo download eseguito',
  `xQty1` decimal(15,5) DEFAULT 0.00000 COMMENT 'extra qta 1 - uso futuro',
  `xQty2` decimal(15,5) DEFAULT 0.00000 COMMENT 'extra qta 2 - uso futuro',
  `xQty3` decimal(15,5) DEFAULT 0.00000 COMMENT 'extra qta 3 - uso futuro',
  `isCond1` tinyint(1) DEFAULT 0 COMMENT 'extra flag 1 - uso futuro',
  `isCond2` tinyint(1) DEFAULT 0 COMMENT 'extra flag 2 - uso futuro',
  `isCond3` tinyint(1) DEFAULT 0 COMMENT 'extra flag 3 - uso futuro',
  `xInt1` int(11) DEFAULT 0 COMMENT 'Intero libero 1',
  `xInt2` int(11) DEFAULT 0 COMMENT 'Intero libero 2',
  `xInt3` int(11) DEFAULT 0 COMMENT 'Intero libero 3'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Articoli inmagazzino/deposito di ogni utente/organizzazione - NON contiene ebook/libri\npensata per creaditi e abbonamenti multi-reader utenti aziendali - gestisce le quantita';

-- --------------------------------------------------------

--
-- Table structure for table `student_course`
--

CREATE TABLE `student_course` (
  `userId` bigint(20) NOT NULL COMMENT 'ID utente - dovrebbe essere studente della scuola a cui è associato',
  `schoolId` bigint(20) NOT NULL COMMENT 'ID scuola',
  `courseId` bigint(20) NOT NULL COMMENT 'ID corso',
  `courseSectionId` varchar(45) NOT NULL COMMENT 'ID sezione corso',
  `note` mediumtext DEFAULT NULL,
  `attendanceYear` char(1) DEFAULT NULL COMMENT 'anno di frequenza - NULL= non rilevante\n\nes.\n1 = primo anno\n2 = secondo anno',
  `createDate` timestamp NULL DEFAULT current_timestamp() COMMENT 'data di scelta corso',
  `isDeleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Corsi a cui è iscritto lo studente\n(dovrebbe essere solo uno)\nTutti gli utenti in questa tabella dovrebbero essere studenti';

-- --------------------------------------------------------

--
-- Table structure for table `student_selected_matter`
--

CREATE TABLE `student_selected_matter` (
  `userId` bigint(20) NOT NULL,
  `schoolId` bigint(20) NOT NULL,
  `courseId` bigint(20) NOT NULL,
  `courseSectionId` varchar(45) NOT NULL COMMENT 'sezione corso',
  `matterId` bigint(20) NOT NULL COMMENT 'ID materia',
  `matterModule` char(1) NOT NULL COMMENT 'modulo materia - per materia divise in moduli - "U" = modulo unico (default)\nes.\nmodulo 1, modulo 2\noppure\nmodulo A, modulo B',
  `createDate` timestamp NULL DEFAULT current_timestamp() COMMENT 'data della scelta della mataria/insegnamento',
  `note` mediumtext DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Elenco delle materie scelte dallo studente';

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `id` bigint(20) NOT NULL COMMENT 'id abbonamento (= ID Article)',
  `code` varchar(20) NOT NULL COMMENT 'Codice Abbonamento',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'flag record cancellato',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note',
  `isOption` tinyint(1) DEFAULT 1 COMMENT 'Falg Abbonamento o Opzione- TRUE = opzione aggiuntiva abbonamento (default), FALSE = Abbonamento assegnabile alla registrazione',
  `isFree` tinyint(1) DEFAULT 0 COMMENT 'Flag Gratuito - TRUE = Gratuito, FALSE = a pagamento (default)',
  `type` char(1) DEFAULT 'A' COMMENT 'Tipo opzione/abbonamento - A (default) = va bene per tutti (Any), S = riservato alle Scuole (School), C = riservato alle aziende (Company)',
  `isEnabled` tinyint(1) DEFAULT 1 COMMENT 'Flag tipo abbonamento/opzione abilitata - se FALSE= non utilizzabile (default), TRUE = utilizzabile',
  `isBuyable` tinyint(1) DEFAULT 1 COMMENT 'Flag abbonamento/opzione acquistabile - se TRUE appare in elenco a video per acquisto',
  `schoolLevelId` char(3) DEFAULT NULL COMMENT 'Eventuale associazione del tipo di abbonamento ad un livello scolastico - es. studenti UNI, studenti SS2, ecc',
  `cloudSize` decimal(10,2) DEFAULT 0.00 COMMENT 'Spazio di Cloud (GB) incluso - se = -1 (negativo) significa illimitato',
  `isXCond1` tinyint(1) DEFAULT 0 COMMENT 'extra condition 1 - USI FUTURI',
  `isXCond2` tinyint(1) DEFAULT 0 COMMENT 'extra condition 2 - USI FUTURI',
  `isXCond3` tinyint(1) DEFAULT 0 COMMENT 'extra condition 3 - USI FUTURI',
  `isXCond4` tinyint(1) DEFAULT 0 COMMENT 'extra condition 4 - USI FUTURI',
  `intXValue1` int(11) DEFAULT 0 COMMENT 'extra value 1 - USI FUTURI - Numero di giorni di durata dell abbonamento; se NULL dura per sempre',
  `intXValue2` int(11) DEFAULT 0 COMMENT 'extra value 2 - USI FUTURI',
  `xDate1` date DEFAULT NULL COMMENT 'extra Date 1 - usi futuri',
  `xDate2` datetime DEFAULT NULL COMMENT 'extra Date 2 - usi futuri',
  `xString1` varchar(45) DEFAULT NULL COMMENT 'extra string 1 - usi futuri',
  `xString2` varchar(45) DEFAULT NULL COMMENT 'extra string 2 - usi futuri'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tipi di abbonamento che un utente può sottoscrivere - un utente può sottoscrivere più tipi';

-- --------------------------------------------------------

--
-- Table structure for table `subscription_auth`
--

CREATE TABLE `subscription_auth` (
  `id` bigint(20) NOT NULL COMMENT 'id abbonamento',
  `isManager` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione MANAGER - può delegare autorizzazioni possedute ad altri utenti interni',
  `isDelegationEnabled` tinyint(1) DEFAULT 0 COMMENT 'Flag autorizzazione a delegare il ruolo di manager - può trasferire il ruolo di manager a utenti interni',
  `isBuyEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazioen BUYER - può fare acquisti',
  `isEditEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione EDITOR - può creare e modificare Corsi di eLearning ed eBook',
  `isPublishEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione PUBLISHER - può pubblicare (rendere disponibili a utenti) eBook e Corsi di eLearning (per uso Interno ed Esterno - ove funzione abilitata)',
  `isBookULEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione BOOK-ULOADER - può fare UpLoad di eBook in libreria personale o di organizzazione',
  `isBookDLEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione BOOK-DOWNLOADER - può fare DownLoad di eBook da libreria personale o di organizzazione',
  `isPurchasedBookDLEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione BOOK-DLOADER-BUY - può fare il download di libri propri acquistati dalla piattaforma (questa azione blocca la rivendita, se prevista, alla piattaforma come usato)',
  `isUploadedBookDLEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione BOOK-DLOADER-UPLOAD - può fare il download di libri propri caricati con upload',
  `isCreatedBookDLEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione BOOK-DLOADER-CREATE - può fare il download di libri propri creati',
  `isFileULEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione FILE-ULOADER - può fare upload di file (NO eBook) nel desktop personale (o di organizzazione)',
  `isFileDLEnable` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione FILE-DLOADER - può fare il download di file (NO eBook) dal desktop personale (o di organizzazione)',
  `isBookWREnableIN` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione BOOK-WRITE-IN - può gestire (creare e pubblicare) eBook per uso INTERNO',
  `isBookWREnableOUT` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione BOOK-WRITE-OUT - può gestire (creare e pubblicare) eBook per uso ESTERNO',
  `isLearnWREnableIN` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione LEARN-WRITE-IN - può gestire (creare e pubblicare) cordi di eLearning per uso INTERNO',
  `isLearnWREnableOUT` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione LEARN-WRITE-OUT - può gestire (creare e pubblicare) cordi di eLearning per uso ESTERNO',
  `isBookRDEnableIN` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione BOOK-READ-IN - può prendere in prestito eBook INTERNI',
  `loanStrategyIdIN` int(11) DEFAULT NULL COMMENT 'ID Strategia di prestito Interna - da usare per prestito eBook INTERNO (da Ente a utenti Interni)',
  `isBookRDEnableOUT` tinyint(1) DEFAULT 1 COMMENT 'Autorizzazione BOOK-READ-OUT - può prendere in prestito eBook ESTERNI',
  `loanStrategyIdOUT` int(11) DEFAULT NULL COMMENT 'ID Strategia Esterna - da usare per prestito eBook ESTERNO (da Piattaforma a utenti)',
  `isLearnRDEnableIN` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione LEARN-READ-IN - può iscriversi a corsi di eLearning INTERNI (per utenti interni di organizzazione)',
  `isLearnRDEnableOUT` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione LEARN-READ-OUT - può iscriversi a corsi di eLearning ESTERNI (per tutti gli utenti della piattaforma)',
  `isInternalUserEnable` tinyint(1) DEFAULT 0 COMMENT 'Abilitazione ad averre utenti Interni - valido solo per Enti',
  `isResaleEnable` tinyint(1) DEFAULT 0 COMMENT 'Abilitazione alla rivendita di eBook alla piattaforma come usato (se prevista)',
  `isSurveyCreator` tinyint(1) DEFAULT 0 COMMENT 'Abilitazione a creare Sondaggi',
  `isReviewer` tinyint(1) DEFAULT 1 COMMENT 'Abilitazione a scrivere Recensioni sui libri',
  `isEventAttachmentEnable` tinyint(1) DEFAULT 1 COMMENT 'Abilitazione ad allegare file agli eventi',
  `isGroupCreationEnable` tinyint(1) DEFAULT 1 COMMENT 'Abilitazione a creare Gruppi',
  `isGroupCommentEnable` tinyint(1) DEFAULT 1 COMMENT 'se TRUE può scrivere commenti sui gruppi',
  `isGroupMexAttachmentEnabled` tinyint(1) DEFAULT 1 COMMENT 'Abilitazione a allegare file ai Messaggi/Comment che scrive sui gruppi',
  `isXAuth1` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione Libera 1',
  `isXAuth2` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione Libera 2',
  `isXAuth3` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione Libera 3',
  `isXAuth4` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione Libera 4',
  `isXAuth5` tinyint(1) DEFAULT 0 COMMENT 'Autorizzazione Libera 5'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Caratteristiche (Autorizzazioni/Permessi) del tipo di abbonamneto';

-- --------------------------------------------------------

--
-- Table structure for table `subscription_lang`
--

CREATE TABLE `subscription_lang` (
  `id` bigint(20) NOT NULL COMMENT 'ID abbonamento',
  `langId` char(2) NOT NULL COMMENT 'ID lingua in cui sono espressi nome e descrizione abbonamento',
  `name` varchar(70) NOT NULL COMMENT 'Nome abbonamento in lingua',
  `description` varchar(250) DEFAULT NULL COMMENT 'Descrizoien abbonamento in lingua',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note abbonamento in lingua'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Nomi e descrizione degli abbonamenti in lingua';

-- --------------------------------------------------------

--
-- Table structure for table `supplier_book`
--

CREATE TABLE `supplier_book` (
  `supplierId` bigint(20) NOT NULL COMMENT 'ID fornitore (in tbl clifor)',
  `bookId` bigint(20) NOT NULL COMMENT 'ID Libro/pubblicazione',
  `internalBookCode` varchar(20) DEFAULT NULL COMMENT 'Codice interno fornitore (se il fornitore usa un suo codice interno per gli ordini del libro) oppure ISBN',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag dato cancellato (TRUE) - informazione NON più fornita dal fornitore per il libro',
  `purchasePrice` decimal(10,2) DEFAULT NULL COMMENT 'Prezzo fatto dal fornitore - se NULL usare il prezzo di copertina (prezzo di vendita) del libro',
  `tax` decimal(5,2) DEFAULT 0.00 COMMENT 'Tassa - % iva',
  `discount` decimal(5,2) DEFAULT 0.00 COMMENT 'sconto praticato dal fornitore sul libro',
  `lastUpdate` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Data ultimo aggiornamento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Libri forniti dal fornitore';

-- --------------------------------------------------------

--
-- Table structure for table `support_emails`
--

CREATE TABLE `support_emails` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `from_email` varchar(255) DEFAULT NULL,
  `to_email` varchar(255) DEFAULT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `lft` bigint(20) NOT NULL,
  `rght` bigint(20) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` mediumtext NOT NULL,
  `last_update` datetime NOT NULL,
  `creation_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='E-mail che arrivano dal supporto tecnico o dai contatti.';

-- --------------------------------------------------------

--
-- Table structure for table `support_subjects`
--

CREATE TABLE `support_subjects` (
  `id` bigint(20) NOT NULL,
  `text` varchar(255) NOT NULL,
  `to_email` varchar(255) DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey`
--

CREATE TABLE `survey` (
  `id` bigint(20) NOT NULL COMMENT 'ID sondaggio',
  `creatorId` bigint(20) NOT NULL COMMENT 'ID creatore del sondaggio - può essere un utente normale oppure un utente operatore della piattaforma per sondaggi Globali',
  `note` mediumtext DEFAULT NULL,
  `countryId` char(2) DEFAULT NULL COMMENT 'codice Country dove il sondaggio deve essere effettuato - se NULL il sondaggio viene pubblicato in qualsiasi country - per sondaggi pubblicati da operatori della piattaforma',
  `groupId` bigint(20) DEFAULT NULL COMMENT 'ID gruppo a cui è diretto il sondaggio - se NULL il sondaggio è visibile a tutti - utente reader che crea il sondaggio può scegliere il gruppo solo tra quelli di cui è membro',
  `title` varchar(100) DEFAULT NULL COMMENT 'titolo del sondaggio',
  `text` tinytext DEFAULT NULL COMMENT 'testo del sondaggio',
  `countYes` int(11) DEFAULT 0 COMMENT 'contatore per risposte YES in sondaggi di tipo SI/NO',
  `countNo` int(11) DEFAULT 0 COMMENT 'contatore per risposte NO in sondaggi di tipo SI/NO',
  `isYesNoType` tinyint(1) DEFAULT 0 COMMENT 'Flag tipo sondaggio TRUE = SI/NO oppure FALSE = a livelli (0 = livello più basso - 5 livello più alto)',
  `countLevel0` int(11) DEFAULT 0 COMMENT 'livello 0 - nessuna stella - livello peggiore',
  `countLevel1` int(11) DEFAULT 0 COMMENT 'livello 1 - una stella',
  `countLevel2` int(11) DEFAULT 0 COMMENT 'livello 2 - due stelle',
  `countLevel3` int(11) DEFAULT 0 COMMENT 'livello 3 - tre stelle',
  `countLevel4` int(11) DEFAULT 0 COMMENT 'livello 4 - quattro stelle',
  `countLevel5` int(11) DEFAULT 0 COMMENT 'livello 5 - cinque stelle - livello migliore',
  `createDate` timestamp NULL DEFAULT current_timestamp() COMMENT 'Data di creazione del sondaggio',
  `startDate` date DEFAULT NULL COMMENT 'Data in cui dovrà iniziare il sondaggio (verrà pubblicato il testo del sondaggio)',
  `endDate` date DEFAULT NULL COMMENT 'Data in cui terminerà il sondaggio'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Sondaggi\n- quando creati da utente normale vengono usati i campi TITLE e TEXT\n- quando creati da operatore viene usata la tabella associata LANG che permette di creare sondaggi in varie lingue';

-- --------------------------------------------------------

--
-- Table structure for table `survey_lang`
--

CREATE TABLE `survey_lang` (
  `id` bigint(20) NOT NULL COMMENT 'id sondaggio',
  `langId` char(2) NOT NULL,
  `title` varchar(100) NOT NULL COMMENT 'titolo sondaggio',
  `text` tinytext DEFAULT NULL COMMENT 'testo sondaggio in lingua'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='titolo e testo del sondaggio in lingua \nSOLO per sondaggi creati dalla piattaforma';

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `word` varchar(45) NOT NULL,
  `note` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tag_author`
--

CREATE TABLE `tag_author` (
  `idAuthor` bigint(20) NOT NULL,
  `idTag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tag_book`
--

CREATE TABLE `tag_book` (
  `id` int(11) NOT NULL,
  `idTag` int(11) DEFAULT NULL,
  `idBook` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tag_category`
--

CREATE TABLE `tag_category` (
  `idCategory` int(11) NOT NULL,
  `idTag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tag_gender`
--

CREATE TABLE `tag_gender` (
  `idGender` int(11) NOT NULL,
  `idTag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tag_lang`
--

CREATE TABLE `tag_lang` (
  `idTag` int(11) NOT NULL,
  `idLang` char(2) NOT NULL,
  `wordLang` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `taskfiles`
--

CREATE TABLE `taskfiles` (
  `id` bigint(20) NOT NULL,
  `comment_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) NOT NULL,
  `pid` bigint(20) DEFAULT NULL,
  `tid` bigint(20) NOT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `size` int(11) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `taskgroups`
--

CREATE TABLE `taskgroups` (
  `id` bigint(20) NOT NULL,
  `projectId` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `tax_percentage` decimal(5,2) DEFAULT NULL,
  `total_workinghrs` bigint(20) DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `startdate` datetime DEFAULT NULL,
  `expirydate` datetime DEFAULT NULL,
  `isFuturedGroup` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `taskgroups_projecttasks`
--

CREATE TABLE `taskgroups_projecttasks` (
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `taskgroup_id` bigint(11) NOT NULL,
  `projecttask_id` bigint(11) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `taskusers`
--

CREATE TABLE `taskusers` (
  `id` bigint(20) NOT NULL,
  `taskId` bigint(20) NOT NULL,
  `assignee_id` bigint(20) NOT NULL,
  `assigned_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_course_matter`
--

CREATE TABLE `teacher_course_matter` (
  `userId` bigint(20) NOT NULL COMMENT 'ID docente',
  `schoolId` bigint(20) NOT NULL COMMENT 'ID scuola',
  `courseId` bigint(20) NOT NULL COMMENT 'ID corso',
  `courseSectionId` varchar(45) NOT NULL COMMENT 'ID sezione corso',
  `matterId` bigint(20) NOT NULL COMMENT 'ID materia',
  `matterModule` char(1) NOT NULL COMMENT 'modulo materia - per materia divise in moduli - "U" = modulo unico (default)\nes.\nmodulo 1, modulo 2\noppure\nmodulo A, modulo B',
  `note` mediumtext DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Elenco delle materie insegnate ed in quali corsi e sezioni il docente le insegna';

-- --------------------------------------------------------

--
-- Table structure for table `touseremails`
--

CREATE TABLE `touseremails` (
  `id` bigint(20) NOT NULL,
  `email_id` bigint(20) NOT NULL,
  `touser_id` bigint(20) NOT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` bigint(20) NOT NULL COMMENT 'user ID - Autoinc',
  `choosen_companyId` bigint(20) DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'flag utente cancellato (non più attivo)',
  `firstname` varchar(100) DEFAULT NULL COMMENT 'Nome se una persona o Denominazione 1 nel caso di Scuole/Enti',
  `lastname` varchar(100) DEFAULT NULL COMMENT 'Cognome se persona o Denominazione 2 nel caso di Scuole/Enti',
  `email` varchar(100) NOT NULL COMMENT 'email principale - usato per Login (alternativa a username)',
  `email2` varchar(100) DEFAULT NULL COMMENT 'email secondario usato come alternativa per recupero password',
  `langId` char(2) NOT NULL COMMENT 'id lingua utente per comunicazioni',
  `username` varchar(70) NOT NULL COMMENT 'username utente/scuola - usato per Login (alternativa a email)',
  `password` varchar(245) NOT NULL,
  `passwordExpirationDate` date NOT NULL COMMENT 'Data di scadenza password',
  `lastChangePwdTime` timestamp NULL DEFAULT NULL COMMENT 'timestamp ultimo cambio password',
  `isOrganization` tinyint(1) DEFAULT 0 COMMENT 'Flag tipo utente - FALSE = utente normale (Persona fisica), TRUE = utente di tipo Scuola/Azienda\nidentifica utente SCUOLA o AZIENDA riferimento di studenti/docenti',
  `nickname` varchar(70) NOT NULL COMMENT 'nickname utente / quello che viene visualizzato a video',
  `isBlocked` tinyint(1) DEFAULT 0 COMMENT 'Flag utente bloccato (TRUE), NON bloccato (FALSE)',
  `blockReason` varchar(200) DEFAULT NULL COMMENT 'Motivo del blocco',
  `tel` varchar(100) DEFAULT NULL COMMENT 'eventuali recapiti telefonici supplementari (oltre a quelli in record indirizzo)',
  `registrationDate` timestamp NULL DEFAULT NULL COMMENT 'timestamp di creazione record utente',
  `expirationDate` date DEFAULT NULL COMMENT 'data di scadenza utente - NULL = nessuna scadenza',
  `lastUpdate` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'timestamp ultimo aggiornamento utente (qualsiasi campo)',
  `imageFileName` varchar(255) DEFAULT NULL COMMENT 'nome file immagine/logo - da usare in alternativa al campo Blob',
  `imageFilePath` varchar(255) DEFAULT NULL COMMENT 'Path file immagine/logo - da usare in alternativa al campo Blob',
  `image` blob DEFAULT NULL COMMENT 'immagine/logo utente - da usare in alternativa ai campi FileName e FilePath immagine',
  `note` mediumtext DEFAULT NULL,
  `anagId` bigint(20) DEFAULT NULL COMMENT 'ID anagrafica con dati per fatturazione - NULL se utente non può ricevere fatture, quindi DEVE avere un referralUserId per poter acquistare (per conto del referral)',
  `isReferral` tinyint(1) DEFAULT 0 COMMENT 'Flag utente di riferimento per acquisti di altri utenti (genitore o Azienda/Scuola) se TRUE',
  `referralPrivateUserId` bigint(20) DEFAULT NULL COMMENT 'ID utente di riferimento per acquisti PRIVATI (referral per ENTE è organizationId in tbl organization_user)',
  `level` int(11) DEFAULT 0 COMMENT 'Livello per gestire visualizzazioni con incolonnamento differente per livello\nDefault = 0 (Livello iniziale - NON ha padre/previous)\nOgni item che ha padre/previous setta level = padre.level + 1',
  `isAuthByReferral` tinyint(1) DEFAULT 0 COMMENT 'Flag autorizzazione acquisti per conto del referral - TRUE = autorizzato, FALSE = non autorizzato (default), quindi occorre chiedere autorizzazione al referral per ogni acquisto',
  `birthday` datetime DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `country` varchar(250) DEFAULT NULL,
  `state` varchar(250) DEFAULT NULL,
  `cap` int(11) DEFAULT NULL,
  `gender` text DEFAULT NULL,
  `resetpasswordcode` int(6) DEFAULT NULL,
  `resetpassword_expirydate` datetime DEFAULT NULL,
  `tags` varchar(255) DEFAULT ';User;',
  `profileFilename` varchar(225) DEFAULT NULL,
  `profileFilepath` varchar(225) DEFAULT NULL,
  `last_login` datetime NOT NULL DEFAULT current_timestamp(),
  `status` char(1) DEFAULT NULL,
  `member_type` char(1) NOT NULL DEFAULT 'U',
  `isCompany` tinyint(1) DEFAULT 0,
  `two_factor_securitycode` varchar(255) DEFAULT NULL,
  `two_factor_securitycode_expirydate` datetime DEFAULT NULL,
  `businessname` varchar(255) DEFAULT NULL,
  `tax_code` varchar(255) DEFAULT NULL,
  `vat_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Utenti\nDati per login ed eventuale riferimento per acquisti';

-- --------------------------------------------------------

--
-- Table structure for table `userbanks`
--

CREATE TABLE `userbanks` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `iban` varchar(255) DEFAULT NULL,
  `state_bankbranch` varchar(255) DEFAULT NULL,
  `city_bankbranch` varchar(255) DEFAULT NULL,
  `province_bankbranch` varchar(255) DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `usercompanies`
--

CREATE TABLE `usercompanies` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `company_user` bigint(20) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `country` varchar(150) DEFAULT NULL,
  `city` varchar(150) DEFAULT NULL,
  `state` varchar(150) DEFAULT NULL,
  `postal_code` int(11) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `phone_number` varchar(150) DEFAULT NULL,
  `mobile_number` varchar(150) DEFAULT NULL,
  `iban` varchar(150) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `state_bankbranch` varchar(255) DEFAULT NULL,
  `city_bankbranch` varchar(255) DEFAULT NULL,
  `province_bankbranch` varchar(255) DEFAULT NULL,
  `website` varchar(250) DEFAULT NULL,
  `company_logoFilepath` varchar(250) DEFAULT NULL,
  `company_logoFilename` varchar(250) DEFAULT NULL,
  `businessname` varchar(255) DEFAULT NULL,
  `fiscal_code` varchar(255) DEFAULT NULL,
  `vat_code` varchar(255) DEFAULT NULL,
  `sdi_code` varchar(255) DEFAULT NULL,
  `pec_mail` varchar(255) DEFAULT NULL,
  `entrance_qr_code` int(11) DEFAULT NULL,
  `entrance_qr_code_filepath` varchar(255) DEFAULT NULL,
  `entrance_qr_code_filename` varchar(255) DEFAULT NULL,
  `exit_qr_code` int(11) DEFAULT NULL,
  `exit_qr_code_filepath` varchar(255) DEFAULT NULL,
  `exit_qr_code_filename` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `usermodule_permissions`
--

CREATE TABLE `usermodule_permissions` (
  `id` bigint(20) NOT NULL,
  `designation_id` bigint(20) NOT NULL,
  `module_id` bigint(20) NOT NULL,
  `isAccessed` tinyint(1) NOT NULL DEFAULT 0,
  `isRead` tinyint(1) NOT NULL DEFAULT 0,
  `isWrite` tinyint(1) NOT NULL DEFAULT 0,
  `isCreate` tinyint(1) NOT NULL DEFAULT 0,
  `isDelete` tinyint(1) NOT NULL DEFAULT 0,
  `isImport` tinyint(1) NOT NULL DEFAULT 0,
  `isExport` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `usersettings`
--

CREATE TABLE `usersettings` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `company_id` bigint(20) DEFAULT NULL,
  `two_factor_authentication` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_chain`
--

CREATE TABLE `user_chain` (
  `userId` bigint(20) NOT NULL,
  `chainedId` bigint(20) NOT NULL,
  `isPersonalUser` tinyint(1) DEFAULT 0 COMMENT 'Flag userId = utente Personale (non dipende da nessuna scuola/azienda) = TRUE, utente speciale che dipende da un ente = FALSE (default)',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag record cancellato',
  `createDate` timestamp NULL DEFAULT current_timestamp() COMMENT 'data di creazione associazione dei due utenti'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Collega vari utenti per permettere il login con uno qualsiasi dei profili collegati.\nPer collegare un profilo occorre conoscere la password utente del profilo da collegare';

-- --------------------------------------------------------

--
-- Table structure for table `user_extra_info`
--

CREATE TABLE `user_extra_info` (
  `userId` bigint(20) NOT NULL COMMENT 'ID utente a cui si riferiscono le info extra\nusi futuri',
  `xInt1` int(11) DEFAULT NULL COMMENT 'usi futuri',
  `xInt2` int(11) DEFAULT NULL COMMENT 'usi futuri',
  `xDate1` datetime DEFAULT NULL COMMENT 'usi futuri',
  `xDate2` datetime DEFAULT NULL COMMENT 'usi futuri',
  `xText1` longtext DEFAULT NULL COMMENT 'usi futuri',
  `xText2` longtext DEFAULT NULL COMMENT 'usi futuri',
  `xString1` varchar(250) DEFAULT NULL COMMENT 'usi futuri',
  `xString2` varchar(250) DEFAULT NULL COMMENT 'usi futuri',
  `isCond1` tinyint(1) DEFAULT NULL COMMENT 'usi futuri',
  `isCond2` tinyint(1) DEFAULT NULL COMMENT 'usi futuri',
  `xDec1` decimal(19,5) DEFAULT NULL COMMENT 'usi futuri',
  `xDec2` decimal(19,5) DEFAULT NULL COMMENT 'usi futuri',
  `lastUpdate` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'timestamp ultimo aggiornamento',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'flag record cancellato - deve Seguire flag isDeleted di tbl user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='informazioni extra su utente';

-- --------------------------------------------------------

--
-- Table structure for table `user_favorite_news`
--

CREATE TABLE `user_favorite_news` (
  `channelId` int(11) NOT NULL,
  `userId` bigint(20) NOT NULL,
  `selectionDate` timestamp NULL DEFAULT current_timestamp() COMMENT 'data di selezione del canale news com preferito / da seguire',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'flag record cancellato'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='news channel scelti da utente';

-- --------------------------------------------------------

--
-- Table structure for table `user_friendship`
--

CREATE TABLE `user_friendship` (
  `userId` bigint(20) NOT NULL COMMENT 'ID utente',
  `friendId` bigint(20) NOT NULL COMMENT 'ID amico',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag amicizia Annullata = TRUE, valida = FALSE (default)',
  `requestDate` timestamp NULL DEFAULT current_timestamp() COMMENT 'Data di richiesta amicizia - timestamp creazione record',
  `friendDate` timestamp NULL DEFAULT NULL COMMENT 'Data di accettazione amicizia',
  `isBlocked` tinyint(1) DEFAULT 0 COMMENT 'Flag Blocco Amicizia gentibile da utente - TRUE = Amiciazia Bloccata (amico non può accedere a info protette)',
  `blockDate` timestamp NULL DEFAULT NULL COMMENT 'Data di blocco amicizia da parte di utente (vedi field isBlocked)',
  `note` mediumtext DEFAULT NULL COMMENT 'Note su amicizia gestibili da utente USER',
  `xInt` int(11) DEFAULT NULL COMMENT 'per usi futuri',
  `isXCond1` tinyint(1) DEFAULT 0 COMMENT 'per usi futuri',
  `isXCond2` tinyint(1) DEFAULT 0 COMMENT 'per usi futuri',
  `xString` varchar(150) DEFAULT NULL COMMENT 'per usi futuri'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Amicizia - identifica gli amici di un utente\nSet requestDate alla richiesta (altre date = NULL), set friendDate a accettazione, Se rifiuto o cancellazione amicizia set isDeleted = TRUE';

-- --------------------------------------------------------

--
-- Table structure for table `user_info_type`
--

CREATE TABLE `user_info_type` (
  `id` char(45) NOT NULL COMMENT 'id user info type - usare codice parlante per facilitare gestione ',
  `descr` varchar(245) NOT NULL COMMENT 'descrizione tipo gruppo di informazioni',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'flag record cancellato'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Elenco dei tipi di informazioni utente per dividere in gruppi le info utente e gestire la privacy per ogni gruppo seperatamente';

-- --------------------------------------------------------

--
-- Table structure for table `user_news_archive`
--

CREATE TABLE `user_news_archive` (
  `newsId` bigint(20) NOT NULL,
  `userId` bigint(20) NOT NULL,
  `archiveDate` timestamp NULL DEFAULT current_timestamp() COMMENT 'data archiviazione news',
  `note` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Archivio delle news salvate da utente';

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `userId` bigint(20) NOT NULL COMMENT 'ID utente',
  `itemKey` varchar(70) NOT NULL COMMENT 'chiave della property',
  `itemValue` varchar(255) NOT NULL COMMENT 'valore della property\nSe valore = NULL allora eliminare la property',
  `description` tinytext DEFAULT NULL COMMENT 'descrizione della property',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'flag record cancellato - Deve seguire il flag utente cancellato in tbl user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='profilo utente\ncontiene una mappa (coppie K,V) delle properties del profilo di ogni utente\n';

-- --------------------------------------------------------

--
-- Table structure for table `user_recovery`
--

CREATE TABLE `user_recovery` (
  `userId` bigint(20) NOT NULL COMMENT 'id utente',
  `tag` varchar(100) NOT NULL COMMENT 'Tag UUID4 per identificazione univoca utente',
  `createDate` timestamp NULL DEFAULT current_timestamp() COMMENT 'Data di creazine Tag di recupero password/utente',
  `email` varchar(100) DEFAULT NULL COMMENT 'email a cui il sistema ha inviato il messaggio per il recupero password'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabella per Tag di recupero password/utente da inviare ad utente a mezzo email';

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `userId` bigint(20) NOT NULL,
  `roleId` int(11) NOT NULL COMMENT 'ID ruolo',
  `isDeleted` tinyint(1) DEFAULT 0 COMMENT 'Flag record cancellato',
  `authorizationDate` timestamp NULL DEFAULT current_timestamp() COMMENT 'data abilitazione'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Elenco Ruoli utente';

-- --------------------------------------------------------

--
-- Table structure for table `user_subscription`
--

CREATE TABLE `user_subscription` (
  `userId` bigint(20) NOT NULL COMMENT 'ID utente che ha sottoscritto abbonamento',
  `subscriptionId` bigint(20) NOT NULL COMMENT 'ID abbonamento sottoscritto',
  `subscriptionDate` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Data di inizio validità abbonamento - settata al momento della sottoscrizione',
  `code` varchar(20) NOT NULL COMMENT 'codice abbonamento - Copiare da tbl subscription al momento della sottoscrizione',
  `qty` int(11) DEFAULT 1 COMMENT 'Quantità di abbonamenti sottoscritti (default = 1), da usare per abbonamenti multipli come #utenti Interni e # opzioni Autore per ENTI',
  `expirationDate` date DEFAULT NULL COMMENT 'Data di fine validità abbonamento - se NULL nessuna scadenza (lifetime)',
  `note` mediumtext DEFAULT NULL COMMENT 'eventuali note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Elenco abbonamenti/opzioni sottoscritti da utente\nIl campo CODE contiene l''ID d''abbonamento/opzione';

-- --------------------------------------------------------

--
-- Table structure for table `versions_contract`
--

CREATE TABLE `versions_contract` (
  `id` bigint(20) NOT NULL,
  `project_object_id` bigint(20) UNSIGNED NOT NULL,
  `contract_id` bigint(20) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `listof_members` mediumtext DEFAULT NULL,
  `content` mediumtext DEFAULT NULL,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `acceptance_date` datetime DEFAULT NULL,
  `contract_filename` varchar(255) DEFAULT NULL,
  `contract_filepath` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `tax` decimal(5,2) DEFAULT NULL,
  `total_workinghrs` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_causal`
--

CREATE TABLE `warehouse_causal` (
  `id` char(10) NOT NULL COMMENT 'ID causale di movimentazione magazzino',
  `note` mediumtext DEFAULT NULL,
  `isSystem` tinyint(1) DEFAULT 0 COMMENT 'Causale di Sistema - NON MODIFICABILE da utente - NON CANCELLABILE',
  `isBorrowQty` tinyint(1) DEFAULT 0 COMMENT 'Flag di azione su Qta - TRUE = su Qta in prestito, FALSE = su Qta a magazzino',
  `isAddQty` tinyint(1) DEFAULT 0 COMMENT 'Flag azione su Qta - TRUE = INCrementa qta, FALSE = DECrementa Qta\nINC prestito = uscita per Prestito\nDEC prestito = rientro da Prestito\nINC Qta = ACQUISTO, RESO da Cliente\nDEC Qta = VENDITA, RESO a Fornitore',
  `isInitialQty` tinyint(1) DEFAULT 0 COMMENT 'Flag settaggio Qty Giacenza Iniziale = TRUE (previsto SOLO INC Qta), operazione normale = FALSE',
  `isInventoryCorrection` tinyint(1) DEFAULT 0 COMMENT 'Flag di Rettifica Qty su inventario = TRUE, operazione normale = FALSE',
  `isCond1` tinyint(1) DEFAULT 0 COMMENT 'extra flag 1',
  `isCond2` tinyint(1) DEFAULT 0 COMMENT 'extra flag 2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Causali Movimentazione\n- Uscita per Prestito - INC\n- Reso da Prestito - DEC\n- Acquisto da Fornitore - INC\n- Acquisto da Cliente - INC\n- Vendita a Cliente - DEC\n- Reso a Fornitore - DEC\n- Set giacenza iniziale INC\n- Rettifica inventario PIU - INC\n- Rettifica inventario MENO - DEC\n';

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_causal_lang`
--

CREATE TABLE `warehouse_causal_lang` (
  `Id` char(10) NOT NULL COMMENT 'ID causale movimento magazzino',
  `langId` char(2) NOT NULL COMMENT 'id Lingua in cui è scritto il nome della causale',
  `name` varchar(70) NOT NULL COMMENT 'nome causale in lingua',
  `descr` varchar(245) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='nome causale di magazzino in lingua';

-- --------------------------------------------------------

--
-- Table structure for table `workinghours`
--

CREATE TABLE `workinghours` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `company_id` bigint(20) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `worklocations`
--

CREATE TABLE `worklocations` (
  `id` bigint(20) NOT NULL,
  `work_location` varchar(250) DEFAULT NULL,
  `work_address` varchar(250) DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additionaldatausers`
--
ALTER TABLE `additionaldatausers`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `member_role` (`member_role`);

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_address_anagraphic1_idx` (`anagId`),
  ADD KEY `IDX_NAME` (`name1`,`name2`),
  ADD KEY `IDX_ADDRESS` (`address1`,`address2`),
  ADD KEY `fk_address2_country1_idx` (`countryId`);

--
-- Indexes for table `address_contact`
--
ALTER TABLE `address_contact`
  ADD PRIMARY KEY (`addressId`,`contactId`),
  ADD KEY `fk_address_contact_contact1_idx` (`contactId`),
  ADD KEY `fk_address_contact_address1_idx` (`addressId`);

--
-- Indexes for table `anagraphic`
--
ALTER TABLE `anagraphic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `PIVA` (`pIva`) COMMENT 'azienda può cambiare ragione sociale  e mantenere partia IVA uguale',
  ADD KEY `CODFISC` (`codFiscale`),
  ADD KEY `COMPANYNAME` (`name1`,`name2`),
  ADD KEY `fk_anagraphic_language1_idx` (`langId`),
  ADD KEY `FATHER` (`fatherId`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_article_measure_unit1_idx` (`um`),
  ADD KEY `fk_article_measure_unit2_idx` (`umPack`),
  ADD KEY `GRP_ARTICLE` (`grp`),
  ADD KEY `SINGLE_ARTICLE` (`singleArticleId`);

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `author_external_link`
--
ALTER TABLE `author_external_link`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_author_has_country_country1_idx` (`countryId`),
  ADD KEY `fk_author_has_country_author1_idx` (`authorId`);

--
-- Indexes for table `author_favourite`
--
ALTER TABLE `author_favourite`
  ADD PRIMARY KEY (`userId`,`authorId`);

--
-- Indexes for table `author_info_lang`
--
ALTER TABLE `author_info_lang`
  ADD PRIMARY KEY (`authorId`,`langId`),
  ADD KEY `fk_author_info_lang_language1_idx` (`langId`);

--
-- Indexes for table `author_profession`
--
ALTER TABLE `author_profession`
  ADD PRIMARY KEY (`authorId`,`professionId`),
  ADD KEY `fk_author_has_profession_profession1_idx` (`professionId`),
  ADD KEY `fk_author_has_profession_author1_idx` (`authorId`);

--
-- Indexes for table `awaiting_registration`
--
ALTER TABLE `awaiting_registration`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `validationTag_UNIQUE` (`validationTag`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD UNIQUE KEY `nickname_UNIQUE` (`nickname`);

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ABI_CAB` (`abiCode`,`cabCode`);

--
-- Indexes for table `banned_ip`
--
ALTER TABLE `banned_ip`
  ADD PRIMARY KEY (`ip`),
  ADD KEY `BANNED_TIME` (`banTime`),
  ADD KEY `BANNED` (`isBanned`,`ip`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_book_brand1_idx` (`brandId`),
  ADD KEY `fk_book_destination1_idx` (`destinationId`),
  ADD KEY `fk_book_language1_idx` (`langId`),
  ADD KEY `fk_book_gender1_idx` (`bookGenderId`),
  ADD KEY `isbn_issue_number_UNIQUE` (`isbn`,`issueNumber`),
  ADD KEY `fk_book_category1_idx` (`categoryId`);

--
-- Indexes for table `book_author`
--
ALTER TABLE `book_author`
  ADD PRIMARY KEY (`bookId`,`authorId`),
  ADD KEY `fk_book_author_author1_idx` (`authorId`),
  ADD KEY `fk_book_author_book1_idx` (`bookId`);

--
-- Indexes for table `book_code`
--
ALTER TABLE `book_code`
  ADD PRIMARY KEY (`bookId`,`codeType`),
  ADD KEY `codice_libro` (`bookId`,`codeValue`);

--
-- Indexes for table `book_cover`
--
ALTER TABLE `book_cover`
  ADD PRIMARY KEY (`bookId`),
  ADD KEY `store_sv_name_path` (`storeServerName`,`storePath`),
  ADD KEY `store_sv_ip_path` (`storeServerIp`,`storePath`),
  ADD KEY `fk_book_cover_checksum1_idx` (`checksumId`);

--
-- Indexes for table `book_extra_selection`
--
ALTER TABLE `book_extra_selection`
  ADD PRIMARY KEY (`bookId`),
  ADD KEY `fk_book_extra_selection_ssd_area1_idx` (`ssdAreaId`),
  ADD KEY `fk_book_extra_selection_ssd1_idx` (`ssdId`),
  ADD KEY `fk_book_extra_selection_school_teaching_area1_idx` (`teachingAreaId`),
  ADD KEY `fk_book_extra_selection_school_level1_idx` (`schoolLevelId`),
  ADD KEY `fk_book_extra_selection_school_type1_idx` (`schoolTypeId`);

--
-- Indexes for table `book_file`
--
ALTER TABLE `book_file`
  ADD PRIMARY KEY (`bookId`,`seq`),
  ADD KEY `fk_book_file_checksum1_idx` (`checksumId`),
  ADD KEY `fileName` (`originalFileName`);

--
-- Indexes for table `book_gender`
--
ALTER TABLE `book_gender`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `superCode_UNIQUE` (`superCode`),
  ADD KEY `FATHER` (`fatherId`);

--
-- Indexes for table `book_gender_lang`
--
ALTER TABLE `book_gender_lang`
  ADD PRIMARY KEY (`id`,`langId`),
  ADD KEY `fk_book_gender_lang_language1_idx` (`langId`);

--
-- Indexes for table `book_info_lang`
--
ALTER TABLE `book_info_lang`
  ADD PRIMARY KEY (`bookId`),
  ADD KEY `fk_book_info_lang_language1_idx` (`langId`);

--
-- Indexes for table `book_liked_viewed`
--
ALTER TABLE `book_liked_viewed`
  ADD PRIMARY KEY (`bookId`,`userId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `book_rating`
--
ALTER TABLE `book_rating`
  ADD PRIMARY KEY (`bookId`,`userId`),
  ADD KEY `fk_book_rating_book1_idx` (`bookId`),
  ADD KEY `fk_book_rating_user1_idx` (`userId`);

--
-- Indexes for table `book_review`
--
ALTER TABLE `book_review`
  ADD PRIMARY KEY (`bookId`,`userId`),
  ADD KEY `fk_book_review_language1_idx` (`langId`),
  ADD KEY `published_per book` (`bookId`,`publishDate`,`isPublished`),
  ADD KEY `creation_time` (`createDate`),
  ADD KEY `fk_book_review_user1_idx` (`userId`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_brand_publisher1_idx` (`publisherId`),
  ADD KEY `brand_name` (`name`),
  ADD KEY `brand_code` (`code`);

--
-- Indexes for table `campaign`
--
ALTER TABLE `campaign`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date_range` (`startDate`,`endDate`);

--
-- Indexes for table `campaign_target`
--
ALTER TABLE `campaign_target`
  ADD PRIMARY KEY (`campaignId`,`itemKey`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `superCode_UNIQUE` (`superCode`),
  ADD KEY `FATHER` (`fatherId`);

--
-- Indexes for table `category_lang`
--
ALTER TABLE `category_lang`
  ADD PRIMARY KEY (`id`,`langId`),
  ADD KEY `fk_category_lang_language1_idx` (`langId`);

--
-- Indexes for table `chatcontacts`
--
ALTER TABLE `chatcontacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`touser_id`),
  ADD KEY `fromuser_id` (`fromuser_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `chatfiles`
--
ALTER TABLE `chatfiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `touser_id` (`touser_id`),
  ADD KEY `chat_id` (`chat_id`);

--
-- Indexes for table `chatgroups`
--
ALTER TABLE `chatgroups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creator` (`creator`),
  ADD KEY `chatgroups_ibfk_1` (`group_id`);

--
-- Indexes for table `chatgroupsusers`
--
ALTER TABLE `chatgroupsusers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fromuser_id` (`fromuser_id`),
  ADD KEY `touser_id` (`touser_id`),
  ADD KEY `parentchat_id` (`parentchat_id`);

--
-- Indexes for table `checksum`
--
ALTER TABLE `checksum`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`countryId`,`regionId`,`provinceId`,`id`),
  ADD KEY `name` (`name`,`countryId`,`regionId`,`provinceId`);

--
-- Indexes for table `clientsideemployees`
--
ALTER TABLE `clientsideemployees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `clifor`
--
ALTER TABLE `clifor`
  ADD PRIMARY KEY (`anagId`,`cliforType`),
  ADD KEY `fk_clifor_anagraphic1_idx` (`anagId`),
  ADD KEY `fk_clifor_iva_code1_idx` (`vatCodeExempt`),
  ADD KEY `fk_clifor_language1_idx` (`langId`),
  ADD KEY `fk_clifor_company_bank1_idx` (`companyBankId`),
  ADD KEY `fk_clifor_bank1_idx` (`bankId`),
  ADD KEY `fk_clifor_payment1_idx` (`paymentId`),
  ADD KEY `fk_clifor_priceList1_idx` (`priceListId`),
  ADD KEY `fk_clifor_clifor_group1_idx` (`grouping`);

--
-- Indexes for table `clifor_group`
--
ALTER TABLE `clifor_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `taskId` (`taskId`);

--
-- Indexes for table `companies_user`
--
ALTER TABLE `companies_user`
  ADD PRIMARY KEY (`company_id`,`user_id`) USING BTREE,
  ADD KEY `company_id` (`company_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `member_role` (`member_role`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `company_bank`
--
ALTER TABLE `company_bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_modules`
--
ALTER TABLE `company_modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`itemKey`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_contact_language1_idx` (`langId`);

--
-- Indexes for table `contractlines`
--
ALTER TABLE `contractlines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contract_id` (`contract_id`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_object_id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country_property`
--
ALTER TABLE `country_property`
  ADD PRIMARY KEY (`countryId`,`itemKey`),
  ADD KEY `item_key_idx` (`itemKey`),
  ADD KEY `item_value_val` (`itemValue`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_UNIQUE` (`code`),
  ADD KEY `fk_coupon_campaign1_idx` (`campaignId`),
  ADD KEY `fk_coupon_user1_idx` (`userId`),
  ADD KEY `coupon_date_code` (`startDate`,`endDate`,`code`);

--
-- Indexes for table `course_matter`
--
ALTER TABLE `course_matter`
  ADD PRIMARY KEY (`matterId`,`courseId`,`module`),
  ADD KEY `fk_course_matter_school_course1_idx` (`courseId`);

--
-- Indexes for table `course_section`
--
ALTER TABLE `course_section`
  ADD PRIMARY KEY (`courseId`,`sectionId`);

--
-- Indexes for table `degree_class`
--
ALTER TABLE `degree_class`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_UNIQUE` (`code`),
  ADD KEY `fk_degree_class_degree_class_type1_idx` (`typeId`),
  ADD KEY `fk_degree_class_country1_idx` (`countryId`),
  ADD KEY `class_code` (`code`,`countryId`);

--
-- Indexes for table `degree_class_type`
--
ALTER TABLE `degree_class_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_UNIQUE` (`code`),
  ADD KEY `fk_degree_class_type_isced_level1_idx` (`isced`),
  ADD KEY `type_code` (`code`),
  ADD KEY `fk_degree_class_type_school_level1_idx` (`schoolLevelId`);

--
-- Indexes for table `degree_class_type_lang`
--
ALTER TABLE `degree_class_type_lang`
  ADD PRIMARY KEY (`id`,`langId`),
  ADD KEY `fk_degree_class_type_lang_degree_class_type1_idx` (`id`),
  ADD KEY `fk_degree_class_type_lang_language1_idx` (`langId`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`schoolId`,`code`),
  ADD KEY `anagId` (`anagId`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `desktop_object`
--
ALTER TABLE `desktop_object`
  ADD PRIMARY KEY (`userId`,`itemId`),
  ADD KEY `fk_desktop_object_icon1_idx` (`iconId`),
  ADD KEY `fk_desktop_object_file_object1_idx` (`fileObjId`,`fileObjCnt`),
  ADD KEY `FATHER` (`upperFolderUserId`,`upperFolderItemId`);

--
-- Indexes for table `destination`
--
ALTER TABLE `destination`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_UNIQUE` (`code`);

--
-- Indexes for table `destination_lang`
--
ALTER TABLE `destination_lang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_destination_lang_language1_idx` (`langId`);

--
-- Indexes for table `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_device_user1_idx` (`userId`);

--
-- Indexes for table `discipline`
--
ALTER TABLE `discipline`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_UNIQUE` (`code`),
  ADD UNIQUE KEY `superCode_UNIQUE` (`superCode`),
  ADD KEY `fk_scientific_sector_country1_idx` (`countryId`),
  ADD KEY `FATHER` (`fatherId`);

--
-- Indexes for table `discipline_lang`
--
ALTER TABLE `discipline_lang`
  ADD PRIMARY KEY (`id`,`langId`),
  ADD KEY `fk_ssd_lang_language1_idx` (`langId`);

--
-- Indexes for table `document_type`
--
ALTER TABLE `document_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_UNIQUE` (`code`);

--
-- Indexes for table `document_type_lang`
--
ALTER TABLE `document_type_lang`
  ADD PRIMARY KEY (`id`,`langId`),
  ADD KEY `fk_document_type_lang_language1_idx` (`langId`);

--
-- Indexes for table `emailfiles`
--
ALTER TABLE `emailfiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `touser_id` (`touser_id`),
  ADD KEY `email_id` (`email_id`),
  ADD KEY `forwarded_id` (`forwarded_id`),
  ADD KEY `emailfiles_ibfk_1` (`parentemail_id`);

--
-- Indexes for table `employeerequests`
--
ALTER TABLE `employeerequests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `employeesdailyworkflow`
--
ALTER TABLE `employeesdailyworkflow`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `employee_shifts`
--
ALTER TABLE `employee_shifts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `epictasks_projecttasks`
--
ALTER TABLE `epictasks_projecttasks`
  ADD PRIMARY KEY (`epictask_id`,`projecttask_id`),
  ADD KEY `projectId` (`projectId`),
  ADD KEY `projecttask_id` (`projecttask_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `event_alert`
--
ALTER TABLE `event_alert`
  ADD PRIMARY KEY (`marker`,`ownerType`,`ownerId`,`guestId`,`wakeupTime`),
  ADD KEY `wakeup_user` (`wakeupTime`,`guestId`),
  ADD KEY `fk_event_alert_event_sharing1_idx` (`marker`,`ownerType`,`ownerId`,`guestId`);

--
-- Indexes for table `event_attachment`
--
ALTER TABLE `event_attachment`
  ADD PRIMARY KEY (`marker`,`ownerType`,`ownerId`,`fileMarker`,`fileCnt`),
  ADD KEY `fk_event_attachment_attachment1_idx` (`fileMarker`,`fileCnt`),
  ADD KEY `fk_event_attachment_event_object1_idx` (`marker`,`ownerType`,`ownerId`),
  ADD KEY `fk_event_attachment_icon1_idx` (`iconId`);

--
-- Indexes for table `event_object`
--
ALTER TABLE `event_object`
  ADD PRIMARY KEY (`marker`,`ownerType`,`ownerId`),
  ADD KEY `fk_event_user1_idx` (`creatorId`),
  ADD KEY `events_per_owner` (`ownerType`,`ownerId`,`startDate`,`startTime`),
  ADD KEY `fk_event_object_icon1_idx` (`iconId`),
  ADD KEY `REFERENCE` (`referenceMarker`,`referenceOwnerType`,`referenceOwnerId`);

--
-- Indexes for table `event_sharing`
--
ALTER TABLE `event_sharing`
  ADD PRIMARY KEY (`marker`,`ownerType`,`ownerId`,`guestId`),
  ADD KEY `fk_event_sharing_user1_idx` (`guestId`),
  ADD KEY `pending_join` (`isProcessed`,`guestId`,`invitationTime`),
  ADD KEY `confirmed_join` (`isJoined`,`guestId`,`marker`,`ownerType`,`ownerId`),
  ADD KEY `fk_event_sharing_event_object1_idx` (`marker`,`ownerType`,`ownerId`);

--
-- Indexes for table `exchange_rate`
--
ALTER TABLE `exchange_rate`
  ADD PRIMARY KEY (`currencyCode`);

--
-- Indexes for table `e_answers`
--
ALTER TABLE `e_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `e_question_id` (`e_question_id`);

--
-- Indexes for table `e_category`
--
ALTER TABLE `e_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_UNIQUE` (`code`),
  ADD UNIQUE KEY `superCode_UNIQUE` (`superCode`),
  ADD KEY `name` (`name`),
  ADD KEY `FATHER` (`parent_id`),
  ADD KEY `fk_e_category_organization1_idx` (`organizationId`),
  ADD KEY `e_category_ibfk_1` (`organizationId`,`departmentId`);

--
-- Indexes for table `e_course`
--
ALTER TABLE `e_course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_e_course_creator_idx` (`creatorId`),
  ADD KEY `fk_e_course_e_category1_idx` (`eCategoryId`),
  ADD KEY `titolo_in_lingua` (`languageCode`,`title`),
  ADD KEY `titolo` (`title`),
  ADD KEY `fk_e_course_owner_idx` (`ownerId`),
  ADD KEY `fk_e_course_matter1_idx` (`matterId`),
  ADD KEY `fk_e_course_organization1_idx` (`organizationId`);

--
-- Indexes for table `e_course_acl`
--
ALTER TABLE `e_course_acl`
  ADD PRIMARY KEY (`eCourseId`,`memberType`,`memberId`);

--
-- Indexes for table `e_course_attachment`
--
ALTER TABLE `e_course_attachment`
  ADD PRIMARY KEY (`eCourseId`,`fileMarker`,`fileCnt`),
  ADD KEY `fk_e_course_attachment_attachment1_idx` (`fileMarker`,`fileCnt`),
  ADD KEY `fk_e_course_attachment_e_course1_idx` (`eCourseId`),
  ADD KEY `fk_e_course_attachment_icon1_idx` (`iconId`);

--
-- Indexes for table `e_course_bibliography`
--
ALTER TABLE `e_course_bibliography`
  ADD PRIMARY KEY (`eCourseId`,`bookId`),
  ADD KEY `fk_eCourse_bibliography_book1_idx` (`bookId`),
  ADD KEY `fk_eCourse_bibliography_eCourse1_idx` (`eCourseId`);

--
-- Indexes for table `e_course_references`
--
ALTER TABLE `e_course_references`
  ADD PRIMARY KEY (`e_course_id`,`sort_number`);

--
-- Indexes for table `e_course_user`
--
ALTER TABLE `e_course_user`
  ADD PRIMARY KEY (`eCourseId`,`userId`),
  ADD KEY `fk_eCourse_user_user1_idx` (`userId`),
  ADD KEY `fk_eCourse_user_course1_idx` (`eCourseId`);

--
-- Indexes for table `e_course_years`
--
ALTER TABLE `e_course_years`
  ADD PRIMARY KEY (`id`),
  ADD KEY `e_course_id` (`e_course_id`);

--
-- Indexes for table `e_dictionary`
--
ALTER TABLE `e_dictionary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_e_dictionary_language1_idx` (`languageId`);

--
-- Indexes for table `e_dictionary_attachment`
--
ALTER TABLE `e_dictionary_attachment`
  ADD PRIMARY KEY (`eDictionaryId`,`dKey`,`fileMarker`,`fileCnt`),
  ADD KEY `fk_e_dictionary_attachment_attachment1_idx` (`fileMarker`,`fileCnt`),
  ADD KEY `fk_e_dictionary_attachment_e_dictionary_item1_idx` (`eDictionaryId`,`dKey`),
  ADD KEY `fk_e_dictionary_attachment_icon1_idx` (`iconId`);

--
-- Indexes for table `e_dictionary_item`
--
ALTER TABLE `e_dictionary_item`
  ADD PRIMARY KEY (`eDictionaryId`,`dKey`);

--
-- Indexes for table `e_forum`
--
ALTER TABLE `e_forum`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `e_given_answers`
--
ALTER TABLE `e_given_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `e_lesson`
--
ALTER TABLE `e_lesson`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lesson_course1_idx` (`eCourseId`),
  ADD KEY `fk_e_lesson_user1_idx` (`creatorId`),
  ADD KEY `sorted_lessons` (`eCourseId`,`sortNumber`);

--
-- Indexes for table `e_lesson_attachment`
--
ALTER TABLE `e_lesson_attachment`
  ADD PRIMARY KEY (`eLessonId`,`fileMarker`,`fileCnt`),
  ADD KEY `fk_e_lesson_attachment_attachment1_idx` (`fileMarker`,`fileCnt`),
  ADD KEY `fk_e_lesson_attachment_e_lesson1_idx` (`eLessonId`),
  ADD KEY `fk_e_lesson_attachment_icon1_idx` (`iconId`),
  ADD KEY `file_object_code` (`file_object_code`);

--
-- Indexes for table `e_lesson_completed`
--
ALTER TABLE `e_lesson_completed`
  ADD PRIMARY KEY (`e_lesson_id`,`user_id`) USING BTREE,
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `e_lesson_e_topics`
--
ALTER TABLE `e_lesson_e_topics`
  ADD PRIMARY KEY (`e_topic_id`,`e_lesson_id`),
  ADD KEY `e_topic_id` (`e_topic_id`),
  ADD KEY `e_lesson_id` (`e_lesson_id`);

--
-- Indexes for table `e_lesson_user_attachment`
--
ALTER TABLE `e_lesson_user_attachment`
  ADD PRIMARY KEY (`eCourseId`,`userId`,`eLessonId`,`id`,`cnt`),
  ADD KEY `fk_e_lesson_user_attachment_attachment1_idx` (`id`,`cnt`),
  ADD KEY `fk_e_lesson_user_attachment_e_lesson_user_status_idx` (`eCourseId`,`userId`,`eLessonId`),
  ADD KEY `fk_e_lesson_user_attachment_icon1_idx` (`iconId`);

--
-- Indexes for table `e_lesson_user_status`
--
ALTER TABLE `e_lesson_user_status`
  ADD PRIMARY KEY (`eCourseId`,`userId`,`eLessonId`),
  ADD KEY `fk_e_course_user_has_e_lesson_e_lesson1_idx` (`eLessonId`),
  ADD KEY `fk_e_course_user_has_e_lesson_e_course_user1_idx` (`eCourseId`,`userId`);

--
-- Indexes for table `e_log`
--
ALTER TABLE `e_log`
  ADD PRIMARY KEY (`eCourseId`,`temporal`,`seq`),
  ADD KEY `fk_e_log_e_course1_idx` (`eCourseId`),
  ADD KEY `fk_e_log_e_lesson1_idx` (`eLessonId`),
  ADD KEY `fk_e_log_user1_idx` (`userId`),
  ADD KEY `cambi_stato_corso` (`eCourseId`,`changeTime`),
  ADD KEY `cambi_da_programma` (`progId`);

--
-- Indexes for table `e_message`
--
ALTER TABLE `e_message`
  ADD PRIMARY KEY (`eForumId`,`senderId`,`createDate`),
  ADD KEY `fk_message_user1_idx` (`senderId`),
  ADD KEY `year_user` (`year`,`senderId`,`createDate`),
  ADD KEY `fk_e_message_e_forum1_idx` (`eForumId`),
  ADD KEY `cronological` (`createDate`),
  ADD KEY `fk_e_message_e_message1_idx` (`prevForumId`,`prevSenderId`,`prevDate`);

--
-- Indexes for table `e_message_attachment`
--
ALTER TABLE `e_message_attachment`
  ADD PRIMARY KEY (`eForumId`,`senderId`,`createDate`,`fileMarker`,`fileCnt`),
  ADD KEY `fk_e_message_attachment_attachment1_idx` (`fileMarker`,`fileCnt`),
  ADD KEY `fk_e_message_attachment_e_message1_idx` (`eForumId`,`senderId`,`createDate`),
  ADD KEY `fk_e_message_attachment_icon1_idx` (`iconId`);

--
-- Indexes for table `e_questions`
--
ALTER TABLE `e_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `e_quiz_id` (`e_quiz_id`);

--
-- Indexes for table `e_quizzes`
--
ALTER TABLE `e_quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `e_request`
--
ALTER TABLE `e_request`
  ADD PRIMARY KEY (`eCourseId`,`temporal`),
  ADD KEY `fk_e_request_user1_idx` (`examinerId`),
  ADD KEY `LAST_REQUEST` (`eCourseId`,`temporal`),
  ADD KEY `fk_e_request_user2_idx` (`supervisorId`);

--
-- Indexes for table `e_timeline`
--
ALTER TABLE `e_timeline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `e_topics`
--
ALTER TABLE `e_topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `e_course_id` (`e_course_id`);

--
-- Indexes for table `e_user_awaiting`
--
ALTER TABLE `e_user_awaiting`
  ADD PRIMARY KEY (`eCourseId`,`userId`),
  ADD KEY `fk_eCourse_user_user1_idx` (`userId`),
  ADD KEY `fk_eCourse_user_course1_idx` (`eCourseId`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_faq_faq_category1_idx` (`faqCategoryId`),
  ADD KEY `rilevanza` (`relevance`,`id`) COMMENT 'ordina le faq per rilevanza';

--
-- Indexes for table `faq_category`
--
ALTER TABLE `faq_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `superCode_UNIQUE` (`superCode`),
  ADD KEY `rilevanza` (`relevance`,`id`),
  ADD KEY `FATHER` (`fatherId`);

--
-- Indexes for table `faq_category_lang`
--
ALTER TABLE `faq_category_lang`
  ADD PRIMARY KEY (`id`,`langId`),
  ADD KEY `fk_faq_category_lang_language1_idx` (`langId`);

--
-- Indexes for table `faq_lang`
--
ALTER TABLE `faq_lang`
  ADD PRIMARY KEY (`id`,`langId`),
  ADD KEY `fk_faq_lang_language1_idx` (`langId`);

--
-- Indexes for table `favoriteposts`
--
ALTER TABLE `favoriteposts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `file_extension`
--
ALTER TABLE `file_extension`
  ADD PRIMARY KEY (`code`),
  ADD KEY `fk_file_extension_icon1_idx` (`iconId`),
  ADD KEY `fk_file_extension_file_type1` (`fileTypeId`);

--
-- Indexes for table `file_object`
--
ALTER TABLE `file_object`
  ADD PRIMARY KEY (`marker`,`cnt`),
  ADD KEY `fk_attachment_checksum1_idx` (`checksumId`),
  ADD KEY `store_sv_name_path` (`storeServerName`,`storePath`,`originalFileName`),
  ADD KEY `store_sv_ip_path` (`storeServerIp`,`storePath`,`originalFileName`),
  ADD KEY `obj_for_event` (`marker`,`cnt`),
  ADD KEY `obj_for_user` (`cnt`),
  ADD KEY `fk_attachment_user1_idx` (`ownerId`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `file_type`
--
ALTER TABLE `file_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_UNIQUE` (`code`),
  ADD KEY `fk_file_type_icon1_idx` (`iconId`);

--
-- Indexes for table `file_type_lang`
--
ALTER TABLE `file_type_lang`
  ADD PRIMARY KEY (`id`,`langId`),
  ADD KEY `fk_file_type_lang_language1_idx` (`langId`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `general_auth`
--
ALTER TABLE `general_auth`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_subscription_feature_loan_strategy1_idx` (`loanStrategyIdIN`),
  ADD KEY `fk_subscription_feature_loan_strategy2_idx` (`loanStrategyIdOUT`);

--
-- Indexes for table `groupchatfiles`
--
ALTER TABLE `groupchatfiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groupchat_id` (`groupchat_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `groupchats`
--
ALTER TABLE `groupchats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `parentgroupchat_id` (`parentgroupchat_id`);

--
-- Indexes for table `groupfileposts`
--
ALTER TABLE `groupfileposts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `groupfiles`
--
ALTER TABLE `groupfiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groupfilepost_id` (`groupfilepost_id`);

--
-- Indexes for table `groupmembers`
--
ALTER TABLE `groupmembers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `groupnotes`
--
ALTER TABLE `groupnotes`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `grouppostfiles`
--
ALTER TABLE `grouppostfiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `grouppost_id` (`grouppost_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `groupposts`
--
ALTER TABLE `groupposts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `groupposttagmembers`
--
ALTER TABLE `groupposttagmembers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `reply_id` (`reply_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `creatorId` (`creatorId`);

--
-- Indexes for table `group_connector`
--
ALTER TABLE `group_connector`
  ADD PRIMARY KEY (`groupId`),
  ADD KEY `fk_group_connector_school1_idx` (`schoolId`),
  ADD KEY `teaching_area_idx` (`teachingAreaId`),
  ADD KEY `course_idx` (`courseId`),
  ADD KEY `course_section_idx` (`courseSectionId`),
  ADD KEY `matter_idx` (`matterId`),
  ADD KEY `fk_group_connector_e_course1_idx` (`eCourseId`);

--
-- Indexes for table `group_member`
--
ALTER TABLE `group_member`
  ADD PRIMARY KEY (`groupId`,`memberType`,`memberId`),
  ADD KEY `group_members` (`memberType`,`memberId`,`groupId`) COMMENT 'gruppi a cui partecipa il membro',
  ADD KEY `fk_group_member_user1_idx` (`sponsorId`);

--
-- Indexes for table `group_message`
--
ALTER TABLE `group_message`
  ADD PRIMARY KEY (`groupId`,`senderId`,`createDate`),
  ADD KEY `fk_group_comment_user1_idx` (`senderId`),
  ADD KEY `fk_group_comment_language1_idx` (`langId`),
  ADD KEY `FATHER` (`fatherGroupId`,`fatherSenderId`,`fatherCreateDate`);

--
-- Indexes for table `group_message_attachment`
--
ALTER TABLE `group_message_attachment`
  ADD PRIMARY KEY (`groupId`,`senderId`,`createDate`,`fileMarker`,`fileCnt`),
  ADD KEY `fk_group_message_attachment_file_object1_idx` (`fileMarker`,`fileCnt`),
  ADD KEY `fk_group_message_attachment_icon1_idx` (`iconId`);

--
-- Indexes for table `group_message_favorite`
--
ALTER TABLE `group_message_favorite`
  ADD PRIMARY KEY (`groupId`,`senderId`,`createDate`,`userId`),
  ADD KEY `fk_group_message_has_user_user1_idx` (`userId`),
  ADD KEY `fk_group_message_has_user_group_message1_idx` (`groupId`,`senderId`,`createDate`);

--
-- Indexes for table `group_object`
--
ALTER TABLE `group_object`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `superCode_UNIQUE` (`superCode`),
  ADD KEY `fk_group_app_user1_idx` (`creatorId`),
  ADD KEY `NAME` (`name`),
  ADD KEY `VISIBILITY` (`visibility`,`isSchool`),
  ADD KEY `FATHER` (`fatherId`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `icon`
--
ALTER TABLE `icon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_icon_icon_type1_idx` (`iconTypeId`);

--
-- Indexes for table `icon_type`
--
ALTER TABLE `icon_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_UNIQUE` (`code`);

--
-- Indexes for table `icon_type_lang`
--
ALTER TABLE `icon_type_lang`
  ADD PRIMARY KEY (`id`,`langId`),
  ADD KEY `fk_icon_type_lang_language1_idx` (`langId`);

--
-- Indexes for table `industry`
--
ALTER TABLE `industry`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `superCode_UNIQUE` (`superCode`),
  ADD UNIQUE KEY `code_UNIQUE` (`code`),
  ADD UNIQUE KEY `parentCode_UNIQUE` (`parentCode`),
  ADD KEY `ISICreference` (`refISIC`),
  ADD KEY `FATHER` (`fatherId`);

--
-- Indexes for table `industry_lang`
--
ALTER TABLE `industry_lang`
  ADD PRIMARY KEY (`id`,`langId`),
  ADD KEY `fk_industry_lang_language1_idx` (`langId`);

--
-- Indexes for table `invoiceitems`
--
ALTER TABLE `invoiceitems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoiceId` (`invoiceId`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `projectId` (`projectId`);

--
-- Indexes for table `isced_level`
--
ALTER TABLE `isced_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `iva_code`
--
ALTER TABLE `iva_code`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_iva_code_country1_idx` (`countryId`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lc_annotation`
--
ALTER TABLE `lc_annotation`
  ADD PRIMARY KEY (`userId`,`bookId`,`seq`,`idTime`),
  ADD UNIQUE KEY `page_number` (`userId`,`bookId`,`seq`,`pageNumber`,`sideLeft`,`top`) COMMENT 'Identifica univocamente la posizione su una pagina di un libro di un utente',
  ADD KEY `fk_lc_annotation_book_file1_idx` (`bookId`,`seq`);

--
-- Indexes for table `lc_hand_write`
--
ALTER TABLE `lc_hand_write`
  ADD PRIMARY KEY (`userId`,`bookId`,`seq`,`pointIdTime`),
  ADD UNIQUE KEY `page_number` (`userId`,`bookId`,`seq`,`pageNumber`,`sideLeft`,`top`) COMMENT 'Identifica univocamente la posizione su una pagina di un libro di un utente',
  ADD KEY `line_selector` (`userId`,`bookId`,`seq`,`lineId`),
  ADD KEY `fk_lc_hand_write_book_file1_idx` (`bookId`,`seq`);

--
-- Indexes for table `lc_selection`
--
ALTER TABLE `lc_selection`
  ADD PRIMARY KEY (`userId`,`bookId`,`seq`,`idTime`),
  ADD KEY `sel_group` (`userId`,`bookId`,`seq`,`idSelectionGroup`),
  ADD KEY `fk_lc_selection_book_file1_idx` (`bookId`,`seq`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`id`,`type`),
  ADD UNIQUE KEY `superCode_UNIQUE` (`superCode`),
  ADD KEY `fk_library_ssd1_idx` (`ssdId`),
  ADD KEY `fk_library_school_type1_idx` (`schoolTypeId`),
  ADD KEY `fk_library_school_level1_idx` (`schoolLevelId`),
  ADD KEY `fk_library_school_teaching_area1_idx` (`teachingAreaId`),
  ADD KEY `fk_library_ssd_area1_idx` (`ssdAreaId`),
  ADD KEY `fk_library_loan_strategy1_idx` (`loanStrategyId`),
  ADD KEY `FATHER` (`fatherId`,`fatherType`);

--
-- Indexes for table `library_book`
--
ALTER TABLE `library_book`
  ADD PRIMARY KEY (`libraryId`,`libraryType`,`bookId`),
  ADD KEY `fk_library_book1_idx` (`bookId`),
  ADD KEY `OWNER` (`ownerId`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`libraryId`,`libraryType`,`bookId`,`userId`,`issueDate`),
  ADD KEY `book_per_user` (`userId`,`bookId`) COMMENT 'libri prestati per utente',
  ADD KEY `borrow_date` (`issueDate`,`bookId`,`userId`) COMMENT 'perstiti per data prestito per utente',
  ADD KEY `expected_return_books` (`expectedReturnDate`,`bookId`) COMMENT 'rientri previsti per libro',
  ADD KEY `fk_loan_loan_strategy1_idx` (`loanStrategyId`);

--
-- Indexes for table `loan_closed`
--
ALTER TABLE `loan_closed`
  ADD PRIMARY KEY (`libraryId`,`libraryType`,`bookId`,`userId`,`issueDate`),
  ADD KEY `book_per_user` (`userId`,`bookId`) COMMENT 'libri prestati per utente',
  ADD KEY `borrow_date` (`issueDate`,`bookId`,`userId`) COMMENT 'perstiti per data prestito per utente',
  ADD KEY `expected_return_books` (`expectedReturnDate`,`bookId`) COMMENT 'rientri previsti per libro';

--
-- Indexes for table `loan_strategy`
--
ALTER TABLE `loan_strategy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_UNIQUE` (`code`),
  ADD KEY `fk_loan_strategy_school1_idx` (`schoolId`),
  ADD KEY `fk_loan_strategy_school_teaching_area1_idx` (`teachingAreaId`),
  ADD KEY `fk_loan_strategy_school_level1_idx` (`schoolLevelId`),
  ADD KEY `fk_loan_strategy_school_type1_idx` (`schoolTypeId`),
  ADD KEY `fk_loan_strategy_ssd1_idx` (`ssdId`),
  ADD KEY `fk_loan_strategy_ssd_area1_idx` (`ssdAreaId`);

--
-- Indexes for table `loan_strategy_item`
--
ALTER TABLE `loan_strategy_item`
  ADD PRIMARY KEY (`strategyId`,`itemKey`);

--
-- Indexes for table `loan_strategy_lang`
--
ALTER TABLE `loan_strategy_lang`
  ADD PRIMARY KEY (`id`,`langId`),
  ADD KEY `fk_loan_strategy_lang_language1_idx` (`langId`);

--
-- Indexes for table `log_app`
--
ALTER TABLE `log_app`
  ADD PRIMARY KEY (`temporal`,`action`),
  ADD KEY `action` (`action`,`isResultOk`,`temporal`),
  ADD KEY `remote_addr` (`remoteAddr`,`temporal`),
  ADD KEY `method` (`method`,`remoteAddr`,`temporal`),
  ADD KEY `scheme` (`scheme`,`remoteAddr`,`temporal`),
  ADD KEY `query_string` (`queryString`,`remoteAddr`,`temporal`);

--
-- Indexes for table `mail_message`
--
ALTER TABLE `mail_message`
  ADD PRIMARY KEY (`temporal`,`senderId`),
  ADD KEY `fk_message_user1_idx` (`senderId`),
  ADD KEY `year_user` (`year`,`senderId`,`temporal`),
  ADD KEY `conversation` (`initialTemporal`,`initialSenderId`),
  ADD KEY `previous_message` (`prevTemporal`,`prevSenderId`);

--
-- Indexes for table `mail_message_attachment`
--
ALTER TABLE `mail_message_attachment`
  ADD PRIMARY KEY (`temporal`,`senderId`,`fileMarker`,`fileCnt`),
  ADD KEY `fk_mail_message_attachment_mail_message1_idx` (`temporal`,`senderId`),
  ADD KEY `fk_mail_message_attachment_icon1_idx` (`iconId`),
  ADD KEY `fk_mail_message_attachment_file_object1_idx` (`fileMarker`,`fileCnt`);

--
-- Indexes for table `mail_receiver`
--
ALTER TABLE `mail_receiver`
  ADD PRIMARY KEY (`temporal`,`senderId`,`receiverId`),
  ADD KEY `fk_message_receiver_user1_idx` (`receiverId`);

--
-- Indexes for table `mail_recipient`
--
ALTER TABLE `mail_recipient`
  ADD PRIMARY KEY (`temporal`,`senderId`,`seq`),
  ADD KEY `recipientMode` (`temporal`,`senderId`,`mode`,`seq`) COMMENT 'recuper i destinatari del messaggio divisi per modo (T, C, B) nello stesso ordine in cui sono stati inseriti';

--
-- Indexes for table `matter`
--
ALTER TABLE `matter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `superCode_UNIQUE` (`superCode`),
  ADD UNIQUE KEY `code_UNIQUE` (`code`),
  ADD KEY `fk_matter_country1_idx` (`countryId`),
  ADD KEY `FATHER` (`fatherId`),
  ADD KEY `fk_matter_ssd1_idx` (`ssdId`),
  ADD KEY `fk_matter_school_data1_idx` (`schoolId`);

--
-- Indexes for table `matter_lang`
--
ALTER TABLE `matter_lang`
  ADD PRIMARY KEY (`id`,`langId`),
  ADD KEY `fk_matter_area_lang_language1_idx` (`langId`);

--
-- Indexes for table `measure_unit`
--
ALTER TABLE `measure_unit`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `measure_unit_lang`
--
ALTER TABLE `measure_unit_lang`
  ADD PRIMARY KEY (`code`,`langId`),
  ADD KEY `fk_measure_unit_lang_language1_idx` (`langId`);

--
-- Indexes for table `menu_acl`
--
ALTER TABLE `menu_acl`
  ADD PRIMARY KEY (`menuItemId`,`userId`),
  ADD KEY `fk_menu_acl_role1_idx` (`roleId`),
  ADD KEY `fk_menu_acl_user1_idx` (`userId`),
  ADD KEY `fk_menu_acl_menu_item1_idx` (`menuItemId`);

--
-- Indexes for table `menu_item`
--
ALTER TABLE `menu_item`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `superCode_UNIQUE` (`superCode`),
  ADD KEY `fk_menu_item_menu_module1_idx` (`moduleId`),
  ADD KEY `FATHER` (`fatherId`);

--
-- Indexes for table `menu_item_lang`
--
ALTER TABLE `menu_item_lang`
  ADD PRIMARY KEY (`id`,`langId`),
  ADD KEY `fk_menu_lang_language1_idx` (`langId`);

--
-- Indexes for table `menu_module`
--
ALTER TABLE `menu_module`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_UNIQUE` (`code`);

--
-- Indexes for table `menu_module_lang`
--
ALTER TABLE `menu_module_lang`
  ADD PRIMARY KEY (`id`,`langId`),
  ADD KEY `fk_menu_module_lang_language1_idx` (`langId`),
  ADD KEY `fk_menu_module_lang_menu_module1_idx` (`id`);

--
-- Indexes for table `movement`
--
ALTER TABLE `movement`
  ADD PRIMARY KEY (`storageId`,`storageType`,`storageNum`,`articleId`,`orderYear4`,`orderCountryId`,`orderTypeId`,`orderNumDoc`,`movDate`),
  ADD KEY `fk_movement_causal1_idx` (`causalId`),
  ADD KEY `fk_movement_article1_idx` (`articleId`),
  ADD KEY `fk_movement_iva_code1_idx` (`ivaCodeId`),
  ADD KEY `fk_movement_exchange_rate1_idx` (`currencyCode`),
  ADD KEY `fk_movement_document_type1` (`doc2TypeId`);

--
-- Indexes for table `news_channel`
--
ALTER TABLE `news_channel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news_channel_lang`
--
ALTER TABLE `news_channel_lang`
  ADD PRIMARY KEY (`id`,`langId`),
  ADD KEY `fk_news_channel_lang_language1_idx` (`langId`);

--
-- Indexes for table `news_internal`
--
ALTER TABLE `news_internal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_news_internal_news_status1_idx` (`statusId`),
  ADD KEY `fk_news_internal_news_channel1_idx` (`channelId`),
  ADD KEY `expired_news` (`statusId`,`schoolId`,`isExpired`),
  ADD KEY `expiring_news` (`isExpired`,`expirationDate`,`channelId`,`schoolId`,`statusId`),
  ADD KEY `fk_news_internal_school1_idx` (`schoolId`);

--
-- Indexes for table `news_status`
--
ALTER TABLE `news_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news_status_lang`
--
ALTER TABLE `news_status_lang`
  ADD PRIMARY KEY (`id`,`langId`),
  ADD KEY `fk_news_status_lang_language1_idx` (`langId`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`userId`,`screenType`,`objectType`,`objectId`,`objectDate`),
  ADD KEY `recent` (`userId`,`screenType`,`createDate`,`type`,`isRead`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`fromuser_id`),
  ADD KEY `touser_id` (`touser_id`),
  ADD KEY `module_id` (`module_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `module_action_id` (`module_action_id`);

--
-- Indexes for table `notification_settings`
--
ALTER TABLE `notification_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_id` (`module_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `onsiteemployees`
--
ALTER TABLE `onsiteemployees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `projectId` (`projectId`),
  ADD KEY `work_categoryId` (`work_location_Id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`orderYear4`,`countryId`,`orderTypeId`,`orderNum`,`itemId`),
  ADD KEY `fk_order_item_iva_code1_idx` (`ivaCodeId`);

--
-- Indexes for table `order_object`
--
ALTER TABLE `order_object`
  ADD PRIMARY KEY (`year4`,`countryId`,`typeId`,`numDoc`),
  ADD KEY `fk_order_app_order_status1_idx` (`statusId`),
  ADD KEY `fk_order_app_exchange_rate1_idx` (`currencyCode`),
  ADD KEY `fk_order_object_clifor1_idx` (`anagId`,`cliforType`),
  ADD KEY `REQUEST` (`requestYear`,`requestCountryId`,`requestTypeId`,`requestNum`);

--
-- Indexes for table `order_prog`
--
ALTER TABLE `order_prog`
  ADD PRIMARY KEY (`year4`,`countryId`,`typeId`),
  ADD KEY `fk_order_prog_country1_idx` (`countryId`),
  ADD KEY `fk_order_prog_order_type1` (`typeId`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_status_lang`
--
ALTER TABLE `order_status_lang`
  ADD PRIMARY KEY (`id`,`langId`),
  ADD KEY `fk_order_status_lang_language1_idx` (`langId`);

--
-- Indexes for table `order_type`
--
ALTER TABLE `order_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_type_lang`
--
ALTER TABLE `order_type_lang`
  ADD PRIMARY KEY (`id`,`langId`),
  ADD KEY `fk_order_type_lang_language1_idx` (`langId`);

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_organization_anagraphic1_idx` (`anagId`),
  ADD KEY `FATHER` (`fatherId`);

--
-- Indexes for table `organization_industry`
--
ALTER TABLE `organization_industry`
  ADD PRIMARY KEY (`organizationId`,`industryId`),
  ADD KEY `fk_organization_has_industry_industry1_idx` (`industryId`),
  ADD KEY `fk_organization_has_industry_organization1_idx` (`organizationId`);

--
-- Indexes for table `organization_roles`
--
ALTER TABLE `organization_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `e_category_id` (`e_category_id`),
  ADD KEY `organization_id` (`organization_id`,`department_code`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `organization_user`
--
ALTER TABLE `organization_user`
  ADD PRIMARY KEY (`organizationId`,`userId`),
  ADD KEY `fk_school_user_user1_idx` (`userId`),
  ADD KEY `school_membership` (`isExpired`,`isConfirmed`,`organizationId`,`userId`,`isDisabled`),
  ADD KEY `teachers` (`isTeacher`,`organizationId`,`isConfirmed`,`isExpired`,`isDisabled`),
  ADD KEY `students` (`isStudent`,`organizationId`,`isConfirmed`,`isExpired`,`isDisabled`),
  ADD KEY `employees` (`isAdmin`,`organizationId`,`isConfirmed`,`isExpired`,`isDisabled`),
  ADD KEY `expiring_date` (`expirationDate`,`organizationId`,`userId`,`isExpired`,`isDisabled`),
  ADD KEY `fk_school_user_department1_idx` (`organizationId`,`departmentCode`),
  ADD KEY `organization_user_ibfk_1` (`e_category_id`);

--
-- Indexes for table `organization_user_auth`
--
ALTER TABLE `organization_user_auth`
  ADD PRIMARY KEY (`organizationId`,`userId`),
  ADD KEY `fk_subscription_feature_loan_strategy1_idx` (`loanStrategyIdIN`),
  ADD KEY `fk_subscription_feature_loan_strategy2_idx` (`loanStrategyIdOUT`),
  ADD KEY `fk_subscription_feature_copy1_organization_user1_idx` (`organizationId`,`userId`);

--
-- Indexes for table `organizatio_users_years`
--
ALTER TABLE `organizatio_users_years`
  ADD PRIMARY KEY (`organization_id`,`user_id`,`year`) USING BTREE;

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `payment_lang`
--
ALTER TABLE `payment_lang`
  ADD PRIMARY KEY (`code`,`langId`),
  ADD KEY `fk_payment_lang_language1_idx` (`langId`);

--
-- Indexes for table `payslips`
--
ALTER TABLE `payslips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `postcommentfiles`
--
ALTER TABLE `postcommentfiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `reply_id` (`reply_id`);

--
-- Indexes for table `postcommentlikes`
--
ALTER TABLE `postcommentlikes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`comment_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `reply_id` (`reply_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `postcomments`
--
ALTER TABLE `postcomments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `postlikes`
--
ALTER TABLE `postlikes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `prefixed_course`
--
ALTER TABLE `prefixed_course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_prefixed_course_prefixed_teaching_area1_idx` (`teachingAreaId`),
  ADD KEY `fk_prefixed_course_degree_class1_idx` (`degreeClassId`);

--
-- Indexes for table `prefixed_course_matter`
--
ALTER TABLE `prefixed_course_matter`
  ADD PRIMARY KEY (`courseId`,`matterId`),
  ADD KEY `fk_prefixed_course_matter_prefixed_course1_idx` (`courseId`),
  ADD KEY `fk_prefixed_course_matter_matter1_idx` (`matterId`);

--
-- Indexes for table `prefixed_teaching_area`
--
ALTER TABLE `prefixed_teaching_area`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_teaching_area_country1_idx` (`countryId`),
  ADD KEY `fk_teaching_area_school_level1_idx` (`schoolLevelId`);

--
-- Indexes for table `preloaded_school`
--
ALTER TABLE `preloaded_school`
  ADD PRIMARY KEY (`code`),
  ADD KEY `code_MAIN` (`referenceCode`),
  ADD KEY `fk_school_school_level1_idx` (`schoolLevelId`);

--
-- Indexes for table `price`
--
ALTER TABLE `price`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_price_exchange_rate1_idx` (`currencyCode`),
  ADD KEY `fk_price_article1_idx` (`articleId`),
  ADD KEY `fk_price_price_list1_idx` (`priceListId`),
  ADD KEY `activation_date` (`startDate`),
  ADD KEY `expiration_date` (`endDate`);

--
-- Indexes for table `price_list`
--
ALTER TABLE `price_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_price_list_exchange_rate1_idx` (`currencyCode`),
  ADD KEY `fk_price_list_country1_idx` (`countryId`);

--
-- Indexes for table `privacy_desktop`
--
ALTER TABLE `privacy_desktop`
  ADD PRIMARY KEY (`ownerId`,`itemId`,`id`),
  ADD KEY `friend` (`friendId`,`ownerId`,`itemId`);

--
-- Indexes for table `privacy_event`
--
ALTER TABLE `privacy_event`
  ADD PRIMARY KEY (`eventMarker`,`eventOwnerType`,`eventOwnerId`,`id`),
  ADD KEY `friend` (`friendId`),
  ADD KEY `fk_privacy_event_event_object1_idx` (`eventMarker`,`eventOwnerType`,`eventOwnerId`);

--
-- Indexes for table `privacy_group_message`
--
ALTER TABLE `privacy_group_message`
  ADD PRIMARY KEY (`groupId`,`senderId`,`createDate`,`id`),
  ADD KEY `friend` (`friendId`,`groupId`,`senderId`,`createDate`);

--
-- Indexes for table `privacy_lc_annotation`
--
ALTER TABLE `privacy_lc_annotation`
  ADD PRIMARY KEY (`userId`,`bookId`,`seq`,`idTime`,`id`),
  ADD KEY `friend` (`userId`,`bookId`,`seq`,`idTime`,`friendId`);

--
-- Indexes for table `privacy_setting`
--
ALTER TABLE `privacy_setting`
  ADD PRIMARY KEY (`ownerId`);

--
-- Indexes for table `privacy_survey`
--
ALTER TABLE `privacy_survey`
  ADD PRIMARY KEY (`surveyId`,`creatorId`,`id`),
  ADD KEY `friend` (`friendId`,`surveyId`,`creatorId`);

--
-- Indexes for table `privacy_user`
--
ALTER TABLE `privacy_user`
  ADD PRIMARY KEY (`ownerId`,`id`,`infoTypeId`),
  ADD KEY `friend` (`friendId`,`ownerId`),
  ADD KEY `fk_privacy_user_user_info_type1_idx` (`infoTypeId`);

--
-- Indexes for table `privacy_user_setting`
--
ALTER TABLE `privacy_user_setting`
  ADD PRIMARY KEY (`ownerId`,`infoTypeId`),
  ADD KEY `fk_privacy_user_setting_user_info_type1_idx` (`infoTypeId`);

--
-- Indexes for table `profession`
--
ALTER TABLE `profession`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `profession_lang`
--
ALTER TABLE `profession_lang`
  ADD PRIMARY KEY (`id`,`langId`),
  ADD KEY `fk_profession_lang_language1_idx` (`langId`),
  ADD KEY `profession_name` (`name`);

--
-- Indexes for table `projectassets`
--
ALTER TABLE `projectassets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `projectbccemails`
--
ALTER TABLE `projectbccemails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_id` (`email_id`),
  ADD KEY `bccuser_id` (`bccuser_id`);

--
-- Indexes for table `projectccemails`
--
ALTER TABLE `projectccemails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_id` (`email_id`),
  ADD KEY `ccemail_id` (`ccuser_id`);

--
-- Indexes for table `projectemail`
--
ALTER TABLE `projectemail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parentemail_id` (`parentemail_id`),
  ADD KEY `forwarded_id` (`forwarded_id`),
  ADD KEY `fromuser_id` (`fromuser_id`),
  ADD KEY `rootmail_id` (`rootmail_id`);

--
-- Indexes for table `projectfiles`
--
ALTER TABLE `projectfiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `projecttasks`
--
ALTER TABLE `projecttasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status_updatedby` (`status_updatedby`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `creatorId` (`creatorId`),
  ADD KEY `referred_taskId` (`referred_taskId`);

--
-- Indexes for table `projecttypes`
--
ALTER TABLE `projecttypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_member`
--
ALTER TABLE `project_member`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projectId` (`projectId`),
  ADD KEY `memberId` (`memberId`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `project_member_ibfk_4` (`designation_id`);

--
-- Indexes for table `project_object`
--
ALTER TABLE `project_object`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`countryId`,`regionId`,`id`),
  ADD KEY `name` (`name`,`countryId`,`regionId`),
  ADD KEY `tag` (`tag`,`countryId`,`regionId`);

--
-- Indexes for table `publisher`
--
ALTER TABLE `publisher`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Indexes for table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`countryId`,`id`),
  ADD KEY `name` (`name`,`countryId`,`isDeleted`),
  ADD KEY `country_region` (`countryId`,`isDeleted`,`name`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`email_id`);

--
-- Indexes for table `repeate_shifts`
--
ALTER TABLE `repeate_shifts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shift_id` (`shift_id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`designation_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `module_id` (`usermodule_id`);

--
-- Indexes for table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `shift_schedules`
--
ALTER TABLE `shift_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `shift_id` (`shift_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `taskfiles`
--
ALTER TABLE `taskfiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tid` (`tid`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `taskgroups`
--
ALTER TABLE `taskgroups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projectId` (`projectId`);

--
-- Indexes for table `taskgroups_projecttasks`
--
ALTER TABLE `taskgroups_projecttasks`
  ADD PRIMARY KEY (`taskgroup_id`,`projecttask_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `projecttask_id` (`projecttask_id`);

--
-- Indexes for table `taskusers`
--
ALTER TABLE `taskusers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `choosen_companyId` (`choosen_companyId`);

--
-- Indexes for table `userbanks`
--
ALTER TABLE `userbanks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `usercompanies`
--
ALTER TABLE `usercompanies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `usermodule_permissions`
--
ALTER TABLE `usermodule_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_id` (`module_id`),
  ADD KEY `user_id` (`designation_id`);

--
-- Indexes for table `versions_contract`
--
ALTER TABLE `versions_contract`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workinghours`
--
ALTER TABLE `workinghours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `company_id` (`company_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chatcontacts`
--
ALTER TABLE `chatcontacts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chatfiles`
--
ALTER TABLE `chatfiles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chatgroups`
--
ALTER TABLE `chatgroups`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chatgroupsusers`
--
ALTER TABLE `chatgroupsusers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_modules`
--
ALTER TABLE `company_modules`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_shifts`
--
ALTER TABLE `employee_shifts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groupchatfiles`
--
ALTER TABLE `groupchatfiles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groupchats`
--
ALTER TABLE `groupchats`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groupfileposts`
--
ALTER TABLE `groupfileposts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groupfiles`
--
ALTER TABLE `groupfiles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groupmembers`
--
ALTER TABLE `groupmembers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grouppostfiles`
--
ALTER TABLE `grouppostfiles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groupposts`
--
ALTER TABLE `groupposts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groupposttagmembers`
--
ALTER TABLE `groupposttagmembers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoiceitems`
--
ALTER TABLE `invoiceitems`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_settings`
--
ALTER TABLE `notification_settings`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payslips`
--
ALTER TABLE `payslips`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `postcommentfiles`
--
ALTER TABLE `postcommentfiles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `postcommentlikes`
--
ALTER TABLE `postcommentlikes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `postcomments`
--
ALTER TABLE `postcomments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `postlikes`
--
ALTER TABLE `postlikes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projectfiles`
--
ALTER TABLE `projectfiles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projecttasks`
--
ALTER TABLE `projecttasks`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projecttypes`
--
ALTER TABLE `projecttypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_member`
--
ALTER TABLE `project_member`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_object`
--
ALTER TABLE `project_object`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `repeate_shifts`
--
ALTER TABLE `repeate_shifts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salaries`
--
ALTER TABLE `salaries`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shift_schedules`
--
ALTER TABLE `shift_schedules`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taskfiles`
--
ALTER TABLE `taskfiles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taskgroups`
--
ALTER TABLE `taskgroups`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taskusers`
--
ALTER TABLE `taskusers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'user ID - Autoinc';

--
-- AUTO_INCREMENT for table `userbanks`
--
ALTER TABLE `userbanks`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usercompanies`
--
ALTER TABLE `usercompanies`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usermodule_permissions`
--
ALTER TABLE `usermodule_permissions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `versions_contract`
--
ALTER TABLE `versions_contract`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `workinghours`
--
ALTER TABLE `workinghours`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `additionaldatausers`
--
ALTER TABLE `additionaldatausers`
  ADD CONSTRAINT `additionaldatausers_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `companies_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `chatcontacts`
--
ALTER TABLE `chatcontacts`
  ADD CONSTRAINT `chatcontacts_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `usercompanies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chatcontacts_ibfk_2` FOREIGN KEY (`fromuser_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chatcontacts_ibfk_3` FOREIGN KEY (`touser_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `chatgroupsusers`
--
ALTER TABLE `chatgroupsusers`
  ADD CONSTRAINT `chatgroupsusers_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `chatgroups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `companies_user`
--
ALTER TABLE `companies_user`
  ADD CONSTRAINT `companies_user_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `usercompanies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `companies_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_shifts`
--
ALTER TABLE `employee_shifts`
  ADD CONSTRAINT `employee_shifts_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `usercompanies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `epictasks_projecttasks`
--
ALTER TABLE `epictasks_projecttasks`
  ADD CONSTRAINT `epictasks_projecttasks_ibfk_1` FOREIGN KEY (`projectId`) REFERENCES `project_object` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `epictasks_projecttasks_ibfk_2` FOREIGN KEY (`epictask_id`) REFERENCES `projecttasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `epictasks_projecttasks_ibfk_3` FOREIGN KEY (`projecttask_id`) REFERENCES `projecttasks` (`id`);

--
-- Constraints for table `favoriteposts`
--
ALTER TABLE `favoriteposts`
  ADD CONSTRAINT `favoriteposts_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `groupposts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favoriteposts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `groupfileposts`
--
ALTER TABLE `groupfileposts`
  ADD CONSTRAINT `groupfileposts_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `groupfileposts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `groupfiles`
--
ALTER TABLE `groupfiles`
  ADD CONSTRAINT `groupfiles_ibfk_1` FOREIGN KEY (`groupfilepost_id`) REFERENCES `groupfileposts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `groupmembers`
--
ALTER TABLE `groupmembers`
  ADD CONSTRAINT `groupmembers_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `groupnotes`
--
ALTER TABLE `groupnotes`
  ADD CONSTRAINT `groupnotes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `groupposts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `grouppostfiles`
--
ALTER TABLE `grouppostfiles`
  ADD CONSTRAINT `grouppostfiles_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `groupposts`
--
ALTER TABLE `groupposts`
  ADD CONSTRAINT `groupposts_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `groupposttagmembers`
--
ALTER TABLE `groupposttagmembers`
  ADD CONSTRAINT `groupposttagmembers_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `groupposts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `groupposttagmembers_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `groupposttagmembers_ibfk_3` FOREIGN KEY (`comment_id`) REFERENCES `postcomments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `groupposttagmembers_ibfk_4` FOREIGN KEY (`reply_id`) REFERENCES `postcomments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies_user` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `leaves`
--
ALTER TABLE `leaves`
  ADD CONSTRAINT `leaves_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `usercompanies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `usercompanies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_3` FOREIGN KEY (`touser_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_4` FOREIGN KEY (`fromuser_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `postcommentfiles`
--
ALTER TABLE `postcommentfiles`
  ADD CONSTRAINT `postcommentfiles_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `postcomments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `postcommentlikes`
--
ALTER TABLE `postcommentlikes`
  ADD CONSTRAINT `postcommentlikes_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `postcomments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `postcommentlikes_ibfk_2` FOREIGN KEY (`reply_id`) REFERENCES `postcomments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `postcomments`
--
ALTER TABLE `postcomments`
  ADD CONSTRAINT `postcomments_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `postcomments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `postlikes`
--
ALTER TABLE `postlikes`
  ADD CONSTRAINT `postlikes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `groupposts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `projectfiles`
--
ALTER TABLE `projectfiles`
  ADD CONSTRAINT `projectfiles_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project_object` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `projectfiles_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `projecttasks`
--
ALTER TABLE `projecttasks`
  ADD CONSTRAINT `projecttasks_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project_object` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `projecttasks_ibfk_2` FOREIGN KEY (`creatorId`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `projecttasks_ibfk_3` FOREIGN KEY (`referred_taskId`) REFERENCES `projecttasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_member`
--
ALTER TABLE `project_member`
  ADD CONSTRAINT `project_member_ibfk_1` FOREIGN KEY (`projectId`) REFERENCES `project_object` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_member_ibfk_2` FOREIGN KEY (`memberId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `repeate_shifts`
--
ALTER TABLE `repeate_shifts`
  ADD CONSTRAINT `repeate_shifts_ibfk_1` FOREIGN KEY (`shift_id`) REFERENCES `employee_shifts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`usermodule_id`) REFERENCES `usermodule_permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_permissions_ibfk_3` FOREIGN KEY (`company_id`) REFERENCES `usercompanies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `salaries`
--
ALTER TABLE `salaries`
  ADD CONSTRAINT `salaries_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shift_schedules`
--
ALTER TABLE `shift_schedules`
  ADD CONSTRAINT `shift_schedules_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies_user` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `shift_schedules_ibfk_3` FOREIGN KEY (`shift_id`) REFERENCES `employee_shifts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `shift_schedules_ibfk_4` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `shift_schedules_ibfk_5` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `taskfiles`
--
ALTER TABLE `taskfiles`
  ADD CONSTRAINT `taskfiles_ibfk_1` FOREIGN KEY (`tid`) REFERENCES `projecttasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `taskfiles_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `taskgroups`
--
ALTER TABLE `taskgroups`
  ADD CONSTRAINT `taskgroups_ibfk_1` FOREIGN KEY (`projectId`) REFERENCES `project_object` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `taskgroups_projecttasks`
--
ALTER TABLE `taskgroups_projecttasks`
  ADD CONSTRAINT `taskgroups_projecttasks_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project_object` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `taskgroups_projecttasks_ibfk_2` FOREIGN KEY (`taskgroup_id`) REFERENCES `taskgroups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `taskgroups_projecttasks_ibfk_3` FOREIGN KEY (`projecttask_id`) REFERENCES `projecttasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`choosen_companyId`) REFERENCES `usercompanies` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `userbanks`
--
ALTER TABLE `userbanks`
  ADD CONSTRAINT `userbanks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usercompanies`
--
ALTER TABLE `usercompanies`
  ADD CONSTRAINT `usercompanies_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usermodule_permissions`
--
ALTER TABLE `usermodule_permissions`
  ADD CONSTRAINT `usermodule_permissions_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `company_modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usermodule_permissions_ibfk_2` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `workinghours`
--
ALTER TABLE `workinghours`
  ADD CONSTRAINT `workinghours_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `usercompanies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `workinghours_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
