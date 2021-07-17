<?php
/*	Custom Block Anzeige Aktivierung (true)	/ Deaktivierung (false) */

	$block_teamspeak 	= 'true';		// TeamSpeak Status
	$block_smart	 	= 'false';		// S.M.A.R.T Status - NUR BEI ROOT- NICHT BEI VSERVERN MÖGLICH
	$block_raid	 	= 'false';		// RAID Status - NUR BEI ROOT- NICHT BEI VSERVERN MÖGLICH
	$block_temperatur	= 'false';		// Temperatur Status - NUR BEI ROOT- NICHT BEI VSERVERN MÖGLICH

/*	KeyHelp Block Anzeige Aktivierung (true) / Deaktivierung (false) */

	$block_news 		= 'true';		// News Block
	$block_service 		= 'true';		// Service / Port Status
	$block_notes 		= 'true';		// Notiz Block
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
