<?php


class repository extends sqlite3 {
    
    private $DBREPO ;
    private $SESSDB ;
    
    function __construct( $repo = __DIR__ .'/../config/.repo.sqlite', $sess_db = null) {
        $this->open( $repo );
        if ( isset($sess_db) and $sess_db != null ){
            $this->SESSDB=new sqlite3 ($sess_db) ;
        }
    }
    
    function getDBInfos ( $ID ) {
      return $this->querySingle( 'select * from dbs where db_id=' . $ID , true) ;    
    }
        
    function getDBList ( ) {
      $ret=array();
      
      $r=$this->query( 'select db_id, name, db_type from dbs') ;    
      
      while ( $lg = $r->fetchArray(SQLITE3_ASSOC) ) {
       $ret[]=$lg;
      }

      return $ret ;
    }
    
    function getJsLibs () {
      $ret=" <!-- JS Libs /-->\n";
      $css=" <!-- CSS for js Libs /-->\n";
      $r=$this->query('select * from js_libs order by sort_col'); 

      while ( $lg = $r->fetchArray(SQLITE3_ASSOC) ) {
        if ( isset ($lg['location']) && $lg['location'] != '' ) {
            $ret.=" <!-- ".$lg['name']."  /-->\n" ;
            $ret.="  <script src=\"".$lg['location']."\" type=\"text/javascript\"></script>\n" ;
        }
       if ( isset ($lg['css_location']) && $lg['css_location'] != '' ) {
        $locs=explode(',',$lg['css_location']) ;
        foreach ($locs as $location ) {
          $css.="  <link rel=\"stylesheet\"  href=\"".$location."\">\n" ;
        }
       }
       $ret.="\n";
      }   
      $ret.="$css\n";      
      return $ret;
    }
    
    function addRefDB( $user, $psw, $cnx, $superUsr, $db_type, $name) {
      
      $GLOBALS['DEBUGTXT'].="<h6>dbRepository::addRefDB ( $user, $psw, $cnx, $superUsr, $db_type, $name )</h6>\n";

      if (isset($superUsr) && $superUsr == 'y') {
        $SUVal="'y'" ;
      } else {
        $SUVal='null' ;
      }

      $cPsw=pChiffreR( $psw, $pKey );
      $sql="insert into dbs (name, user, connection_descriptor, password, db_type, spare1, spare2 ) 
                     values ('".$name."', '".$user."', '".$cnx."', '".$cPsw."', '".$db_type."', ".$SUVal.", '".$pKey."')";
      
      $this->exec($sql);

      return 0 ;
    }

    function setDBType ( $dbType ) {
      $this->DBREPO=new dbRepository($dbType) ;
    }
    
    function &getSessDB () {
        if (isset( $this->SESSDB ) ) {
            return $this->SESSDB ;
        } else {
            return $this ;
        }
    } 
}

?>