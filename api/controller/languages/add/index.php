<?php


header('Content-Type: application/json');

if (!require realpath(dirname(__DIR__, 3)) . '/conf.php')
    http_response_code(403);




try {

    # Check required fields
    Criteria::_formRequiredCheck([LANNAME,WRITING, SPEAKING, READING], $_POST);

    $language = (new Language($_POST[LANNAME], $_POST[WRITING], $_POST[SPEAKING], $_POST[READING]))->save();
    if ($language instanceof Language)
        Reply::_success($language->toArray());

    Reply::_error('sorry!!! could not register the new language');
} catch (Exception $exception) {
    Reply::_exception($exception);
}
