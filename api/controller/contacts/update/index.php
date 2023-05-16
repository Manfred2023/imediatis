<?php


header('Content-Type: application/json');

if (!require realpath(dirname(__DIR__, 3)) . '/conf.php')
    http_response_code(403);




try { 

    # Check required fields
    Criteria::_formRequiredCheck([FSTNAME, LSTNAME,DBIRTH, MBIRTH, YBIRTH, GENDER, PHONE, PROFESSION, DESCRIPTION, CITY], $_POST);
    $contact = Contact::_get(Criteria::TOKEN, $_POST[TOKEN]);
    $city = City::_get(Criteria::TOKEN, $_POST[CITY]);
    if (!($contact instanceof Contact))
        Reply::_error('not_found');

    $contact->setFirstname($_POST[FSTNAME]);
    $contact->setLastname($_POST[LSTNAME]);
    $contact->setDayofbirth($_POST[DBIRTH]);
    $contact->setMonthofbirth($_POST[MBIRTH]);
    $contact->setYearofbirth($_POST[YBIRTH]);
    $contact->setGender($_POST[GENDER]);
    $contact->setPhonenumber($_POST[PHONE]);
    $contact->setProfession($_POST[PROFESSION]);
    $contact->setDescription($_POST[DESCRIPTION]);
    $contact->setDateModification(DATEMODIF);

    if (!($city instanceof City))
        Reply::_error("City isn't already register, make sure to register it first!");
    $contact->setCity($city);

    $c = $contact->save();
    if ($c instanceof Contact)
        Reply::_success($c->toArray());  

    Reply::_error('sorry!!! could not update the contact');
} catch (Exception $exception) {
    Reply::_exception($exception);
}