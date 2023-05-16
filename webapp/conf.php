<?php


@session_start();
try{

        # SET TIME ZONE
        date_default_timezone_set('Africa/Douala');

        # SET DEVELOPMENT MODE
        define('_DEVMODE_', true);
        ini_set('display_errors', _DEVMODE_);
        ini_set('display_startup_errors', _DEVMODE_);
        error_reporting(_DEVMODE_ ? E_ALL ^ E_NOTICE : 0);

        # COMMON EXTENSIONS
        define('_PHP', '.php');

        # BASIC PATHS
        define('_SEP', '/');
        define('_ROOT', dirname(__FILE__) . _SEP);

        # COMMON DIRECTORIES
        define('_VDR', 'vendors');
        define('AUTO', 'autoload');
        define('_LIB', 'lib');
        define('_MODEL', 'models');
        define('_DBA', 'dba');
        define('_UTIL', 'utilities');
        define('_ALIAS', _ROOT . 'alias' . _PHP);
        define('_ENV', _ROOT . 'env' . _PHP);
        define('_WAP', 'webapp');

        # ORM SET
        define('_ORM', _ROOT ._VDR . _SEP . 'rb' . _PHP);
        if(!(file_exists(_ORM) || is_readable(_ORM)) || !@require(_ORM))
            throw new Exception ("unabl3 to reach to datda mapping: '" . _ORM ."'");

        # AUTOLOAD DB ADAPTERS
        spl_autoload_register(function ($Cn) {
            $Fn = _ROOT . join(_SEP, [_LIB, _DBA, $Cn . _PHP]);
            if (@file_exists($Fn)) include_once $Fn;
        });

        # AUTOLOAD MODELS CLASSES
        spl_autoload_register(function ($Cn) {
            $Fn = _ROOT . join(_SEP, [_LIB, _MODEL, $Cn . _PHP]);
            if (@file_exists($Fn)) include_once $Fn;
        });

        # AUTOLOAD UTILITIES CLASSES
        spl_autoload_register(function ($Cn) {
            $Fn = _ROOT . join(_SEP, [_LIB, _UTIL, $Cn . _PHP]);
            if (@file_exists($Fn)) include_once $Fn;
        });

        if (!@require _ALIAS)
            throw new Exception("Unable to read alias file!");

        if (!@require _ENV)
            throw new Exception("Unable to read environment file!");


        # Connect to DB
        DBConn::_conn();
        
    }catch (Exception $exception) {
        die($exception->getMessage());
  }