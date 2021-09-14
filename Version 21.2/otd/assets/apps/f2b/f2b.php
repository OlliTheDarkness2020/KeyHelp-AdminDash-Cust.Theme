<?php
require_once('engine.inc.php');

if(isset($_POST['f2b-submit']))
  {
    $error2=ban_ip($_POST['ban_jail'],$_POST['ban_ip']);
    if($error2!='OK')
      {
        $error2=' <font class="f2b-msg_er"> '.$error2.' </font> ';
      }
    else
      {
        $error2=' <font class="f2b-msg_ok"> IP wurde erfolgreich gebannt ! </font> ';
    	   unset($_POST); clearstatcache(); sleep(1);
      }
  }

if($_GET['j']!='' && $_GET['c']!='')
  {
    $error1=unban_ip($_GET['j'],$_GET['c']);
    if($error1!='OK')
      {
        $error1=' <font class="f2b-msg_er"> '.$error1.' </font> ';
      }
    else
      {
        $error1=' <font class="f2b-msg_ok"> IP wurde erfolgreich entbannt. </font> ';
  	    unset($_GET); clearstatcache(); sleep(1);
      }
  }

$chk=check_socket();

if($chk!='OK')
  {
    echo ' <p class="f2b-msg_er"> '.$chk.' </p> ';
    exit;
  }

$jails=list_jails();

foreach($jails as $j=>$i)
  {
    $banned=list_banned($j); $jails[$j]=$banned;
  }
?>

<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="theme/otd/assets/apps/f2b/f2b.css" type="text/css" charset="utf-8">
    <title> Fail2Ban Web für KeyHelp by OTD </title>
  </head>
    <body>
      <h2 style="font-weight: bold; text-decoration: underline; text-align: center; font-size: larger;"> Gebannte IPs per Jail </h2>
      <p> <?=$error1?> </p>
      <table class="table" style="border: none;">
        <?php
          foreach($jails as $j=>$cli)
            {
              if($f2b['noempt']===false || is_array($cli))
                {
                  echo ' <tr> <td style="font-weight: bold;	background-color: #fffd83; text-align: center; text-decoration: underline;" colspan="2"> '.strtoupper($j);
                  if($f2b['jainfo']===true)
                    {
                      $inf=jail_info($j);
                      $inf=implode(', ',$inf);
                      echo ' <span style="color: #666; font-weight: normal;"> <br/> '.$inf.' </span>';
                    }

                  echo ' </td> </tr> ';

                  if(is_array($cli))
                    {
                      foreach($cli as $i=>$c)
                        {
                          $ip=strstr($c,'(',true);
                        	echo
                            '
                            <tr>
                              <td align="center">
                                <a href="'.$_SERVER['PHP_SELF'].'?j='.$j.'&c='.$ip.'"> <img src="theme/otd/assets/apps/f2b/images/del.gif" alt="del" title="IP entbannen"> </a>
                              </td>
                              <td align="center">
                                TEST' .$c. '
                              </td>
                            </tr>
                            '
                          ;
                        }
                    }
                  else
                    {
                      echo
                        '
                          <tr>
                            <td colspan="2" style="font-weight: bold; color: #666; font-style: italic; text-align: center;"> Keine IPs gebannt </td>
                          </tr>
                        '
                      ;
                    }
                }
            }
        ?>
      </table>
      <br />
      <h2 style="font-weight: bold; text-decoration: underline; text-align: center; font-size: larger;"> Eigenen Ban zum Jail hinzufügen </h2>
      <form method="POST" action="<?=$_SERVER['PHP_SELF']?>">
        <p> <?=$error2?> </p>
        <table class="table" style="margin-left:auto; margin-right:auto;">
          <tr>
           <td>
            <select class="select" name="ban_jail" size="1">
            <option value="">- Jail wählen -</option>
            <?php
              foreach($jails as $j=>$cli)
                {
                  echo ' <option value="'.$j.'" ';
                  if($_POST['ban_jail']==$j)
                    {
                      echo ' selected';
                    }
                  echo '>'.$j.'</option>';
                }
            ?>
            </select>
           </td>
          </tr>
          <tr>
           <td>
             <input class="input" type="text" name="ban_ip" size="18" placeholder="IP-Adresse" value="<?=$_POST['ban_ip']?>">
           </td>
          </tr>
          <tr class="has-text-centered">
           <td colspan="2">
             <button type="submit" class="center" name="f2b-submit"> IP bannnen </button>
           </td>
          </tr>
        </table>
      </form>
      <br />
      <p style="color: #666; font-style: italic; font-weight: normal;"> F2B - Version: <?=$f2b['version']?> </p>
    </body>
</html>
