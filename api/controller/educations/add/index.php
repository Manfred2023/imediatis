<?php


header('Content-Type: application/json');

if (!require realpath(dirname(__DIR__, 3)) . '/conf.php')
    http_response_code(403);




try {

    # Check required fields
    Criteria::_formRequiredCheck([SCHOOL, DIPLOMA,STUDYFIELD, SRTMONTH, SRTYEAR, ENDMONTH, ENDYEAR, ASSOCIATION, CONTACT], $_POST);

    if (!($contact = Contact::_get(Criteria::TOKEN, trim($_POST[CONTACT]))) instanceof Contact)
        Reply::_error("Contact isn't already register, make sure to register it first!");

    $education = (new Education(null,null, $_POST[SCHOOL], $_POST[DIPLOMA], $_POST[STUDYFIELD], $_POST[SRTMONTH], $_POST[SRTYEAR], 
    $_POST[ENDMONTH],$_POST[ENDYEAR], $_POST[ASSOCIATION], $contact))->save();
    if ($education instanceof Education)
        Reply::_success($education->toArray());

    Reply::_error('sorry!!! could not register the new education');
} catch (Exception $exception) {
    Reply::_exception($exception);
}