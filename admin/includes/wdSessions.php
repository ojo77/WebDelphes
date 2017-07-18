<?php
    $layout=new layout ( $CONFDB, 'wdSessions' );
    require_once ( $INCS . '/head.php');
    echo $layout->render() ;
?>