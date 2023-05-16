<?php


header('Content-Type: application/json');

if (!require realpath(dirname(__DIR__, 3)) . '/conf.php')
    http_response_code(403);




try {

    # Check required fields
    Criteria::_formRequiredCheck([ POSITION, COMPANY, PLACE, TYPEPLACE,SRTMONTH, SRTYEAR, ENDMONTH, ENDYEAR, CONTRACT, DESCRIPTION, CONTACT], $_POST);

    if (!($contact = Contact::_get(Criteria::TOKEN, trim($_POST[CONTACT]))) instanceof Contact)
        Reply::_error("Contact isn't already register, make sure to register it first!");

    $experience = (new Experience(null,null, $_POST[POSITION], $_POST[COMPANY], $_POST[PLACE], $_POST[TYPEPLACE], $_POST[SRTMONTH], 
    $_POST[SRTYEAR], $_POST[ENDMONTH],$_POST[ENDYEAR], $_POST[CONTRACT], $_POST[DESCRIPTION], $contact))->save();
    if ($experience instanceof Experience)
        Reply::_success($experience->toArray());

    Reply::_error('sorry!!! could not register the new experience');
} catch (Exception $exception) {
    Reply::_exception($exception);
}