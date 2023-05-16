<?php
header('Content-Type: application/json');
if (!require realpath(dirname(__DIR__, 3)) . '/conf.php')
    http_response_code(403);

try {

    # Check required fields
    Criteria::_formRequiredCheck([TOKEN], $_POST);

    $contact = Contact::_get(Criteria::TOKEN, $_POST[TOKEN]);

    if ($contact instanceof Contact && $contact->delete())
        Reply::_success($contact->toArray());

    Reply::_error('contact does not exist');
} catch (Exception $exception) {
    Reply::_exception($exception);
}