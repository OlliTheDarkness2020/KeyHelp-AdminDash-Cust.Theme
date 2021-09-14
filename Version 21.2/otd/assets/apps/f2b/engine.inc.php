<?php
require_once('config.inc.php');

function check_socket()
  {
    global $f2b;
    if(!file_exists($f2b['socket']))
      {
        return 'Socket - Verbindung nicht gefunden.';
      }
    elseif(!is_readable($f2b['socket']))
      {
        return 'Socket - Verbindung nicht lesbar.';
      }
    elseif(!is_writeable($f2b['socket']))
      {
        return 'Socket - Verbindung nicht schreibbar.';
      }
    return 'OK';
  }

function list_jails()
  {
    global $f2b;
    $jails=array();
    $erg=@exec('fail2ban-client status | grep "Jail list:" | awk -F ":" \'{print $2}\' | awk \'{$1=$1;print}\'');
    $erg=explode(",",$erg);
    foreach($erg as $i=>$j)
      {
        $jails[trim($j)]=false;
      }
    ksort($jails);
    return $jails;
  }

function jail_info($jail)
  {
    global $f2b;
    $info=array();
    $erg=@exec('fail2ban-client get '.escapeshellarg($jail).' findtime ');
    if(is_numeric($erg))
      {
        $info['findtime']='<b>Zeit</b>: '.$erg.' Sek.';
      }
    $erg=@exec('fail2ban-client get '.escapeshellarg($jail).' bantime ');
    if(is_numeric($erg))
      {
        $info['bantime']='<b>Ban</b>: '.$erg.' Sek.';
      }
    $erg=@exec('fail2ban-client get '.escapeshellarg($jail).' maxretry ');
    if(is_numeric($erg))
      {
        $info['maxretry']='<b>Funde</b>: '.$erg.' St.';
      }
    return $info;
  }

function list_banned($jail)
  {
    global $f2b;
    $banned=array();
    $erg=@exec('fail2ban-client status '.$jail.' | grep "IP list:" | awk -F ":" \'{print$2}\' | awk \'{$1=$1;print}\'');
    if($erg!='')
      {
        $banned=explode(" ",$erg);
        if($f2b['usedns']===true)
          {
            foreach($banned as $i=>$cli)
              {
                $dns=gethostbyaddr($cli);
                if($dns==$cli)
                  {
                    $dns=' (Unbekannt)';
                  }
                else
                  {
                    $dns=' ('.$dns.')';
                  }
                $banned[$i].=$dns;
              }
          }
        return $banned;
      }
    return false;
  }

function ban_ip($jail,$ip)
  {
    if($jail=='')
      {
        return 'Kein JAIL ausgewählt.';
      }
    elseif(!filter_var($ip,FILTER_VALIDATE_IP))
      {
        return 'Keine gültige IP-Adresse.';
      }
    $erg=@exec('fail2ban-client set '.escapeshellarg($jail).' banip '.escapeshellarg($ip));
    if($erg!=$ip)
      {
        return 'IP kann nicht gebannt werden.';
      }
    return 'OK';
  }

function unban_ip($jail,$ip)
  {
    if($jail=='')
      {
        return 'Kein JAIL ausgewählt.';
      }
    elseif(!filter_var($ip,FILTER_VALIDATE_IP))
      {
        return 'Keine gültige IP-Adresse.';
      }
    $erg=@exec('fail2ban-client set '.escapeshellarg($jail).' unbanip '.escapeshellarg($ip));
    if($erg!=$ip)
      {
        return 'IP kann nicht entbannt werden.';
      }
    return 'OK';
  }

?>
