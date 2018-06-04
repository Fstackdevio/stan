<?php 
  echo dirname(__FILE__) . '<br>';
  echo getcwd(). '<br>';
  echo $_SERVER['DOCUMENT_ROOT']. '<br>';
  echo  dirname(dirname(dirname(__FILE__))) . '\\' . 'uploads\\' . '</br>';
    $a =  __dir__;
  $pathInPieces = explode('/',$a);
  print_r( $pathInPieces );


