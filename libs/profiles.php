<?php

class profile {
  private $DB;
  private $USER;
  private $ROLES=array();
  
  private function setRoles () {
	$rslt=$this->DB->query('select profile from userProfiles where user_name =\'' . $this->USER . '\'');
    while ($row = $rslt->fetchArray(SQLITE3_ASSOC)) {
        $this->ROLES[$row['profile']]='true';
    }
  }
  
  function __construct ( $DB ) {    
	$this->DB=$DB ;
  }
  
  function connect ( $U, $P ) {
	$USER=$this->DB->querySingle('select * from users where name =\'' . strtoupper($U) . '\'', true);
    if ( ! isset ( $USER['password'] ) ) {
      return null ;
    }
	
    $pass=$USER['password'] ;
    $k1=$USER['k1'];	
    $k2=$USER['k2'];
	
    if ( $pass == PVerifU( strtoupper($U), $P, $k1, $k2) ) {
	  $this->USER=strtoupper($U);
	  $this->setRoles();
	  return strtoupper($U) ;
    } else { 
	  return null ;
	}
  }
  
  function getRoles () {
	return $this->ROLES ;
  }
  
  function setUser ( $U ) {
    $this->USER=strtoupper($U);
	$this->setRoles();
  }
}
?>