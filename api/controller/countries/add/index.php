<?php


header('Content-Type: application/json');

if (!require realpath(dirname(__DIR__, 3)) . '/conf.php')
    http_response_code(403);




try {

    # Check required fields
    Criteria::_formRequiredCheck([CNAMEFR, CNAMEFR, CODE, ALPHA2, ALPHA3, DIALCODE], $_POST);

    $country = (new Country(null, $_POST[CNAMEFR], $_POST[CNAMEEN], $_POST[CODE], $_POST[ALPHA2], $_POST[ALPHA3], $_POST[DIALCODE]))->save();
    if ($country instanceof Country)
        Reply::_success($country->toArray());

    Reply::_error('sorry!!! could not register the new country');
} catch (Exception $exception) {
    Reply::_exception($exception);
}
