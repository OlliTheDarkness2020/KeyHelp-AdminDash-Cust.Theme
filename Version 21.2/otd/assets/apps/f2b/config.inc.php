<?php

$f2b['socket']='/run/fail2ban/fail2ban.sock'; # path to the Fail2Ban socket file (Must CMDOD to 777)
$f2b['usedns']=true; # show hostnames per banned IP [true|false]
$f2b['noempt']=false; # do not show jails without banned clients [true|false]
$f2b['jainfo']=true; # show jail information in table headers [true|false]

$f2b['version']='0.10.2';

?>
