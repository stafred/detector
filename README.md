# Detector

<pre>
composer require stafred/detector
</pre>

# About Detector

the package is used to detect errors and exceptions with a small set of settings. 
the detector is lightweight and allows you to run any code in the handler. 
specify the settings to run: the path to the folder with the error log, 
the name of the error log file, permission to display brief information 
about the error, permission to start the debugger, or part of a subroutine.

# Example
<pre>
$detector = new \Detector\Run;
$detector->setErrorDebug(your_constant_or_value);
$detector->setErrorInfo(your_constant_or_value);
$detector->setErrorNameLog(your_constant_or_value);
$detector->setErrorPathLog(your_constant_or_value);
$detector->make(function(){
     your_handler_or_code
});
</pre>

# Example With Package Filp\Whoops
<pre>
$detector = new \Detector\Run;
$detector->setErrorDebug('APP_DEBUG');
$detector->setErrorInfo('ERROR_INFO');
$detector->setErrorNameLog('ERROR_NAME_LOG');
$detector->setErrorPathLog('ERROR_PATH_LOG');
$detector->make(function(){
     $whoops = new \Whoops\Run;
     $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
     $whoops->register();
});
</pre>
