<?php
$wdb=new sqlite3( __DIR__ . './.words.db' );

$SEPLIST = '-_';
$sep=$SEPLIST[rand(0, strlen($SEPLIST)-1)];

function f1 ( &$a ) {
  foreach ( $a as $k => $v ) {
	  $a[$k]=ucfirst($v);
  }  
}

function f2 ( &$a ) {
  foreach ( $a as $k => $v ) {
	  $a[$k]=str_replace(array('a','e','i'),array('@','3','I'),$v);
  } 
  return '<li>convert a to @ </li>'.chr(10).'<li> convert e to 3 </li>'.chr(10).'<li> convert i to I</li>'.chr(10) ;  
}

function f3 ( &$a ) {
  foreach ( $a as $k => $v ) {
	  $a[$k]=str_replace(array('o','a','e'),array('0','4','E'),$v);
  }  
  return '<li>convert o to 0 </li>'.chr(10).'<li> convert a to 4 </li>'.chr(10).'<li> convert e to E</li>'.chr(10) ;  
}

function f4 ( &$a ) {
  foreach ( $a as $k => $v ) {
	  $a[$k]=str_replace(array('i','a','o'),array('!','4','O'),$v);
  }  
  return '<li> convert i to ! </li>'.chr(10).'<li> convert a to 4 </li>'.chr(10).'<li> convert o to O</li>'.chr(10) ;  
}

function f5 ( &$a ) {
  foreach ( $a as $k => $v ) {
	  $a[$k]=str_replace(array('u','e','a'),array('V','3','A'),$v);
  }  
  return '<li> convert u to V </li>'.chr(10).'<li> convert e to 3 </li>'.chr(10).'<li> convert a to A</li>'.chr(10) ;  
}

function f6 ( &$a ) {
  foreach ( $a as $k => $v ) {
	  $a[$k]=str_replace(array('u','i','a'),array('V','1','@'),$v);
  }  
  return '<li> convert u to V </li>'.chr(10).'<li> convert i to 1 </li>'.chr(10).'<li> convert a to @</li>'.chr(10) ;  
}

function f7 ( &$a ) {
  foreach ( $a as $k => $v ) {
	  $a[$k]=str_replace(array('o','e','a'),array('0','E','@'),$v);
  }  
  return '<li> convert o to 0 </li>'.chr(10).'<li> convert e to E </li>'.chr(10).'<li> convert a to @</li>'.chr(10) ;  
}

function f8 ( &$a ) {
  foreach ( $a as $k => $v ) {
	  $a[$k]=str_replace(array('i','e','a'),array('1','E','@'),$v);
  }  
  return '<li> convert i to 1 </li>'.chr(10).'<li> convert e to E </li>'.chr(10).'<li> convert a to @</li>'.chr(10) ;  
}

function f9 ( &$a ) {
  foreach ( $a as $k => $v ) {
	  $a[$k]=str_replace(array('s','e','a'),array('5','E','A'),$v);
  }  
  return '<li> convert s to 5 </li>'.chr(10).'<li> convert e to E </li>'.chr(10).'<li> convert a to A</li>'.chr(10) ;  
}

function f10 ( &$a ) {
  foreach ( $a as $k => $v ) {
	  $a[$k]=str_replace(array('s','e','i'),array('z','3','!'),$v);
  }  
  return '<li> convert s to z </li>'.chr(10).'<li> convert e to 3 </li>'.chr(10).'<li> convert i to !</li>'.chr(10) ;  
}



$sql='SELECT w
      FROM w
      WHERE _ROWID_ >= (abs(random() ) % (SELECT max(_ROWID_) FROM w )) 
      LIMIT 1 ';

if ( isset($_GET['sz']) ) {
 $SZ=$_GET['sz'] ;
} else {
 $SZ=4 ;
}

$words=array();

for ( $i=0 ; $i < $SZ ; $i++ ) {	
 $r=$wdb->querySingle($sql);
 $words[$i]=$r ;
}

//var_dump($words);

$e='<li>'.$SZ.' words ( '.implode(', ',$words).' )</li> '.chr(10);

if ( rand( 3, 101 ) % 2  == 0 ) {
 f1($words);
 $e.='<li>Uppercase first letter for every eord</li>'.chr(10);
} else {
 $e.='<li>lowercase every word</li>';
}

$e.='<li>Word separator "'.$sep.'"</li>'.chr(10);
switch ( rand(2, 10) ) {
case  2 : $e.=f2 ($words); break;
case  3 : $e.=f3 ($words); break;
case  4 : $e.=f4 ($words); break;
case  5 : $e.=f5 ($words); break;
case  6 : $e.=f6 ($words); break;
case  7 : $e.=f7 ($words); break;
case  8 : $e.=f8 ($words); break;
case  9 : $e.=f9 ($words); break;
case 10 : $e.=f10($words); break;
}
echo implode($sep, $words );

//var_dump($words);
//
//echo '<ol>Rules'.chr(10);
//echo $e.chr(10) ;
//echo '</ol>'.chr(10);
?>