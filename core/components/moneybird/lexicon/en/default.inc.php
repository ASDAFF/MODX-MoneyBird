<?php
/**
 * The English MoneyBird language entries
 * 
 * @author Bert Oost at Oostdesign.nl <bert@oostdesign.nl>
 * @package moneybird
 * @language en
 */

$_lang['moneybird'] = "MoneyBird";
$_lang['moneybird.desc'] = "Manage the MoneyBird contacts with your MODX users for their invoices listing.";

$_lang['moneybird.manage'] = "Your MoneyBird contacts vs. local users";
$_lang['moneybird.manage.desc'] = "Below you find the local MODX users on the left and on the right your contacts from MoneyBird. It's the intention to bind your MoneyBird contacts to local user accounts, so they can see their invoices etc. You can do this by dragging the MoneyBird contact on the local user from the right to the left tree. Each local user can contain multiple MoneyBird contacts.";

$_lang['moneybird.local_users'] = "Local users";
$_lang['moneybird.local_users.remove'] = "Remove contact from user";
$_lang['moneybird.local_users.remove_confirm'] = "Are you sure you want to remove <b>[[+name]]</b> from this user?";
$_lang['moneybird.contacts'] = "MoneyBird contacts";
$_lang['moneybird.contacts.refresh'] = "Refresh from MoneyBird";

$_lang['moneybird.error.invalid_data'] = "Some error occurred based on the contact and user id. Please refresh and try again!";
$_lang['moneybird.error.user_ahr'] = "The user already haves a relationship with a MoneyBird contact. Just one relation per user is allowed!";
$_lang['moneybird.error.relation_ne'] = "The relation between the user and the MoneyBird contact cnanot be found. Please refresh and try again!";

$_lang['moneybird.invoice.id'] = "Invoice ID";
$_lang['moneybird.invoice.total'] = "Total amount";
$_lang['moneybird.invoice.state'] = "State";
$_lang['moneybird.invoice.state.draft'] = "Draft";
$_lang['moneybird.invoice.state.open'] = "Open";
$_lang['moneybird.invoice.state.late'] = "Late";
$_lang['moneybird.invoice.state.paid'] = "Paid";
$_lang['moneybird.invoice.view'] = "View invoice";
$_lang['moneybird.invoice.pay'] = "Pay invoice";
$_lang['moneybird.invoice.pdf'] = "Get PDF";

$_lang['moneybird.contacts.filter'] = "Filter by contact";
$_lang['moneybird.contacts.shownone'] = "-- none --";

// OAuth authentication
$_lang['moneybird.consumer.set'] = "Set your application Consumer Key";
$_lang['moneybird.consumer.accountname'] = "MoneyBird Account";
$_lang['moneybird.consumer.accountname.desc'] = "Your MoneyBird Account name is the same as the name in the front of the direct URL to your MoneyBird Dashboard. Like: [accountname].moneybird.nl";
$_lang['moneybird.consumer.key'] = "Consumer Key";
$_lang['moneybird.consumer.secret'] = "Consumer Secret";
$_lang['moneybird.consumer.set.desc'] = "To use your MoneyBird you should make your MODX installation as a valid application for the use of the MoneyBird API. To authenticate your application you should first create an application at your MoneyBird account (see MoneyBird documentation). Once you did that you will get a Consumer Key and Consumer Secret and this id's should be entered below the MoneyBird Account name to continue. If they are already filled, just hit the \"Authenticate application\" button to request the API Access Token.";
$_lang['moneybird.consumer.set.setgoauth'] = "Set & Authenticate application";
$_lang['moneybird.consumer.set.goauth'] = "Authenticate application";
$_lang['moneybird.consumer.set.exit'] = "Exit MoneyBird";

$_lang['moneybird.consumer.set.error.name_ns'] = "MoneyBird Account Name not specified! Please enter your Account Name!";
$_lang['moneybird.consumer.set.error.key_ns'] = "MoneyBird Consumer Key not specified! Please enter the Consumer Key!";
$_lang['moneybird.consumer.set.error.secret_ns'] = "MoneyBird Consumer Secret not specified! Please enter the Consumer Secret!";

// settings
$_lang['setting_moneybird.account_name'] = "MoneyBird Account Name";
$_lang['setting_moneybird.account_name_desc'] = "Enter the MoneyBird Account Name. The part in the front of your MoneyBird URL, like: [accountname].moneybird.nl.";
$_lang['setting_moneybird.auth_username'] = "MoneyBird username";
$_lang['setting_moneybird.auth_username_desc'] = "Enter the username where you login with at MoneyBird. Mostly this is your email address.";
$_lang['setting_moneybird.auth_password'] = "MoneyBird password";
$_lang['setting_moneybird.auth_password_desc'] = "Enter the password you use to access your MoneyBird account.";


?>