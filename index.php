<?php
// Check Infos Git Hub
$URLINDEX = $_SERVER['PHP_SELF'];

require_once ( __DIR__ .'/config/.htconf.php' ) ;

$CURRUSER = $SESS->get('currentUser') ;

if ( isset($_GET['page']) && $_GET['page'] == 'userLogout' ) {
  $SESS->reset('currentUser');
  header("Location: ".$_SERVER['PHP_SELF']);  
}

if ( isset($_GET['page']) && $_GET['page'] == 'wdAdminPage' ) {
  header("Location: admin.php");  
}

if ( ! isset ( $CURRUSER ) ) {
  include($INCS . '/login.php' );
} else {
  $PROFILE= new profile ( $CONFDB ) ;
  $PROFILE->setUser( $CURRUSER ) ;
}


$CURRDB = $SESS->get('currentDB') ;

if ( isset($_GET['page']) && $_GET['page'] == 'dbLogout' ) {
  $SESS->reset('currentDB');
  header("Location: ".$_SERVER['PHP_SELF']);  
}

if ( ! isset ( $CURRDB ) ) {
  include($INCS . '/new_db.php' );
} else {
  $CURR_ORA_DB=new oradb ( $CONFDB, $SESS ) ;
  $cdb=$CURR_ORA_DB->connectDB( $CURRDB );
  
  if ( $cdb != $CURRDB ) {
    exit;
  }
}

$CURR_ORA_DB->setModule($APPNAME);

isset ( $_GET['page'] ) ? $PAGE=$_GET['page'] : $PAGE='dbHome' ;

$CURR_ORA_DB->setAction($PAGE);

require_once ( $INCS . '/head.php');
echo '<div class="container-fluid spantop">'.chr(10);
if ( is_file ($INCS . '/' . $PAGE . '.php') ) {
  include($INCS . '/' . $PAGE . '.php' );
} else {
  include($INCS . '/noPageForNow.php');
}
echo '</div>'.chr(10);

if ( is_file ($FRMS . '/' . $PAGE . '.js.php') ) {
  include ( $FRMS . '/' . $PAGE . '.js.php' );
}


require_once ( $INCS . '/foot.php');

$CURR_ORA_DB->close();
$CONFDB->close();
?>