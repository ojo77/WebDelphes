<?php

function aff_form_checkAsh () {
	global $INCS ;
	global $CONFDB ;
	
    $form=new template ( $CONFDB, 'checkASH' );
	
	$form->addLex('this_page',$_GET['page']);
        
    echo '<div class="jumbotron col-md-6 col-md-offset-3 spantop">' . chr(10);
    echo $form->render() ;
    echo '</div>'.chr(10) ;
}

  
if ( isset ($_POST['radios']) && $_POST['radios'].'toto' != 'toto' ) {
  $CURR_ORA_DB->setDBparam('metrics_pack',$_POST['radios']) ;
  $ashTool=$_POST['radios'] ;
} else {
  aff_form_checkAsh();	  
  exit;
}


?>