<?php
// Affichage du formulaire de login applicatif
// 
// Who When        What
// --- ----------- --------------------------------------------------------------------------
// OJO 2017/01/15  Creation
// OJO 2017/01/16  Formulaire dans un "jumbotron" 

function aff_form_logdb () {
	global $INCS ;
	global $CONFDB ;
	
    $form_login=new template ( $CONFDB, 'wdDBLogin' );
    $form_lstdb=new template ( $CONFDB, 'wdDBLstLg' );
        
    require_once ( $INCS . '/head.php');
    echo '<div class="jumbotron col-md-6 col-md-offset-3 spantop">' . chr(10);
    echo $form_lstdb->render() ;
    echo $form_login->render() ;
    echo '</div>'.chr(10) ;
    require_once ( $INCS . '/foot.php');
}

$CURR_ORA_DB=new oradb ( $CONFDB, $SESS ) ;
  
if ( isset ($_POST['HostName']) && $_POST['HostName'].'toto' != 'toto' ) {
  
  if ( ! isset( $_POST['PortNbr'] ) || $_POST['PortNbr'].'toto' == 'toto' ) {
	  $portNbr='1521' ;
  } else {
	  $portNbr=$_POST['PortNbr'] ;
  }
    
  if ( $_POST['asSysDBA'] == 2 ) {
	$sysdba='N';
  } else {
	$sysdba='Y';
  }
  
  if ( $_POST['service'] == 2 ) {
	$service='N';
  } else {
	$service='Y';
  }
  
  $cdb=$CURR_ORA_DB->registerDB( $_POST['DBName'], $_POST['UserName'], $_POST['UserPass'], $_POST['HostName'], $portNbr, $_POST['DBSID'], $sysdba, $service  );
    
} else if ( isset ($_POST['dbList']) && $_POST['dbList'].'toto' != 'toto' ) {
  $cdb=$CURR_ORA_DB->connectDB( $_POST['dbList'] );
} else {
  $CURR_ORA_DB=null;
  aff_form_logdb();	  
  exit;
}

if ( ! isset ( $cdb ) ) {
  $CURR_ORA_DB=null;
  aff_form_logdb();	  
  exit;
} else {
  $SESS->set('currentDB',$cdb);
  $CURRDB=$cdb;  
}

?>