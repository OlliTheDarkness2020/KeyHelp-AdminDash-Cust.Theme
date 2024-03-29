<?php
include_once 'setting.php';

$tsdebug = "ohno";

$panel_version = '21.1.1';

/* String Funktion Beginn */
function get_string_between($string, $start, $end) {
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini+= strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
/* String Funktion Ende */

if (filemtime('setting.php') > filemtime('setting_block.json'))
  {
    $blockfile = array(
      'block_news' => $block_news,
      'block_server' => $block_server,
      'block_resources' => $block_resources,
      'block_notes' => $block_notes,
      'block_applications' => $block_applications,
      'block_service' => $block_service,
      'block_teamspeak' => $block_teamspeak,
      'block_smart' => $block_smart,
      'block_raid' => $block_raid,
      'block_temperatur' => $block_temperatur
    );
    $blockjson = json_encode($blockfile);
    $handle = fopen("setting_block.json", "w");
    fwrite($handle, $blockjson);
    fclose($handle);
  }

$stylecss = '
		<style type="text/css">
		<!--
		.alignleftfooter {
			float: left;
			width:50%;
			text-align:left;
		  }
		.alignrightfooter {
		   float: right;
		   width:50%;
		   text-align:right;
		  }​
		/* @group Blink */
		.blink {
			-webkit-animation: blink .75s linear infinite;
			-moz-animation: blink .75s linear infinite;
			-ms-animation: blink .75s linear infinite;
			-o-animation: blink .75s linear infinite;
			 animation: blink .75s linear infinite;
		}
		@-webkit-keyframes blink {
			0% { opacity: 1; }
			50% { opacity: 1; }
			50.01% { opacity: 0; }
			100% { opacity: 0; }
		}
		@-moz-keyframes blink {
			0% { opacity: 1; }
			50% { opacity: 1; }
			50.01% { opacity: 0; }
			100% { opacity: 0; }
		}
		@-ms-keyframes blink {
			0% { opacity: 1; }
			50% { opacity: 1; }
			50.01% { opacity: 0; }
			100% { opacity: 0; }
		}
		@-o-keyframes blink {
			0% { opacity: 1; }
			50% { opacity: 1; }
			50.01% { opacity: 0; }
			100% { opacity: 0; }
		}
		@keyframes blink {
			0% { opacity: 1; }
			50% { opacity: 1; }
			50.01% { opacity: 0; }
			100% { opacity: 0; }
		}
		/* @end */
		-->
		</style>
	';

switch ($_GET["realtime"])
  {

/* Service Monitor Beginn */

    case 'raid':
        /* --------- RAID STATUS --------- */
        echo $stylecss;
        $raid = "/home/keyhelp/www/keyhelp/theme/otd/stats/raid.log";
        if (file_exists($raid)) {
            $fp = fopen($raid, "r");
            if ($fp) {
                $zeile = 0;
                while (!feof($fp)) {
                    @$rinhalt[] = explode(":", fgets($fp));
                    @$rinhalt[count($rinhalt) - 1][0];
                    @$rinhalt[count($rinhalt) - 1][1];
                    $zeile++;
                }
                fclose($fp);
            }
        } else {
            @$rinhalt = NULL;
            echo '<b>Vermutlich lief der Cronjob noch nicht.<br />Entweder warten Sie bis zur Ausführung des Cron oder führen folgenden Befehl auf der Shell aus:<br /><br />"/home/keyhelp/www/keyhelp/theme/otd/test.sh raid"<br /><br />Danach sollte diese Meldung verschwunden und die Werte angezeigt werden.';
        }
        echo '
				<div class="table-container">
				<table class="table is-fullwidth is-striped">
					<colgroup>
						<col span="1" style="width: 80%;">
						<col span="1" style="width: 20%;">
					</colgroup>
				<tbody>
				<tr>
					<th><u>Verbund</u></th>
					<th><center><u>Status</u></center></th>
				</tr>
				';
        if (@$rinhalt == NULL) {
            echo '<tr><td><b>Fehler:</b></td><td>Datei nicht gefunden !</td></tr>';
        } else {
            if (@$rinhalt[0][0] != NULL) {
                echo '<tr><td><b> ' . @$rinhalt[0][0] . ' </b></td><td><center> ' . @$rinhalt[0][1] . ' </center></td></tr>';
            }
            if (@$rinhalt[1][0] != NULL) {
                echo '<tr><td><b> ' . @$rinhalt[1][0] . ' </b></td><td><center> ' . @$rinhalt[1][1] . ' </center></td></tr>';
            }
            if (@$rinhalt[2][0] != NULL) {
                echo '<tr><td><b> ' . @$rinhalt[2][0] . ' </b></td><td><center> ' . @$rinhalt[2][1] . ' </center></td></tr>';
            }
            if (@@$rinhalt[3][0] != NULL) {
                echo '<tr><td><b> ' . @$rinhalt[3][0] . ' </b></td><td><center> ' . @$rinhalt[3][1] . ' </center></td></tr>';
            }
            if (@@$rinhalt[4][0] != NULL) {
                echo '<tr><td><b> ' . @$rinhalt[4][0] . ' </b></td><td><center> ' . @$rinhalt[4][1] . ' </center></td></tr>';
            }
        }
        echo '
				</tbody>
				</table>
				</div>
				<div align="right"><b>Stand</b>: ' . date("d. F Y - H:i:s", filemtime($raid)) . ' Uhr</div>
				';
        exit();
    break;

    case 'smart':
        /* --------- SMART STATUS --------- */
        echo $stylecss;
        $smart = "/home/keyhelp/www/keyhelp/theme/otd/stats/smart.log";
        if (file_exists($smart)) {
            $fp = fopen($smart, "r");
            if ($fp) {
                $zeile = 0;
                while (!feof($fp)) {
                    @$inhalt[] = explode(":", fgets($fp));
                    @$inhalt[count(@$inhalt) - 1][0];
                    @$inhalt[count(@$inhalt) - 1][1];
                    $zeile++;
                }
                fclose($fp);
            }
        } else {
            @$inhalt = NULL;
            echo '<b>Vermutlich lief der Cronjob noch nicht.<br />Entweder warten Sie bis zur Ausführung des Cron oder führen folgenden Befehl auf der Shell aus:<br /><br />"/home/keyhelp/www/keyhelp/theme/otd/test.sh"<br /><br />Danach sollte diese Meldung verschwunden und die Werte angezeigt werden.';
        }
        echo '
					<div class="table-container">
						<table class="table is-fullwidth is-striped">
						<colgroup>
							<col span="1" style="width: 60%;">
							<col span="1" style="width: 20%;">
							<col span="1" style="width: 20%;">
						</colgroup>
					<tbody>
					<tr>
						<th><u>Festplatte</u></th>
						<th><center><u>Temp.</u></center></th>
						<th><center><u>Status</u></center></th>
					</tr>
					';
        if (@$inhalt == NULL) {
            echo '<b>Vermutlich lief der Cronjob noch nicht.<br />Entweder warten Sie bis zur Ausführung des Cron oder führen folgenden Befehl auf der Shell aus:<br /><br />"/home/keyhelp/www/keyhelp/theme/otd/test.sh smart"<br /><br />Danach sollte diese Meldung verschwunden sein und die Werte angezeigt werden.';
        } else {
            if (@$inhalt[0][0] == "Festplatte ") {
                echo '<tr><td><b> ' . @$inhalt[0][1] . ' </b></td><td><center>' . @$inhalt[2][1] . ' </center></td><td><center> ' . @$inhalt[1][1] . ' </center></td></tr>';
            }
            if (count(@$inhalt) > "2") {
                if (@$inhalt[3][0] == "Festplatte ") {
                    echo '<tr><td><b> ' . @$inhalt[3][1] . ' </b></td><td><center> ' . @$inhalt[5][1] . ' </center></td><td><center> ' . @$inhalt[4][1] . ' </center></td></tr>';
                }
                if (count(@$inhalt) > "5") {
                    if (@$inhalt[6][0] == "Festplatte ") {
                        echo '<tr><td><b> ' . @$inhalt[6][1] . ' </b></td><td><center> ' . @$inhalt[8][1] . ' </center></td><td><center> ' . @$inhalt[7][1] . ' </center></td></tr>';
                    }
                    if (count(@$inhalt) > "8") {
                        if (@$inhalt[9][0] == "Festplatte ") {
                            echo '<tr><td><b> ' . @$inhalt[9][1] . ' </b></td><td><center> ' . @$inhalt[11][1] . ' </center></td><td><center> ' . @$inhalt[10][1] . ' </center></td></tr>';
                        }
                        if (count(@$inhalt) > "11") {
                            if (@$inhalt[12][0] == "Festplatte ") {
                                echo '<tr><td><b> ' . @$inhalt[12][1] . ' </b></td><td><center> ' . @$inhalt[14][1] . ' </center></td><td><center> ' . @$inhalt[13][1] . ' </center></td></tr>';
                            }
                        }
                    }
                }
            }
        }
        echo '
					</tbody>
					</table>
					</div>
					<div align="right"><b>Stand</b>: ' . date("d. F Y - H:i:s", filemtime($smart)) . ' Uhr</div>
				 ';
        exit();
    break;

    case 'teamspeak3':
        /* --------- TEAMSPEAK STATUS --------- */
        echo $stylecss;
        require_once ('assets/vendor/teamspeak3/TeamSpeak3.php');
        echo '
  				<div class="table-container">
  				<table class="table is-fullwidth is-striped">
  					<colgroup>
  						<col span="1" style="width: 40%;">
  						<col span="1" style="width: 30%;">
  						<col span="1" style="width: 10%;">
  						<col span="1" style="width: 20%;">
  					</colgroup>
  				<tbody>
  				<tr>
  					<th><u>Server Name</u></th>
  					<th><center><u>IP</u></center></th>
  					<th><center><u>Status</u></center></th>
  					<th><center><u>Start / Stop</u></center></th>
  				</tr>
  			';
        foreach ($tsserver as $idx => $val) {
            $all_array[] = [$val, $tsquery[$idx], $tsport[$idx], $tsuser[$idx], $tspass[$idx]];
        }
        foreach ($all_array as $item) {
            try {
                $uri = "serverquery://" . $item[3] . ":" . $item[4] . "@" . $item[0] . ":" . $item[1];
                $ts3 = TeamSpeak3::factory($uri);
                try {
                    session_start(['cookie_lifetime' => 43200]);
                    $uri = "serverquery://" . $item[3] . ":" . $item[4] . "@" . $item[0] . ":" . $item[1] . "/?server_port=" . $item[2];
                    $_SESSION["_TS3_" . $item[0] . $item[2]] = serialize($uri);
                    session_write_close();
                    $ts3 = TeamSpeak3::factory($uri);
                    echo '
  								<tr>
  									<td><b>' . $ts3->virtualserver_name . '</b></td>
  									<td> <center> <i class="far fa-eye" title="' . $item[0] . ':' . $item[2] . '"></i> </center> </td>
  									<td> <center> <font color="green"> Online </font> </center> </td>
  									<td> <center> <a onclick="getStat(\'stop\', ' . $item[2] . ', \'' . $item[0] . $item[2] . '\')"> <i class="far fa-stop-circle fa-lg"></i> </a> </center> </td>
  								</tr>
  							';
                }
                catch(Exception $e) {
                    echo '
  									<tr>
  										<td> <b> ---- </b> </td>
  										<td> <center> <h4>' . $item[0] . ':' . $item[2] . '</h4> </center> </td>
  										<td> <center> <font class="tab blink" color="red"> Offline </font> </center> </td>
  										<td> <center> <a onclick="getStat(\'start\', ' . $item[2] . ', \'' . $item[0] . $item[2] . '\')"> <i class="far fa fa-play-circle fa-lg"></i> </a> </center> </td>
  									</tr>
  								';
                }
            }
            catch(Exception $e) {
                echo '
  							<tr>
  								<td colspan="4"><font class="tab blink" color="red">Hostsystem <b>' . $item[0] . ':' . $item[2] . '</b> nicht erreichbar !</font> <br /> <font color="red"> Bitte die Datei "setting.php" und ggf. den Host prüfen !</font></td>
  							</tr>
  						';
            }
        }
        echo '
  					</tbody>
  				</table><div>
  				<p class="alignleftfooter" id="ts3stat"></p>
  				<p class="alignrightfooter"><b>Stand</b>: ' . date("H:i:s", time()) . ' Uhr</p>
  				</div></div>
  				';
        exit();
    break;

    case 'teamspeak3_controller':
        /* --------- TEAMSPEAK Controller --------- */
        require_once ('assets/vendor/teamspeak3/TeamSpeak3.php');
        $tscontrol = $_GET["tscontrol"];
        $tskey = $_GET["tskey"];
        $tsp = $_GET["tsp"];
        session_start(['cookie_lifetime' => 43200]);
        $uri = unserialize($_SESSION["_TS3_" . $tskey]);
        $ts3port = intval(substr($uri, strrpos($uri, "=") + 1));
        $ts3ip = get_string_between($uri, '@', ':');
        $ts3 = TeamSpeak3::factory(substr($uri, 0, strpos($uri, '/?server')));
        $ts3id = $ts3->serverIdGetByPort($ts3port);
        if ($tscontrol == 'start') {
            if ($tsdebug === "ohyes") {
                $ts3->message("Debug: Server gestartet ! (No Action, wir sind im Test Mode)");
            } else {
                $ts3->serverStart($ts3id);
            }
            echo '{"servinst": "<b> Server ' . $ts3ip . ':' . $ts3port . ' gestartet! </b>"}';
            exit();
        }
        if ($tscontrol == 'stop') {
            if ($tsdebug === "ohyes") {
                $ts3->message("Debug: Server gestoppt ! (No Action, wir sind im Test Mode)");
            } else {
                $ts3->serverStop($ts3id, "Der Server wurde durch den Anbieter abgeschaltet! ");
            }
            echo '{"servinst": "<b> Server ' . $ts3ip . ':' . $ts3port . ' gestoppt! </b>"}';
            exit();
        }
        if ($tscontrol == 'del') {
            if ($tsdebug === "ohyes") {
                $ts3->message("Debug: Server gelöscht ! (No Action, wir sind im Test Mode)");
            } else {
                $ts3->serverDelete($ts3id);
            }
            echo '{"servinst": "<b> Server gelöscht ! </b>"}';
            exit();
        }
        exit();
    break;

    case 'dashversion':
        /* --------- Rückmeldung zur Version --------- */
        echo $panel_version;
        exit();
    break;

    case 'temperatur':
        /* --------- Temperatur Status --------- */
        echo $stylecss;
         $readtempsys1 = @fopen("/sys/devices/virtual/thermal/thermal_zone0/temp","r");
         $tempsys1 = @fgets($readtempsys1);
         $systemp1 = @round($tempsys1/1000);

         $readtempsys2 = @fopen("/sys/devices/virtual/thermal/thermal_zone1/temp","r");
         $tempsys2 = @fgets($readtempsys2);
         $systemp2 = @round($tempsys2/1000);

         $readtempcpu = @fopen("/sys/devices/virtual/thermal/thermal_zone2/temp","r");
         $tempcpu = @fgets($readtempcpu);
         $cputemp = @round($tempcpu/1000);

         if ($systemp1 <= 35)
          {
            $temp1color = 'is-success';
          }
         if ($systemp1 > 35)
          {
            $temp1color = 'is-warning';
          }
         if ($systemp1 > 50)
          {
            $temp1color = 'is-danger blink';
          }

         if ($systemp2 <= 35)
          {
            $temp2color = 'is-success';
          }
         if ($systemp2 > 35)
          {
            $temp2color = 'is-warning';
          }
         if ($systemp2 > 50)
          {
            $temp2color = 'is-danger blink';
          }

         if ($cputemp <= 50)
          {
            $cpucolor = 'is-success';
          }
         if ($cputemp > 50)
          {
            $cpucolor = 'is-warning';
          }
         if ($cputemp > 70)
          {
            $cpucolor = 'is-danger blink';
          }
         @fclose($readtempsys1);
         @fclose($readtempsys2);
         @fclose($readtempcpu);
        echo '
      		<div class="table-container">
      		<table class="table is-fullwidth is-striped">
      			<colgroup>
      				<col span="1" style="width: 40%;">
      				<col span="1" style="width: 20%;">
      				<col span="1" style="width: 40%;">
      			</colgroup>
      		<tbody>
      		<tr>
      			<th><u>Sensor</u></th>
      			<th><center><u>°C</u></center></th>
      			<th><center><u> </u></center></th>
      		</tr>
      		';
            echo '
          				<tr>
          					<td><b> System Temp 1 </b></td>
          					<td>
          						<center>
          							' . $systemp1 . ' °C
          						</center>
          					</td>
          					<td>
          						<center>
          							<progress class="progress is-xsmall '.$temp1color.'" value="' . $systemp1 . '" max="100"></progress>
          						</center>
          					</td>
          				</tr>
                  <tr>
          					<td><b> System Temp 2 </b></td>
          					<td>
          						<center>
          							' . $systemp2 . ' °C
          						</center>
          					</td>
          					<td>
          						<center>
          							<progress class="progress is-xsmall '.$temp2color.'" value="' . $systemp2 . '" max="100"></progress>
          						</center>
          					</td>
          				</tr>
                  <tr>
          					<td><b> CPU Temp </b></td>
          					<td>
          						<center>
          							' . $cputemp . ' °C
          						</center>
          					</td>
          					<td>
          						<center>
          							<progress class="progress is-xsmall '.$cpucolor.'" value="' . $cputemp . '" max="100"></progress>
          						</center>
          					</td>
          				</tr>
          			';
        echo '
          	</tbody>
          </table>
          </div>
          <div align="right"><b>Stand</b>: ' . date("H:i:s", time()) . ' Uhr</div>
      		';
        exit();
    break;

        /* Service Monitor Ende */
    default:
        echo 'Keine Ausgabe gewählt oder Daten fehlerhaft.';
        exit();
    break;
}
/* SWITCH LISTE Ende */
?>

<br />

<?php
emergency_lock_active:
    if ($_GET["realtime"] === "teamspeak3_controller")
      {

      }
    else
      {
        echo '<b> <u> <p style="text-align: center;"> Created 2021 by OlliTheDarkness </p> </u> </b>';
      }
?>
