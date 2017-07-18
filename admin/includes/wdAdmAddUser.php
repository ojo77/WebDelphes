<?php 
function aff_form_addUser () {
	global $INCS ;
	global $CONFDB ;
	
    $form_add_user=new template ( $CONFDB, 'wdAdmAddUser' );
        
    echo '<div class="jumbotron col-md-8 col-md-offset-2 spantop">' . chr(10);
    echo $form_add_user->render() ;
    echo '</div>'.chr(10) ;
}

if ( isset($_POST['btnCancel'])) {
	header("Location: admin.php"); 
	exit ;
}

if ( isset ($_POST['uname']) && $_POST['uname'].'toto' != 'toto' ) {
  
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
  aff_form_addUser();	  
  exit;
}

if ( ! isset ( $cdb ) ) {
  $CURR_ORA_DB=null;
  aff_form_addUser();	  
  exit;
} else {
  $SESS->set('currentDB',$cdb);
  $CURRDB=$cdb;  
}
?>