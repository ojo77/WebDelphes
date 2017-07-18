<?php
/*  echo "\n<!-- \n";
  print_r ($GLOBALS);
  echo "\n-->\n";
*/  
  $jsLibs=$CONFDB->getJsLibs();
?>
<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title><?php if ( isset($pageTitle) ) { echo $pageTitle ; } else { echo $GLOBALS['APPNAME'] ; } ?></title>
  <link rel="shortcut icon" href="./media/logo_64.png">
<?php
 echo $jsLibs ;
?>
  <link rel="stylesheet" type="text/css" href="./webdelphes.css">
</head>
<body>
<?php
  if ( isset ( $GLOBALS['CURR_ORA_DB'] ) ) {
    $MENU=new menu ( $GLOBALS['CONFDB'], $GLOBALS['PROFILE'], $GLOBALS['CURR_ORA_DB'] );
  } else if ( isset ( $GLOBALS['PROFILE'] ) ) {
    $MENU=new menu ( $GLOBALS['CONFDB'], $GLOBALS['PROFILE'] );
  } else {
	$MENU=new menu ( $GLOBALS['CONFDB'] );
  }
  if ( ! isset($CONTEXT) ) {
	  $CONTEXT='R';
  }
  
  echo $MENU->render($CONTEXT) . "\n";
  
?>