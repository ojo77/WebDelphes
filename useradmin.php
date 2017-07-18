<?php

$URLINDEX = $_SERVER['PHP_SELF'];

require_once ( __DIR__ .'/config/.htconf.php' ) ;
$FRMS = $ROOT . '/admin/forms' ;

$CURRUSER = $SESS->get('currentUser') ;

if ( ! isset ( $CURRUSER ) ) {
	header("Location: index.php"); 
	exit ;
} 


?>