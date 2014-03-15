<?php
/**
 * Default Dutch Lexicon Entries for redirector
 *
 * @package redirector
 * @subpackage lexicon
 */
$_lang['redirector'] = 'Redirector';
$_lang['redirector.active'] = 'Actief';
$_lang['redirector.desc'] = 'Beheer verwijzingen voor je website. Rode regels betekenen dat het patroon nog altijd een bestaande URL is OF dat de target niet bestaat, als resource en dat deze niet geredirect wordt.';
$_lang['redirector.nothing_found'] = 'Nog geen verwijzingen gevonden!';
$_lang['redirector.description'] = 'Beschrijving';
$_lang['redirector.redirect_err_ae'] = 'Er bestaat al een verwijzing met deze naam.';
$_lang['redirector.redirect_err_nf'] = 'Verwijzing niet gevonden.';
$_lang['redirector.redirect_err_ns'] = 'Verwijzing niet gespecificeerd.';
$_lang['redirector.redirect_err_ns_name'] = 'Specificeer een naam voor de verwijzing.';
$_lang['redirector.redirect_err_remove'] = 'Er is een fout opgetreden bij het verwijderen van de verwijzing.';
$_lang['redirector.redirect_err_save'] = 'Er is een fout opgetreden bij het opslaan van de verwijzing.';
$_lang['redirector.redirect_create'] = 'Cre&euml;er Nieuwe Verwijzing';
$_lang['redirector.redirect_remove'] = 'Verwijder Verwijzing';
$_lang['redirector.redirect_remove_confirm'] = 'Weet je zeker dat je deze verwijzing wilt verwijderen?';
$_lang['redirector.redirect_update'] = 'Wijzig Verwijzing';
$_lang['redirector.redirects'] = 'Verwijzingen';
$_lang['redirector.management'] = 'Verwijzingen Beheer';
$_lang['redirector.menu_desc'] = 'Beheer je verwijzingen.';
$_lang['redirector.pattern'] = 'Patroon';
$_lang['redirector.search...'] = 'Zoeken...';
$_lang['redirector.target'] = 'Doel';
$_lang['redirector.context'] = 'Context';
$_lang['redirector.context_desc'] = 'Als context ingesteld is, zal de redirect alleen plaatsvinden als deze geladen is.';

$_lang['redirector.import'] = 'Importeer CSV';
$_lang['redirector.import_desc'] = 'Hier kunt u nieuwe verwijs regels importeren middels CSV formaat. U kunt een CSV bestand uploaden of ruwe CSV in het textveld hieronder plaatsen.';
$_lang['redirector.import.csv_desc'] = 'Let op: het formaat van de CSV moet "pattern;target;context" zijn, waar "context" overgeslagen of leeg mag zijn.<br/>Daarnaast: gebruik relatieve URLs, gebruik geen [[+site_url]] of vergelijkbare waarden.';
$_lang['redirector.import.csv_file'] = 'CSV Bestand selecteren';
$_lang['redirector.import.raw_csv'] = 'Plak ruwe CSV data hier';
$_lang['redirector.import.do'] = 'Start Import!';
$_lang['redirector.import.doing'] = 'Bezig met importeren CSV data...';
$_lang['redirector.import.success'] = 'Totaal [[+total]] records gevonden. Geimporteerd: [[+succeed]] met succes en [[+failed]] mislukt!';
$_lang['redirector.import.failed'] = 'Mislukt CSV te importeren... Probeer het nog eens!';