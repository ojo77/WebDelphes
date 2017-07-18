<?php
// Affichage du formulaire de login applicatif
// 
// Who When        What
// --- ----------- --------------------------------------------------------------------------
// OJO 2017/01/15  Creation
// OJO 2017/01/16  Formulaire dans un "jumbotron" 

function aff_form () {
	global $INCS ;
	global $CONFDB ;
	
    $form_login=new template ( $CONFDB, 'wdUserLogin' );
        
    require_once ( $INCS . '/head.php');
    echo '<div class="row justify-content-center spantop">'.chr(10);
    echo '<div class="jumbotron col-4">' . chr(10);
    echo $form_login->render() ;
    echo '</div>'.chr(10) ;
    echo '</div>'.chr(10) ;
    require_once ( $INCS . '/foot.php');
}

if ( isset ($_POST['userName']) && $_POST['userName'].'toto' != 'toto' ) {
  $PROFILE=new profile ( $CONFDB ) ;
  $CURRUSER = $PROFILE->connect ( $_POST['userName'], $_POST['UserPass'] );
  if ( ! isset ( $CURRUSER ) ) {
	$PROFILE=null;
    aff_form();		
    exit;
  } else {
	$SESS->set('currentUser',$CURRUSER);
  }
} else {
  $PROFILE=null;
  aff_form();	  
  exit;
}

?>