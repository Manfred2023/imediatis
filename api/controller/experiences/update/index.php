<?php


header('Content-Type: application/json');

if (!require realpath(dirname(__DIR__, 3)) . '/conf.php')
    http_response_code(403);




try { 

    # Check required fields
    Criteria::_formRequiredCheck([POSITION, COMPANY, PLACE, TYPEPLACE, SRTMONTH, SRTYEAR, ENDMONTH, ENDYEAR, CONTRACT, DESCRIPTION, CONTACT], $_POST);
    $experience = Experience::_get(Criteria::TOKEN, $_POST[TOKEN]);
    $contact = Contact::_get(Criteria::TOKEN, $_POST[CONTACT]);
    if (!($experience instanceof Experience))
        Reply::_error('not_found');

    $experience->setPosition($_POST[POSITION]);
    $experience->setCompany($_POST[COMPANY]);
    $experience->setPlace($_POST[PLACE]);
    $experience->setTypeofplace($_POST[TYPEPLACE]);
    $experience->setStartmonth($_POST[SRTMONTH]);
    $experience->setStartyear($_POST[SRTYEAR]);
    $experience->setEndmonth($_POST[ENDMONTH]);
    $experience->setEndyear($_POST[ENDYEAR]);
    $experience->setContract($_POST[CONTRACT]);
    $experience->setDescription($_POST[DESCRIPTION]);

    if (!($contact instanceof Contact))
        Reply::_error("Contact isn't already register, make sure to register it first!");
    $experience->setContact($contact);

    $c = $experience->save();
    if ($c instanceof Experience)
        Reply::_success($c->toArray());  

    Reply::_error('sorry!!! could not update the contact');
} catch (Exception $exception) {
    Reply::_exception($exception);
}