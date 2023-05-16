<?php


header('Content-Type: application/json');

if (!require realpath(dirname(__DIR__, 3)) . '/conf.php')
    http_response_code(403);




try {

    # Check required fields
    Criteria::_formRequiredCheck([FSTNAME, LSTNAME,DBIRTH, MBIRTH, YBIRTH, GENDER, PHONE, PROFESSION, DESCRIPTION, CITY], $_POST);

    if (!($city = City::_get(Criteria::TOKEN, trim($_POST[CITY]))) instanceof City)
        Reply::_error("City isn't already register, make sure to register it first!");

    $contact = (new Contact(null,null, $_POST[FSTNAME], $_POST[LSTNAME], $_POST[DBIRTH], $_POST[MBIRTH], $_POST[YBIRTH], $_POST[GENDER],
     $_POST[PHONE], $_POST[PROFESSION], $_POST[DESCRIPTION],null, null, $city))->save();
    if ($contact instanceof Contact){
        /* Reply::_success($contact->toArray()); */
        header('location:../../../../webapp/views/');
    }
    else{
        Reply::_error('sorry!!! could not register the new contact');
    }   

    
} catch (Exception $exception) {
    Reply::_exception($exception);
}

