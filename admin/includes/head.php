<?php
  echo "\n<!-- \n";
  print_r ($GLOBALS);
  echo "\n-->\n";

?>
<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title><?php if ( isset($pageTitle) ) { echo $pageTitle ; } else { echo $GLOBALS['APPNAME'] ; } ?></title>
  <link rel="shortcut icon" href="./media/logo_64.png">
  
  <link rel="stylesheet" href="./js/bs/fa/css/font-awesome.min.css">
  <link rel="stylesheet" href="./js/bs/css/bootstrap.min.css" crossorigin="anonymous">
  <link rel="stylesheet" href="./js/bs/css/bootstrap-theme.min.css" crossorigin="anonymous">
      
  <script src="./js/jq/jq.js"></script>
  <script src="./js/bs/js/bs.js" crossorigin="anonymous"></script>  
  <style>
  .spantop {
	margin-top: 70px;
  }
  
  .icon-primary { color: #337ab7; }
  .icon-success { color: #5cb85c; }
  .icon-info    { color: #5bc0de; }
  .icon-warning { color: #f0ad4e; }
  .icon-danger  { color: #d9534f; }
  
  </style>
</head>
<body>
<?php
  if ( isset ( $GLOBALS['CURR_ORA_DB'] ) ) {
    $MENU=new menu ( $GLOBALS['CONFDB'], $GLOBALS['PROFILE'], $GLOBALS['CURR_ORA_DB'] );
  } else if ( isset ( $GLOBALS['PROFILE'] ) ) {
    $MENU=new menu ( $GLOBALS['CONFDB'], $GLOBALS['PROFILE'] );
  } else {
	$MENU=new menu ( $GLOBALS['CONFDB'] );
  }
  
  echo $MENU->render() . "\n";
  
?>