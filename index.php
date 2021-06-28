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
	<li><a href="#members">Relations</a><li>
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

<?php // !!!!! NOTE: curl, php and .NET buttons broken. Displays "Show :href="?lib=curl">curl|href="?lib=php">php|href="?lib=dotnet">.NET" !!!!! ?>

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
<tr><td class="var">modified:</td><td class="explanation">Date and time of last modification made</td></tr>
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
	"unsubscribe_notification_email", "unsubscription@example.net",
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
<p>If there is something wrong with the parameters provided, a code is displayed with an error message. You may use these in combination with the variable 'parameter' to display a message to the user. See above under 'Error messages' what the codes stand for.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">name <span class="required">(mandatory)</span>:</td><td class="explanation">Name given to the list in question</td></tr>
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
  -d unsubscribe_notification_email=unsubscription@example.net
<? } else if ($lib == 'php') { ?>
require_once('./lib/Laposta.php');
Laposta::setApiKey('JdMtbsMq2jqJdQZD9AHC');
$list = new Laposta_List();
$result = $list->create(array(
	'name' => 'Testlist',
	'remarks' => 'A list for testing purposes.',
	'subscribe_notification_email' => 'subscription@example.net',
	'unsubscribe_notification_email' => 'unsubscription@example.net'
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
	"unsubscribe_notification_email", "unsubscription@example.net",
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
<tr><td class="var">list_id <span class="required">(mandatory)</span>:</td><td class="explanation">The list's ID</td></tr>
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
	"unsubscribe_notification_email", "unsubscription@example.net",
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
<h3>Modifying lists</h3>
<p>You will only have to include the fields that need to be modified in the application. Fields that are not mentioned will keep their current value. As soon as a field is mentioned, it is checked and may therefore cause an error message. A code is displayed with this error message. You may use this code in combination with the variable 'parameter' to display a message to the user. See above under 'Error messages' what the codes stand for.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the list that has to be modified</td></tr>
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
	"unsubscribe_notification_email", "unsubscription@example.net",
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
<p>This permanently deletes a list. If the list does not exist, an error message is displayed. In response you are shown another list object, but now with the state 'deleted'. After having finished this procedure, it is no longer possible for the user to request the list.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the list</td></tr>
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
	"unsubscribe_notification_email", "unsubscription@example.net",
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
<p>No parameters need to be provided.</p>
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
        	"unsubscribe_notification_email", "unsubscription@example.net"
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
        	"unsubscribe_notification_email", "unsubscription@example.net"
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
<tr><td class="var">list_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the list</td></tr>
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
	"unsubscribe_notification_email", "unsubscription@example.net",
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
<p>This section allows you to request, add and modify fields of lists.</p>
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
<tr><td class="var">modified:</td><td class="explanation">Date and time of last modification made</td></tr>
<tr><td class="var">state:</td><td class="explanation">The status of the field in question: either <code>active</code> or <code>deleted</code></td></tr>
<tr><td class="var">name:</td><td class="explanation">Name of the field (for displaying purposes)</td></tr>
<tr><td class="var">tag:</td><td class="explanation">The relation variable for usage in campaigns (not modifyable)</td></tr>
<tr><td class="var">custom_name:</td><td class="explanation">Name of the field (for use in member API calls)</td></tr>
<tr><td class="var">defaultvalue:</td><td class="explanation">The default value (will be used in the absence of this field)</td></tr>
<tr><td class="var">datatype:</td><td class="explanation">The data type of the field in question (<code>text</code>, <code>numeric</code>, <code>date</code>, <code>select_single</code>, <code>select_multiple</code>)</td></tr>
<tr><td class="var">datatype_display:</td><td class="explanation">Only applicable for select_single: the desired display (<code>select</code>, <code>radio</code>)</td></tr>
<tr><td class="var">options:</td><td class="explanation">An array of the available options (only for <code>select_single</code> or <code>select_multiple</code>)</td></tr>
<tr><td class="var">options_full:</td><td class="explanation">An array of the available options, including IDs (alleen bij <code>select_single</code> or <code>select_multiple</code>)</td></tr>
<tr><td class="var">required:</td><td class="explanation">Is this a mandatory field? (<code>true</code> or <code>false</code>)</td></tr>
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
<p>If there is something wrong with the parameters provided, a code is displayed with an error message. See above under 'Error messages' what the codes stand for.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the list to which the field belongs</td></tr>
<tr><td class="var">name <span class="required">(mandatory)</span>:</td><td class="explanation">A name for this field</td></tr>
<tr><td class="var">defaultvalue:</td><td class="explanation">A potential default value</td></tr>
<tr><td class="var">datatype <span class="required">(mandatory)</span>:</td><td class="explanation">The data type: <code>text</code>, <code>numeric</code>, <code>date</code>, <code>select_single</code> or <code>select_multiple</code></td></tr>
<tr><td class="var">datatype_display:</td><td class="explanation">Only applicable for select_single: the desired display (<code>select</code>, <code>radio</code>)</td></tr>
<tr><td class="var">options:</td><td class="explanation">What selection options are available? (mandatory for the data types <code>select_single</code> of <code>select_multiple</code>). The options can be given as an array. In the answer the options are repeated, but there is also an extra field <code>options_full</code>. Also listed are the option IDs, which may eventually be used to change the options later.</td></tr>
<tr><td class="var">required <span class="required">(mandatory)</span>:</td><td class="explanation">Is this a mandatory field?</td></tr>
<tr><td class="var">in_form <span class="required">(mandatory)</span>:</td><td class="explanation">Does this field occur in the subscription form? (<code>boolean</code>)</td></tr>
<tr><td class="var">in_list <span class="required">(mandatory)</span>:</td><td class="explanation">Is this field visible in Laposta's overview? (<code>boolean</code>)</td></tr>
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
<tr><td class="var">list_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the list to which the field belongs</td></tr>
<tr><td class="var">field_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the requestable field</td></tr>
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
<h3>Modifying fields</h3>
<p>You will only have to include the fields that need to be modified in the application. Fields that are not mentioned will keep their current value fields keep their current values. As soon as a field is mentioned it does get checked, and thus can cause an error message. This error message displays a code with a message. See above under 'Error messages' what the codes stand for.</p>
<p class="info">Please note that changing the data type removes all data from the field in question.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the list to which the field belongs</td></tr>
<tr><td class="var">name:</td><td class="explanation">A name for this field</td></tr>
<tr><td class="var">datatype:</td><td class="explanation">The data type of this field (<code>text</code>, <code>numeric</code>, <code>date</code>, <code>select_single</code>, <code>select_multiple</code>)</td></tr>
<tr><td class="var">datatype_display:</td><td class="explanation">Only applicable for select_single: the desired display (<code>select</code>, <code>radio</code>)</td></tr>
<tr><td class="var">options:</td><td class="explanation">What selection options are available? Array with values only. Please note that this list replaces the existing options in its entirety. To modify fields already in use, it is preferable to use <code>options_full</code>. (Only possible for data types <code>select_single</code> or <code>select_multiple</code>)</td></tr>
<tr><td class="var">options_full:</td><td class="explanation">What selection options are there? Array with per option both the value (<code>value</code>) and the ID (<code>ID</code>). Please note that this list replaces the existing options in its entirety. If IDs match, the corresponding option is modified. (Only possible for data types <code>select_single</code> of <code>select_multiple</code>)</td></tr>
<tr><td class="var">defaultvalue:</td><td class="explanation">The default value (will be used in the absence of this field)</td></tr>
<tr><td class="var">required:</td><td class="explanation">Is this a mandatory field?</td></tr>
<tr><td class="var">in_form:</td><td class="explanation">Does this field occur in the subscription form? (<code>boolean</code>)</td></tr>
<tr><td class="var">in_list:</td><td class="explanation">Is this field visible in Laposta's overview? (<code>boolean</code>)</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
POST https://api.laposta.nl/v2/field/{field_id}
</pre>

<h4>Example of request</h4>
<p class="info">This example makes the field no longer  mandatory.</p>
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
<h4>Example of response</h4>
<pre class="code">
{
    "field": {
        "field_id": "hsJ5zbDfzJ",
        "list_id": "BaImMu3JZA",
        "created": "2012-10-31 11:55:50",
        "modified": "2012-10-31 12:05:44",
        "state": "active",
        "name": "Age,
        "tag": "{{Age}}",
        "custom_name": "Age",
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
<h3>Deleting a field</h3>
<p>This permanently deletes a field. If the field does not exist, an error message is displayed. In response you are shown another field object, but now with the state 'deleted'. After having finished this procedure, it is no longer possible for the user to request the field.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">field_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the field to be deleted</td></tr>
<tr><td class="var">list_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the list to which the field belongs</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
DELETE https://api.laposta.nl/v2/field/{field_id}
</pre>

<h4>Example of request</h4>
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
<h4>Example of response</h4>
<pre class="code">
{
    "field": {
        "field_id": "lxwc8OyD3a",
        "list_id": "BaImMu3JZA",
        "created": "2012-10-30 21:44:40",
        "modified": null,
        "state": "deleted",
        "name": "FavoriteColor",
        "tag": "{{favoritecolor}}",
        "custom_name": "favoritecolor",
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
<h3>Requesting all fields of a list</h3>
<p>All fields of a list in an array of field objects. The field objects are compiled in an array named 'data'.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the list to which the field belongs</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
GET https://api.laposta.nl/v2/field
</pre>

<h4>Example of request</h4>
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
<h4>Example of response</h4>
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
		"name": "Name",
		"tag": "{{name}}",
		"custom_name": "name",
		"defaultvalue": "reader",
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
		"name": "Age",
		"tag": "{{age}}",
		"custom_name": "age",
		"defaultvalue": "unknown",
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
<!-- *************************** RELATIONS **************************** -->
<!-- ***************************************************************** -->
<tr>
<td class="left">
<a id="members"></a>
<h2>Relations</h2>
<p>This section allows you to retrieve, add and modify relations.</p>
<p>You will need a list_id as a parameter each time. You can find this by logging in, and proceeding to the corresponding list under 'Relations'. Next up, click on the tab labeled 'Attributes list'. On the right side you will see the ID there.</p>
</td><!-- /left -->

<td class="right">
<h2>URL patterns</h2>
<ul class="code">
<li>/v2/member</li>
<li>/v2/member/{member_id}</li>
</ul>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>The member object</h3>
<h4>Fields</h4>
<table class="vars">
<tr><td class="var">member_id:</td><td class="explanation">The ID of this member object</td></tr>
<tr><td class="var">list_id:</td><td class="explanation">The ID of the related list</td></tr>
<tr><td class="var">email:</td><td class="explanation">The email address</td></tr>
<tr><td class="var">state:</td><td class="explanation">The current status of this relation: <code>active</code>, <code>unsubscribed</code>, <code>unconfirmed</code> or <code>cleaned</code></td></tr>
<tr><td class="var">signup_date:</td><td class="explanation">Date and time of subscription, format YYYY-MM-DD HH:MM:SS</td></tr>
<tr><td class="var">modified:</td><td class="explanation">Date and time of last modification made, format YYYY-MM-DD HH:MM:SS</td></tr>
<tr><td class="var">ip:</td><td class="explanation">IP from which the relation is registered</td></tr>
<tr><td class="var">source_url:</td><td class="explanation">URL from which the relation is registered</td></tr>
<tr><td class="var">custom_fields:</td><td class="explanation">An array with the value of all additional fields of the corresponding list. If there are fields where several options can be selected, these options are listed in an array..</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Example of member object</h4>
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
<h3>Adding a relation</h3>
<p>If there is something wrong with the parameters provided, a code is displayed with an error message. You can use this in combination with the variable 'parameter' to display a message to the user. See above under 'Error messages' what the codes stand for.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the list to which the relation must be added</td></tr>
<tr><td class="var">ip <span class="required">(mandatory)</span>:</td><td class="explanation">The IP address from which the relation is registered</td></tr>
<tr><td class="var">email <span class="required">(mandatory)</span>:</td><td class="explanation">The email address of the relation to be added</td></tr>
<tr><td class="var">source_url:</td><td class="explanation">The URL from which the relation is registered</td></tr>
<tr><td class="var">custom_fields:</td><td class="explanation">The values of the additionally created fields</td></tr>
<tr><td class="var">options:</td><td class="explanation">Additional instructions, with possibilities being: <code>suppress_email_notification: true</code> to prevent a notification email from being sent every time someone logs in via an API, <code>suppress_email_welcome: true</code> to prevent the welcome email from being sent when registering via the API, and <code>ignore_doubleoptin: true</code> to instantly activate relationships on a double-optin list and ensure that no confirmation email is sent when signing up through the API.</td></tr>
</table>
<p class="info">If it concerns a double-optin list then a confirmation email will be sent with each subscription, unless the 'ignore_doubleoptin' option is included (see above).</p>
<p class="info">If there are custom_fields that have been set to mandatory, then filling these fields via the API is also mandatory.</p>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
POST https://api.laposta.nl/v2/member
</pre>

<h4>Example of request</h4>
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
<p class="info">Multiple choice custom fields can be filled with the currently defined options for that field. So you can simply enter the value of the field. If multiple choices can be made, you can pass them in an array; see the example above.</p>
<h4>Example of response</h4>
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
<h3>Requesting a relation</h3>
<p>All information about a relation in a member object</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the list in which the relation appears</td></tr>
<tr><td class="var">member_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID <i>or</i> the email address of the relation</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
GET https://api.laposta.nl/v2/member/{member_id}
</pre>
<h4>Example of request</h4>
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
<p class="info">You may also use the email address here instead of the member_id. Please note that a '+' in the address should be displayed as: %252B</p>
<h4>Example of response</h4>
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
<h3>Modifying a relation</h3>
<p>You only have to include the fields that need to be modified in the request. Fields that are not named will keep their current value. As soon as a field is mentioned it does get checked, and thus can cause an error message. This error message displays a code with a message. See above under 'Error messages' what the codes stand for.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the list to which the relation must be modified</td></tr>
<tr><td class="var">email:</td><td class="explanation">The email address of the relation that must be modified</td></tr>
<tr><td class="var">state</span>:</td><td class="explanation">The new status of the relation: active or unsubscribed</td></tr>
<tr><td class="var">custom_fields:</td><td class="explanation">The values of the extra created fields</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
POST https://api.laposta.nl/v2/member/{member_id}
</pre>

<h4>Example of request</h4>
<p class="info">This example changes the name and the amount of children</p>
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
<p class="info">Instead of using the member_id, you may also use the email address</p>
<p class="info">Multiple choice custom fields that are not mandatory can be emptied by including the variable in the change request, but without an assigned value.</p>

<h4>Example of response</h4>
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
<h3>Deleting a relation</h3>
<p>This permanently deletes a relation. If the relation does not exist, an error message is displayed. In response you are shown another list object, but now with the state 'deleted'. After having finished this procedure, it is no longer possible for the user to request the relation.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the list in which the relation appears</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
DELETE https://api.laposta.nl/v2/member/{member_id}
</pre>

<h4>Example of request</h4>
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
<p class="info">You may also use the email address here instead of the member_id.</p>
<h4>Example of response</h4>
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
<h3>Requesting all relations of a list</h3>
<p>All fields of a list in an array of member objects. The member objects are compiled in an array named 'data'.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the list from which the relations are being requested</td></tr>
<tr><td class="var">state</span>:</td><td class="explanation">The status of the requested relations: active, unsubscribed or cleaned</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
GET https://api.laposta.nl/v2/member
</pre>

<h4>Example of request</h4>
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
<h4>Example of response</h4>
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
<p>Webhooks are a separate part of the API. With the normal API, the request for information always comes from the developer. With webhooks it is the other way around and Laposta takes the initiative to inform the developer of something. A webhook does this by querying a URL that you have specified; in the form of a POST with a JSON object containing information.</p>
<p>You can enter URLs for adding, changing or deleting relations. Let us suppose you create a webhook for additions, and someone registers via a Laposta registration form, then almost immediately after this new registration you will receive a POST at the URL you have specified.</p>
<h3>Application: Syncronization with other systems</h3>
<p>Our API is mainly used to synchronize the relationship file in Laposta with another application, for example a CMS or a CRM. Adding and changing relations to Laposta is then accomplished via the API (as described above). Webhooks notify your application of modifies in the relation file that take place within Laposta (subscriptions, the cancelling of subscriptions, or modifications). With the combination of these two functions, you are able to keep the two files in sync.</p>
<h3>The processing of webhooks</h3>
<p>With a webhook, a URL is requested on your server. You are completely in control of how that information is processed. To indicate that you have received a webhook correctly, the server must return a 200 HTTP status code. (This will usually be the case by default).</p>
</td><!-- /left -->

<td class="right">
<h2>Registering webhooks</h2>
<p>You can register webhooks per list. This is done by going to the appropriate list (under Relations), and proceeding to the Attributes list. There, you will find the tab called Webhooks.</p>
<p><img src="/doc/assets/static/img/webhooks.jpg" width="500" height="146"></p>
<p>For each webhook, you can specify the event for which it should be requested: adding a relation, modifying a relation, or deleting a relation. In addition, you specify the URL to which the information should be POSTed.</p>
<p>It is possible to moderate the webhooks through this API; please see the information below.</p>
<h3>Timing</h3>
<p>It may happen that calling up a webhook fails, for example, because your server is not accessible or produces an error message. Laposta will then continue to offer the webhook a number of times (7, to be exact). First after 5 minutes and then in increasing intervals of up to about 14 days. If no contact has been made by then, the webhook is deleted.</p>
<h3>Bundling events</h3>
<p>Every 5 seconds, the present webhooks are called. If there happen to be several, they are bundled together, up to a maximum of 1000 events per request. This prevents your server from being overloaded with requests, e.g. when importing larger numbers of relations into Laposta.</p>
</td><!-- /right -->
</tr>

<tr>
<td class="left">
<h3>Structure of a webhook</h3>
<p>You will receive an object in JSON format from the URL you have specified. This object consists of an array with the name <span class="code">data</span>, in which the different events are listed. This means that several events can be included in a single request (see above under 'Bundling events')..</p>
<h4>Fields</h4>
<table class="vars">
<tr><td class="var">type:</td><td class="explanation">The type of webhook (always <span class="code">member</span>)</td></tr>
<tr><td class="var">event:</td><td class="explanation">The reason why the webhook has been requested. Could be: <span class="code">subscribed</span>, <span class="code">modified</span> or <span class="code">deactivated</span></td></tr>
<tr><td class="var">data:</td><td class="explanation">The data of the object that has been added, modified or deleted. In this case, a member object</td></tr>
<tr><td class="var">info:</td><td class="explanation">Extra information in regards to the request of the webhook, see below</td></tr>
<tr><td class="var">date_fired:</td><td class="explanation">The time at which this request was sent</td></tr>
</table>
<h4>Fields info object</h4>
<table class="vars">
<tr><td class="var">date_event:</td><td class="explanation">The moment this event occurred (and at the same time the moment the webhook was triggered)</td></tr>
<tr><td class="var">action <span class="optional">(optional)</span>:</td><td class="explanation">Extra information in regards to the event, different options for the various events. For the event <span class="code">subscribed</span>:
<p>
<table class="vars">
<tr><td class="var">subscribed:</td><td class="explanation">Relation added</td></tr>
<tr><td class="var">resubscribed:</td><td class="explanation">Relation readded</td></tr>
</table>
</p>
<p>
For the event <span class="code">deactivated</span>:
</p>
<p>
<table class="vars">
<tr><td class="var">unsubscribed:</td><td class="explanation">Relation unsubscribed</td></tr>
<tr><td class="var">deleted:</td><td class="explanation">Relation deleted</td></tr>
<tr><td class="var">hardbounce:</td><td class="explanation">Relation deleted after hard bounce</td></tr>
</table>
</p>
</td></tr>
<tr><td class="var">source <span class="optional">(optioneel)</span>:</td><td class="explanation">Source of the event: could be <span class="code">app</span> (within the web interface) or <span class="code">external</span> (via, for example, a subscription form)</td></tr>
</table>
</td><!-- /left -->

<td class="right">
<h4>Example of webhook response</h4>
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
<h2>Managing webhooks</h2>
<p>You can also manage the webhooks with the API. Below is explained how to retrieve, add and modify webhooks.</p>
</td><!-- /left -->

<td class="right">
<h2>URL patterns</h2>
<ul class="code">
<li>/v2/webhook</li>
<li>/v2/webhook/{webhook_id}</li>
</ul>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>The webhook object</h3>
<h4>Fields</h4>
<table class="vars">
<tr><td class="var">webhook_id:</td><td class="explanation">The ID of this webhook</td></tr>
<tr><td class="var">list_id:</td><td class="explanation">The ID of the list to which the field belongs</td></tr>
<tr><td class="var">created:</td><td class="explanation">Date and time of creation</td></tr>
<tr><td class="var">modified:</td><td class="explanation">Date and time of last modification made</td></tr>
<tr><td class="var">state:</td><td class="explanation">The status of this webhook: <code>active</code> or <code>deleted</code></td></tr>
<tr><td class="var">event:</td><td class="explanation">When will the webhook be requested? (<code>subscribed</code>, <code>modified</code> or <code>deactivated</code>)</td></tr>
<tr><td class="var">url:</td><td class="explanation">The URL to be accessed</td></tr>
<tr><td class="var">blocked:</td><td class="explanation">Is the accessing of the webhook (temporarily) blocked? (<code>true</code> or <code>false</code>)</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Example of webhook object</h4>
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
<h3>Adding a webhook</h3>
<p>If there is something wrong with the parameters provided, a code is displayed with an error message. See above under 'Error messages' what the codes stand for.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the list to which the field belongs</td></tr>
<tr><td class="var">event <span class="required">(mandatory)</span>:</td><td class="explanation">When will the webhook be requested? (<code>subscribed</code>, <code>modified</code> of <code>deactivated</code>)</td></tr>
<tr><td class="var">url <span class="required">(mandatory)</span>:</td><td class="explanation">The URL to be accessed</td></tr>
<tr><td class="var">blocked <span class="required">(mandatory)</span>:</td><td class="explanation">Is the accessing of the webhook (temporarily) blocked? (<code>true</code> or <code>false</code>)</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
POST https://api.laposta.nl/v2/webhook
</pre>

<h4>Example of request</h4>
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
<h4>Example of response</h4>
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
<h3>Requesting a webhook</h3>
<p>All information about a webhook</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the list to which the field belongs</td></tr>
<tr><td class="var">webhook_id<span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the list to be requested</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
GET https://api.laposta.nl/v2/webhook/{webhook_id}
</pre>
<h4>Example of request</h4>
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
<h4>Example of response</h4>
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
<h3>Modifying a webhook</h3>
<p>If there is something wrong with the parameters provided, a code is displayed with an error message. Fields that are not mentioned will keep their current value fields keep their current value. As soon as a field is mentioned it does get checked, and thus can cause an error message. This error message displays a code with a message. See above under 'Error messages' what the codes stand for. See above under 'Error messages' what the codes stand for.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the list to which the field belongs</td></tr>
<tr><td class="var">webhook_id<span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the list to be requested</td></tr>
<tr><td class="var">event:</td><td class="explanation">When will the webhook be requested? (<code>subscribed</code>, <code>modified</code> or <code>deactivated</code>)</td></tr>
<tr><td class="var">url:</td><td class="explanation">The URL to be accessed</td></tr>
<tr><td class="var">blocked:</td><td class="explanation">Is the accessing of the webhook (temporarily) blocked? (<code>true</code> or <code>false</code>)</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
POST https://api.laposta.nl/v2/webhook/{webhook_id}
</pre>

<h4>Example of request</h4>
<p class="info">This example modifies the URL</p>
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
<h4>Example of response</h4>
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
<h3>Deleting a webhook</h3>
<p>This permanently deletes a webhook. Potentially outstanding requests from the webhook will still be completed. If the field does not exist, an error message is displayed. In response you are shown another webhook object, but now with the state 'deleted'. After having finished this procedure, it is no longer possible for the user to request the webhook.</p>
<h4>Parameters</h4>
<table class="vars">
	<tr><td class="var">field_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the webhook to be deleted</td></tr>
	<tr><td class="var">list_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the list to which the webhook belongs</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
DELETE https://api.laposta.nl/v2/webhook/{webhook_id}
</pre>

<h4>Example of request</h4>
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
<h4>Example of response</h4>
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
<h3>Requesting all webhooks of a list</h3>
<p>All webhooks of a list in an array of member objects. The webhook objects are compiled in an array named 'data'.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">list_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the list to which the webhooks belong</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
GET https://api.laposta.nl/v2/webhook
</pre>

<h4>Example of request</h4>
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
<h4>Example of response</h4>
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
<h2>Campaigns</h2>
<p>Retrieving, creating, filling and sending campaigns.</p>
</td><!-- /left -->

<td class="right">
<h2>URL patterns</h2>
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
<h3>The campaign object</h3>
<h4>Fields</h4>
<table class="vars">
<tr><td class="var">account_id:</td><td class="explanation">The ID of this account</td></tr>
<tr><td class="var">campaign_id:</td><td class="explanation">The ID of this campaign</td></tr>
<tr><td class="var">created:</td><td class="explanation">Date and time of creation</td></tr>
<tr><td class="var">modified:</td><td class="explanation">Date and time of last modification made</td></tr>
<tr><td class="var">type:</td><td class="explanation">The type of campaign (currently only possible: <code>regular</code>)</td></tr>
<tr><td class="var">delivery_requested:</td><td class="explanation">When to send</td></tr>
<tr><td class="var">delivery_started:</td><td class="explanation">Start of last transmission</td></tr>
<tr><td class="var">delivery_ended:</td><td class="explanation">End of last transmission</td></tr>
<tr><td class="var">name:</td><td class="explanation">Internal name of campaign</td></tr>
<tr><td class="var">subject:</td><td class="explanation">Subject line</td></tr>
<tr><td class="var">from:</td><td class="explanation">Sender (name en email address)</td></tr>
<tr><td class="var">reply_to:</td><td class="explanation">Email address for receiving replies</td></tr>
<tr><td class="var">list_ids:</td><td class="explanation">Linked lists</td></tr>
<tr><td class="var">stats:</td><td class="explanation">Linked web statistics</td></tr>
<tr><td class="var">web:</td><td class="explanation">URL to web version</td></tr>
<tr><td class="var">screenshot:</td><td class="explanation">Screenshots of campaign</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Example of campaign object</h4>
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
        "name": "My first campaign",
        "subject": "My first campaign",
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
<h3>Creating a campaign</h3>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">type <span class="required">(mandatory)</span>:</td><td class="explanation">Type of campaign (must be set to: <code>regular</code>)</td></tr>
<tr><td class="var">name <span class="required">(mandatory)</span>:</td><td class="explanation">A name for this campaign for internal use</td></tr>
<tr><td class="var">subject <span class="required">(mandatory)</span>:</td><td class="explanation">Subject line</td></tr>
<tr><td class="var">from[name] <span class="required">(mandatory)</span>:</td><td class="explanation">The name of the sender</td></tr>
<tr><td class="var">from[email] <span class="required">(mandatory)</span>:</td><td class="explanation">The email address of the sender (must be a sender address approved within the program)</td></tr>
<tr><td class="var">reply_to:</td><td class="explanation">Email address for receiving replies</td></tr>
<tr><td class="var">list_ids <span class="required">(mandatory)</span>:</td><td class="explanation">Recipients, array of list_ids</td></tr>
<tr><td class="var">stats[ga]:</td><td class="explanation">Link Google Analytics (<code>true</code> or <code>false</code>)</td></tr>
<tr><td class="var">stats[mtrack]:</td><td class="explanation">Link Mtrack (<code>true</code> or <code>false</code>)</td></tr>
</table>
<p class="info">The campaign has not yet been filled or scheduled after the request. Use the <code>/content</code> and <code>/action</code> patterns in order to do this, see below.</p>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
POST https://api.laposta.nl/v2/campaign
</pre>

<h4>Example of request</h4>
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
[No .NET wrapper is available yet for this feature]
<? } ?>
</pre>
<h4>Example of response</h4>
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
<h3>Requesting a campaign</h3>
<p>All information about a campaign</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">campaign_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the campaign</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
GET https://api.laposta.nl/v2/campaign/{campaign_id}
</pre>
<h4>Example of request</h4>
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
[No .NET wrapper is available yet for this feature]
<? } ?>
</div>
<h4>Example of response</h4>
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
        "name": "My first campaign",
        "subject": "My first campaign",
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
<h3>Modifying a campaign</h3>
<p>You only have to submit the fields that require to be modified in the application. Fields that are not mentioned will keep their current value fields keep their current value. As soon as a field is mentioned it does get checked, and thus can cause an error message. This error message displays a code with a message. See above under 'Error messages' what the codes stand for.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">campaign_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the campaign that has to be modified</td></tr>
<tr><td class="var">name:</td><td class="explanation">A name for this campaign for internal use</td></tr>
<tr><td class="var">subject:</td><td class="explanation">Subject line</td></tr>
<tr><td class="var">from[name]:</td><td class="explanation">The name of the sender</td></tr>
<tr><td class="var">from[email]:</td><td class="explanation">The email address of the sender (must be a sender address approved within the program)</td></tr>
<tr><td class="var">reply_to:</td><td class="explanation">Email address for receiving replies</td></tr>
<tr><td class="var">list_ids:</td><td class="explanation">Recipients, array of list_ids</td></tr>
<tr><td class="var">stats[ga]:</td><td class="explanation">Link Google Analytics (<code>true</code> or <code>false</code>)</td></tr>
<tr><td class="var">stats[mtrack]:</td><td class="explanation">Link Mtrack (<code>true</code> or <code>false</code>)</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
POST https://api.laposta.nl/v2/campaign/{campaign_id}
</pre>

<h4>Example of request</h4>
<p class="info">This example changes the subject line.</p>
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
No .NET wrapper is available yet for this feature
<? } ?>
</pre>
<h4>Example of response</h4>
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
<h3>Deleting a campaign</h3>
<p>This deletes a campaign. Unsent campaigns will be permanently deleted. Campaigns that have been sent are permanently deleted only after 180 days. In the meantime, they can be restored in the overview of campaigns in our program.</p>
<p>In response you are shown another campaign object, but now with the state 'deleted'. After having finished this procedure, it is no longer possible for the user to request the campaign.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">campaign_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the campaign to be deleted</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
DELETE https://api.laposta.nl/v2/campaign/{campaign_id}
</pre>

<h4>Example of request</h4>
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
[No .NET wrapper is available yet for this feature]
<? } ?>
</pre>
<h4>Example of response</h4>
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
<h3>Requesting all campaigns of an account</h3>
<p>All campaigns in an array of campaign objects. The campaign objects have been ordered in an array with the name 'data'.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td>None.</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
GET https://api.laposta.nl/v2/campaign
</pre>

<h4>Example of request</h4>
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
[No .NET wrapper is available yet for this feature]
<? } ?>
</pre>
<h4>Example of response</h4>
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
                "name": "My first campaign",
                "subject": "My first campaign",
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
                "name": "My second campaign",
                "subject": "My second campaign",
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
<h3>Requesting campaign content</h3>
<p>Requesting the content of a campaign.</p>
<p><i>Please note that this is only possible if it involves a campaign that has been exported, and not for a campaign created within the application using the drag &amp; drop editor.</i></p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">campaign_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the campaign</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
GET https://api.laposta.nl/v2/campaign/{campaign_id}/content
</pre>
<h4>Example of request</h4>
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
[No .NET wrapper is available yet for this feature]
<? } ?>
</div>
<h4>Example of response</h4>
<pre class="code">
{
    "campaign": {
        "account_id": "wFiUS4HL4e",
        "campaign_id": "pbrqulw2tc",
        "plaintext": "View the web version here:\n/tag/web\n\n           \n\n \t\tInsert a short and captivating description of your newsletter here.\n\n \t\tView the web version [1]\n\n \t\tTitle of this segment\n\n This is a text segment. If you click this text, you can edit\nthis. On the left side you are presented with two tabs. Under the Content\ntab, you can enter your text and do some formatting. Here you can also edit the\ntitle of this segment. Under the Formatting tab, you will be able to deal with the main\nformatting, of the title, the text and the box.\n\nWould you like to return to the overview of segments and the options for overall\nlayout? Save your segment of click the outside of your\nnewsletter. \n\n This email has been sent to {{email}} [2].\nIf you no longer wish to receive our newsletter, you may unsubscribe here\n[3].\nYou may also review and modify your data [4].\nFor proper delivery, please add {{from_email}} [5] to your\ncontact book. \n\nThis email has been sent to {{email}}.\nIf you no longer wish to receive our newsletter, you may unsubscribe here\n\n[6].\n\n \n\nLinks:\n------\n[1] http://clients.laposta.nl/tag/web\n[2] mailto:{{email}}\n[3] http://clients.laposta.nl/tag/unsubscribe\n[4] http://clients.laposta.nl/tag/edit\n[5] mailto:{{from_email}}\n[6] /tag/unsubscribe\n",
        "html": "<?= htmlspecialchars('<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\">\n<head>\n<style type=\"text/css\">\n\n</style>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /> ... <table cellspacing=\"0\" cellpadding=\"0\"><tr><td><![endif]-->\n</td></tr></table>\n<table width=\"100%\" cellspacing=\"0\" cellpadding=\"30\" border=\"0\" bgcolor=\"#ffffff\"><tr><td>&nbsp;</td></tr><tr><td align=\"center\" style=\"color:#333333 !important;line-height:17px !important;font-size:13px !important;font-family:arial !important;font-weight:normal !important\">Deze email is verstuurd aan {{email}}.<br>Als u geen nieuwsbrief meer wilt ontvangen, kunt u zich <a style=\"color:#333;text-decoration:underline;font-size:13px;font-family:arial;font-weight:normal\" href=\"/tag/unsubscribe\">hier afmelden</a>.</td></tr></table></body>\n</html>') ?>",
	"import_url": "https://example.net/newsletter"
    }
}
</pre>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Filling campaign content</h3>
<p>Filling in the content of a campaign</p>
<h4>Parameters</h4>
<p>The campaign can either be filled directly with html, or through a URL, in which case Laposta imports the html found at the specified URL. One of the two must be chosen. If both parameters are given the html is taken.</p>
<table class="vars">
<tr><td class="var">campaign_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the campaign</td></tr>
<tr><td class="var">html:</td><td class="explanation">The html for the campaign</td></tr>
<tr><td class="var">import_url:</td><td class="explanation">The URL from which the html must be imported</td></tr>
<tr><td class="var">inline_css:</td><td class="explanation">Potential inlining of css (<code>true</code> or <code>false</code>)</td></tr>
</table>
<h4>Report result</h4>
<p>If the import fails, a 400 error message from the API will occur. If it does succeed in importing the html, but problems were found during the import, they are shown in the variable <code>report</code> in the response. These may include:</p>
<table class="vars">
<tr><td class="var">javascript:</td><td class="explanation">JavaScript was encountered</td></tr>
<tr><td class="var">flash:</td><td class="explanation">Flash was encountered</td></tr>
<tr><td class="var">no_unsubscribe:</td><td class="explanation">No unsubscribe could be located</td></tr>
<tr><td class="var">empty_unsubscribe:</td><td class="explanation">Empty unsubscribe encountered</td></tr>
<tr><td class="var">css:</td><td class="explanation">Missing external css files (listed)</td></tr>
<tr><td class="var">images:</td><td class="explanation">Missing external images (listed)</td></tr>
</table>
<p>Solving these problems is not necessary in order to properly send the newsletter, but it is highly recommended.</p>
<h4>Advertising and unsubscribe link</h4>
<p>In the case of a free account, our advertising is added to the bottom of the newsletter. If the offered html does not contain an unsubscribe link, it will simply be added by our program.</p>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
POST https://api.laposta.nl/v2/campaign/{campaign_id}/content
</pre>
<h4>Example of request</h4>
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
[No .NET wrapper is available yet for this feature]
<? } ?>
</div>
<h4>Example of response</h4>
<pre class="code">
{
	   "campaign": {
	       "account_id": "wFiUS4HL4e",
	       "campaign_id": "pbrqulw2tc",
	       "plaintext": "View the web version here:\n/tag/web\n\n           \n\n \t\tInsert a short and captivating description of your newsletter here.\n\n \t\tView the web version [1]\n\n \t\tTitle of this segment\n\n This is a text segment. If you click this text, you can edit\nthis. On the left side you are presented with two tabs. Under the Content\ntab, you can enter your text and do some formatting. Here you can also edit the\ntitle of this segment. Under the Formatting tab, you will be able to deal with the main\nformatting, of the title, the text and the box.\n\nWould you like to return to the overview of segments and the options for overall\nlayout? Save your segment of click the outside of your\nnewsletter. \n\n This email has been sent to {{email}} [2].\nIf you no longer wish to receive our newsletter, you may unsubscribe here\n[3].\nYou may also review and modify your data [4].\nFor proper delivery, please add {{from_email}} [5] to your\ncontact book. \n\nThis email has been sent to {{email}}.\nIf you no longer wish to receive our newsletter, you may unsubscribe here\n\n[6].\n\n \n\nLinks:\n------\n[1] http://clients.laposta.nl/tag/web\n[2] mailto:{{email}}\n[3] http://clients.laposta.nl/tag/unsubscribe\n[4] http://clients.laposta.nl/tag/edit\n[5] mailto:{{from_email}}\n[6] /tag/unsubscribe\n",
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
<h3>Sending a campaign</h3>
<p>Directly sending  a campaign</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">campaign_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the campaign</td></tr>
</table>
<p>Note: A campaign that has been sent before can also be re-sent. The campaign will then only be sent to the addresses that have been added since the last send.</p>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
POST https://api.laposta.nl/v2/campaign/{campaign_id}/action/send
</pre>
<h4>Example of request</h4>
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
[No .NET wrapper is available yet for this feature]
<? } ?>
</div>
<h4>Example of response</h4>
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
        "name": "My first campaign",
        "subject": "My first campaign",
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
<h3>Planning a campaign</h3>
<p>Planning a campaign for a later date.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">campaign_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the campaign</td></tr>
<tr><td class="var">delivery_requested <span class="required">(mandatory)</span>:</td><td class="explanation">The time and date of sending (format YYYY-MM-DD HH:MM:SS)</td></tr>
</table>
<p>Note: A campaign that has been sent before can also be re-planned. The campaign will then only be sent to the addresses that have been added since the last send.</p>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
POST https://api.laposta.nl/v2/campaign/{campaign_id}/action/schedule
</pre>
<h4>Example of request</h4>
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
[No .NET wrapper is available yet for this feature]
<? } ?>
</div>
<h4>Example of response</h4>
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
        "name": "My first campaign",
        "subject": "My first campaign",
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
<h3>Testing a campaign</h3>
<p>Sending a test mail</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">campaign_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the campaign</td></tr>
<tr><td class="var">email <span class="required">(mandatory)</span>:</td><td class="explanation">The email address to which the test should be sent.</td></tr>
</table>
<p>Note: only in the case of a campaign for which there already is content, but which has not yet been sent, is it possible for a test email to be sent.</p>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
POST https://api.laposta.nl/v2/campaign/{campaign_id}/action/testmail
</pre>
<h4>Example of request</h4>
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
[No .NET wrapper is available yet for this feature]
<? } ?>
</div>
<h4>Example of response</h4>
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
        "name": "My first campaign",
        "subject": "My first campaign",
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
<h2>Results</h2>
<p>Retrieve the figures of the results of campaigns.</p>
</td><!-- /left -->

