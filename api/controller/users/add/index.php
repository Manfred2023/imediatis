<?php


header('Content-Type: application/json');

if (!@require realpath(dirname(__DIR__, 3)) . '/conf.php')
    http_response_code(403);




try {
    # Check required fields
    Criteria::_formRequiredCheck([EMAIL, PASSWORD], $_POST);
    if (!($contact = Contact::_get(Criteria::TOKEN, trim($_POST[TOKEN]))) instanceof Contact)
        Reply::_error("Contact isn't already register, make sure to register it first!");

    $user = (new User(NULL,NULL, $_POST[EMAIL] , password_hash($_POST[PASSWORD], PASSWORD_DEFAULT) , $contact))->save(); 


    if ($user instanceof User)
        Reply::_success($user->toArray());

    Reply::_error('sorry!!! could not register the new user');
} catch (Exception $exception) {
    Reply::_exception($exception);
}


