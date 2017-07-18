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
  exit;
}

if ( ! isset($CURRUSER) || ! isset($CURRDB) ) {
  exit -1;
}

if ( !isset( $_GET['qname']) ) {
  exit -1 ;
}

$sqltext = $CURR_ORA_DB->repoQueryJson( $_GET['qname'] );
echo $sqltext;

?>