<td class="right">
<h2>URL patterns</h2>
<ul class="code">
<li>/v2/report</li>
<li>/v2/report/{campaign_id}</li>
</ul>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>The object</h3>
<h4>Fields</h4>
<table class="vars">
<tr><td class="var">account_id:</td><td class="explanation">The ID of this account</td></tr>
<tr><td class="var">campaign_id:</td><td class="explanation">The ID of the campaign</td></tr>
<tr><td class="var">sent:</td><td class="explanation">The number of emails sent</td></tr>
<tr><td class="var">accepted:</td><td class="explanation">The number of emails accepted by the recipient mail servers</td></tr>
<!--
<tr><td class="var">opened:</td><td class="explanation">The number of registered opens</td></tr>
<tr><td class="var">clicked:</td><td class="explanation">The number of registered clicks</td></tr>
<tr><td class="var">webversion:</td><td class="explanation">The number of times the web version was viewed</td></tr>
-->
<tr><td class="var">cleaned:</td><td class="explanation">The number of deleted relations</td></tr>
<tr><td class="var">complained:</td><td class="explanation">The number of spam complaints (by clicking on the spam button in the email program)</td></tr>
<tr><td class="var">hardbounced:</td><td class="explanation">The number of hard-bounces</td></tr>
<tr><td class="var">unsubscribed:</td><td class="explanation">The number of unsubscriptions</td></tr>
<tr><td class="var">opened_unique:</td><td class="explanation">The number of relations who have opened the email once or more</td></tr>
<tr><td class="var">clicked_unique:</td><td class="explanation">The number of relations who have clicked on the email once or more</td></tr>
<tr><td class="var">webversion_unique:</td><td class="explanation">The number of relations who have requested the web version</td></tr>
<tr><td class="var">accepted_ratio:</td><td class="explanation">The ratio of accepted emails to the number of sent emails</td></tr>
<tr><td class="var">opened_ratio:</td><td class="explanation">The ratio of emails opened once or more to the number of accepted emails</td></tr>
<tr><td class="var">clicked_ratio:</td><td class="explanation">The ratio of emails that have been clicked once or more to the number of accepted emails</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Example of report object</h4>
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
<h3>Results of a campaign request</h3>
<p>The results of a campaign.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">campaign_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of a campaign</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
GET https://api.laposta.nl/v2/report/{campaign_id}
</pre>
<h4>Example of request</h4>
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
[No .NET wrapper is available yet for this feature]
<? } ?>
</div>
<h4>Example of response</h4>
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
<h3>Viewing the results of all campaigns of an account</h3>
<p>The results of all campaigns in an array of list objects. The report objects have been ordered in an array with the name 'data'.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td>None.</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
GET https://api.laposta.nl/v2/report
</pre>

