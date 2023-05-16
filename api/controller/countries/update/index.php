<?php


header('Content-Type: application/json');

if (!require realpath(dirname(__DIR__, 3)) . '/conf.php')
    http_response_code(403);




try { 

    # Check required fields
    Criteria::_formRequiredCheck([CNAMEFR, CNAMEFR, CODE, ALPHA2, ALPHA3, DIALCODE], $_POST);
    $country = Country::_get(Criteria::ALPHA2, $_POST[ALPHA2]);
    if (!($country instanceof Country))
        Reply::_error('not_found');
    $country->setNamefr($_POST[CNAMEFR]);
    $country->setNameen($_POST[CNAMEEN]);
    $country->setCode($_POST[CODE]);
    $country->setAlpha2($_POST[ALPHA2]);
    $country->setAlpha3($_POST[ALPHA3]);
    $country->setDialcode($_POST[DIALCODE]);

    $c = $country->save();
    if ($c instanceof Country)
        Reply::_success($c->toArray());

    Reply::_error('sorry!!! could not register the new country');
} catch (Exception $exception) {
    Reply::_exception($exception);
}
