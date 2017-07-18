<?php
class menu {
  private $DB;
  private $PROF=null;
  private $ORA=null;
  private $LEX=array();
  
  private function get_menu ( $ctx, $p, $l = null ) {
	$ret=null ;
	$whc=' where l_r_menu=\''.$p.'\''.chr(10);
	
	if ( isset ($l) ) {
	  $whc.='  and parent_id=\''.$l.'\'';
	} else {
      $whc.='  and parent_id is null';
    }	  
	
	if ( !isset($this->PROF) ) {
	  $whc.='  and need_user=-1';
	} 
	
	if ( !isset($this->ORA) && $ctx != 'ADM' ) {
	  $whc.='  and need_db=-1';
	}
	
	$whc.='  and menu_context in (\'A\',\''.$ctx.'\')';

    $results=$this->DB->query('select lex, icon, target_page, id, menu_context mc from menu_items '.$whc.' order by position');
	while ($row = $results->fetchArray()) {
      $cntnt='';

	  if ( $row['mc'] == 'A' || $row['mc'] == 'R' ) {
		$tgt_page='index.php';
	  }
	  
	  if ( $row['mc'] == 'ADM' ) {
		$tgt_page='admin.php';
	  }
	  
      
      if ( isset($row['icon']) ) {
      	$cntnt.='<span class="fa '.$row['icon'].'"></span> ';
      }
      
      if ( isset($row['lex']) && $row['lex'] != '' ) {
      	$cntnt.='{{'.$row['lex'].'}}';
      }
      $subMenu=$this->get_menu($ctx, $p, $row['id']);
	  if ( isset ( $subMenu ) ) {
		$ret.='     <li class="nav-item dropdown">'.chr(10);
		$ret.='      <a href="#" class="nav-link dropdown-toggle"  id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button" aria-haspopup="true" aria-expanded="false" id="navbarDropdown'.$row['id'].'">'.$cntnt.'</a>'.chr(10);
		$ret.='      <div class="dropdown-menu" aria-labelledby="navbarDropdown'.$row['id'].'">'.chr(10);
		$ret.=$subMenu.chr(10) ;
		$ret.='      </div>';
		$ret.='     </li>'.chr(10);
      } else {
		if ( ! isset($l) ) {
  		$ret.='     <li class="nav-item"><a class="nav-link" href="'.$tgt_page.'?page='.$row['target_page'].'">'.$cntnt.'</a></li>'.chr(10);
		} else {
	  	$ret.='<a class="dropdown-item" href="'.$tgt_page.'?page='.$row['target_page'].'">'.$cntnt.'</a>';			
		}
	  }
    }
	return $ret;	
  }
  
  function __construct ( $DB, $PROFILE=null, $ORADB=null ) {
	$this->DB=$DB;	
	if ( isset ( $PROFILE ) ) {
	  $this->PROF=$PROFILE ;
	}
	if ( isset ( $ORADB ) ) {
	  $this->ORA=$ORADB ;
	}
  }
  
  function render( $C ) {
	$m='<nav class="navbar navbar-toggleable-md navbar-light bg-faded fixed-top">   
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
	  <a class="navbar-brand" href="index.php">        
       <img style="max-width:50px; margin-top: -15px;" src="./media/logo_32.png" alt="WEB DELPHES" >
    </a>
   <div id="navbar" class="navbar-collapse collapse">'.chr(10);
	$m.='   <ul class="navbar-nav  mr-auto">'.chr(10);
	$m.=$this->get_menu( $C, 'l' );
	$m.='   </ul>'.chr(10);
	$m.='   <ul class="navbar-nav">'.chr(10);
	$m.=$this->get_menu( $C, 'r' );
	$m.='   </ul>'.chr(10);
	$m.='  </div>'.chr(10);
//	$m.=' </div>'.chr(10);
	$m.='</nav>'.chr(10);
	
	$r=$this->DB->query ( 'select l.lex, case when d.value is null then l.def_val else d.value end val from menu_lex_list l left join menu_dict d on d.lex=l.lex and d.lang=\''.$GLOBALS['LANG'].'\' '); 

	
	while ( $row = $r->fetchArray(SQLITE3_NUM) ) {
		$this->LEX[$row[0]]=$row[1] ;
	}

	$r=new Mustache_Engine ;
	$m=$r->render( $m, $this->LEX);
	
	return $m ;
  }
  
}
?>