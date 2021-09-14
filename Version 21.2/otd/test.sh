#!/bin/bash

logpfade="/home/keyhelp/www/keyhelp/theme/otd/stats"
zeit=`date +%d.%m.%Y_%H:%M`

case "$1" in
  smart)
  echo Entferne alte Logdaten ...
  rm $logpfade/smart.log
  rm $logpfade/raid.log
  echo Lese S.M.A.R.T Werte ...
  befehl="smartctl -HA"
  platten=$(ls /dev/sd[a-z$])
  array=( $platten )
  for i in "${array[@]}"
  do
  echo Festplatte : $i >> $logpfade/smart.log
  $befehl $i | grep -E 'Temperature_Celsius|SMART overall-health' | sed 's/-/ :/g' | sed 's/all :hea/allhea/g' | sed 's/self :a/selfa/g' >> $logpfade/smart.log
  done
  echo S.M.A.R.T Status ermittelt und abgelegt.
  unset zeit
  unset logpfade
	;;

  raid)
  echo Starte auslesen des RAID Status.
  cat /proc/mdstat | grep -E 'md' | cut -c '1-13' >> $logpfade/raid.log
  echo RAID Status ermittelt und abgelegt.
  unset zeit
  unset logpfade
	;;

  both)
  echo Entferne alte Logdaten ...
  rm $logpfade/smart.log
  rm $logpfade/raid.log
  echo Lese S.M.A.R.T Werte ...
  befehl="smartctl -HA"
  platten=$(ls /dev/sd[a-z$])
  array=( $platten )
  for i in "${array[@]}"
  do
  echo Festplatte : $i >> $logpfade/smart.log
  $befehl $i | grep -E 'Temperature_Celsius|SMART overall-health' | sed 's/-/ :/g' | sed 's/all :hea/allhea/g' | sed 's/self :a/selfa/g' >> $logpfade/smart.log
  done
  echo
  echo S.M.A.R.T Status ermittelt und abgelegt.
  echo
  echo Starte auslesen des RAID Status.
  cat /proc/mdstat | grep -E 'md' | cut -c '1-13' >> $logpfade/raid.log
  echo RAID Status ermittelt und abgelegt.
  unset zeit
  unset logpfade
	;;

  ubu-both)
  echo Entferne alte Logdaten ...
  rm $logpfade/smart.log
  rm $logpfade/raid.log
  echo Lese S.M.A.R.T Werte ...
  befehl="smartctl -HA"
  platten=$(ls /dev/sd[a-z$])
  array=( $platten )
  for i in "${array[@]}"
  do
  echo Festplatte : $i >> $logpfade/smart.log
  sudo $befehl $i | grep -E 'Temperature_Celsius|SMART overall-health' | sed 's/-/ :/g' | sed 's/all :hea/allhea/g' | sed 's/self :a/selfa/g' &>>$logpfade/smart.log 2>&1
  done
  echo
  echo S.M.A.R.T Status ermittelt und abgelegt.
  echo
  echo Starte auslesen des RAID Status.
  cat /proc/mdstat | grep -E 'md' | cut -c '1-13' >>$logpfade/raid.log 2>&1
  echo RAID Status ermittelt und abgelegt.
  unset befehl
  unset platten
  unset array
  unset zeit
  unset logpfade
	;;

  ubu-smart)
  echo Entferne alte Logdaten ...
  rm $logpfade/smart.log
  echo Lese S.M.A.R.T Werte ...
  befehl="smartctl -HA"
  platten=$(ls /dev/sd[a-z$])
  array=( $platten )
  for i in "${array[@]}"
  do
  echo Festplatte : $i >> $logpfade/smart.log
  sudo $befehl $i | grep -E 'Temperature_Celsius|SMART overall-health' | sed 's/-/ :/g' | sed 's/all :hea/allhea/g' | sed 's/self :a/selfa/g' &>>$logpfade/smart.log 2>&1
  done
  echo
  echo S.M.A.R.T Status ermittelt und abgelegt.
  unset befehl
  unset platten
  unset array
  unset zeit
  unset logpfade
	;;

  ubu-raid)
  echo Entferne alte Logdaten ...
  rm $logpfade/raid.log
  echo Starte auslesen des RAID Status.
  cat /proc/mdstat | grep -E 'md' | cut -c '1-13' >>$logpfade/raid.log 2>&1
  echo RAID Status ermittelt und abgelegt.
  unset befehl
  unset platten
  unset array
  unset zeit
  unset logpfade
	;;

  *)
	echo "Fehlerhafte Eingabe: Nutzung wie folgt: /home/keyhelp/www/keyhelp/theme/otd/test.sh { Für DEBIAN: smart|raid|both / Für UBUNTU: ubu-smart|ubu-raid|ubu-both}" || true
	unset befehl
	unset platten
	unset array
        unset zeit
        unset logpfade
	exit 1
esac

exit 0
