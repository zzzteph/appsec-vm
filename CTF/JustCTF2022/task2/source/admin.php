<?php

if (!empty($_POST['cmd'])) {
	$command = "ping -c 1 " . $_POST['cmd'];
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
      <li><span><strong>PING</strong></span></li>
      <li><a href="whois.php"><strong>WHOIS</strong></a></li>

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
<legend>Test the reachability of a host</legend>


<form action="" method="POST">
<div class="setting">
<div class="label">Hostname</div>
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
<dt class="term">Ping (networking utility)</dt>
<dd class="definition">ping is a computer network administration software utility used to test the reachability of a host on an Internet Protocol (IP) network.<br><br>The command-line options of the ping utility and its output vary between the numerous implementations. Options may include the size of the payload, count of tests, limits for the number of network hops (TTL) that probes traverse, and interval between the requests. Many systems provide a companion utility ping6, for testing on Internet Protocol version 6 (IPv6) networks, which implement ICMP6.</dd>
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