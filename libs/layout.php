<?php

class layout {
  private $DB;
  private $TMPL; 
  private $TMPL_NAME;
  private $LEX=array();
  
  private function get_layout ( $l = null ) {
	$ret=null ;
	$whc=' where layout_name=\''.$this->TMPL_NAME.'\'';
	
	if ( isset ($l) ) {
	  $whc.='  and parent_id=\''.$l.'\'';
	} else {
      $whc.='  and parent_id is null';
    }	  
	
    $results=$this->DB->query('select name, size, title_lex, id, title_pre_icon, title_post_icon, toggle_icon, type, span_class from layout '.$whc.' order by position');
	while ($row = $results->fetchArray()) {
	  
	  if ( isset( $row['name'] ) ) {
		$nm=' id="'.$row['name'].'"';
	  } else {
		$nm='';
	  }

		if ( $row['type'] != 'row' ) {       
			if ( isset( $row['size'] ) && $row['size'] != '' ) {
			$sz=' col-'.$row['size'];
			} else {
			$sz=' col';
			}
		} else {
			$sz='';
		}
	  
	  if ( isset( $row['type'] ) ) {
		$tp=' '.$row['type'];
	  } else {
		$tp='';
	  }
	  
	  if ( "$tp$sz" !== '' ) {
        $cl=' class="'.trim("$tp$sz").'"';
	  } else {
		$cl='';
	  }
	  
	  if ( isset( $row['title_lex'] ) && $row['title_lex'] != '' ) {
		$lx= '{{' . $row['title_lex'] . '}}';
	  } else {
		$lx='';
	  }
	  
	  if ( isset( $row['span_class'] ) && $row['span_class'] != '' ) {
		$sc= '<span class="' . $row['span_class'] . '"></span> ';
	  } else {
		$sc='';
	  }
	  
            
	  if ( isset( $row['title_pre_icon'] ) && $row['title_pre_icon'] !== '' ) {
		$ic='<i class="fa ' . $row['title_pre_icon'] . '"></i> ';
	  } else {
		$ic='';
	  }
            
	  if ( isset( $row['title_post_icon'] ) && $row['title_post_icon'] !== '' ) {
		$ci='<i class="fa ' . $row['title_post_icon'] . '"></i> ';
        if ( isset( $row['toggle_icon'] ) && $row['toggle_icon'] == 0 ) {
          $ci='<button class="btn btn-warning btn-sm reset" style="float: right;margin-right: 5px; display: none;" type="button" onclick="javascript:'. $row['name'] .'.filterAll(); dc.renderAll();">'. $ci . '</button>' ;
        } else {
          $ci='<button class="btn btn-warning btn-sm reset" style="float: right;margin-right: 5px;" type="button" onclick="javascript:'. $row['name'] .'.filterAll(); dc.renderAll();">'. $ci . '</button>' ;
        }			
	  } else {
		$ci='';
	  }
            
	  if ( "$ic$sc$lx$ci" !== '' ) {
		$ti="    <h6>$ic$sc$lx$ci</h6>";
	  } else {
		$ti='';
	  }

      $subMenu=$this->get_layout($row['id']);
	  
	    if ( !isset ( $subMenu ) ) {
		    $subMenu=chr(10) ;
      } 
	    $ret.="<div$cl$nm>\n$ti$subMenu</div>\n"; 
    }
	return $ret;	
  }

// -------------------------------------------------------------------------------- 
// PUBLIC FUNCTIONS
// CONSTRUCTOR
// --------------------------------------------------------------------------------

  function __construct ( $DB, $T ) {    
    global $FRMS ;
	
	$this->DB=$DB ;
	$this->TMPL_NAME=$T;
	$this->TMPL=$this->get_layout();
  }
  
// -------------------------------------------------------------------------------- 
// addLex function ==> adding a lex and its value for mustache
// -------------------------------------------------------------------------------- 

  function addLex ( $k, $v ) {
	$this->LEX[$k]=$v;
  }
  
// -------------------------------------------------------------------------------- 
// render function ==> returns html / bootstrap style layout 
// -------------------------------------------------------------------------------- 

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
	
	$m=new Mustache_Engine ;
	$T=$m->render( $T, $this->LEX);
	
	return $T ;
  }
  
  
 }
?>