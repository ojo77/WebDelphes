<?php

class oradb {
  private $REPOSITORY;
  private $DB;
  private $SESS;
  
  private function setDBParams () {
	$sql='select EDITION, DATABASE_ROLE, DB_UNIQUE_NAME, OPEN_MODE, regexp_substr(VERSION,\'[0-9]+\') VERSION from v$instance natural join v$database';
	$stmt=oci_parse($this->DB , $sql);
	oci_execute($stmt);
	
	while ( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ) {
	  foreach ( $row as $k => $v ) {
		$this->SESS->set( $k, $v );
	  }
	}
  }
  
  private function checkCNX ( $U, $P, $H, $PRT, $ID, $SYS='N', $SRVC='Y' ) {
	if ( $SRVC == 'Y' ) {
		$cnx_string='//'.$H.':'.$PRT.'/'.$ID ;
	} else {
		$cnx_string='(description=(address=(host='.$H.')(protocol=tcp)(port='.$PRT.'))(connect_data=(sid='.$ID.')))';
	}
	
	if ( $SYS == 'Y' ) {
		$MODE=OCI_SYSDBA;
	} else {
		$MODE=OCI_DEFAULT;
	}
	
    $db = oci_pconnect( $U, $P, $cnx_string, null, $MODE );
	if (!$db) {
        $e = oci_error();
		return 'Not OK';
    } else {
		$this->DB=$db;
		$this->setDBParams();
		return 'OK';
	}
  }    

  function __construct ( $REPO, $SESS ) {    	
	$this->REPOSITORY=$REPO ;
	$this->SESS=$SESS;
  }
  
  function registerDB ( $A, $U, $P, $H, $PRT, $ID, $SYS='N', $SRVC='Y' ) {
     if ( $this->checkCNX( $U, $P, $H, $PRT, $ID, $SYS, $SRVC ) == 'OK' ) {
		$cPass=PChiffreR($P, $K) ;
		$alias="$U@//$H:$PRT/$ID ( $A )" ;
		
		$SYS == 'Y'  ? $sysdba=0  : $sysdba=-1  ;
		$SRVC == 'Y' ? $service=0 : $service=-1 ;
		
		$this->REPOSITORY->exec( "insert into databases values ( '$alias','$ID','$U','$cPass','$H',$PRT,'$K',$sysdba, $service, null, null, null, null)" ) ;
		return $alias;
	 } else {
		return null;
     }
  }
  
  function setDBParam ( $p, $v ) {
	$this->REPOSITORY->exec( "insert into db_parameters values ('". $GLOBALS['CURRDB']."', '$p', '$v' )") ;
  }
  
  function getDBParam ( $p ) {
	$r=$this->REPOSITORY->querySingle( "select value from db_parameters  where db_name='". $GLOBALS['CURRDB']."' and parameter='$p'") ;
	return $r[0];
  }
  
  function connectDB ( $DB ) {
	$res=$this->REPOSITORY->querySingle( "select * from databases where name='$DB'", true ) ;
    
	if ( !isset ($res['name']) ) {
	  return null;
	}
	
	$U=$res['user'];
    $P=PDechiffreR($res['passwd'],$res['spare']);
	$H=$res['host'];
	$PRT=$res['port'];
	$ID=$res['ID'];
	$res['sysdba'] == 0 ? $SYS='Y' : $SYS='N' ;
	$res['service'] == 0 ? $SRVC='Y' : $SRVC='N' ;
	
    if ( $this->checkCNX( $U, $P, $H, $PRT, $ID, $SYS, $SRVC ) == 'OK' ) {
	  return $DB;
	} else {
	  return null;
    }
  }
  
  function repoQuery ( $qName ) {
	$SQL="select text from ora_queries where name='$qName' and min_version = ( select max(min_version) from ora_queries where name='$qName' and min_version <= " . $this->SESS->get('VERSION') . " )";
	$sql=$this->REPOSITORY->querySingle( $SQL  ) ;
	
	$stmt=oci_parse($this->DB , $sql);
	oci_execute($stmt);

    $head=0;
	$res='';
	while ( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ) {
	  if ( $head == 0 ) {
		$res.= '"' . implode ( '","',array_keys($row) ) . '"' ;
		$head=1;
	  }
	  $fRow=array();
	  foreach ( $row as  $k => $v ) {
		if ( is_numeric($v) ) {
		  $fRow[]= $v ;
		} else {
		  $fRow[]='"'.$v.'"';
		}
      }
      $res.=chr(10) . implode ( ',',$fRow ) ;
	}  
	return $res;
  }
  
  function setModule ( $M ) {
	return oci_set_module_name( $this->DB, $M );
  }
  
  function setAction ( $A ) {
	return oci_set_action( $this->DB, $A );
  }
  
  function close() {
	oci_close($this->DB);
  }
  
}

?>