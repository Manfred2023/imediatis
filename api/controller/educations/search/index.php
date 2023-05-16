<?php
header('Content-Type: application/json');
if (!@require realpath(dirname(__DIR__, 3)) . '/conf.php')
    http_response_code(403);    


try {

    # Check required fields
    Criteria::_formRequiredCheck([CONTACT], $_POST);

    if (!($contact = Contact::_get(Criteria::TOKEN, trim($_POST[CONTACT]))) instanceof Contact)
        Reply::_error("Contact isn't already register, make sure to register it first!");


} catch (Exception $exception) {
    Reply::_exception($exception);
}


