<?php

$URLINDEX = $_SERVER['PHP_SELF'];
$CONTEXT='ADM';

require_once ( __DIR__ .'/config/.htconf.php' ) ;

$GINC = $INCS;
$FRMS = $ROOT . '/admin/forms' ;
$INCS = $ROOT . '/admin/includes';

$CURRUSER = $SESS->get('currentUser') ;

if ( ! isset ( $CURRUSER ) ) {
	header("Location: index.php"); 
	exit ;
} else {
  $PROFILE= new profile ( $CONFDB ) ;
  $PROFILE->setUser( $CURRUSER ) ;
}

$MYROLES=$PROFILE->getRoles();

if ( null == isset($MYROLES['admin']) && null == isset($MYROLES['useradmin']) && null == isset($MYROLES['dbadmin']) ) {
	header("Location: useradmin.php"); 
	exit ;
}


$CURRDB = $SESS->get('currentDB') ;

if ( isset ( $CURRDB ) ) {
  $CURR_ORA_DB=new oradb ( $CONFDB, $SESS ) ;
  $cdb=$CURR_ORA_DB->connectDB( $CURRDB );
  
  if ( $cdb != $CURRDB ) {
    exit;
  }
}

isset ( $_GET['page'] ) ? $PAGE=$_GET['page'] : $PAGE='dbHome' ;

require_once ( $GINC . '/head.php');
echo '<div class="container col-md-12 spantop">'.chr(10);
if ( is_file ($INCS . '/' . $PAGE . '.php') ) {
  include($INCS . '/' . $PAGE . '.php' );
} else {
  include($GINC . '/noPageForNow.php');
}
echo '</div>'.chr(10);
require_once ( $GINC . '/foot.php');

if ( isset( $CURR_ORA_DB ) ) {
  $CURR_ORA_DB->close();
}
$CONFDB->close();
?>