<?php

  $npfn=new template ( $CONFDB, 'noPageForNow' );
  $npfn->addLex( 'URLINDEX', $URLINDEX );
  echo $npfn->render() ;

?>

