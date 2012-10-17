<form action="[[~[[+invoicesResource]]]]" method="get">
	<p>
		<strong>[[%moneybird.contacts.filter]]</strong>
		<select name="[[+filterKey]]" onchange="this.form.submit()">
			[[+showNone:eq=`1`:then=`<option value="">[[%moneybird.contacts.shownone]]</option>`:else=``]]
			[[+wrapper]]
		</select>
	</p>
</form>