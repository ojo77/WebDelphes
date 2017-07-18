<?php
$URLINDEX = $_SERVER['PHP_SELF'] . '/..';
require_once ( __DIR__ .'/../config/.htconf.php' ) ;

$CURRUSER = $SESS->get('currentUser') ;
$PROFILE= new profile ( $CONFDB ) ;
$PROFILE->setUser( $CURRUSER ) ;

$CURRDB = $SESS->get('currentDB') ;
$CURR_ORA_DB=new oradb ( $CONFDB, $SESS ) ;
$cdb=$CURR_ORA_DB->connectDB( $CURRDB );

if ( $cdb != $CURRDB ) {
  exit -1 ;
}

$CURR_ORA_DB->setModule($APPNAME);

if ( ! isset($CURRUSER) || ! isset($CURRDB) ) {
  exit -1 ;
}

if ( !isset( $_GET['qname']) ) {
  exit -1 ;
}

$CURR_ORA_DB->setAction($_GET['qname']);


$sqltext = $CURR_ORA_DB->repoQuery( $_GET['qname'] );
echo $sqltext;

$CURR_ORA_DB->close();
?>