<?php
// In SQLITE3 DB session management

session_start();

class sqlite_sess {
  private $sessID ;
  private $DB;
  
  private function cleanSession($DF) {
	  $this->DB->exec('delete from sessions where lastActive < \'' . $DF . '\'');
	  $this->DB->exec('delete from session_params where sess_id not in (select sess_id from sessions)');
  }
  
  function __construct ( &$DB, $sessDuration = 60 ) {
    $this->sessID=session_id();
    $this->DB=$DB;
    
    $DT=date('YmdHis');
    $DF=date('YmdHis', time() - ( $sessDuration * 60 )) ;
    
    $this->cleanSession($DF) ;
    $this->DB->exec('insert or replace into sessions values (\'' . $this->sessID . '\',' . $DT . ')');
  }
  
  function set( $P, $V ){
	  $this->DB->exec('insert into session_params values ( \'' . $this->sessID . '\', \'' . $P . '\', \'' . $V . '\' )');
  }
  
  function get( $P ){
	  return $this->DB->querySingle('select value from session_params where sess_id =\'' . $this->sessID . '\' and param=\'' . $P . '\''); 
  }
  
  function reset( $P ){
	  $this->DB->exec('delete from session_params where sess_id =\'' . $this->sessID . '\' and param=\'' . $P . '\''); 
  }
}

?>