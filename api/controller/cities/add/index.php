<?php


header('Content-Type: application/json');

if (!@require realpath(dirname(__DIR__, 3)) . '/conf.php')
    http_response_code(403);




try {
    # Check required fields
    Criteria::_formRequiredCheck([CITYNAME, COUNTRY], $_POST);
    if (!($country = Country::_get(Criteria::ALPHA2, trim($_POST[COUNTRY]))) instanceof Country)
        Reply::_error("Country isn't already register, make sure to register it first!");

    $city = (new City(NULL,NULL, $_POST[CITYNAME] , $country))->save(); 


    if ($city instanceof City)
        Reply::_success($city->toArray());

    Reply::_error('sorry!!! could not register the new city');
    if ($city instanceof City)
        Reply::_success($city->toArray());

    Reply::_error('sorry!!! could not register the new city');

    

    
} catch (Exception $exception) {
    Reply::_exception($exception);
}


