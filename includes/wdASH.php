<?php
if ( null == ( $ashTool = $CURR_ORA_DB->getDBParam('metrics_pack') ) ) {
  include ( __DIR__ . '/checkASH.php' ) ;
}


?>