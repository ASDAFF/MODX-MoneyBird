<?php
/**
 * Formats decimal numbers with the PHP's number_format().
 * Use it as output filter like: [[+decimalNumber:NumberFormat=`d=2&ds=,&ts=.`]]
 *
 * Parameters:
 * d - Decimals. The number of decimals to show. Default to 2
 * ds - Decimal seperator. Default to '.'
 * ts - Thousands separator. Default empty
 * s - Symbol. Adds a symbol to the number (with space). Default empty
 *
 * @package moneybird
 * @author Bert Oost at OostDesign.nl <bert@oostdesign.nl>
 */

$opts = array();
$options = ((!empty($options)) ? explode('&', $options) : '');
if(!empty($options) && is_array($options)) {
  foreach($options as $option) {
    list($key, $value) = explode('=', $option);
    $opts[$key] = $value;
  }
}

$input = ((!empty($input)) ? (float) str_replace(',', '.', $input) : $input);
$decimals = $modx->getOption('d', $opts, 2);
$seperator = $modx->getOption('ds', $opts, ',');
$thousands = $modx->getOption('ts', $opts, '');
$symbol = $modx->getOption('s', $opts, false);

if(!empty($input) && is_float($input)) {
  
  $output = ((!empty($symbol)) ? $symbol : '').' ';
  $output .= number_format($input, $decimals, $seperator, $thousands);
  return $output;
}

return $input;

?>