<h4>Example of request</h4>
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
[No .NET wrapper is available yet for this feature]
<? } ?>
</pre>
<h4>Example of response</h4>
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
<p>Through our API, it is also possible for partners to create new accounts. This option is not activated by default; please contact us to make this option available to you.</p>
<p>Currently it is only possible to create accounts, and to view created accounts. It is not yet possible to modify or delete accounts.</p>
<p><i>This part of the API can only be used using https.</i></p>
</td><!-- /left -->

<td class="right">
<h2>URL patterns</h2>
<ul class="code">
<li>/v2/account</li>
<li>/v2/account/{account_id}</li>
</ul>
</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>The object</h3>
<h4>Fields</h4>
<table class="vars">
<tr><td class="var">account_id:</td><td class="explanation">The ID of the account</td></tr>
<tr><td class="var">created:</td><td class="explanation">Date and time of creation</td></tr>
<tr><td class="var">modified:</td><td class="explanation">Date and time of last modification made</td></tr>
<tr><td class="var">hostname:</td><td class="explanation">The hostname for use in the domain email-provider.nl</td></tr>
<tr><td class="var">api_key:</td><td class="explanation">The API-key for this account</td></tr>
<tr><td class="var">company:</td><td class="explanation">The organization associated with this account</td></tr>
<tr><td class="var">users:</td><td class="explanation">The users associated with this account</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Example of account object</h4>
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
<h3>Creating an account</h3>
<p>When creating an account, you will only need to provide the name of the organization and provide some information regarding the user associated with the account. The API response will then specify a login <i>and</i> password. The password is a one-time entry because we do not store the passwords. The user may later change the password themselves.</p>
<p>If there is something wrong with the parameters provided, a code is displayed with an error message. See above under 'Error messages' what the codes stand for.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">hostname:</td><td class="explanation">The hostname for this account, for in the url hostname.email-provider.com</td></tr>
<tr><td class="var">company[name1] <span class="required">(mandatory)</span>:</td><td class="explanation">The name of the organization of this account</td></tr>
<tr><td class="var">company[name2]:</td><td class="explanation">Extra line for the name of the organization of this account</td></tr>
<tr><td class="var">user[email] <span class="required">(mandatory)</span>:</td><td class="explanation">Email address of the user associated with this account</td></tr>
<tr><td class="var">user[sex]:</td><td class="explanation">The sex of the user associated with this account (<code>male</code> or <code>female</code>)</td></tr>
<tr><td class="var">user[name1]:</td><td class="explanation">The first name of the user associated with this account</td></tr>
<tr><td class="var">user[name2]:</td><td class="explanation">The last name of the user associated with this account</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
POST https://api.laposta.nl/v2/account
</pre>

