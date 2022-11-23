<?php

if (!empty($_POST['cmd'])) {
	$command = "whois " . $_POST['cmd'];
    $cmd = shell_exec($command );
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!-- saved from url=(0045)https://www.dd-wrt.com/demo/Status_Server.asp -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		
		<link rel="icon" href="https://www.dd-wrt.com/demo/images/favicon.ico" type="image/x-icon">
		<link rel="shortcut icon" href="https://www.dd-wrt.com/demo/images/favicon.ico" type="image/x-icon">
		<link type="text/css" rel="stylesheet" href="./files/style.css">
		<link type="text/css" rel="stylesheet" href="./files/default.css">
		<link type="text/css" rel="stylesheet" href="./files/ddwrt.css">
		<title>XX-WRT (build 16562) - Server Status</title>
    <style>
        .container-shell {
            width: 550px;
        }
    </style>


</head>
<body class="gui">

<div id="wrapper">
<div id="content">
<div id="header">
<div id="logo"><h1>XX-WRT Control Panel</h1></div>
<div id="menu">
 <div id="menuMain">
  <ul id="menuMainList">
   <li><a href="index.html"><strong>Status</strong></a></li>
     <li class="current"><span><strong>Administration</strong></span>


    <div id="menuSub">
     <ul id="menuSubList">
      <li><a href="admin.php"><strong>PING</strong></a></li>
      <li><span><strong>WHOIS</strong></span></li>
     </ul>
    </div>
    </li>
  </ul>
 </div>
</div>

</div>
<div id="main">
<div id="contents">


<fieldset>
<legend>Search domain name registration records</legend>


<form action="" method="POST">
<div class="setting">
<div class="label">IP address or host name:</div>
<input name="cmd" size="40" maxlength="63"  value="<?= htmlspecialchars($_POST['cmd'], ENT_QUOTES, 'UTF-8') ?>">

</div>


        <input type="submit" value="Submit" class="button">
    </form>
<br><br>
<?php if ($cmd): ?>
<div class="container-shell">
    <div classs="page-header">
        <h2> Output </h2>
		<div class="label">
		
		
		</div>
    </div>
    <pre>
<?= htmlspecialchars($command, ENT_QUOTES, 'UTF-8') ?><br>--------------------------------
	
<?= htmlspecialchars($cmd, ENT_QUOTES, 'UTF-8') ?>
    </pre>
</div>
<?php endif; ?>



</fieldset>
</div>

</div>

<div id="helpContainer">
<div id="help">
<div><h2>Help</h2></div>
<dl>
<dt class="term">WHOIS  (networking utility)</dt>
<dd class="definition">The WHOIS is a query/response protocol that is widely used to query databases that hold information about internet resources such as domain names and IP address allocations.<br><br>The WHOIS protocol is a TCP-based protocol designed to work on the port 43. This makes extremely difficult to perform a WHOIS query from a browser without relying on a server-side third party tool. In fact, client side JavaScript is not able to perform socket requests on port 43.</dd>
</dl><br>
<a href="#">More...</a>
</div>
</div>


<div id="floatKiller"></div>
<div id="statusInfo">
<div class="info"></div>
<div class="info">Time:  <span id="uptime"> 15:34:17 up 24 min, load average: 0.14, 0.03, 0.00</span></div>
<div class="info">WAN<span id="ipinfo">&nbsp;IP: 10.88.193.137</span></div>
</div>
</div>
</div>


<div class="__disk_root__" style="position: static;"></div><div></div></body></html>