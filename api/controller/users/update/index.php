<?php


header('Content-Type: application/json');

if (!require realpath(dirname(__DIR__, 3)) . '/conf.php')
    http_response_code(403);




try { 

    # Check required fields
    Criteria::_formRequiredCheck([EMAIL, PASSWORD], $_POST);
    $user = User::_get(Criteria::TOKEN, $_POST[TOKEN]);
    if (!($user instanceof User))
        Reply::_error('not_found');
    $user->setPassword(password_hash($_POST[PASSWORD], PASSWORD_DEFAULT));

    $c = $user->save();
    if ($c instanceof User)
        Reply::_success($c->toArray());  

    Reply::_error('sorry!!! could not update the password');
} catch (Exception $exception) {
    Reply::_exception($exception);
}