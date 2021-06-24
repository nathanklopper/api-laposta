<?
$lib = $_GET['lib'];
if (empty($lib)) {
	$lib = $_SESSION['lib'];
}
if (empty($lib) || !in_array($lib, ['curl', 'php', 'dotnet'])) {
	// default
	$lib = 'curl';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl" lang="nl">

<head>
<title>Laposta API Documentation</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="/doc/assets/130402/css/normalize.css" type="text/css" />
<link rel="stylesheet" href="/doc/assets/130402/css/api.css" type="text/css" />
<link rel="shortcut icon" href="/doc/assets/static/img/favicon.ico" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script>
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-23294879-1']);
  _gaq.push(['_setDomainName', '.laposta.nl']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

function generate_address(username, domain) {
        var atsign = "&#64;";
        var addr = username + atsign + domain;
        document.write( "<" + "a" + " " + "href=" + "mail" + "to:" + addr + ">" + addr + "<\/a>");
}
</script>
</head>

<body>
<div id="container">
<div id="header">
<ul id="nav">
	<li><a href="#auth">Authentication, Ratelimiting and Error Messages</a><li>
	<li class="sep">|</li>
	<li><a href="#lists">Lists</a><li>
	<li class="sep">|</li>
	<li><a href="#fields">Fields</a><li>
	<li class="sep">|</li>
	<li><a href="#members">Members</a><li>
	<li class="sep">|</li>
	<li><a href="#webhooks">Webhooks</a><li>
	<li class="sep">|</li>
	<li><a href="#campaigns">Campaigns</a><li>
	<li class="sep">|</li>
	<li><a href="#reports">Reports</a><li>
	<li class="sep">|</li>
	<li><a href="#accounts">Accounts</a><li>
	<li class="sep">|</li>
	<li><a href="#login">Login</a><li>
</ul>

<?php // NOTE: curl, php and .NET buttons broken. Displays Show :href="?lib=curl">curl|href="?lib=php">php|href="?lib=dotnet">.NET?>

<ul id="lib">
<li>Show:</li>
<li><a<? if ($lib == 'curl') print ' class="selected"'; ?> href="?lib=curl">curl</a></li>
<li class="sep">|</li>
<li><a<? if ($lib == 'php') print ' class="selected"'; ?> href="?lib=php">php</a></li>
<li class="sep">|</li>
<li><a<? if ($lib == 'dotnet') print ' class="selected"'; ?> href="?lib=dotnet"><b>.</b>NET</a></li>
</ul>

<ul id="links">
	<li><a class="login" href="https://login.laposta.nl/">Login</a><li>
	<li class="sep">|</li>
	<li><a href="http://www.laposta.nl/contact">Contact</a><li>
</ul>
</div><!-- /header -->

<table class="content">

<!-- into -->
<tr>
<td class="left first">
<a id="home" href="http://www.laposta.nl/"><img src="/doc/assets/static/img/logo-laposta-y18-v2-800x232.png" width="120" height="35" alt="Laposta - gemakkelijk nieuwsbrieven versturen" /></a>
<h1>API documentation</h1>
</td><!-- /left -->

<td class="right first" style="vertical-align:bottom">
<p class="info alert">We would love to hear any questions and feedback you may have! Please mail us at <a href="mailto:api@laposta.nl">api@laposta.nl</a>.</p>
<p class="info alert">The API key used in the examples is available for testing.</p>
</td><!-- /right -->
</tr>

<tr class="continue">
<td class="left">
<p>The Laposta API has been set up according to the <a href="http://en.wikipedia.org/wiki/Representational_State_Transfer">REST</a> principle. All responses from the API, including error messages, have been compiled in <a href="http://www.json.org/">JSON</a> format.</p>
<p>The API primarily focuses on the addition and reading relations. This allows for Laposta to, among other things, synchronize with other systems, like a CMS or a CRM. Another of its common applications is the automatic addition of relations to Laposta, for instance when placing an order in a webshop.</p>
<p>It is also possible for partners to create accounts using the API, so that the set-up of customer accounts can fully be achieved without the need of our assistence.</p>
<p>In order to make programming with the API easier <a href="./libraries">php and .NET (C#) libraries</a> have been made available for users.</p>
</td><!-- /left -->

<td class="right">
<h2>Default API URL</h2>
<p>The API is available via http and https. For security reasons, we strongly recommend users to work with https URLs.</p><p><ul class="code"><li>http://api.laposta.nl/</li><li>https://api.laposta.nl/</li></ul></p>
<h2>Available URL patterns</h2>
<ul class="code">
<li>/v2/member</li>
<li>/v2/member/{member_id}</li>
</ul>
</td><!-- /right -->
</tr>

<tr>
<td class="left">
<a id="auth"></a>
<h2>Authentication</h2>
<p>Each request must include the account's API key. This can be found by logging in and proceeding to click on 'Access &amp; Subscription' on the top right, and then going to 'Links - API'.</p>
<p>The Authentication process is achieved using <a href="http://en.wikipedia.org/wiki/Basic_access_authentication">Basic Authentication</a>. The API-key functions as the username; a password is not required.</p>
</td><!-- /left -->

<td class="right">
<h4>Example of request</h4>
<? if (empty($lib) || $lib == 'curl') { ?>
<pre class="code">
$ curl https://api.laposta.nl/v2/member?list_id=BaImMu3JZA \
  -u JdMtbsMq2jqJdQZD9AHC:
</pre>
<p class="info">Using the '-u' parameter, you will be able to pass the API key using Basic Authentication. Adding a colon behind the key avoids any password requests.</p>
<? } else if ($lib == 'php') { ?>
<pre class="code">
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$member = new Laposta_Member('BaImMu3JZA');
$result = $member->all();
</pre>
<? } else if ($lib == 'dotnet') { ?>
<pre class="code">
LapostaConfig.apiKey = "JdMtbsMq2jqJdQZD9AHC";
var memberService = new LapostaMemberService("BaImMu3JZA");
LapostaMember member = new LapostaMember();
member = memberService.Get("9978ydioiZ");
</pre>
<? } ?>
</td><!-- /right -->
</tr>

<tr>
<td class="left">
<a id="ratelimiting"></a>
<h2>Ratelimiting</h2>
<p>In order to protect our systems, we have decided to limit the number of requests per unit of time. If you have reached a limit, you will recieve a notification from our server. This notification also indicates after how many seconds a next request is possible again.</p>
</td><!-- /left -->

<td class="right">
<h4>If the limit is reached</h4>
<p>If you reach the limit, the server will respond with status code 429 (Too Many Requests). The server will also send a Retry-After header indicating the number of seconds to wait until the next request is possible.
</td><!-- /right -->
</tr>

<tr>
<td class="left">
<a id="errors"></a>
<h2>Error messages</h2>
<p>Our API uses as many standard HTTP status codes as possible in order to indicate how a request has proceeded. Codes in the 2xx range indicate a successful request, codes in the 4xx range indicate the presence of an error in the delivery of information (e.g. missing parameters), and codes in the 5xx range indicate that something went wrong on our end.</p>
<p>All error messages are compiled in JSON format and include an indication in regards to the type of error, a notification in regular language, and potentially a code with a parameter (in order to indicate the nature of the error).</p>
</td><!-- /left -->

<td class="right">
<h2>Overview of used HTTP status codes</h2>
<table class="list">
<tr><td class="l">200  OK</td><td>Everything is in order</td></tr>
<tr><td class="l">201  Created</td><td>Everything is in order, object created</td></tr>
<tr><td class="l">400  Bad Request</td><td>Incomplete input</td></tr>
<tr><td class="l">401  Unauthorized</td><td>No valid API key was provided</td></tr>
<tr><td class="l">402  Request Failed</td><td>Input was in order, but request was not processed</td></tr>
<tr><td class="l">404  Not Found</td><td>The requested object does not exist/could not be located</td></tr>
<tr><td class="l">429  Too Many Requests</td><td>The maximum number of requests was reached within the given unit of time</td></tr>
<tr><td class="l">500  Server Error</td><td>Error detected on Laposta's side</td></tr>
</table>

<h2>Overview  of attributes in error messages</h2>
<table class="list">
<tr><td class="l">type</td><td>The nature of the error. This could be <b>invalid_request</b> for an error in the URL invocation, <b>invalid_input</b> for an error in the supplied data, or <b>internal</b> for an error in our system.</td></tr>
<tr><td class="l">message</td><td>An explanation of the error in for humans intelligible language.</td></tr>
<tr><td class="l">code</td><td>A numerical indication of the error (optional, see below).</td></tr>
<tr><td class="l">parameter</td><td>The parameter concerning the error (optional).</td></tr>
</table>

<h2>Overview of codes in error messages</h2>
<table class="list">
<tr><td class="l">201</td><td class="explanation">The parameter is empty</td></tr>
<tr><td class="l">202</td><td class="explanation">The syntax of the parameter is incorrect</td></tr>
<tr><td class="l">203</td><td class="explanation">The parameter is unknown</td></tr>
<tr><td class="l">204</td><td class="explanation">The parameter already exists</td></tr>
<tr><td class="l">205</td><td class="explanation">The parameter is not a number</td></tr>
<tr><td class="l">206</td><td class="explanation">The parameter is not a boolean (true/false)</td></tr>
<tr><td class="l">207</td><td class="explanation">The parameter is not a date</td></tr>
<tr><td class="l">208</td><td class="explanation">The parameter is not an email address</td></tr>
<tr><td class="l">209</td><td class="explanation">The parameter is not a URL</td></tr>
<tr><td class="l">999</td><td class="explanation">The parameter contains another error</td></tr>
</table>

<h2>Example of an error object</h2>
<pre class="code">
{
    "error": {
        "type": "invalid_input",
        "message": "Email: invalid address",
        "code": 208,
        "parameter": "email"
    }
}
</pre>
</td><!-- /right -->
</tr>

<!-- ***************************************************************** -->
<!-- *************************** Lists **************************** -->
<!-- ***************************************************************** -->
<tr>
<td class="left">
<a id="lists"></a>
<h2>Lists</h2>
<p>This element allows the user to retrieve, add, modify, delete and empty lists.</p>
</td><!-- /left -->

<td class="right">
<h2>URL patterns</h2>
<ul class="code">
<li>/v2/list</li>
<li>/v2/list/{list_id}</li>
<li>/v2/list/{list_id}/members</li>
</ul>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>URL patterns</h3>
<h4>Fields</h4>
<table class="vars">
<tr><td class="var">list_id:</td><td class="explanation">ID of the list in question</td></tr>
<tr><td class="var">created:</td><td class="explanation">Date and time of creation</td></tr>
<tr><td class="var">modified:</td><td class="explanation">Date and time of last made change</td></tr>
<tr><td class="var">state:</td><td class="explanation">Status of the list: <code>active</code> or <code>deleted</code></td></tr>
<tr><td class="var">name:</td><td class="explanation">Name given to the list in question</td></tr>
<tr><td class="var">remarks:</td><td class="explanation">Potential remarks</td></tr>
<tr><td class="var">subscribe_notification_email:</td><td class="explanation">Email address to which a notification will be sent upon a subscription</td></tr>
<tr><td class="var">unsubscribe_notification_email:</td><td class="explanation">Email address to which a notification will be sent upon the cancelling of a subscription</td></tr>
<tr><td class="var">members:</td><td class="explanation">Information in regards to the number of active, unsubscribed and cleaned (deleted) members</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Example of list object</h4>
<pre class="code">
{
    "list": {
  	"list_id": "BaImMu3JZA",
  	"created": "2012-02-18 11:42:38",
  	"modified": "2012-06-02 14:07:20",
	"state": "active",
  	"name": "Testlist",
  	"remarks": "A list for testing purposes",
	"subscribe_notification_email", "subscription@example.net",
	"unsubscribe_notification_email", "cancellationsub@example.net",
	"members": {
		"active": 1232,
		"unsubscribed": 113,
		"cleaned": 14
        }
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Adding a list</h3>
<p>If there is something wrong with the parameters provided, a code is displayed with the error message. You may use these in combination with the variable 'parameter' to display a message to the user. See above under 'Error messages' what the codes stand for.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">name <span class="required">(manditory)</span>:</td><td class="explanation">Name given to the list in question</td></tr>
<tr><td class="var">remarks:</td><td class="explanation">Potential remarks</td></tr>
<tr><td class="var">subscribe_notification_email:</td><td class="explanation">Email address to which a notification will be sent upon a subscription</td></tr>
<tr><td class="var">unsubscribe_notification_email:</td><td class="explanation">Email address to which a notification will be sent upon the cancelling of a subscription</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
POST https://api.laposta.nl/v2/list
</pre>

<h4>Example of request</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/list \
  -u JdMtbsMq2jqJdQZD9AHC: \
  -d name=Testlist \
  '-d remarks=A list for testing purposes.' \
  -d subscribe_notification_email=subscription@example.net \
  -d unsubscribe_notification_email=cancellationsub@example.net
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$list = new Laposta_List();
$result = $list->create(array(
	'name' => 'Testlist',
	'remarks' => 'A list for testing purposes.',
	'subscribe_notification_email' => 'subscription@example.net',
	'unsubscribe_notification_email' => 'cancellationsub@example.net'
	)
);
<? } else if ($lib == 'dotnet') { ?>
LapostaConfig.apiKey = "JdMtbsMq2jqJdQZD9AHC";
var listService = new LapostaListService();
LapostaList list = new LapostaList();
list.Name = "Testlijst";
list.Remarks = "Testing purposes.";
list = listService.Create(list);
<? } ?>
</pre>
<h4>Example of response</h4>
<pre class="code">
{
    "list": {
  	"list_id": "BaImMu3JZA",
  	"created": "2012-02-18 11:42:38",
  	"modified": "2012-06-02 14:07:20",
	"state": "active",
  	"name": "Testlist",
  	"remarks": "A list for testing purposes.",
	"subscribe_notification_email", "subscription@example.net",
	"unsubscribe_notification_email", "cancellationsub@example.net",
	"members": {
		"active": 0,
		"unsubscribed": 0,
		"cleaned": 0
        }
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Requesting a list</h3>
<p>All information about a list.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(manditory)</span>:</td><td class="explanation">The list's ID</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
GET https://api.laposta.nl/v2/list/{list_id}
</pre>
<h4>Example of request</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/list/BaImMu3JZA \
  -u JdMtbsMq2jqJdQZD9AHC:
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$list = new Laposta_List();
$result = $list->get('BaImMu3JZA');
<? } else if ($lib == 'dotnet') { ?>
LapostaConfig.apiKey = "JdMtbsMq2jqJdQZD9AHC";
var listService = new LapostaListService();
LapostaList list = new LapostaList();
list = listService.Get("BaImMu3JZA");
<? } ?>
</div>
<h4>Example of response</h4>
<pre class="code">
{
    "list": {
	"list_id": "BaImMu3JZA",
	"created": "2012-02-18 11:42:38",
	"modified": "2012-06-02 14:07:20",
	"state": "active",
	"name": "Testlist",
	"remarks": "A list for testing purposes",
	"subscribe_notification_email", "subscription@example.net",
	"unsubscribe_notification_email", "cancellationsub@example.net",
	"members": {
		"active": 1232,
		"unsubscribed": 113,
		"cleaned": 14
	}
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Editing lists</h3>
<p>You only need to send the fields that need to be changed in the application. Fields that are not mentioned will keep their current value. As soon as a field is mentioned, it is checked and may therefore cause an error message. A code is displayed with this error message. You may use this code in combination with the variable 'parameter' to display a message to the user. See above under 'Error messages' what the codes stand for.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(manditory)</span>:</td><td class="explanation">The ID of the list that has to be edited</td></tr>
<tr><td class="var">name:</td><td class="explanation">A name for the list in question</td></tr>
<tr><td class="var">remarks:</td><td class="explanation">Potential remarks</td></tr>
<tr><td class="var">subscribe_notification_email:</td><td class="explanation">Email address to which a notification will be sent upon a subscription</td></tr>
<tr><td class="var">unsubscribe_notification_email:</td><td class="explanation">Email address to which a notification will be sent upon the cancelling of a subscription</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
POST https://api.laposta.nl/v2/list/{list_id}
</pre>

<h4>Example of request</h4>
<p class="info">This example changes the name.</p>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/list/BaImMu3JZA \
  -u JdMtbsMq2jqJdQZD9AHC: \
  -d name=Customers
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$list = new Laposta_List();
$result = $list->update('BaImMu3JZA', array(
		'name' => 'Customers'
	)
);
<? } else if ($lib == 'dotnet') { ?>
LapostaConfig.apiKey = "JdMtbsMq2jqJdQZD9AHC";
var listService = new LapostaListService();
LapostaList list = new LapostaList();
list.Name = "A new name for this list";
list = listService.Update("BaImMu3JZA", list);
<? } ?>
</pre>
<h4>Example of response</h4>
<pre class="code">
{
    "list": {
        "list_id": "BaImMu3JZA",
        "created": "2012-02-18 11:42:38",
        "modified": "2012-06-02 14:07:20",
	"state": "active",
        "name": "Customers",
        "remarks": "A list for testing purposes.",
	"subscribe_notification_email", "subscription@example.net",
	"unsubscribe_notification_email", "cancellationsub@example.net",
	"members": {
		"active": 1232,
		"unsubscribed": 113,
		"cleaned": 14
        }
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Deleting a list</h3>
<p>This permanently deletes a list. If the list does not exist, an error message is displayed. In response you get another list object, but now with the state 'deleted'. After having finished this procedure, it is no longer possible for the user to request the list.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(manditory)</span>:</td><td class="explanation">The ID of the list</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
DELETE https://api.laposta.nl/v2/list/{list_id}
</pre>

<h4>Example of request</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/list/BaImMu3JZA \
  -u JdMtbsMq2jqJdQZD9AHC: \
  -X DELETE
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$list = new Laposta_List();
$result = $list->delete('BaImMu3JZA');
<? } else if ($lib == 'dotnet') { ?>
LapostaConfig.apiKey = "JdMtbsMq2jqJdQZD9AHC";
var listService = new LapostaListService();
LapostaList list = new LapostaList();
list = listService.Delete("BaImMu3JZA");
<? } ?>
</pre>
<h4>Example of response</h4>
<pre class="code">
{
    "list": {
        "list_id": "BaImMu3JZA",
        "created": "2012-02-18 11:42:38",
        "modified": "2012-06-02 14:07:20",
	"state": "deleted",
    	"name": "Customers",
        "remarks": "A list for testing purposes",
	"subscribe_notification_email", "subscription@example.net",
	"unsubscribe_notification_email", "cancellationsub@example.net",
	"members": {
		"active": 1232,
		"unsubscribed": 113,
		"cleaned": 14
        }
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Requesting all lists</h3>
<p>All lists in an array of list objects. The list objects have been ordered in an array with the name 'data'.</p>
<h4>Parameters</h4>
<p>No parameters need to be entered.</p>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
GET https://api.laposta.nl/v2/list
</pre>

<h4>Example of request</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/list \
  -u JdMtbsMq2jqJdQZD9AHC:
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$list = new Laposta_List();
$result = $list->all();
<? } else if ($lib == 'dotnet') { ?>
LapostaConfig.apiKey = "JdMtbsMq2jqJdQZD9AHC";
var listService = new LapostaListService();
var lists = Enumerable.Empty<LapostaList>();
lists = listService.All();
<? } ?>
</pre>
<h4>Example of response</h4>
<pre class="code">
{
    "data": [
        {
            "list": {
                "list_id": "BaImMu3JZA",
                "created": "2012-02-18 11:42:38",
                "modified": "2012-06-02 14:07:20",
		"state": "active",
                "name": "Testlist",
                "remarks": "A list for testing purposes.",
        	"subscribe_notification_email", "subscription@example.net",
        	"unsubscribe_notification_email", "cancellationsub@example.net"
		"members": {
			"active": 1232,
			"unsubscribed": 113,
			"cleaned": 14
		}
            }
	},
        {
            "list": {
                "list_id": "Z87Jajj9Ak",
                "created": "2012-03-30 12:23:46",
                "modified": "2012-04-10 13:33:21",
		"state": "active",
                "name": "Another list",
                "remarks": "Customers",
        	"subscribe_notification_email", "subscription@example.net",
        	"unsubscribe_notification_email", "cancellationsub@example.net"
		"members": {
			"active": 8182,
			"unsubscribed": 205,
			"cleaned": 56
		}
            }
	}
    ]
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Purging a list</h3>
<p>This permanently purges all <i>active</i> relations from a list, but doesn't delete the list itself. If the list does not exist, an error message is displayed. In response, you are shown another list object.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(manditory)</span>:</td><td class="explanation">The ID of the list</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
DELETE https://api.laposta.nl/v2/list/{list_id}/members
</pre>

<h4>Example of request</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/list/BaImMu3JZA/members \
  -u JdMtbsMq2jqJdQZD9AHC: \
  -X DELETE
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$list = new Laposta_List();
$result = $list->delete('BaImMu3JZA', 'members');
<? } else if ($lib == 'dotnet') { ?>
[a .NET wrapper is not yet available for this functionality]
<? } ?>
</pre>
<h4>Example of response</h4>
<pre class="code">
{
    "list": {
        "list_id": "BaImMu3JZA",
        "created": "2012-02-18 11:42:38",
        "modified": "2012-06-02 14:07:20",
	"state": "deleted",
    	"name": "Customers",
        "remarks": "A list for testing purposes",
	"subscribe_notification_email", "subscription@example.net",
	"unsubscribe_notification_email", "cancellationsub@example.net",
	"members": {
		"active": 1232,
		"unsubscribed": 113,
		"cleaned": 14
        }
    }
}
</pre>
</td><!-- /right -->
</tr>


<!-- ***************************************************************** -->
<!-- *************************** FIELDS **************************** -->
<!-- ***************************************************************** -->
<tr>
<td class="left">
<a id="fields"></a>
<h2>Fields</h2>
<p>This section allows you to request, add and edit fields of lists.</p>
</td><!-- /left -->

<td class="right">
<h2>URL patterns</h2>
<ul class="code">
<li>/v2/field</li>
<li>/v2/field/{field_id}</li>
</ul>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>The field object</h3>
<h4>Fields</h4>
<table class="vars">
<tr><td class="var">field_id:</td><td class="explanation">The ID of the field in question</td></tr>
<tr><td class="var">list_id:</td><td class="explanation">The ID of the list to which the field belongs</td></tr>
<tr><td class="var">created:</td><td class="explanation">Date and time of creation</td></tr>
<tr><td class="var">modified:</td><td class="explanation">Date and time of last change made</td></tr>
<tr><td class="var">state:</td><td class="explanation">The status of the field in question: either <code>active</code> or <code>deleted</code></td></tr>
<tr><td class="var">name:</td><td class="explanation">Name of the field (for displaying purposes)</td></tr>
<tr><td class="var">tag:</td><td class="explanation">The relation variable for usage in campaigns (not changeable)</td></tr>
<tr><td class="var">custom_name:</td><td class="explanation">Name of the field (for use in member API calls)</td></tr>
<tr><td class="var">defaultvalue:</td><td class="explanation">The default value (will be used in the absence of this field)</td></tr>
<tr><td class="var">datatype:</td><td class="explanation">The datatype of the field in question (<code>text</code>, <code>numeric</code>, <code>date</code>, <code>select_single</code>, <code>select_multiple</code>)</td></tr>
<tr><td class="var">datatype_display:</td><td class="explanation">Only applicable for select_single: the desired display (<code>select</code>, <code>radio</code>)</td></tr>
<tr><td class="var">options:</td><td class="explanation">An array of the available options (only for <code>select_single</code> or <code>select_multiple</code>)</td></tr>
<tr><td class="var">options_full:</td><td class="explanation">An array of the available options, including IDs (alleen bij <code>select_single</code> or <code>select_multiple</code>)</td></tr>
<tr><td class="var">required:</td><td class="explanation">Is this a manditory field? (<code>true</code> or <code>false</code>)</td></tr>
<tr><td class="var">in_form:</td><td class="explanation">Does this field occur in the subscription form? (<code>true</code> or <code>false</code>)</td></tr>
<tr><td class="var">in_list:</td><td class="explanation">Does this field occur while browsing the list? (<code>true</code> or <code>false</code>)</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Example of field object</h4>
<pre class="code">
{
    "field": {
        "field_id": "Z87ysHha9A",
        "list_id": "BaImMu3JZA",
        "created": "2012-02-18 11:42:38",
        "modified": "2012-06-02 14:07:20",
	"state": "active",
        "name": "Name",
        "tag": "{{name}}",
        "custom_name": "name",
        "defaultvalue": "",
        "datatype": "text",
        "datatype_display": null,
        "required": true,
        "in_form": true,
        "in_list": true
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Adding a field</h3>
<p>If there is something wrong with the parameters provided, a code is displayed with the error message. See above under 'Error messages' what the codes stand for.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(verplicht)</span>:</td><td class="explanation">The ID of the list to which the field belongs</td></tr>
<tr><td class="var">name <span class="required">(verplicht)</span>:</td><td class="explanation">A name for this field</td></tr>
<tr><td class="var">defaultvalue:</td><td class="explanation">A potential default value</td></tr>
<tr><td class="var">datatype <span class="required">(verplicht)</span>:</td><td class="explanation">The datatype: <code>text</code>, <code>numeric</code>, <code>date</code>, <code>select_single</code> or <code>select_multiple</code></td></tr>
<tr><td class="var">datatype_display:</td><td class="explanation">Only applicable for select_single: the desired display (<code>select</code>, <code>radio</code>)</td></tr>
<tr><td class="var">options:</td><td class="explanation">What selection options are available? (Manditory for the datatypes <code>select_single</code> of <code>select_multiple</code>). The options can be given as an array. In the answer the options are repeated, but there is also an extra field <code>options_full</code>. Also listed are the option IDs, which may eventually be used to change the options later.</td></tr>
<tr><td class="var">required <span class="required">(verplicht)</span>:</td><td class="explanation">Is this a manditory field?</td></tr>
<tr><td class="var">in_form <span class="required">(verplicht)</span>:</td><td class="explanation">Does this field occur in the subscription form? (<code>boolean</code>)</td></tr>
<tr><td class="var">in_list <span class="required">(verplicht)</span>:</td><td class="explanation">Is this field visible in Laposta's overview? (<code>boolean</code>)</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
POST https://api.laposta.nl/v2/field
</pre>

<h4>Example of request</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
curl https://api.laposta.nl/v2/field \
  -u JdMtbsMq2jqJdQZD9AHC: \
  -d list_id=srbhotdwob \
  -d name=Color \
  -d defaultvalue=Green \
  -d datatype=select_single \
  -d datatype_display=radio \
  -d options[]=Red \
  -d options[]=Green \
  -d options[]=Blue \
  -d required=true \
  -d in_form=true \
  -d in_list=true
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$field = new Laposta_Field('srbhotdwob');
$result = $field->create(array(
		'name' => 'Color',
		'defaultvalue' => 'Green',
		'datatype' => 'select_single',
		'options' => array('Red', 'Green', 'Blue'),
		'required' => 'true',
		'in_form' => 'true',
		'in_list' => 'true'
	)
);
<? } else if ($lib == 'dotnet') { ?>
LapostaConfig.apiKey = "JdMtbsMq2jqJdQZD9AHC";
var fieldService = new LapostaFieldService("BaImMu3JZA");
LapostaField field = new LapostaField();
field.Name = "Age";
field.DefaultValue = "Age";
field.Datatype = "numeric";
field.Required = true;
field = fieldService.Create(field);
<? } ?>
</pre>
<h4>Example of response</h4>
<pre class="code">
{
    "field": {
        "field_id": "GeVKetES6z",
        "list_id": "srbhotdwob",
        "created": "2016-06-06 22:24:38",
        "modified": null,
        "state": "active",
        "name": "Color",
        "tag": "{{color}}",
        "defaultvalue": "Green",
        "datatype": "select_single",
        "datatype_display": "radio",
        "required": true,
        "in_form": true,
        "in_list": true,
        "is_email": false,
        "options": [
            "Red",
            "Green",
            "Blue"
        ],
        "options_full": [
            {
                "id": 1,
                "value": "Red"
            },
            {
                "id": 2,
                "value": "Green"
            },
            {
                "id": 3,
                "value": "Blue"
            }
        ]
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Requesting a field</h3>
<p>All information about a field.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(verplicht)</span>:</td><td class="explanation">The ID of the list to which the field belongs</td></tr>
<tr><td class="var">field_id <span class="required">(verplicht)</span>:</td><td class="explanation">The ID of the requestable field</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
GET https://api.laposta.nl/v2/field/{field_id}
</pre>
<h4>Example of request</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/field/gt2Em8vJwi?list_id=BaImMu3JZA \
  -u JdMtbsMq2jqJdQZD9AHC:
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$field = new Laposta_Field('BaImMu3JZA');
$result = $field->get('gt2Em8vJwi');
<? } else if ($lib == 'dotnet') { ?>
LapostaConfig.apiKey = "JdMtbsMq2jqJdQZD9AHC";
var fieldService = new LapostaFieldService("BaImMu3JZA");
LapostaField field = new LapostaField();
field = fieldService.Get("gt2Em8vJwi");
<? } ?>
</div>
<h4>Example of response</h4>
<pre class="code">
{
    "field": {
        "field_id": "gt2Em8vJwi",
        "list_id": "BaImMu3JZA",
        "created": "2012-02-18 11:42:38",
        "modified": "2012-06-02 14:07:20",
	"state": "active",
        "name": "Name",
        "tag": "{{name}}",
        "custom_name": "name",
        "defaultvalue": "",
        "datatype": "text",
        "datatype_display": null,
        "required": true,
        "in_form": true,
        "in_list": true
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Veld wijzigen</h3>
<p>U hoeft alleen de velden die gewijzigd moeten worden in de aanvraag mee te sturen. Velden die niet worden genoemd houden hun huidige waarde. Zodra een veld wordt genoemd wordt het wel gecontroleerd, en kan dus voor een foutmelding zorgen. Bij deze foutmelding wordt een code weergegeven met een melding. Zie hierboven bij Foutmeldingen wat de codes betekenen.</p>
<p class="info">Let op: het wijzigen van het datatype verwijderd alle gegevens uit het betreffende veld.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(verplicht)</span>:</td><td class="explanation">Het id van de lijst waartoe het veld behoort</td></tr>
<tr><td class="var">name:</td><td class="explanation">Een naam voor dit veld</td></tr>
<tr><td class="var">datatype:</td><td class="explanation">Het datatype van dit veld (<code>text</code>, <code>numeric</code>, <code>date</code>, <code>select_single</code>, <code>select_multiple</code>)</td></tr>
<tr><td class="var">datatype_display:</td><td class="explanation">Alleen voor select_single: de gewenste weergave (<code>select</code>, <code>radio</code>)</td></tr>
<tr><td class="var">options:</td><td class="explanation">Welke selectiemogelijkheden zijn er? Array met alleen de waardes. Let op: deze lijst vervangt in zijn geheel de bestaande options; voor het wijzigen van velden die al in gebruik zijn is het beter <code>options_full</code> te gebruiken. (Alleen mogelijk bij datatypes <code>select_single</code> of <code>select_multiple</code>)</td></tr>
<tr><td class="var">options_full:</td><td class="explanation">Welke selectiemogelijkheden zijn er? Array met per optie zowel de waarde (<code>value</code>) als het id (<code>id</code>). Let op: deze lijst vervangt in zijn geheel de bestaande options. Als id's overeenkomen wordt de bijbehorende optie gewijzigd. (Alleen mogelijk bij datatypes <code>select_single</code> of <code>select_multiple</code>)</td></tr>
<tr><td class="var">defaultvalue:</td><td class="explanation">Standaardwaarde (wordt gebruikt bij afwezigheid van dit veld)</td></tr>
<tr><td class="var">required:</td><td class="explanation">Is dit een verplicht veld?</td></tr>
<tr><td class="var">in_form:</td><td class="explanation">Is het veld te zien in het aanmeldformulier? (<code>boolean</code>)</td></tr>
<tr><td class="var">in_list:</td><td class="explanation">Is het veld te zien in het overzicht in Laposta? (<code>boolean</code>)</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
POST https://api.laposta.nl/v2/field/{field_id}
</pre>

<h4>Voorbeeld aanvraag</h4>
<p class="info">Dit voorbeeld maakt het veld niet meer verplicht.</p>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/field/hsJ5zbDfzJ \
  -u JdMtbsMq2jqJdQZD9AHC: \
  -d list_id=BaImMu3JZA \
  -d required=false
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$field = new Laposta_Field('BaImMu3JZA');
$result = $field->update('hsJ5zbDfzJ", array(
	'required' => 'false'
	)
);
<? } else if ($lib == 'dotnet') { ?>
LapostaConfig.apiKey = "JdMtbsMq2jqJdQZD9AHC";
var fieldService = new LapostaFieldService("BaImMu3JZA");
LapostaField field = new LapostaField();
field.Required = false;
field = fieldService.Update("hsJ5zbDfzJ", field);
<? } ?>
</pre>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "field": {
        "field_id": "hsJ5zbDfzJ",
        "list_id": "BaImMu3JZA",
        "created": "2012-10-31 11:55:50",
        "modified": "2012-10-31 12:05:44",
        "state": "active",
        "name": "Leeftijd",
        "tag": "{{leeftijd}}",
        "custom_name": "leeftijd",
        "defaultvalue": "",
        "datatype": "text",
        "datatype_display": null,
        "required": false,
        "in_form": true,
        "in_list": true
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Veld verwijderen</h3>
<p>Hiermee verwijdert u een veld definitief. Als het veld niet bestaat wordt een foutmelding gegeven. Als antwoord krijgt u weer een veld object, maar nu met state 'deleted'. Hierna is dit veld niet nogmaals op te vragen.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">field_id <span class="required">(verplicht)</span>:</td><td class="explanation">Het id van het te verwijderen veld</td></tr>
<tr><td class="var">list_id <span class="required">(verplicht)</span>:</td><td class="explanation">Het id van de lijst waartoe het veld behoort</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
DELETE https://api.laposta.nl/v2/field/{field_id}
</pre>

<h4>Voorbeeld aanvraag</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/field/lxwc8OyD3a?list_id=BaImMu3JZA \
  -u JdMtbsMq2jqJdQZD9AHC: \
  -X DELETE
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$field = new Laposta_Field('BaImMu3JZA');
$result = $field->delete('lxwc8OyD3a');
<? } else if ($lib == 'dotnet') { ?>
LapostaConfig.apiKey = "JdMtbsMq2jqJdQZD9AHC";
var fieldService = new LapostaFieldService("BaImMu3JZA");
LapostaField field = new LapostaField();
field = fieldService.Delete("lxwc8OyD3a");
<? } ?>
</pre>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "field": {
        "field_id": "lxwc8OyD3a",
        "list_id": "BaImMu3JZA",
        "created": "2012-10-30 21:44:40",
        "modified": null,
        "state": "deleted",
        "name": "Lievelingskleur",
        "tag": "{{lievelingskleur}}",
        "custom_name": "lievelingskleur",
        "defaultvalue": "",
        "datatype": "text",
        "datatype_display": null,
        "required": false,
        "in_form": true,
        "in_list": true
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Alle velden van een lijst opvragen</h3>
<p>Alle velden van een lijst in een array van field objecten. De field objecten zijn opgenomen in een array met de naam 'data'.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(verplicht)</span>:</td><td class="explanation">Het id van de lijst waarbij de velden horen</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
GET https://api.laposta.nl/v2/field
</pre>

<h4>Voorbeeld aanvraag</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/field?list_id=BaImMu3JZA \
  -u JdMtbsMq2jqJdQZD9AHC:
<? } else if ($lib == 'php') { ?>
require_once('../../lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$field = new Laposta_Field('BaImMu3JZA');
$result = $field->all();
<? } else if ($lib == 'dotnet') { ?>
LapostaConfig.apiKey = "JdMtbsMq2jqJdQZD9AHC";
var fieldService = new LapostaFieldService("BaImMu3JZA");
var fields = Enumerable.Empty<LapostaField>();
fields = fieldService.All();
<? } ?>
</pre>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "data": [
        {
	    "field": {
		"field_id": "Z87ysHha9A",
		"list_id": "BaImMu3JZA",
		"created": "2012-02-18 11:42:38",
		"modified": "2012-06-02 14:07:20",
		"state": "active",
		"name": "Naam",
		"tag": "{{naam}}",
		"custom_name": "naam",
		"defaultvalue": "lezer",
		"datatype": "text",
		"required": true,
		"in_form": true,
		"in_list": true
	    }
	},
        {
	    "field": {
		"field_id": "9hj8HA_8A2",
		"list_id": "BaImMu3JZA",
		"created": "2012-03-28 20:12:02",
		"modified": "2012-03-28 20:13:10",
		"state": "active",
		"name": "Leeftijd",
		"tag": "{{leeftijd}}",
		"custom_name": "leeftijd",
		"defaultvalue": "onbekend",
		"datatype": "date",
		"required": true,
		"in_form": true,
		"in_list": true
	    }
	}
    ]
}
</pre>
</td><!-- /right -->
</tr>


<!-- ***************************************************************** -->
<!-- *************************** RELATIES **************************** -->
<!-- ***************************************************************** -->
<tr>
<td class="left">
<a id="members"></a>
<h2>Relaties</h2>
<p>Met dit onderdeel kunt u relaties opvragen, toevoegen en wijzigen.</p>
<p>Als parameter heeft u steeds een list_id nodig. Deze kunt u vinden door in te loggen, en dan naar de betreffende lijst te gaan onder 'Relaties'. Vervolgens klikt u op de tab 'Kenmerken lijst'. Aan de rechterzijde ziet u daar het ID staan.</p>
</td><!-- /left -->

<td class="right">
<h2>URL patronen</h2>
<ul class="code">
<li>/v2/member</li>
<li>/v2/member/{member_id}</li>
</ul>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Het member object</h3>
<h4>Velden</h4>
<table class="vars">
<tr><td class="var">member_id:</td><td class="explanation">Het id van dit member object</td></tr>
<tr><td class="var">list_id:</td><td class="explanation">Het id van de bijbehorende lijst</td></tr>
<tr><td class="var">email:</td><td class="explanation">Het e-mail adres</td></tr>
<tr><td class="var">state:</td><td class="explanation">De huidige status van deze relatie: <code>active</code>, <code>unsubscribed</code>, <code>unconfirmed</code> of <code>cleaned</code></td></tr>
<tr><td class="var">signup_date:</td><td class="explanation">Moment van aanmelding, formaat YYYY-MM-DD HH:MM:SS</td></tr>
<tr><td class="var">modified:</td><td class="explanation">Moment van laatste wijziging, formaat YYYY-MM-DD HH:MM:SS</td></tr>
<tr><td class="var">ip:</td><td class="explanation">IP vanwaar de relatie is aangemeld</td></tr>
<tr><td class="var">source_url:</td><td class="explanation">URL vanwaar de relatie is aangemeld</td></tr>
<tr><td class="var">custom_fields:</td><td class="explanation">Een array met de waarde van alle extra velden van de bijbehorende lijst. Als hier velden bijzitten waar meerdere opties kunnen worden gekozen, dan worden deze opties in een array opgesomd.</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Voorbeeld member object</h4>
<pre class="code">
{
    "member": {
        "member_id": "9978ydioiZ",
        "list_id": "BaImMu3JZA",
        "email": "maartje@example.net",
        "state": "active",
        "signup_date": "2012-08-13 16:13:07",
        "modified": "2012-08-13 16:14:27",
        "ip": "198.51.100.10",
	"source_url": "http://example.com",
        "custom_fields": {
            "name": "Maartje de Vries",
            "dateofbirth": "1973-05-10 00:00:00",
            "children": 2,
            "prefs": [
                "optionA",
                "optionB"
            ]
        }
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Relatie toevoegen</h3>
<p>Als er iets niet klopt aan de meegegeven parameters dan wordt bij de foutmelding een code weergegeven. Deze kunt u in combinatie met de variabele 'parameter' gebruiken om een melding aan de gebruiker te tonen. Zie hierboven bij Foutmeldingen wat de codes betekenen.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(verplicht)</span>:</td><td class="explanation">Het id van de lijst waaraan de relatie moet worden toegevoegd</td></tr>
<tr><td class="var">ip <span class="required">(verplicht)</span>:</td><td class="explanation">Het IP-adres vanwaar de relatie is aangemeld</td></tr>
<tr><td class="var">email <span class="required">(verplicht)</span>:</td><td class="explanation">Het e-mailadres van de toe te voegen relatie</td></tr>
<tr><td class="var">source_url:</td><td class="explanation">De URL vanwaar de relatie is aangemeld</td></tr>
<tr><td class="var">custom_fields:</td><td class="explanation">De waardes van de extra aangemaakte velden</td></tr>
<tr><td class="var">options:</td><td class="explanation">Extra aanwijzingen, mogelijkheden zijn: <code>suppress_email_notification: true</code> om te voorkomen dat bij elke aanmedling via een api een notificatiemailtje wordt verstuurd, <code>suppress_email_welcome: true</code> om te voorkomen dat de welkomstmail wordt verstuurd bij een aanmelding via de api, en <code>ignore_doubleoptin: true</code> om relaties bij een double-optin lijst meteen actief te maken en ervoor te zorgen dat er geen bevestigingsmail wordt verstuurd bij een aanmelding via de api.</td></tr>
</table>
<p class="info">Als het een double-optin lijst betreft dan wordt bij elke aanmelding een bevestigingsmail verstuurd, tenzij de optie 'ignore_doubleoptin' wordt meegegeven (zie hierboven).</p>
<p class="info">Als er custom_fields zijn die verplicht zijn gesteld, is het vullen van deze velden via de API ook verplicht.</p>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
POST https://api.laposta.nl/v2/member
</pre>

<h4>Voorbeeld aanvraag</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/member \
  -u JdMtbsMq2jqJdQZD9AHC: \
  -d list_id=BaImMu3JZA  \
  -d ip=198.51.100.0  \
  -d email=maartje@example.net \
  -d source_url=http://example.com \
  -d 'custom_fields[name]=Maartje de Vries' \
  -d custom_fields[dateofbirth]=1973-05-10 \
  -d custom_fields[children]=2 \
  -d custom_fields[prefs][]=optionA  \
  -d custom_fields[prefs][]=optionB
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$member = new Laposta_Member('BaImMu3JZA');
$result = $member->create(array(
	'ip' => '198.51.100.0',
	'email' => 'maartje@example.net',
	'source_url' => 'http://example.com',
	'custom_fields' => array(
		'name' => 'Maartje de Vries',
		'dateofbirth' => '1973-05-10',
		'children' => 2,
		'prefs' => array('optionA', 'optionB')
		)
	)
);
<? } else if ($lib == 'dotnet') { ?>
LapostaConfig.apiKey = "JdMtbsMq2jqJdQZD9AHC";
var memberService = new LapostaMemberService("BaImMu3JZA");
LapostaMember member = new LapostaMember();
member.Email = "maartje@example.net";
member.IP = "198.51.100.0";
member.SourceUrl = "http://example.com";
member.CustomFields = new Dictionary<string, string>()
{
	{"name", "Maartje de Vries"}
};
member = memberService.Create(member);
<? } ?>
</pre>
<p class="info">Meerkeuze custom fields kunnen gevuld worden met de op dat moment voor dat veld gedefinieerde opties. U kunt dus gewoon de waarde van het veld meegeven. Als er meerdere keuzes gemaakt kunnen worden, dan kunt u deze in een array meegeven; zie het voorbeeld hierboven.</p>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "member": {
        "member_id": "9978ydioiZ",
        "list_id": "BaImMu3JZA",
        "email": "maartje@example.net",
        "state": "active",
        "signup_date": "2012-08-13 16:13:07",
        "ip": "198.51.100.10",
	"source_url": "http://example.com",
        "custom_fields": {
            "name": "Maartje de Vries",
            "dateofbirth": "1973-05-10 00:00:00",
            "children": 2,
            "prefs": [
                "optionA",
                "optionB"
            ]
        }
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Relatie opvragen</h3>
<p>Alle informatie over een relatie in een member object.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(verplicht)</span>:</td><td class="explanation">Het id van de lijst waarin de relatie voorkomt</td></tr>
<tr><td class="var">member_id <span class="required">(verplicht)</span>:</td><td class="explanation">Het id OF het emailadres van de relatie</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
GET https://api.laposta.nl/v2/member/{member_id}
</pre>
<h4>Voorbeeld aanvraag</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/member/Du83Hyjhj8?list_id=BaImMu3JZA \
  -u JdMtbsMq2jqJdQZD9AHC:
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$member = new Laposta_Member('BaImMu3JZA');
$result = $member->get('Du83Hyjhj8');
<? } else if ($lib == 'dotnet') { ?>
LapostaConfig.apiKey = "JdMtbsMq2jqJdQZD9AHC";
var memberService = new LapostaMemberService("BaImMu3JZA");
LapostaMember member = new LapostaMember();
member = memberService.Get("9978ydioiZ");
<? } ?>
</div>
<p class="info">U kunt hier in plaats van het member_id ook het e-mailadres gebruiken. Let op: een '+' in het adres moet weergegeven worden als: %252B</p>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "member": {
        "member_id": "9978ydioiZ",
        "list_id": "BaImMu3JZA",
        "email": "maartje@example.net",
        "state": "active",
        "signup_date": "2012-08-13 16:13:07",
        "ip": "198.51.100.10",
	"source_url": "http://example.com",
        "custom_fields": {
            "name": "Maartje de Vries - Abbink",
            "dateofbirth": "1973-05-10 00:00:00",
            "children": 3,
            "prefs": [
                "optionA",
                "optionB"
            ]
        }
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Relatie wijzigen</h3>
<p>U hoeft alleen de velden die gewijzigd moeten worden in de aanvraag mee te sturen. Velden die niet worden genoemd houden hun huidige waarde. Zodra een veld wordt genoemd wordt het wel gecontroleerd, en kan dus voor een foutmelding zorgen. Bij deze foutmelding wordt een code weergegeven. Deze kunt u in combinatie met de variabele 'parameter' gebruiken om een melding aan de gebruiker te tonen. Zie hierboven bij Foutmeldingen wat de codes betekenen.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(verplicht)</span>:</td><td class="explanation">Het id van de lijst waaraan de relatie moet worden gewijzigd</td></tr>
<tr><td class="var">email:</td><td class="explanation">Het e-mailadres van de te wijzigen relatie</td></tr>
<tr><td class="var">state</span>:</td><td class="explanation">De nieuwe status van de relatie: active of unsubscribed</td></tr>
<tr><td class="var">custom_fields:</td><td class="explanation">De waardes van de extra aangemaakte velden</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
POST https://api.laposta.nl/v2/member/{member_id}
</pre>

<h4>Voorbeeld aanvraag</h4>
<p class="info">Dit voorbeeld wijzigt de naam en het aantal kinderen.</p>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/member/9978ydioiZ \
  -u JdMtbsMq2jqJdQZD9AHC: \
  -d list_id=BaImMu3JZA  \
  -d 'custom_fields[name]=Maartje de Vries - Abbink' \
  -d custom_fields[children]=3
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$member = new Laposta_Member('BaImMu3JZA');
$result = $member->update('9978ydioiZ', array(
	'custom_fields' => array(
		'name' => 'Maartje de Vries - Abbink',
		'children' => 3
		)
	)
);
<? } else if ($lib == 'dotnet') { ?>
LapostaConfig.apiKey = "JdMtbsMq2jqJdQZD9AHC";
var memberService = new LapostaMemberService("BaImMu3JZA");
LapostaMember member = new LapostaMember();
member.CustomFields = new Dictionary<string, string>()
{
	{"name", "Maartje de Vries - Abbink"},
	{"children", "3"}
};
member = memberService.Update("9978ydioiZ", member);
<? } ?>
</pre>
<p class="info">U kunt hier in plaats van het member_id ook het e-mailadres gebruiken.</p>
<p class="info">Meerkeuze custom fields die niet verplicht zijn kunnen leeggemaakt worden door de variabele wel op te nemen in de aanvraag voor de wijziging, maar zonder waarde.</p>

<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "member": {
        "member_id": "9978ydioiZ",
        "list_id": "BaImMu3JZA",
        "email": "maartje@example.net",
        "state": "active",
        "signup_date": "2012-08-13 16:13:07",
        "ip": "198.51.100.10",
	"source_url": "http://example.com",
        "custom_fields": {
            "name": "Maartje de Vries - Abbink",
            "dateofbirth": "1973-05-10 00:00:00",
            "children": 3,
            "prefs": [
                "optionA",
                "optionB"
            ]
        }
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Relatie verwijderen</h3>
<p>Hiermee verwijdert u een relatie definitief. Als de relatie niet bestaat wordt een foutmelding gegeven. Als antwoord krijgt u weer een member object, maar nu met state 'deleted'. Hierna is deze relatie niet nogmaals op te vragen.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(verplicht)</span>:</td><td class="explanation">Het id van de lijst waarin de relatie voorkomt</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
DELETE https://api.laposta.nl/v2/member/{member_id}
</pre>

<h4>Voorbeeld aanvraag</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/member/9978ydioiZ?list_id=BaImMu3JZA \
  -u JdMtbsMq2jqJdQZD9AHC: \
  -X DELETE
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$member = new Laposta_Member('BaImMu3JZA');
$result = $member->delete('9978ydioiZ');
<? } else if ($lib == 'dotnet') { ?>
LapostaConfig.apiKey = "JdMtbsMq2jqJdQZD9AHC";
var memberService = new LapostaMemberService("BaImMu3JZA");
LapostaMember member = new LapostaMember();
member = memberService.Delete("9978ydioiZ");
<? } ?>
</pre>
<p class="info">U kunt hier in plaats van het member_id ook het e-mailadres gebruiken.</p>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "member": {
        "member_id": "9978ydioiZ",
        "list_id": "BaImMu3JZA",
        "email": "maartje@example.net",
        "state": "deleted",
        "signup_date": "2012-08-13 16:13:07",
        "ip": "198.51.100.10",
	"source_url": "http://example.com",
        "custom_fields": {
            "name": "Maartje de Vries - Abbink",
            "dateofbirth": "1973-05-10 00:00:00",
            "children": 3,
            "prefs": [
                "optionA",
                "optionB"
            ]
        }
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Alle relaties van een lijst opvragen</h3>
<p>Alle relaties in een array van member objecten. De member objecten zijn opgenomen in een array met de naam 'data'.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(verplicht)</span>:</td><td class="explanation">Het id van de lijst waaraan de relaties opgevraagd worden</td></tr>
<tr><td class="var">state</span>:</td><td class="explanation">De status van de opgevraagde relaties: active, unsubscribed of cleaned</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
GET https://api.laposta.nl/v2/member
</pre>

<h4>Voorbeeld aanvraag</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl 'https://api.laposta.nl/v2/member?list_id=BaImMu3JZA&state=active' \
  -u JdMtbsMq2jqJdQZD9AHC:
<? } else if ($lib == 'php') { ?>
require_once('../../lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$member = new Laposta_Member('BaImMu3JZA');
$result = $member->all();
<? } else if ($lib == 'dotnet') { ?>
LapostaConfig.apiKey = "JdMtbsMq2jqJdQZD9AHC";
var memberService = new LapostaMemberService("BaImMu3JZA");
var members = Enumerable.Empty<LapostaMember>();
members = memberService.All();
<? } ?>
</pre>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "data": [
        {
            "member": {
                "member_id": "9978ydioiZ",
                "list_id": "BaImMu3JZA",
                "email": "maartje@example.net",
                "state": "active",
                "signup_date": "2012-08-13 16:13:07",
                "ip": "198.51.100.10",
		"source_url": "http://example.com",
                "custom_fields": {
                    "name": "Maartje de Vries - Abbink",
                    "dateofbirth": "1973-05-10 00:00:00",
                    "children": 3,
                    "prefs": [
                        "optionA",
                        "optionB"
                    ]
                }
            }
	},
        {
            "member": {
                "member_id": "Hy8RA178HB",
                "list_id": "BaImMu3JZA",
                "email": "stefan@example.net",
                "state": "active",
                "signup_date": "2012-06-24 11:54:12",
                "ip": "198.51.100.10",
		"source_url": "http://example.com",
                "custom_fields": {
                    "name": "Stefan van Aalst",
                    "dateofbirth": null,
                    "children": 0,
                    "prefs": [
                        "optionA"
                    ]
                }
            }
	}
    ]
}
</pre>
</td><!-- /right -->
</tr>

<!-- ***************************************************************** -->
<!-- *************************** WEBHOOKS **************************** -->
<!-- ***************************************************************** -->
<tr>
<td class="left">
<a id="webhooks"></a>
<h2>Webhooks</h2>
<p>Webhooks vormen een apart onderdeel van de API. Bij de normale API gaat het opvragen van informatie steeds van de ontwikkelaar uit. Bij webhooks is het andersom, en neem Laposta het initiatief om de ontwikkelaar van iets op de hoogte te stellen. Een webhook doet dat door het aanroepen van een URL die door u is opgegeven; in de vorm van een POST met een JSON object met informatie.</p>
<p>U kunt URL's opgeven voor het toevoegen, wijzigen of verwijderen van relaties. Stel dat u een webhook aanmaakt voor toevoegingen, en iemand meld zich aan via een aanmeldformulier van Laposta, dan krijgt u vrijwel meteen na deze nieuwe aanmelding een POST op de door u opgegeven URL.</p>
<h3>Toepassing: synchronisatie met andere systemen</h3>
<p>Onze API wordt het meest gebruikt om het relatiebestand in Laposta te synchroniseren met een andere applicatie, bijvoorbeeld een CMS of een CRM. Het toevoegen aan en wijzigen van relaties aan Laposta wordt dan via de API gedaan (zoals hierboven beschreven). Webhooks stellen uw applicatie op de hoogte van veranderingen in het relatiebestand die binnen Laposta plaats vinden (aan- of afmeldingen, of wijzigingen). Met de combinatie van deze twee functies kunt u de twee bestanden synchroon houden.</p>
<h3>Het verwerken van webhooks</h3>
<p>Bij een webhook wordt er een URL aangeroepen op uw server. U bent helemaal vrij in de manier waarop de informatie verwerkt wordt. Om aan te geven dat u een webhook correct ontvangen hebt, moet de server een 200 HTTP statuscode teruggeven. (Dit zal meestal standaard het geval zijn).</p>
</td><!-- /left -->

<td class="right">
<h2>Webhooks registreren</h2>
<p>U kunt webhooks per lijst registreren. Dit doet u door naar de betreffende lijst te gaan (onder Relaties), en dan naar Kenmerken lijst. Daar vindt u het tabblad Webhooks.</p>
<p><img src="/doc/assets/static/img/webhooks.jpg" width="500" height="146"></p>
<p>Voor elke webhook kunt u aangeven voor welke event deze moet worden aangeroepen: het toevoegen van een relatie, het wijzigen van een relatie, of het verwijderen van een relatie. Daarbij geeft u de URL op waarnaar de informatie gePOST moet worden.</p>
<p>Het is ook mogelijk de webhooks via deze API te beheren; zie daarvoor de informatie hieronder.</p>
<h3>Timing</h3>
<p>Het kan zijn dat het aanroepen van een webhook niet lukt, bijvoorbeeld omdat uw server niet bereikbaar is of een foutmelding geeft. Laposta blijft de webhook dan nog een aantal keer (7 om precies te zijn) aanbieden. Eerst na 5 minuten, en dan in oplopende intervallen tot ongeveer 14 dagen. Als er dan nog geen contact mogelijk wordt de webhook verwijderd.</p>
<h3>Bundeling events</h3>
<p>Elke 5 seconden worden de op dat moment aanwezige webhooks aangeroepen. Als het er meerdere zijn, dan worden ze gebundeld, tot maximaal 1000 events per aanvraag. Zo wordt voorkomen dat uw server overspoeld wordt met aanvragen, bijvoorbeeld bij het importeren van grotere hoeveelheden relaties in Laposta.</p>
</td><!-- /right -->
</tr>

<tr>
<td class="left">
<h3>Opbouw webhook</h3>
<p>Op de door u opgegeven URL ontvangt u een object in JSON formaat. Dit object bestaat uit een array met de naam <span class="code">data</span>, waarin de verschillende events worden opgenomen. Er kunnen dus meerdere events in een enkele aanvraag zijn opgenomen (zie hierboven onder 'Bundeling events').</p>
<h4>Velden</h4>
<table class="vars">
<tr><td class="var">type:</td><td class="explanation">Het type webhook (steeds <span class="code">member</span>)</td></tr>
<tr><td class="var">event:</td><td class="explanation">De reden waarom de webhook is aangeroepen. Kan zijn: <span class="code">subscribed</span>, <span class="code">modified</span> of <span class="code">deactivated</span></td></tr>
<tr><td class="var">data:</td><td class="explanation">De gegevens van het object dat toegevoegd, gewijzigd of verwijderd is. In dit geval een member object.</td></tr>
<tr><td class="var">info:</td><td class="explanation">Extra informatie over de aanroep van de webhook, zie hieronder</td></tr>
<tr><td class="var">date_fired:</td><td class="explanation">Het moment waarop deze aanvraag is verzonden</td></tr>
</table>
<h4>Velden info object</h4>
<table class="vars">
<tr><td class="var">date_event:</td><td class="explanation">Het moment waarop dit event plaatshad (en de webhook getriggerd werd)</td></tr>
<tr><td class="var">action <span class="optional">(optioneel)</span>:</td><td class="explanation">Extra informatie over het event, verschillende opties bij de diverse events. Bij event <span class="code">subscribed</span>:
<p>
<table class="vars">
<tr><td class="var">subscribed:</td><td class="explanation">Relatie toegevoegd</td></tr>
<tr><td class="var">rebsubscribed:</td><td class="explanation">Relatie opnieuw toegevoegd</td></tr>
</table>
</p>
<p>
Bij event <span class="code">deactivated</span>:
</p>
<p>
<table class="vars">
<tr><td class="var">unsubscribed:</td><td class="explanation">Relatie is afgemeld</td></tr>
<tr><td class="var">deleted:</td><td class="explanation">Relatie verwijderd</td></tr>
<tr><td class="var">hardbounce:</td><td class="explanation">Relatie opgeschoond na hard bounce</td></tr>
</table>
</p>
</td></tr>
<tr><td class="var">source <span class="optional">(optioneel)</span>:</td><td class="explanation">Bron van het event: kan zij <span class="code">app</span> (binnen de webinterface) of <span class="code">external</span> (via bijvoorbeeld een aanmeldformulier)</td></tr>
</table>
</td><!-- /left -->

<td class="right">
<h4>Voorbeeld webhook response</h4>
<pre class="code">
{
    "data": [
        {
            "type": "member",
            "event": "deactivated",
            "data": {
                "member_id": "9978ydioiZ",
                "list_id": "BaImMu3JZA",
                "email": "maartje@example.net",
                "state": "deleted",
                "signup_date": "2012-08-13 16:13:07",
                "ip": "198.51.100.10",
		"source_url": "http://example.com",
                "custom_fields": {
                    "name": "Maartje de Vries - Abbink",
                    "dateofbirth": "1973-05-10 00:00:00",
                    "children": 3,
                    "prefs": [
                        "optionA",
                        "optionB"
                    ]
                }
            },
            "info": {
                "source": "app",
                "action": "deleted",
                "date_event": "2012-08-17 20:56:31
            }
        }
    ],
    "date_requested": "2012-08-17 20:56:34
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left">
<a id="fields"></a>
<h2>Webhooks beheren</h2>
<p>U kunt de webhooks ook met de API beheren. Hieronder staat uitgelegd hoe u webhooks kunt opvragen, toevoegen en wijzigen.</p>
</td><!-- /left -->

<td class="right">
<h2>URL patronen</h2>
<ul class="code">
<li>/v2/webhook</li>
<li>/v2/webhook/{webhook_id}</li>
</ul>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Het webhook object</h3>
<h4>Velden</h4>
<table class="vars">
<tr><td class="var">webhook_id:</td><td class="explanation">Het id van deze webhook</td></tr>
<tr><td class="var">list_id:</td><td class="explanation">Het id van de lijst waartoe het veld behoort</td></tr>
<tr><td class="var">created:</td><td class="explanation">Moment van aanmaken</td></tr>
<tr><td class="var">modified:</td><td class="explanation">Moment van laatste wijziging</td></tr>
<tr><td class="var">state:</td><td class="explanation">De status van deze webhook: <code>active</code> of <code>deleted</code></td></tr>
<tr><td class="var">event:</td><td class="explanation">Wanneer wordt de webhook aangeroepen? (<code>subscribed</code>, <code>modified</code> of <code>deactivated</code>)</td></tr>
<tr><td class="var">url:</td><td class="explanation">De aan te roepen url</td></tr>
<tr><td class="var">blocked:</td><td class="explanation">Is het aanroepen van de webhook (tijdelijk) geblokkeerd? (<code>true</code> of <code>false</code>)</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Voorbeeld webhook object</h4>
<pre class="code">
{
    "webhook": {
        "webhook_id": "cW5ls8IVJl",
        "list_id": "BaImMu3JZA",
        "created": "2012-10-31 17:03:21",
        "modified": "2012-10-31 17:12:08",
	"state": "active",
        "event": "subscribed",
        "url": "http://example.net/webhook.asp",
        "blocked": false
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Webhook toevoegen</h3>
<p>Als er iets niet klopt aan de meegegeven parameters dan wordt bij de foutmelding een code en een melding weergegeven. Zie hierboven bij Foutmeldingen wat de codes betekenen.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(verplicht)</span>:</td><td class="explanation">Het id van de lijst waartoe het veld behoort</td></tr>
<tr><td class="var">event <span class="required">(verplicht)</span>:</td><td class="explanation">Wanneer wordt de webhook aangeroepen? (<code>subscribed</code>, <code>modified</code> of <code>deactivated</code>)</td></tr>
<tr><td class="var">url <span class="required">(verplicht)</span>:</td><td class="explanation">De aan te roepen url</td></tr>
<tr><td class="var">blocked <span class="required">(verplicht)</span>:</td><td class="explanation">Is het aanroepen van de webhook (tijdelijk) geblokkeerd? (<code>true</code> of <code>false</code>)</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
POST https://api.laposta.nl/v2/webhook
</pre>

<h4>Voorbeeld aanvraag</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/webhook \
  -u JdMtbsMq2jqJdQZD9AHC: \
  -d list_id=BaImMu3JZA \
  -d event=modified \
  -d url=http://example.com/webhook.pl \
  -d blocked=false
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$webhook = new Laposta_Webhook('BaImMu3JZA');
$result = $webhook->create(array(
	'event' => 'modified',
	'url' => 'http://example.com/webhook.pl',
	'blocked' => false
	)
);
<? } else if ($lib == 'dotnet') { ?>
LapostaConfig.apiKey = "JdMtbsMq2jqJdQZD9AHC";
var webhookService = new LapostaWebhookService("BaImMu3JZA");
LapostaWebhook webhook = new LapostaWebhook();
webhook.Event = "modified";
webhook.Url = "http://example.net/webhook.pl";
webhook.Blocked = false;
webhook = webhookService.Create(webhook);
<? } ?>
</pre>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "webhook": {
        "webhook_id": "JH_y9dEsfH",
        "list_id": "BaImMu3JZA",
        "created": "2012-10-31 21:08:58",
        "modified": null,
        "state": "active",
        "event": "modified",
        "url": "http://example.com/webhook.pl",
        "blocked": false
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Webhook opvragen</h3>
<p>Alle informatie over een webhook.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(verplicht)</span>:</td><td class="explanation">Het id van de lijst waarbij het veld hoort</td></tr>
<tr><td class="var">webhook_id<span class="required">(verplicht)</span>:</td><td class="explanation">Het id van het op te vragen veld</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
GET https://api.laposta.nl/v2/webhook/{webhook_id}
</pre>
<h4>Voorbeeld aanvraag</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/webhook/cW5ls8IVJl?list_id=BaImMu3JZA \
  -u JdMtbsMq2jqJdQZD9AHC:
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$webhook = new Laposta_Webhook('BaImMu3JZA');
$result = $webhook->get('cW5ls8IVJl');
<? } else if ($lib == 'dotnet') { ?>
LapostaConfig.apiKey = "JdMtbsMq2jqJdQZD9AHC";
var webhookService = new LapostaWebhookService("BaImMu3JZA");
LapostaWebhook webhook = new LapostaWebhook();
webhook = webhookService.Get("cW5ls8IVJl");
<? } ?>
</div>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "webhook": {
        "webhook_id": "cW5ls8IVJl",
        "list_id": "BaImMu3JZA",
        "created": "2012-10-31 17:03:21",
        "modified": "2012-10-31 17:12:08",
        "state": "active",
        "event": "subscribed",
        "url": "http://example.net/webhook.asp",
        "blocked": false
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Webhook wijzigen</h3>
<p>U hoeft alleen de velden die gewijzigd moeten worden in de aanvraag mee te sturen. Velden die niet worden genoemd houden hun huidige waarde. Zodra een veld wordt genoemd wordt het wel gecontroleerd, en kan dus voor een foutmelding zorgen. Bij deze foutmelding wordt een code weergegeven met een melding. Zie hierboven bij Foutmeldingen wat de codes betekenen.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(verplicht)</span>:</td><td class="explanation">Het id van de lijst waartoe het veld behoort</td></tr>
<tr><td class="var">webhook_id<span class="required">(verplicht)</span>:</td><td class="explanation">Het id van het op te vragen veld</td></tr>
<tr><td class="var">event:</td><td class="explanation">Wanneer wordt de webhook aangeroepen? (<code>subscribed</code>, <code>modified</code> of <code>deactivated</code>)</td></tr>
<tr><td class="var">url:</td><td class="explanation">De aan te roepen url</td></tr>
<tr><td class="var">blocked:</td><td class="explanation">Is het aanroepen van de webhook (tijdelijk) geblokkeerd? (<code>true</code> of <code>false</code>)</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
POST https://api.laposta.nl/v2/webhook/{webhook_id}
</pre>

<h4>Voorbeeld aanvraag</h4>
<p class="info">Dit voorbeeld wijzigt de url.</p>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/webhook/JH_y9dEsfH \
  -u JdMtbsMq2jqJdQZD9AHC: \
  -d list_id=BaImMu3JZA \
  -d url=http://example.com/dir/webhook.pl
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$webhook = new Laposta_Webhook('BaImMu3JZA');
$result = $webhook->update('iH52rJwguo", array(
	'url' => 'http://example.com/dir/webhook.pl',
	)
);
<? } else if ($lib == 'dotnet') { ?>
LapostaConfig.apiKey = "JdMtbsMq2jqJdQZD9AHC";
var webhookService = new LapostaWebhookService("BaImMu3JZA");
LapostaWebhook webhook = new LapostaWebhook();
webhook.Url = "http://example.com/dir/webhook.pl";
webhook = webhookService.Update("iH52rJwguo", webhook);
<? } ?>
</pre>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "webhook": {
        "webhook_id": "iH52rJwguo",
        "list_id": "BaImMu3JZA",
        "created": "2012-10-31 21:08:58",
        "modified": "2012-10-31 21:32:21",
        "state": "active",
        "event": "modified",
        "url": "http://example.com/dir/webhook.pl",
        "blocked": false
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Webhook verwijderen</h3>
<p>Hiermee verwijdert u een webhook definitief. Eventuele uitstaande aanvragen van de webhook worden nog wel afgerond. Als een veld niet bestaat wordt een foutmelding gegeven. Als antwoord krijgt u weer een webhook object, maar nu met state 'deleted'. Hierna is de webhook niet nogmaals op te vragen.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">webhook_id <span class="required">(verplicht)</span>:</td><td class="explanation">Het id van de te verwijderen webhook</td></tr>
<tr><td class="var">list_id <span class="required">(verplicht)</span>:</td><td class="explanation">Het id van de lijst waartoe de webhook behoort</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
DELETE https://api.laposta.nl/v2/webhook/{webhook_id}
</pre>

<h4>Voorbeeld aanvraag</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/webhook/8HdlEGtlml?list_id=BaImMu3JZA \
  -u JdMtbsMq2jqJdQZD9AHC: \
  -X DELETE
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$webhook = new Laposta_Webhook('BaImMu3JZA');
$result = $webhook->delete('8HdlEGtlml');
<? } else if ($lib == 'dotnet') { ?>
LapostaConfig.apiKey = "JdMtbsMq2jqJdQZD9AHC";
var webhookService = new LapostaWebhookService("BaImMu3JZA");
LapostaWebhook webhook = new LapostaWebhook();
webhook = webhookService.Delete("8HdlEGtlml");
<? } ?>
</pre>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "webhook": {
        "webhook_id": "8HdlEGtlml",
        "list_id": "BaImMu3JZA",
        "created": "2012-10-31 17:11:15",
        "modified": null,
        "state": "deleted",
        "event": "modified",
        "url": "http://example.com/laposta.php",
        "blocked": true
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Alle webhooks van een lijst opvragen</h3>
<p>Alle webhooks van een lijst in een array van webhook objecten. De webhook objecten zijn opgenomen in een array met de naam 'data'.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(verplicht)</span>:</td><td class="explanation">Het id van de lijst waarbij de webhooks horen</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
GET https://api.laposta.nl/v2/webhook
</pre>

<h4>Voorbeeld aanvraag</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/webhook?list_id=BaImMu3JZA \
  -u JdMtbsMq2jqJdQZD9AHC:
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$webhook = new Laposta_Webhook('BaImMu3JZA');
$result = $webhook->all();
<? } else if ($lib == 'dotnet') { ?>
LapostaConfig.apiKey = "JdMtbsMq2jqJdQZD9AHC";
var webhookService = new LapostaWebhookService("BaImMu3JZA");
var webhooks = Enumerable.Empty<LapostaWebhook>();
webhooks = webhookService.All();
<? } ?>
</pre>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "data": [
	{
	    "webhook": {
		"webhook_id": "8HdlEGtlml",
		"list_id": "BaImMu3JZA",
		"created": "2012-10-31 17:11:15",
		"modified": null,
		"state": "active",
		"event": "modified",
		"url": "http://example.com/laposta.php",
		"blocked": false
	    }
	},
	{
	    "webhook": {
		"webhook_id": "mh7Qao0_lR",
		"list_id": "BaImMu3JZA",
		"created": "2012-09-20 14:20:14",
		"modified": null,
		"state": "active",
		"event": "subscibed",
		"url": "http://example.com/laposta.php",
		"blocked": false
	    }
	}
    ]
}
</pre>
</td><!-- /right -->
</tr>

<!-- ***************************************************************** -->
<!-- ************************** CAMPAIGNS **************************** -->
<!-- ***************************************************************** -->
<tr>
<td class="left">
<a id="campaigns"></a>
<h2>Campagnes</h2>
<p>Campagnes opvragen, aanmaken, vullen en versturen.</p>
</td><!-- /left -->

<td class="right">
<h2>URL patronen</h2>
<ul class="code">
<li>/v2/campaign</li>
<li>/v2/campaign/{campaign_id}</li>
<li>/v2/campaign/{campaign_id}/content</li>
<li>/v2/campaign/{campaign_id}/action/send</li>
<li>/v2/campaign/{campaign_id}/action/schedule</li>
</ul>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Het  object</h3>
<h4>Velden</h4>
<table class="vars">
<tr><td class="var">account_id:</td><td class="explanation">Het id van dit account</td></tr>
<tr><td class="var">campaign_id:</td><td class="explanation">Het id van de campagne</td></tr>
<tr><td class="var">created:</td><td class="explanation">Moment van aanmaken</td></tr>
<tr><td class="var">modified:</td><td class="explanation">Moment van laatste wijziging</td></tr>
<tr><td class="var">type:</td><td class="explanation">Het soort campagne (op dit moment alleen <code>regular</code>)</td></tr>
<tr><td class="var">delivery_requested:</td><td class="explanation">Wanneer verzenden?</td></tr>
<tr><td class="var">delivery_started:</td><td class="explanation">Start laatste keer verzenden</td></tr>
<tr><td class="var">delivery_ended:</td><td class="explanation">Einde laatste keer verzenden</td></tr>
<tr><td class="var">name:</td><td class="explanation">Interne naam campagne</td></tr>
<tr><td class="var">subject:</td><td class="explanation">Onderwerpregel</td></tr>
<tr><td class="var">from:</td><td class="explanation">Afzender (naam en e-mailadres)</td></tr>
<tr><td class="var">reply_to:</td><td class="explanation">E-mailadres voor reacties</td></tr>
<tr><td class="var">list_ids:</td><td class="explanation">Gekoppelde lijsten</td></tr>
<tr><td class="var">stats:</td><td class="explanation">Gekoppelde webstatistieken</td></tr>
<tr><td class="var">web:</td><td class="explanation">Url naar webversie</td></tr>
<tr><td class="var">screenshot:</td><td class="explanation">Screenshots van campagne</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Voorbeeld campaign object</h4>
<pre class="code">
{
    "campaign": {
        "account_id": "wFiUS4HL4e",
        "campaign_id": "njhgaf61ye",
        "created": "2014-12-11 11:26:19",
        "modified": "2014-12-11 11:27:31",
        "type": "regular",
        "delivery_requested": null,
        "delivery_started": "2014-12-11 11:27:29",
        "delivery_ended": "2014-12-11 11:27:31",
        "name": "Mijn eerste campagne",
        "subject": "Mijn eerste campagne",
        "from": {
            "name": "Laposta API",
            "email": "api@laposta.nl"
        },
        "reply_to": "api@laposta.nl",
	"list_ids": [
	    "nnhnkrytua",
	    "srbhotdwob"
	],
	"stats": {
	    "ga": "true",
	    "mtrack": "false"
	},
        "web": "https://laposta-api.email-provider.nl/web/wFiUS4HL4e/njhgaf61ye",
        "screenshot": {
            "113x134": "https://app.laposta.nl/clients/images/screenshots/9dknAdbAXm.2.png"
            "226x268": "https://app.laposta.nl/clients/images/screenshots/9dknAdbAXm.2.png"
        }
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Campagne aanmaken</h3>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">type <span class="required">(verplicht)</span>:</td><td class="explanation">Type campagne (moet zijn: <code>regular</code>)</td></tr>
<tr><td class="var">name <span class="required">(verplicht)</span>:</td><td class="explanation">Een naam voor deze campagne, voor intern gebruik</td></tr>
<tr><td class="var">subject <span class="required">(verplicht)</span>:</td><td class="explanation">De onderwerpregel</td></tr>
<tr><td class="var">from[name] <span class="required">(verplicht)</span>:</td><td class="explanation">De naam van de afzender</td></tr>
<tr><td class="var">from[email] <span class="required">(verplicht)</span>:</td><td class="explanation">Het e-mailadres van de afzender (dit moet een binnen het programma goedgekeurd afzendadres zijn)</td></tr>
<tr><td class="var">reply_to:</td><td class="explanation">Het e-mailadres bij beantwoorden</td></tr>
<tr><td class="var">list_ids <span class="required">(verplicht)</span>:</td><td class="explanation">Ontvangers, array van list_id's</td></tr>
<tr><td class="var">stats[ga]:</td><td class="explanation">Koppel Google Analytics (<code>true</code> of <code>false</code>)</td></tr>
<tr><td class="var">stats[mtrack]:</td><td class="explanation">Koppel Mtrack (<code>true</code> of <code>false</code>)</td></tr>
</table>
<p class="info">De campagne is na de aanvraag nog niet gevuld of ingepland. Gebruik hiervoor de <code>/content</code> en <code>/action</code> patronen, zie hieronder.</p>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
POST https://api.laposta.nl/v2/campaign
</pre>

<h4>Voorbeeld aanvraag</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/campaign \
  -u JdMtbsMq2jqJdQZD9AHC: \
  -d type=regular \
  -d 'name=Test via API' \
  -d 'subject=Hello from us' \
  -d 'from[name]=Max de Vries' \
  -d from[email]=max@example.net \
  -d reply_to=reply@example.net \
  -d list_ids[]=nnhnkrytua \
  -d list_ids[]=srbhotdwob \
  -d stats[ga]=true

<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$campaign = new Laposta_Campaign();
$result = $campaign->create(array(
	'type' => 'regular',
	'name' => 'Test API ' . date('d-m-Y H:i:s'),
	'subject' => 'This is the subject',
	'from' => array(
		'name' => 'Max de Vries',
		'email' => 'max@example.net'
	),
	'reply_to' => 'reply@example.net',
	'list_ids' => array(
		'nnhnkrytua', 'srbhotdwob'
	),
	'stats' => array(
		'ga' => true
	)
));
<? } else if ($lib == 'dotnet') { ?>
[voor deze functionaliteit is nog geen .NET wrapper beschikbaar]
<? } ?>
</pre>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "campaign": {
        "account_id": "wFiUS4HL4e",
        "campaign_id": "pbrqulw2tc",
        "created": "2016-05-16 21:24:12",
        "modified": null,
        "type": "regular",
        "delivery_requested": null,
        "delivery_started": null,
        "delivery_ended": null,
        "name": "Test via API",
        "subject": "Hello from us",
        "from": {
            "name": "Max de Vries",
            "email": "max@example.net"
        },
        "reply_to": "reply@example.net",
        "list_ids": [
            "nnhnkrytua",
            "srbhotdwob"
        ],
        "stats": {
            "ga": "true",
            "mtrack": "false"
        },
        "web": "https://laposta-api.email-provider.nl/web/wFiUS4HL4e/pbrqulw2tc",
        "screenshot": {
            "113x134": "https://app.laposta.nl/clients/images/screenshots/default/113x134_nl.png",
            "226x268": "https://app.laposta.nl/clients/images/screenshots/default/113x134_nl.png"
        }
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Campagne opvragen</h3>
<p>Alle informatie over een campagne.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">campaign_id <span class="required">(verplicht)</span>:</td><td class="explanation">Het id van de campagne</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
GET https://api.laposta.nl/v2/campaign/{campaign_id}
</pre>
<h4>Voorbeeld aanvraag</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/campaign/njhgaf61ye \
  -u JdMtbsMq2jqJdQZD9AHC:
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$campaign = new Laposta_Campaign();
$result = $campaign->get('njhgaf61ye');
<? } else if ($lib == 'dotnet') { ?>
[voor deze functionaliteit is nog geen .NET wrapper beschikbaar]
<? } ?>
</div>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "campaign": {
        "account_id": "wFiUS4HL4e",
        "campaign_id": "njhgaf61ye",
        "created": "2014-12-11 11:26:19",
        "modified": "2014-12-11 11:27:31",
        "type": "regular",
        "delivery_requested": null,
        "delivery_started": "2014-12-11 11:27:29",
        "delivery_ended": "2014-12-11 11:27:31",
        "name": "Mijn eerste campagne",
        "subject": "Mijn eerste campagne",
        "from": {
            "name": "Laposta API",
            "email": "api@laposta.nl"
        },
        "reply_to": "api@laposta.nl",
	"list_ids": [
	    "nnhnkrytua",
	    "srbhotdwob"
	],
	"stats": {
	    "ga": "true",
	    "mtrack": "false"
	},
        "web": "https://laposta-api.email-provider.nl/web/wFiUS4HL4e/njhgaf61ye",
        "screenshot": {
            "113x134": "https://app.laposta.nl/clients/images/screenshots/9dknAdbAXm.2.png"
        }
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Campagne wijzigen</h3>
<p>U hoeft alleen de velden die gewijzigd moeten worden in de aanvraag mee te sturen. Velden die niet worden genoemd houden hun huidige waarde. Zodra een veld wordt genoemd wordt het wel gecontroleerd, en kan dus voor een foutmelding zorgen. Bij deze foutmelding wordt een code weergegeven met een melding. Zie hierboven bij Foutmeldingen wat de codes betekenen.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">campaign_id <span class="required">(verplicht)</span>:</td><td class="explanation">Het id van de campagne die gewijzigd moet worden</td></tr>
<tr><td class="var">name:</td><td class="explanation">Een naam voor deze campagne, voor intern gebruik</td></tr>
<tr><td class="var">subject:</td><td class="explanation">De onderwerpregel</td></tr>
<tr><td class="var">from[name]:</td><td class="explanation">De naam van de afzender</td></tr>
<tr><td class="var">from[email]:</td><td class="explanation">Het e-mailadres van de afzender (dit moet een binnen het programma goedgekeurd afzendadres zijn)</td></tr>
<tr><td class="var">reply_to:</td><td class="explanation">Het e-mailadres bij beantwoorden</td></tr>
<tr><td class="var">list_ids:</td><td class="explanation">Ontvangers, array van list_id's</td></tr>
<tr><td class="var">stats[ga]:</td><td class="explanation">Koppel Google Analytics (<code>true</code> of <code>false</code>)</td></tr>
<tr><td class="var">stats[mtrack]:</td><td class="explanation">Koppel Mtrack (<code>true</code> of <code>false</code>)</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
POST https://api.laposta.nl/v2/campaign/{campaign_id}
</pre>

<h4>Voorbeeld aanvraag</h4>
<p class="info">Dit voorbeeld wijzigt de onderwerpregel.</p>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/campaign/pbrqulw2tc \
  -u JdMtbsMq2jqJdQZD9AHC: \
  -d 'subject=Hello from us, modified'
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$result = $campaign->update('pbrqulw2tc', array(
	'subject' => 'Hello from us, modified'
));
<? } else if ($lib == 'dotnet') { ?>
[voor deze functionaliteit is nog geen .NET wrapper beschikbaar]
<? } ?>
</pre>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "campaign": {
        "account_id": "wFiUS4HL4e",
        "campaign_id": "pbrqulw2tc",
        "created": "2016-05-16 21:24:12",
        "modified": "2016-05-16 21:51:27",
        "type": "regular",
        "delivery_requested": null,
        "delivery_started": null,
        "delivery_ended": null,
        "name": "Test via API",
        "subject": "Hello from us, modified",
        "from": {
            "name": "Max de Vries",
            "email": "max@example.net"
        },
        "reply_to": "reply@example.net",
        "list_ids": [
            "nnhnkrytua",
            "srbhotdwob"
        ],
        "stats": {
            "ga": "true",
            "mtrack": "false"
        },
        "web": "https://laposta-api.email-provider.nl/web/wFiUS4HL4e/pbrqulw2tc",
        "screenshot": {
            "113x134": "https://app.laposta.nl/clients/images/screenshots/default/113x134_nl.png",
            "226x268": "https://app.laposta.nl/clients/images/screenshots/default/113x134_nl.png"
        }
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Campagne verwijderen</h3>
<p>Hiermee verwijdert u een campagne. Campagnes die nog niet verzonden zijn worden definitief verwijderd. Campagnes die verzonden zijn worden pas na 180 dagen definitief verwijderd. In de tussentijd zijn ze te herstellen in het overzicht van campagnes in ons programma.</p>
<p>Als antwoord krijgt u het campaign object, maar nu met state 'deleted'. Hierna is de campagne niet nogmaals op te vragen.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">campaign_id <span class="required">(verplicht)</span>:</td><td class="explanation">Het id van de te verwijderen campagne</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
DELETE https://api.laposta.nl/v2/campaign/{campaign_id}
</pre>

<h4>Voorbeeld aanvraag</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/campaign/az0ndh7akc \
  -u JdMtbsMq2jqJdQZD9AHC: \
  -X DELETE
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$campaign = new Laposta_Campaign();
$result = $campaign->delete('az0ndh7akc');
<? } else if ($lib == 'dotnet') { ?>
[voor deze functionaliteit is nog geen .NET wrapper beschikbaar]
<? } ?>
</pre>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "campaign": {
        "account_id": "wFiUS4HL4e",
        "campaign_id": "az0ndh7akc",
        "created": "2016-05-16 22:44:49",
        "modified": "2016-05-16 22:44:49",
        "type": "regular",
        "delivery_requested": null,
        "delivery_started": null,
        "delivery_ended": null,
        "name": "Test API 16-05-2016 22:44:49",
        "subject": "This is the subject",
        "from": {
            "name": "Max de Vries",
            "email": "max@example.net"
        },
        "reply_to": "reply@example.net",
        "list_ids": [
            "nnhnkrytua",
            "srbhotdwob"
        ],
        "stats": {
            "ga": "true",
            "mtrack": "false"
        },
        "web": "https://laposta-api.email-provider.nl/web/wFiUS4HL4e/az0ndh7akc",
        "screenshot": {
            "113x134": "https://app.laposta.nl/clients/images/screenshots/default/113x134_nl.png",
            "226x268": "https://app.laposta.nl/clients/images/screenshots/default/113x134_nl.png"
        },
        "state": "deleted"
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Alle campagnes van een account opvragen</h3>
<p>Alle campagnes in een array van campaign objecten. De campaign objecten zijn opgenomen in een array met de naam 'data'.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td>Geen.</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
GET https://api.laposta.nl/v2/campaign
</pre>

<h4>Voorbeeld aanvraag</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/campaign \
  -u JdMtbsMq2jqJdQZD9AHC:
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$campaign = new Laposta_Campaign();
$result = $campaign->all();
<? } else if ($lib == 'dotnet') { ?>
[voor deze functionaliteit is nog geen .NET wrapper beschikbaar]
<? } ?>
</pre>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "data": [
        {
            "campaign": {
                "account_id": "wFiUS4HL4e",
                "campaign_id": "njhgaf61ye",
                "created": "2014-12-11 11:26:19",
                "modified": "2014-12-11 11:27:31",
		"type": "regular",
		"delivery_requested": null,
                "delivery_started": "2014-12-11 11:27:29",
                "delivery_ended": "2014-12-11 11:27:31",
                "name": "Mijn eerste campagne",
                "subject": "Mijn eerste campagne",
                "from": {
                    "name": "Laposta API",
                    "email": "api@laposta.nl"
                },
                "reply_to": "api@laposta.nl",
		"list_ids": [
		    "nnhnkrytua",
		    "srbhotdwob"
		],
		"stats": {
		    "ga": "true",
		    "mtrack": "false"
		},
                "web": "https://laposta-api.email-provider.nl/web/wFiUS4HL4e/njhgaf61ye",
                "screenshot": {
                    "113x134": "https://app.laposta.nl/clients/images/screenshots/9dknAdbAXm.2.png"
                }
            }
        },
        {
            "campaign": {
                "account_id": "wFiUS4HL4e",
                "campaign_id": "qzgllqculd",
                "created": "2014-12-11 11:27:45",
                "modified": "2014-12-11 11:27:56",
		"type": "regular",
		"delivery_requested": null,
                "delivery_started": null,
                "delivery_ended": null,
                "name": "Mijn tweede campagne",
                "subject": "Mijn tweede campagne",
                "from": {
                    "name": "Laposta API",
                    "email": "api@laposta.nl"
                },
                "reply_to": "api@laposta.nl",
		"list_ids": [
		    "nnhnkrytua",
		    "srbhotdwob"
		],
		"stats": {
		    "ga": "true",
		    "mtrack": "false"
		},
                "web": "https://laposta-api.email-provider.nl/web/wFiUS4HL4e/qzgllqculd",
                "screenshot": {
                    "113x134": "https://app.laposta.nl/clients/images/screenshots/ClCvez9GXQ.2.png"
                }
            }
        }
    ]
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Campagne content opvragen</h3>
<p>De inhoud van een campagne opvragen.</p>
<p><i>Let op: dit kan alleen als het een campagne betreft die ge&iuml;mporteerd is, en niet bij een campagne die binnen de applicatie is gemaakt met de drag &amp; drop-editor.</i></p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">campaign_id <span class="required">(verplicht)</span>:</td><td class="explanation">Het id van de campagne</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
GET https://api.laposta.nl/v2/campaign/{campaign_id}/content
</pre>
<h4>Voorbeeld aanvraag</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/campaign/njhgaf61ye/content \
  -u JdMtbsMq2jqJdQZD9AHC:
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$campaign = new Laposta_Campaign();
$result = $campaign->get('pbrqulw2tc', 'content');
<? } else if ($lib == 'dotnet') { ?>
[voor deze functionaliteit is nog geen .NET wrapper beschikbaar]
<? } ?>
</div>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "campaign": {
        "account_id": "wFiUS4HL4e",
        "campaign_id": "pbrqulw2tc",
        "plaintext": "Bekijk hier de webversie:\n/tag/web\n\n           \n\n \t\tZet hier een korte, pakkende omschrijving van uw nieuwsbrief.\n\n \t\tBekijk de webversie [1]\n\n \t\tDe titel van dit blok\n\n Dit is het blok Tekst. Als u deze tekst aanklikt, kunt u deze\nwijzigen. Aan de linkerkant krijgt u twee tabs te zien. Onder de tab\nInhoud kunt u uw tekst invoeren en iets opmaken. Hier kunt u ook de\ntitel van dit blok aanpassen. Onder de tab Vormgeving doet u de grote\nopmaak, van de titel, de tekst en het vak.\n\nWilt u weer naar het overzicht van blokken en de opties voor algehele\nopmaak? Sla dan uw blok op of klik op de buitenkant van uw\nnieuwsbrief. \n\n Deze e-mail is verstuurd aan {{email}} [2].\nAls u geen nieuwsbrief meer wilt ontvangen, kunt u zich hier afmelden\n[3].\nU kunt ook uw gegevens inzien en wijzigen [4].\nVoor een goede ontvangst voegt u {{from_email}} [5] toe aan uw\nadresboek. \n\nDeze email is verstuurd aan {{email}}.\nAls u geen nieuwsbrief meer wilt ontvangen, kunt u zich hier afmelden\n[6].\n\n \n\nLinks:\n------\n[1] http://clients.laposta.nl/tag/web\n[2] mailto:{{email}}\n[3] http://clients.laposta.nl/tag/unsubscribe\n[4] http://clients.laposta.nl/tag/edit\n[5] mailto:{{from_email}}\n[6] /tag/unsubscribe\n",
        "html": "<?= htmlspecialchars('<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\">\n<head>\n<style type=\"text/css\">\n\n</style>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /> ... <table cellspacing=\"0\" cellpadding=\"0\"><tr><td><![endif]-->\n</td></tr></table>\n<table width=\"100%\" cellspacing=\"0\" cellpadding=\"30\" border=\"0\" bgcolor=\"#ffffff\"><tr><td>&nbsp;</td></tr><tr><td align=\"center\" style=\"color:#333333 !important;line-height:17px !important;font-size:13px !important;font-family:arial !important;font-weight:normal !important\">Deze email is verstuurd aan {{email}}.<br>Als u geen nieuwsbrief meer wilt ontvangen, kunt u zich <a style=\"color:#333;text-decoration:underline;font-size:13px;font-family:arial;font-weight:normal\" href=\"/tag/unsubscribe\">hier afmelden</a>.</td></tr></table></body>\n</html>') ?>",
	"import_url": "https://example.net/newsletter"
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Campagne content vullen</h3>
<p>De inhoud van een campagne vullen.</p>
<h4>Parameters</h4>
<p>De campagne kan ofwel direct gevuld worden met html, ofwel via een url, waarbij Laposta de html importeert die op de opgegeven url te vinden is. Een van beide moet gekozen worden. Als beide parameters worden meegegeven dan wordt de html genomen.</p>
<table class="vars">
<tr><td class="var">campaign_id <span class="required">(verplicht)</span>:</td><td class="explanation">Het id van de campagne</td></tr>
<tr><td class="var">html:</td><td class="explanation">De html voor de campagne</td></tr>
<tr><td class="var">import_url:</td><td class="explanation">De url vanwaar de html ge&iuml;mporteerd moet worden</td></tr>
<tr><td class="var">inline_css:</td><td class="explanation">Eventueel inlinen van css (<code>true</code> of <code>false</code>)</td></tr>
</table>
<h4>Rapportage resultaat</h4>
<p>Als het importeren niet lukt volgt er een 400-foutmelding van de api. Als het wel lukt om de html te importeren, maar er zijn tijdens de import problemen gevonden, dan worden die in de variabele <code>report</code> in het antwoord getoond. Het kan hier gaan om:</p>
<table class="vars">
<tr><td class="var">javascript:</td><td class="explanation">Er is javascript aangetroffen</td></tr>
<tr><td class="var">flash:</td><td class="explanation">Er is flash aangetroffen</td></tr>
<tr><td class="var">no_unsubscribe:</td><td class="explanation">Er is geen afmeldlink gevonden</td></tr>
<tr><td class="var">empty_unsubscribe:</td><td class="explanation">Er is een lege afmeldlink gevonden</td></tr>
<tr><td class="var">css:</td><td class="explanation">Er zijn ontbrekende externe css bestanden (worden opgesomd)</td></tr>
<tr><td class="var">images:</td><td class="explanation">Er zijn ontbrekende externe afbeeldingen (worden opgesomd)</td></tr>
</table>
<p>Het is voor het versturen niet noodzakelijk deze problemen op te lossen, maar wel geadviseerd.</p>
<h4>Reclame en afmeldink</h4>
<p>Bij een gratis account wordt aan de onderkant van de nieuwsbrief onze reclame toegevoegd. Als de aangeboden html geen afmeldlink bevat, dan wordt ook deze door ons programma toegevoegd.</p>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
POST https://api.laposta.nl/v2/campaign/{campaign_id}/content
</pre>
<h4>Voorbeeld aanvraag</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
curl https://api.laposta.nl/v2/campaign/pbrqulw2tc/content \
  -u JdMtbsMq2jqJdQZD9AHC: \
  -d import_url=https://example.net/newsletter
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$campaign = new Laposta_Campaign();
$result = $campaign->update('pbrqulw2tc', array(
	'import_url' => 'http://google.com'
), 'content');
<? } else if ($lib == 'dotnet') { ?>
[voor deze functionaliteit is nog geen .NET wrapper beschikbaar]
<? } ?>
</div>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "campaign": {
        "account_id": "wFiUS4HL4e",
        "campaign_id": "pbrqulw2tc",
        "plaintext": "Bekijk hier de webversie:\n/tag/web\n\n           \n\n \t\tZet hier een korte, pakkende omschrijving van uw nieuwsbrief.\n\n \t\tBekijk de webversie [1]\n\n \t\tDe titel van dit blok\n\n Dit is het blok Tekst. Als u deze tekst aanklikt, kunt u deze\nwijzigen. Aan de linkerkant krijgt u twee tabs te zien. Onder de tab\nInhoud kunt u uw tekst invoeren en iets opmaken. Hier kunt u ook de\ntitel van dit blok aanpassen. Onder de tab Vormgeving doet u de grote\nopmaak, van de titel, de tekst en het vak.\n\nWilt u weer naar het overzicht van blokken en de opties voor algehele\nopmaak? Sla dan uw blok op of klik op de buitenkant van uw\nnieuwsbrief. \n\n Deze e-mail is verstuurd aan {{email}} [2].\nAls u geen nieuwsbrief meer wilt ontvangen, kunt u zich hier afmelden\n[3].\nU kunt ook uw gegevens inzien en wijzigen [4].\nVoor een goede ontvangst voegt u {{from_email}} [5] toe aan uw\nadresboek. \n\nDeze email is verstuurd aan {{email}}.\nAls u geen nieuwsbrief meer wilt ontvangen, kunt u zich hier afmelden\n[6].\n\n \n\nLinks:\n------\n[1] http://clients.laposta.nl/tag/web\n[2] mailto:{{email}}\n[3] http://clients.laposta.nl/tag/unsubscribe\n[4] http://clients.laposta.nl/tag/edit\n[5] mailto:{{from_email}}\n[6] /tag/unsubscribe\n",
        "html": "<?= htmlspecialchars('<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\">\n<head>\n<style type=\"text/css\">\n\n</style>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /> ... <table cellspacing=\"0\" cellpadding=\"0\"><tr><td><![endif]-->\n</td></tr></table>\n<table width=\"100%\" cellspacing=\"0\" cellpadding=\"30\" border=\"0\" bgcolor=\"#ffffff\"><tr><td>&nbsp;</td></tr><tr><td align=\"center\" style=\"color:#333333 !important;line-height:17px !important;font-size:13px !important;font-family:arial !important;font-weight:normal !important\">Deze email is verstuurd aan {{email}}.<br>Als u geen nieuwsbrief meer wilt ontvangen, kunt u zich <a style=\"color:#333;text-decoration:underline;font-size:13px;font-family:arial;font-weight:normal\" href=\"/tag/unsubscribe\">hier afmelden</a>.</td></tr></table></body>\n</html>') ?>",
	"import_url": "https://example.net/newsletter",
	"report": {
            "javascript": true,
            "no_unsubscribe": true
        }
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Campagne verzenden</h3>
<p>Een campagne direct versturen.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">campaign_id <span class="required">(verplicht)</span>:</td><td class="explanation">Het id van de campagne</td></tr>
</table>
<p>Ter info: een campagne die al eerder verzonden werd, kan ook opnieuw verzonden worden. De campagne wordt dan alleen gestuurd naar de adressen die er sinds de laatste verzending zijn bijgekomen.</p>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
POST https://api.laposta.nl/v2/campaign/{campaign_id}/action/send
</pre>
<h4>Voorbeeld aanvraag</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
curl https://api.laposta.nl/v2/campaign/pbrqulw2tc/action/send \
  -u JdMtbsMq2jqJdQZD9AHC: \
  -X POST
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$campaign = new Laposta_Campaign();
$result = $campaign->update('pbrqulw2tc', array(), 'action', 'send');
<? } else if ($lib == 'dotnet') { ?>
[voor deze functionaliteit is nog geen .NET wrapper beschikbaar]
<? } ?>
</div>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "campaign": {
        "account_id": "wFiUS4HL4e",
        "campaign_id": "pbrqulw2tc",
        "created": "2014-12-11 11:26:19",
        "modified": "2014-12-11 11:27:31",
        "type": "regular",
        "delivery_requested": "2014-12-11 11:27:29",
        "delivery_started": null,
        "delivery_ended": null,
        "name": "Mijn eerste campagne",
        "subject": "Mijn eerste campagne",
        "from": {
            "name": "Laposta API",
            "email": "api@laposta.nl"
        },
        "reply_to": "api@laposta.nl",
	"list_ids": [
	    "nnhnkrytua",
	    "srbhotdwob"
	],
	"stats": {
	    "ga": "true",
	    "mtrack": "false"
	},
        "web": "https://laposta-api.email-provider.nl/web/wFiUS4HL4e/njhgaf61ye",
        "screenshot": {
            "113x134": "https://app.laposta.nl/clients/images/screenshots/9dknAdbAXm.2.png"
        }
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Campagne inplannen</h3>
<p>Een campagne inplannen voor een later moment.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">campaign_id <span class="required">(verplicht)</span>:</td><td class="explanation">Het id van de campagne</td></tr>
<tr><td class="var">delivery_requested <span class="required">(verplicht)</span>:</td><td class="explanation">Het moment van verzenden (formaat YYYY-MM-DD HH:MM:SS)</td></tr>
</table>
<p>Ter info: een campagne die al eerder verzonden werd, kan ook opnieuw ingepland worden. De campagne wordt dan alleen verzonden naar de adressen die er sinds de laatste verzending zijn bijgekomen.</p>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
POST https://api.laposta.nl/v2/campaign/{campaign_id}/action/schedule
</pre>
<h4>Voorbeeld aanvraag</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
curl https://api.laposta.nl/v2/campaign/pbrqulw2tc/action/schedule \
  -u JdMtbsMq2jqJdQZD9AHC: \
  '-d delivery_requested=2016-05-19 12:00:00'
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$campaign = new Laposta_Campaign();
$result = $campaign->update('pbrqulw2tc', array(
	'delivery_requested' => '2016-05-20 12:00'
), 'action', 'schedule');
<? } else if ($lib == 'dotnet') { ?>
[voor deze functionaliteit is nog geen .NET wrapper beschikbaar]
<? } ?>
</div>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "campaign": {
        "account_id": "wFiUS4HL4e",
        "campaign_id": "pbrqulw2tc",
        "created": "2014-12-11 11:26:19",
        "modified": "2014-12-11 11:27:31",
        "type": "regular",
        "delivery_requested": "2016-05-19 12:00:00",
        "delivery_started": null,
        "delivery_ended": null,
        "name": "Mijn eerste campagne",
        "subject": "Mijn eerste campagne",
        "from": {
            "name": "Laposta API",
            "email": "api@laposta.nl"
        },
        "reply_to": "api@laposta.nl",
	"list_ids": [
	    "nnhnkrytua",
	    "srbhotdwob"
	],
	"stats": {
	    "ga": "true",
	    "mtrack": "false"
	},
        "web": "https://laposta-api.email-provider.nl/web/wFiUS4HL4e/njhgaf61ye",
        "screenshot": {
            "113x134": "https://app.laposta.nl/clients/images/screenshots/9dknAdbAXm.2.png"
        }
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Campagne testen</h3>
<p>Een testmail versturen.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">campaign_id <span class="required">(verplicht)</span>:</td><td class="explanation">Het id van de campagne</td></tr>
<tr><td class="var">email <span class="required">(verplicht)</span>:</td><td class="explanation">Het e-mailadres waarnaar de test verzonden moet worden.</td></tr>
</table>
<p>Ter info: alleen bij een campagne waarvoor al wel inhoud is, maar die nog niet verzonden is, kan een testmail verstuurd worden.</p>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
POST https://api.laposta.nl/v2/campaign/{campaign_id}/action/testmail
</pre>
<h4>Voorbeeld aanvraag</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
curl https://api.laposta.nl/v2/campaign/pbrqulw2tc/action/testmail \
  -u JdMtbsMq2jqJdQZD9AHC: \
  -d email=test@example.net
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$campaign = new Laposta_Campaign();
$result = $campaign->update('pbrqulw2tc', array(
	'email' => 'test@example.net'
), 'action', 'testmail');
<? } else if ($lib == 'dotnet') { ?>
[voor deze functionaliteit is nog geen .NET wrapper beschikbaar]
<? } ?>
</div>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "campaign": {
        "account_id": "wFiUS4HL4e",
        "campaign_id": "pbrqulw2tc",
        "created": "2014-12-11 11:26:19",
        "modified": "2014-12-11 11:27:31",
        "type": "regular",
        "delivery_requested": null,
        "delivery_started": null,
        "delivery_ended": null,
        "name": "Mijn eerste campagne",
        "subject": "Mijn eerste campagne",
        "from": {
            "name": "Laposta API",
            "email": "api@laposta.nl"
        },
        "reply_to": "api@laposta.nl",
	"list_ids": [
	    "nnhnkrytua",
	    "srbhotdwob"
	],
	"stats": {
	    "ga": "true",
	    "mtrack": "false"
	},
        "web": "https://laposta-api.email-provider.nl/web/wFiUS4HL4e/njhgaf61ye",
        "screenshot": {
            "113x134": "https://app.laposta.nl/clients/images/screenshots/9dknAdbAXm.2.png"
        }
    }
}
</pre>
</td><!-- /right -->
</tr>

<!-- **************************************************************** -->
<!-- ************************** RESULTS **************************** -->
<!-- **************************************************************** -->
<tr>
<td class="left">
<a id="reports"></a>
<h2>Resultaten</h2>
<p>De cijfers van de resultaten van campagnes opvragen.</p>
</td><!-- /left -->

<td class="right">
<h2>URL patronen</h2>
<ul class="code">
<li>/v2/report</li>
<li>/v2/report/{campaign_id}</li>
</ul>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Het  object</h3>
<h4>Velden</h4>
<table class="vars">
<tr><td class="var">account_id:</td><td class="explanation">Het id van dit account</td></tr>
<tr><td class="var">campaign_id:</td><td class="explanation">Het id van de campagne</td></tr>
<tr><td class="var">sent:</td><td class="explanation">Het aantal verzonden e-mails</td></tr>
<tr><td class="var">accepted:</td><td class="explanation">Het aantal door de ontvangende mailservers geaccepteerde aantal e-mails</td></tr>
<!--
<tr><td class="var">opened:</td><td class="explanation">Het aantal geregistreerde opens</td></tr>
<tr><td class="var">clicked:</td><td class="explanation">Het aantal geregistreerde kliks</td></tr>
<tr><td class="var">webversion:</td><td class="explanation">Het aantal keer dat de webversie bekeken is</td></tr>
-->
<tr><td class="var">cleaned:</td><td class="explanation">Het aantal opgeschoonde relaties</td></tr>
<tr><td class="var">complained:</td><td class="explanation">Het aantal spamklachten (door klikken op spamknop in e-mailprogramma)</td></tr>
<tr><td class="var">hardbounced:</td><td class="explanation">Het aantal hard-bounces</td></tr>
<tr><td class="var">unsubscribed:</td><td class="explanation">Het aantal afmeldingen</td></tr>
<tr><td class="var">opened_unique:</td><td class="explanation">Het aantal relaties dat de e-mail &eacute;&eacute;n keer of meer geopend heeft</td></tr>
<tr><td class="var">clicked_unique:</td><td class="explanation">Het aantal relaties dat &eacute;&eacute;n keer of meer geklikt heeft</td></tr>
<tr><td class="var">webversion_unique:</td><td class="explanation">Het aantal relaties dat de webversie heeft opgevraagd</td></tr>
<tr><td class="var">accepted_ratio:</td><td class="explanation">De verhouding geaccepteerde e-mails t.o.v. het aantal verzonden e-mails</td></tr>
<tr><td class="var">opened_ratio:</td><td class="explanation">De verhouding &eacute;&eacute;n keer of meer geopende e-mail t.o.v. het aantal geaccepteerde e-mails</td></tr>
<tr><td class="var">clicked_ratio:</td><td class="explanation">De verhouding e-mails waarin &eacute;&eacute;n keer of meer geklikt is t.o.v. het aantal geaccepteerde e-mails</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Voorbeeld report object</h4>
<pre class="code">
{
    "report": {
        "account_id": "wFiUS4HL4e",
        "campaign_id": "njhgaf61ye",
	"sent": 20882,
        "accepted": 20139, <!--
        "opened": 11347,
        "clicked": 2413,
        "webversion": 71, -->
        "cleaned": 744,
        "complained": 1,
        "hardbounced": 743,
        "unsubscribed": 184,
        "opened_unique": 5711,
        "clicked_unique": 1348,
        "webversion_unique": 64,
        "accepted_ratio": 0.96,
        "opened_ratio": 0.28,
        "clicked_ratio": 0.07
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Resultaten van campagne opvragen</h3>
<p>De resultaten van een campagne.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">campaign_id <span class="required">(verplicht)</span>:</td><td class="explanation">Het id van de campagne</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
GET https://api.laposta.nl/v2/report/{campaign_id}
</pre>
<h4>Voorbeeld aanvraag</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/report/njhgaf61ye \
  -u JdMtbsMq2jqJdQZD9AHC:
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$report = new Laposta_Report();
$result = $report->get('njhgaf61ye');
<? } else if ($lib == 'dotnet') { ?>
[voor deze functionaliteit is nog geen .NET wrapper beschikbaar]
<? } ?>
</div>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "report": {
        "account_id": "wFiUS4HL4e",
        "campaign_id": "njhgaf61ye",
	"sent": 20882,
        "accepted": 20139, <!--
        "opened": 11347,
        "clicked": 2413,
        "webversion": 71, -->
        "cleaned": 744,
        "complained": 1,
        "hardbounced": 743,
        "unsubscribed": 184,
        "opened_unique": 5711,
        "clicked_unique": 1348,
        "webversion_unique": 64,
        "accepted_ratio": 0.96,
        "opened_ratio": 0.28,
        "clicked_ratio": 0.07
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>De resultaten van alle campagnes van een account opvragen</h3>
<p>De resultaten van alle campagnes in een array van result objecten. De report objecten zijn opgenomen in een array met de naam 'data'.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td>Geen.</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
GET https://api.laposta.nl/v2/report
</pre>

<h4>Voorbeeld aanvraag</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/report \
  -u JdMtbsMq2jqJdQZD9AHC:
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$report = new Laposta_Report();
$result = $report->all();
<? } else if ($lib == 'dotnet') { ?>
[voor deze functionaliteit is nog geen .NET wrapper beschikbaar]
<? } ?>
</pre>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "data": [
	{
	    "report": {
		"account_id": "wFiUS4HL4e",
		"campaign_id": "njhgaf61ye",
		"sent": 20882,
		"accepted": 20139, <!--
		"opened": 11347,
		"clicked": 2413,
		"webversion": 71, -->
		"cleaned": 744,
		"complained": 1,
		"hardbounced": 743,
		"unsubscribed": 184,
		"opened_unique": 5711,
		"clicked_unique": 1348,
		"webversion_unique": 64,
		"accepted_ratio": 0.96,
		"opened_ratio": 0.28,
		"clicked_ratio": 0.07
	    }
	},
	{
	    "report": {
		"account_id": "wFiUS4HL4e",
		"campaign_id": "keim8js77f",
		"sent": 6989,
		"accepted": 6863, <!--
		"opened": 7150,
		"clicked": 1503,
		"webversion": 151, -->
		"cleaned": 126,
		"complained": 0,
		"hardbounced": 126,
		"unsubscribed": 260,
		"opened_unique": 3385,
		"clicked_unique": 1013,
		"webversion_unique": 120,
		"accepted_ratio": 0.98,
		"opened_ratio": 0.49,
		"clicked_ratio": 0.15
	    }
	}
    ]
}
</pre>
</td><!-- /right -->
</tr>

<!-- ***************************************************************** -->
<!-- *************************** ACCOUNTS **************************** -->
<!-- ***************************************************************** -->
<tr>
<td class="left">
<a id="accounts"></a>
<h2>Accounts</h2>
<p>Via onze API is het voor partners ook mogelijk nieuwe accounts aan te maken. Deze mogelijkheid is standaard niet geactiveerd; neemt u contact met ons op om deze mogelijkheid voor u beschikbaar te maken.</p>
<p>Op dit moment is het alleen mogelijk accounts aan te maken, en aangemaakte accounts op te vragen. Het is nog niet mogelijk accounts te wijzigen of te verwijderen.</p>
<p><i>Dit deel van de API is alleen via https te gebruiken.</i></p>
</td><!-- /left -->

<td class="right">
<h2>URL patronen</h2>
<ul class="code">
<li>/v2/account</li>
<li>/v2/account/{account_id}</li>
</ul>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Het  object</h3>
<h4>Velden</h4>
<table class="vars">
<tr><td class="var">account_id:</td><td class="explanation">Het id van dit account</td></tr>
<tr><td class="var">created:</td><td class="explanation">Moment van aanmaken</td></tr>
<tr><td class="var">modified:</td><td class="explanation">Moment van laatste wijziging</td></tr>
<tr><td class="var">hostname:</td><td class="explanation">De hostname voor gebruik in het domein email-provider.nl</td></tr>
<tr><td class="var">api_key:</td><td class="explanation">De API-key voor dit account</td></tr>
<tr><td class="var">company:</td><td class="explanation">De bij dit account horende organisatie</td></tr>
<tr><td class="var">users:</td><td class="explanation">De bij dit account horende gebruikers</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Voorbeeld account object</h4>
<pre class="code">
{
    "account": {
        "account_id": "1EZsjcmOVT",
        "created": "2012-11-08 21:40:31",
        "modified": null,
        "hostname": "devries",
        "api_key": "Vh9ssijEOkP_CCM2uvQg",
        "company": {
            "name1": "De Vries BV",
            "name2": "Afdeling Apeldoorn"
        },
        "users": [
            {
                "user": {
                    "user_id": "hag8FEWrQp",
                    "created": "2012-11-08 21:40:31",
                    "modified": null,
                    "login": "robin@example.net",
                    "password": null,
                    "email": "robin@example.net",
                    "sex": "male",
                    "name1": "Robin",
                    "name2": "De Vries",
                    "loginlink": "https://login.laposta.nl/url/u/1EZsjcmOVT/hag8FEWrQp"
                }
            }
        ]
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Account aanmaken</h3>
<p>Bij het aanmaken van een account hoeft u alleen de naam van de organisatie en enkele gegevens over de bij het account horende gebruiker aan te geven. In het antwoord van de API worden vervolgens login &eacute;n wachtwoord vermeld. De vermelding van het wachtwoord is eenmalig omdat de wachtwoorden door ons niet worden opgeslagen. De gebruiker kan later eventueel zelf het wachtwoord wijzigen.</p>
<p>Als er iets niet klopt aan de meegegeven parameters dan wordt bij de foutmelding een code en een melding weergegeven. Zie hierboven bij Foutmeldingen wat de codes betekenen.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">hostname:</td><td class="explanation">De hostname voor dit account, voor in de url hostname.email-provider.nl</td></tr>
<tr><td class="var">company[name1] <span class="required">(verplicht)</span>:</td><td class="explanation">De naam van de organisatie van dit account</td></tr>
<tr><td class="var">company[name2]:</td><td class="explanation">Extra regel voor de naam van de organisatie van dit account</td></tr>
<tr><td class="var">user[email] <span class="required">(verplicht)</span>:</td><td class="explanation">E-mailadres van de bij dit account horende gebruiker</td></tr>
<tr><td class="var">user[sex]:</td><td class="explanation">Geslacht van de bij dit account horende gebruiker (<code>male</code> of <code>female</code>)</td></tr>
<tr><td class="var">user[name1]:</td><td class="explanation">De voornaam van de bij dit account horende gebruiker</td></tr>
<tr><td class="var">user[name2]:</td><td class="explanation">De achternaam van de bij dit account horende gebuiker</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
POST https://api.laposta.nl/v2/account
</pre>

<h4>Voorbeeld aanvraag</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/account \
  -u JdMtbsMq2jqJdQZD9AHC: \
  -d hostname=devries \
  '-d company[name1]=De Vries BV' \
  '-d company[name2]=Afdeling Apeldoorn' \
  -d user[email]=robin@example.net \
  -d user[sex]=male \
  -d user[name1]=Robin \
  '-d user[name2]=De Vries'
<? } else if ($lib == 'php') { ?>
Dit onderdeel is nog niet opgenomen in de php-wrapper.
<? } ?>
</pre>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "account": {
        "account_id": "1EZsjcmOVT",
        "created": "2012-11-08 21:40:31",
        "modified": null,
        "hostname": "devries",
        "company": {
            "name1": "De Vries BV",
            "name2": "Afdeling Apeldoorn"
        },
        "users": [
            {
                "user": {
                    "user_id": "hag8FEWrQp",
                    "created": "2012-11-08 21:40:31",
                    "modified": null,
                    "login": "robin@example.net",
                    "password": "rarpa2Nspo",
                    "email": "robin@example.net",
                    "sex": "male",
                    "name1": "Robin",
                    "name2": "De Vries",
                    "loginlink": "https://login.laposta.nl/url/u/1EZsjcmOVT/hag8FEWrQp"
                }
            }
        ]
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Account opvragen</h3>
<p>Alle informatie over een account.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">account_id <span class="required">(verplicht)</span>:</td><td class="explanation">Het id van het account</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
GET https://api.laposta.nl/v2/account/{account_id}
</pre>
<h4>Voorbeeld aanvraag</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/account/1EZsjcmOVT \
  -u JdMtbsMq2jqJdQZD9AHC:
<? } else if ($lib == 'php') { ?>
Dit onderdeel is nog niet opgenomen in de php-wrapper.
<? } ?>
</div>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "account": {
        "account_id": "1EZsjcmOVT",
        "created": "2012-11-08 21:40:31",
        "modified": null,
        "hostname": "devries",
        "api_key": "Vh9ssijEOkP_CCM2uvQg",
        "company": {
            "name1": "De Vries BV",
            "name2": "Afdeling Apeldoorn"
        },
        "users": [
            {
                "user": {
                    "user_id": "hag8FEWrQp",
                    "created": "2012-11-08 21:40:31",
                    "modified": null,
                    "login": "robin@example.net",
                    "password": null,
                    "email": "robin@example.net",
                    "sex": "male",
                    "name1": "Robin",
                    "name2": "De Vries",
                    "loginlink": "https://login.laposta.nl/url/u/1EZsjcmOVT/hag8FEWrQp"
                }
            }
        ]
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Alle accounts opvragen</h3>
<p>Alle account die onder uw partnerschap vallen, in een array van account objecten. De account objecten zijn opgenomen in een array met de naam 'data'.</p>
<h4>Parameters</h4>
<p>Er hoeven geen parameters te worden meegegeven.</p>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
GET https://api.laposta.nl/v2/account
</pre>

<h4>Voorbeeld aanvraag</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/account \
  -u JdMtbsMq2jqJdQZD9AHC:
<? } else if ($lib == 'php') { ?>
Dit onderdeel is nog niet opgenomen in de php-wrapper.
<? } ?>
</pre>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "data": [
        {
            "account": {
                "account_id": "1EZsjcmOVT",
                "created": "2012-11-08 21:40:31",
                "modified": null,
                "hostname": "devries",
		"api_key": "Vh9ssijEOkP_CCM2uvQg",
                "company": {
                    "name1": "De Vries BV",
                    "name2": "Afdeling Apeldoorn"
                },
                "users": [
                    {
                        "user": {
                            "user_id": "hag8FEWrQp",
                            "created": "2012-11-08 21:40:31",
                            "modified": null,
                            "login": "robin@example.net",
                            "password": null,
                            "email": "robin@example.net",
                            "sex": "male",
                            "name1": "Robin",
                            "name2": "De Vries",
                            "loginlink": "https://login.laposta.nl/url/u/1EZsjcmOVT/hag8FEWrQp"
                        }
                    }
                ]
            }
        },
        {
            "account": {
                "account_id": "oHqGyaz23b",
                "created": "2012-11-08 21:45:05",
                "modified": null,
                "hostname": "jansen",
		"api_key": "7Uyq0iO_8UASsju0_92T",
                "company": {
                    "name1": "Jansen Damesmode",
                    "name2": ""
                },
                "users": [
                    {
                        "user": {
                            "user_id": "ni9Spvqdlh",
                            "created": "2012-11-08 21:45:05",
                            "modified": null,
                            "login": "jansen@example.net",
                            "password": null,
                            "email": "jansen@example.net",
                            "sex": "female",
                            "name1": "",
                            "name2": "Jansen",
                            "loginlink": "https://login.laposta.nl/url/u/oHqGyaz23b/ni9Spvqdlh"
                        }
                    }
                ]
            }
        }
    ]
}
</pre>
</td><!-- /right -->
</tr>

<!-- ************************************************************** -->
<!-- *************************** LOGIN **************************** -->
<!-- ************************************************************** -->
<tr>
<td class="left">
<a id="login"></a>
<h2>Inloggen</h2>
<p>Partners die white-label klanten hebben kunnen gebruik maken van ons generieke aanmeldformulier op login.email-provider.nl. Veel partners vinden het echter prettiger een eigen formulier aan te kunnen bieden. Via onze api is dat mogelijk; de login-gegevens uit het formulier kunnen naar ons systeem gestuurd worden, waarna ofwel een foutmelding volgt (als de gegevens niet correct waren), ofwel een login-url. Deze url kunt u tijdelijk gebruiken om uw klant door te sturen, waarmee deze automatisch ingelogd wordt.</p>
<p>Het controleren van logins is alleen beschikbaar voor white-label partners.</p>
<p><i>Dit deel van de API is alleen via https te gebruiken.</i></p>
</td><!-- /left -->

<td class="right">
<h2>URL patronen</h2>
<ul class="code">
<li>/v2/login</li>
</ul>
<br>
<h2>Overzicht codes in foutmelding</h2>
<p>Om makkelijk om te kunnen gaan met de diverse fouten die kunnen optreden bij het inloggen worden de volgende codes gebruikt:
<table class="list">
<tr><td class="l">301</td><td class="explanation">Deze login bestaat niet</td></tr>
<tr><td class="l">302</td><td class="explanation">Het wachtwoord is niet correct</td></tr>
<tr><td class="l">303</td><td class="explanation">Deze gebruiker mag niet (meer) inloggen</td></tr>
<tr><td class="l">304</td><td class="explanation">Dit account mag niet (meer) inloggen</td></tr>
<tr><td class="l">305</td><td class="explanation">Dit account is niet bevestigd</td></tr>
</table>

</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Logingegevens controleren</h3>
<p>Als de gegevens kloppen, dan volgt het login object met de login-url. Deze url is 1 uur geldig. Als inloggen niet mogelijk is, dan staat in de foutmelding de reden. Deze melding kunt u gebruiken om aan de invuller van het formulier te laten zien.</p>
<p>Voor de volledigheid wordt ook de API key van het account meegegeven.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">login:</td><td class="explanation">De login</td></tr>
<tr><td class="var">password:</td><td class="explanation">Het wachtwoord</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definitie</h4>
<pre class="code">
GET https://api.laposta.nl/v2/login
</pre>

<h4>Voorbeeld aanvraag</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/login?login=<?= urlencode('maartje@example.nl') ?>&password=1h2moooRTTR2 \
  -u JdMtbsMq2jqJdQZD9AHC:
<? } else if ($lib == 'php') { ?>
<pre class="code">
$login = new Laposta_Login();
$result = $login->get($_POST['login'], $_POST['password']);
$url = $result['login']['url'];
</pre>
<? } ?>
</pre>
<h4>Voorbeeld antwoord</h4>
<pre class="code">
{
    "login": {
	"url": "https://app.laposta.nl/url/e/XtLGrBVkQb/32166/480759dce7fdd2bd6f37",
	"api_key": "JdMtbsMq2jqJdQZD9AHC"
    }
}
</pre>
</td><!-- /right -->
</tr>

</table>
</div><!-- /container -->
<script>
$(function() {
	$('#nav a').click(function(e) {
		e.preventDefault();
		var hash = e.target.href.substring(e.target.href.indexOf("#"));
		$('html, body').animate({ scrollTop: $(hash).offset().top - 46 }, 'fast');
	});
});

</script>
<!-- Mtrack V2.1.2 -->
<script>
var _Mpage = '';
var _Mclickouts = 1;
var _Mdownloads = 1;
</script>
<script>document.write(unescape('%3Cscript src="http'+((document.location.protocol=='https:')?'s':'')+'://mtrack.nl/js/v2.js?c=emmycat&amp;s=laposta8269&amp;v=2.1" defer="defer" type="text/javascript"%3E%3C/script%3E'));</script>
<!-- End Mtrack -->
</body>
</html>
