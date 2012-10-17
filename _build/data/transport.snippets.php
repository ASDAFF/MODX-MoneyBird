<?php

function getSnippetContent($filename) {
    $o = file_get_contents($filename);
    $o = trim(str_replace(array('<?php','?>'),'',$o));
    return $o;
}

$snippets = array();

$snippets[1]= $modx->newObject('modSnippet');
$snippets[1]->fromArray(array(
    'id' => 1,
    'name' => 'MoneyBirdInvoices',
    'description' => 'Lists the invoices based on the binded contacts',
    'snippet' => getSnippetContent($sources['elements'].'snippets/moneybirdinvoices.snippet.php'),
),'',true,true);

$snippets[2]= $modx->newObject('modSnippet');
$snippets[2]->fromArray(array(
    'id' => 1,
    'name' => 'MoneyBirdContacts',
    'description' => 'Lists all contacts binded to the user',
    'snippet' => getSnippetContent($sources['elements'].'snippets/moneybirdcontacts.snippet.php'),
),'',true,true);

$snippets[3]= $modx->newObject('modSnippet');
$snippets[3]->fromArray(array(
    'id' => 1,
    'name' => 'MoneyBirdNrFormat',
    'description' => 'Formats decimal numbers with the PHP\'s number_format().
Use it as output filter like: [[+decimalNumber:NumberFormat=`d=2&ds=,&ts=.`]]',
    'snippet' => getSnippetContent($sources['elements'].'snippets/moneybirdnrformat.snippet.php'),
),'',true,true);

return $snippets;

?>