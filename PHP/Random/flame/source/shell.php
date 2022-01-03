<?php
/*
$server="dc.appsec";
$dn = "cn=admin, "; 
$password="S7uzxjUA5SPvQ6T8"
$basedn="ou=users, ou=accounts, dc=domain, dc=com";

if (!($connect = ldap_connect($server))) { 
   die ("Could not connect to LDAP server"); 
} 

if (!($bind = ldap_bind($connect, "$dn" . "$basedn", $password))) {        
   die ("Could not bind to $dn"); 
} 

$sr = ldap_search($connect, $basedn,"$filter"); 
$info = ldap_get_entries($connect, $sr); 
$fullname=$info[0]["displayname"][0]; 
$fqdn=$info[0]["dn"]; 






*/




