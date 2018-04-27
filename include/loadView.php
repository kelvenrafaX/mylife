<?php
//Cuspindo as Views de acordo com a URL
if($module == 'cadastro'){
  include 'views/'.$module.'/gerador.php';
}
else{
  if($module != ''){
    if($page != ' '){
      if(file_exists('views/'.$module.'/'.$page.'/index.php')){
        include 'views/'.$module.'/'.$page.'/index.php';
      }
    } else {
      if(file_exists('views/'.$module.'/index.php')){
        include 'views/'.$module.'/index.php';
      }
    }
  } else {
    if(file_exists('views/home.php')){
      include 'views/home.php';
    }
  }
}
?>
