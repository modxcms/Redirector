<?php
/**
 * Default English Lexicon Entries for redirector
 *
 * @package redirector
 * @subpackage lexicon
 */
$_lang['redirector'] = 'Redirector';
$_lang['redirector.active'] = 'Active';
$_lang['redirector.desc'] = 'Manage redirects for your website. Red lines means that the pattern URL is still exists OR target URL doesn\'t exists for a resource and will not be redirected.';
$_lang['redirector.nothing_found'] = 'No redirects found yet!';
$_lang['redirector.description'] = 'Description';
$_lang['redirector.redirect_err_ae'] = 'A redirect with that name already exists.';
$_lang['redirector.redirect_err_nf'] = 'Redirect not found.';
$_lang['redirector.redirect_err_ns'] = 'Redirect not specified.';
$_lang['redirector.redirect_err_ns_name'] = 'Please specify a name for the redirect.';
$_lang['redirector.redirect_err_remove'] = 'An error occurred while trying to remove the redirect.';
$_lang['redirector.redirect_err_save'] = 'An error occurred while trying to save the redirect.';
$_lang['redirector.redirect_create'] = 'Create New Redirect';
$_lang['redirector.redirect_remove'] = 'Remove Redirect';
$_lang['redirector.redirect_remove_confirm'] = 'Are you sure you want to remove this redirect?';
$_lang['redirector.redirect_update'] = 'Update Redirect';
$_lang['redirector.redirects'] = 'Redirects';
$_lang['redirector.management'] = 'Redirects Management';
$_lang['redirector.menu_desc'] = 'Manage your redirects.';
$_lang['redirector.pattern'] = 'Pattern';
$_lang['redirector.search...'] = 'Search...';
$_lang['redirector.target'] = 'Target';
$_lang['redirector.context'] = 'Context';
$_lang['redirector.context_desc'] = 'If context is set, redirect only affects on loaded context.';

$_lang['redirector.import'] = 'Import CSV';
$_lang['redirector.import_desc'] = 'Here you can import new rules provided in CSV format. You can upload a CSV file or past raw CSV format in the textarea below';
$_lang['redirector.import.csv_desc'] = 'Notice: format of the CSV must be "pattern;target;context", where "context" may be skipped or empty.<br/>Also; use relative URLs, not include [[+site_url]] or similar ones.';
$_lang['redirector.import.csv_file'] = 'CSV File selection';
$_lang['redirector.import.raw_csv'] = 'Paste raw CSV data here';
$_lang['redirector.import.do'] = 'Start Import!';
$_lang['redirector.import.doing'] = 'Busy with importing CSV data...';
$_lang['redirector.import.success'] = 'Total [[+total]] records found. Imported: [[+succeed]] successful and [[+failed]] failed!';
$_lang['redirector.import.failed'] = 'Failed importing CSV data... Try again!';

$_lang['redirector.regex_explain'] = 'You can use regular expressions in the pattern and retrieve your replacements back in your target URL.

For example; you have many old URLs like "shop/category-{name}/" and you want to redirect all those URLs to the new "webshop/{name}/" structure, no problem!
Enter these values:

<b>Pattern:</b> ^shop\/category-(.*)\/$
<b>Target:</b> webshop/$1/

You can also apply more wildcards (.*) and use $2, $3 etc. And as you can see, you need to escape the forward slashes and define a ^ for the start and $ for the end position.';

// settings
$_lang['setting_redirector.track_uri_updates'] = 'Track URI Updates';
$_lang['setting_redirector.track_uri_updates_desc'] = 'If enabled, this will keep track on resource URI updates. Automatically created redirects for old > new URIs.';
