<?php

require dirname(__DIR__, 2). '/conf.php';
try{

    Reply::_success(City::_list());

}catch(Exception $e){

}

