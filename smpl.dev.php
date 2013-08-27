<?php
/*------------------------------------------------------------------------------
  SMPL Version:   0.1.1
  Issue Date:     August 1, 2013
  Copyright (c):  Gowon Patterson, Gowon Designs 2013
  Licence:        SMPL is licensed under the Open Software License 3.0.
                  http://www.opensource.org/licenses/osl-3.0.php
------------------------------------------------------------------------------*/
error_reporting(-1);
set_error_handler(array('Debug', 'ErrorHandler'));
register_shutdown_function(array('Debug', 'EndOfExecution'));

// Include all of the classes located in the classes/ folder
function IncludeFromFolder($folder)
{
    foreach (glob("{$folder}*.php") as $filename)
        require_once($filename);
}

function __autoload($class_name)
{
    require_once('classes/Class.'.$class_name.'.php');
}

IncludeFromFolder("classes/");

/*------------------------------------------------------------
  To enable Error Reporting, un-comment string #1
  and comment-out string #2, which turns Error Reporting off.
------------------------------------------------------------*/
// public static function Set($setDebugMode, $setStrict, $setVerbose, $setLogging, $logPath = null)
Debug::Set(true, false, false, false);

// Always update the database, un/publishing content based on the current date

Security::EnforceHttps();

Security::Authenticate();

Content::Update();

Content::Hook();



?>