<h4>Example of request</h4>
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
This feature has not yet been included in the php wrapper.
<? } ?>
</pre>
<h4>Example of response</h4>
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
<h3>Requesting an account</h3>
<p>All information about an account.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">account_id <span class="required">(mandatory)</span>:</td><td class="explanation">The ID of the account</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
GET https://api.laposta.nl/v2/account/{account_id}
</pre>
<h4>Example of request</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/account/1EZsjcmOVT \
  -u JdMtbsMq2jqJdQZD9AHC:
<? } else if ($lib == 'php') { ?>
This feature has not yet been included in the php wrapper.
<? } ?>
</div>
<h4>Example of response</h4>
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
<h3>Requesting all accounts</h3>
<p>All account under your partnerschip in an array of account objects. The account objects have been ordered in an array with the name 'data'.</p>
<h4>Parameters</h4>
<p>No parameters need to be provided.</p>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
GET https://api.laposta.nl/v2/account
</pre>

<h4>Example of request</h4>
<pre class="code">
<? if (empty($lib) || $lib == 'curl') { ?>
$ curl https://api.laposta.nl/v2/account \
  -u JdMtbsMq2jqJdQZD9AHC:
<? } else if ($lib == 'php') { ?>
This feature has not yet been included in the php wrapper.
<? } ?>
</pre>
<h4>Example of response</h4>
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
<h2>Logging in</h2>
<p>Partners who have white-label clients can use our generic sign-up form at login.email-provider.nl. However, many partners prefer to be able to offer their own form. Fortunately, this is possible through our API; the login data from the form can be sent to our system, after which either an error message follows (if the data was incorrect), or a login URL follows. You can temporarily use this URL to redirect your customer, which automatically logs them in.</p>
<p>Monitoring logins is only available to white-label partners.</p>
<p><i>This part of the API can only be used using https.</i></p>
</td><!-- /left -->

