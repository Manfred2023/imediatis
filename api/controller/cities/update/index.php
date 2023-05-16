<?php


header('Content-Type: application/json');

if (!require realpath(dirname(__DIR__, 3)) . '/conf.php')
    http_response_code(403);




try { 

    # Check required fields
    Criteria::_formRequiredCheck([CITYNAME, ALPHA2], $_POST);
    $city = City::_get(Criteria::TOKEN, $_POST[TOKEN]);
    $country = Country::_get(Criteria::ALPHA2, $_POST[ALPHA2]);
    if (!($city instanceof City))
        Reply::_error('not_found');
    $city->setName($_POST[CITYNAME]);

    if (!($country instanceof Country))
        Reply::_error("Country isn't already register, make sure to register it first!");
    $city->setCountry($country);

    $c = $city->save();
    if ($c instanceof City)
        Reply::_success($c->toArray());  

    Reply::_error('sorry!!! could not update the city');
} catch (Exception $exception) {
    Reply::_exception($exception);
}