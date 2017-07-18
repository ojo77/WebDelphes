<?php

require_once ( __DIR__ . '/mustache/src/Mustache/Autoloader.php' );
Mustache_Autoloader::register();

class template {
  private $DB;
  private $TMPL; 
  private $TMPL_NAME;
  private $LEX=array();
  
  private function load_from_file ( $F ) {
	$h=fopen ( $F, 'r');
    $this->TMPL = fread($h, filesize($F));
    fclose($h);
  }
  
  function __construct ( $DB, $T ) {    
    global $FRMS ;
	
	if ( !isset($FRMS) ) {
	  $FRMS= __DIR__ . '/../forms' ;
	}
	
	$this->DB=$DB ;
	$TMPL=$this->DB->querySingle('select * from templates where name =\'' . $T . '\'', true);
	
	if ( isset($TMPL['file_name']) ) {
      $f=$FRMS . '/' . $TMPL['file_name'] ;
	  $this->TMPL_NAME=$T;
	  $this->load_from_file( $f );
	  $this->LEX['this_page']=$T;
	} else {
	  return null;
	}
	
  }
  
  function addLex ( $k, $v ) {
	$this->LEX[$k]=$v;
  }
  
  function render( $L = null ) {
	global $LANG;
	
	if ( !isset($LANG) ) {
	  $LANG= 'en' ;
	}
	
	$T=$this->TMPL;
	
	$r=$this->DB->query ( 'select l.lex, case when d.value is null then l.def_val else d.value end val from templates_lex_list l left join template_dict d on d.t_name = l.t_name and d.lex=l.lex and d.lang=\''.$LANG.'\' where l.t_name=\''. $this->TMPL_NAME.'\''); 

	
	while ( $row = $r->fetchArray(SQLITE3_NUM) ) {
		$this->LEX[$row[0]]=$row[1] ;
	}

	$r=$this->DB->query ( 'select lex, val from global_dict'); 
	
	while ( $row = $r->fetchArray(SQLITE3_NUM) ) {
		$this->LEX[$row[0]]=$row[1] ;
	}
	
	$r=$this->DB->query ( 'select lex_grp, query from template_queries where t_name=\''. $this->TMPL_NAME.'\''); 
    	
	while ( $row = $r->fetchArray(SQLITE3_NUM) ) {
		$s=$this->DB->query ( $row[1] );
    	while ( $l = $s->fetchArray(SQLITE3_ASSOC) ) {
		    $this->LEX[$row[0]][]=$l ;
		}
	}
	
	
	$m=new Mustache_Engine ;
	$T=$m->render( $T, $this->LEX);
	
	return $T ;
  }
  
  
 }
?>