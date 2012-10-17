<tr>
	<td>[[+invoiceId]]</td>
	<td>[[+currencySymbol]] [[+totalPriceInclTax:MoneyBirdNrFormat=`ts=.`]]</td>
	<td>[[%moneybird.invoice.state.[[+state]]]]</td>
	<td><a href="[[+url]]" target="_blank">View invoice</a></td>
	<td>[[+state:ne=`paid`:then=`<a href="[[+payUrl]]" target="_blank">[[%moneybird.invoice.pay]]</a>`:else=``]]</td>
	<td><a href="[[+pdfUrl]]" target="_blank">[[%moneybird.invoice.pdf]]</a></td>
</tr>