<?php


header('Content-Type: application/json');

if (!require realpath(dirname(__DIR__, 3)) . '/conf.php')
    http_response_code(403);




try { 

    # Check required fields
    Criteria::_formRequiredCheck([SCHOOL, DIPLOMA, STUDYFIELD, SRTMONTH, SRTYEAR, ENDMONTH, ENDYEAR, ASSOCIATION, CONTACT], $_POST);
    $education = Education::_get(Criteria::TOKEN, $_POST[TOKEN]);
    $contact = Contact::_get(Criteria::TOKEN, $_POST[CONTACT]);
    if (!($education instanceof Education))
        Reply::_error('not_found');

    $education->setSchool($_POST[SCHOOL]);
    $education->setDilpoma($_POST[DIPLOMA]);
    $education->setStudyfield($_POST[STUDYFIELD]);
    $education->setStartmonth($_POST[SRTMONTH]);
    $education->setStartyear($_POST[SRTYEAR]);
    $education->setEndmonth($_POST[ENDMONTH]);
    $education->setEndyear($_POST[ENDYEAR]);
    $education->setAssociation($_POST[ASSOCIATION]);

    if (!($contact instanceof Contact))
        Reply::_error("Contact isn't already register, make sure to register it first!");
    $education->setContact($contact);

    $c = $education->save();
    if ($c instanceof Education)
        Reply::_success($c->toArray());  

    Reply::_error('sorry!!! could not update the contact');
} catch (Exception $exception) {
    Reply::_exception($exception);
}