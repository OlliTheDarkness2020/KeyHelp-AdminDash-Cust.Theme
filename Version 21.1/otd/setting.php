<?php
/*	Custom Block Anzeige Aktivierung (true)	/ Deaktivierung (false) */

	$block_teamspeak 	= 'false';		// TeamSpeak Status
	$block_smart	 	= 'false';		// S.M.A.R.T Status - NUR BEI ROOT- NICHT BEI VSERVERN MÖGLICH
	$block_raid	 	= 'false';		// RAID Status - NUR BEI ROOT- NICHT BEI VSERVERN MÖGLICH
	$block_temperatur	= 'false';		// Temperatur Status - NUR BEI ROOT- NICHT BEI VSERVERN MÖGLICH
	$block_f2b 		= 'true';		// F2B Status

/*	KeyHelp Block Anzeige Aktivierung (true) / Deaktivierung (false) */

	$block_news 		= 'false';		// News Block
	$block_service 		= 'false';		// Service / Port Status
	$block_notes 		= 'false';		// Notiz Block
	$block_applications	= 'true';		// Anwendungen Block
	$block_resources	= 'true';		// Ressourcen Block
	$block_server		= 'true';		// Server Block

/*	>>TeamSpeak3 Konfiguration<<	*/

  $tsserver	= array('1.1.1.1' , '2.2.2.2');

  $tsquery 	= array('10011' , '10011');

  $tsport  	= array('9987' , '9987');

  $tsuser	= array('serveradmin' , 'serveradmin');

  $tspass	= array('KENNWORT' , 'KENNWORT');

?>