<td class="right">
<h2>URL patterns</h2>
<ul class="code">
<li>/v2/login</li>
</ul>
<br>
<h2>Overview of codes in error messages</h2>
<p>In order to more efficiently deal with the various errors that might occur when logging in, the following codes are used:</p>
<table class="list">
<tr><td class="l">301</td><td class="explanation">This login does not exist</td></tr>
<tr><td class="l">302</td><td class="explanation">The password entered is incorrect</td></tr>
<tr><td class="l">303</td><td class="explanation">This user is not (or no longer) allowed to log in</td></tr>
<tr><td class="l">304</td><td class="explanation">This account is not (or no longer) allowed to log in</td></tr>
<tr><td class="l">305</td><td class="explanation">This account has not been verified</td></tr>
</table>

</td><!-- /right -->
</tr>

<tr>
<td class="left continue">
<h3>Verifying login details</h3>
<p>If the data is correct, then the login object follows with the login URL. This URL is valid for 1 hour. If logging in is not possible, the error message will state the reason. You may show this message to the person who has filled out the form.</p>
<p>For the sake of completeness, the API key of the account is also included.</p>
<h4>Parameters</h4>
<table class="vars">
<tr><td class="var">login:</td><td class="explanation">The login</td></tr>
<tr><td class="var">password:</td><td class="explanation">The password</td></tr>
</table>
</td><!-- /left -->

<td class="right continue">
<h4>Definition</h4>
<pre class="code">
GET https://api.laposta.nl/v2/login
</pre>

<h4>Example of request</h4>
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
<h4>Example of response</h4>
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
