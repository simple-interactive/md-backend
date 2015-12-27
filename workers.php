<?php
// Define path to application directory
defined('APPLICATION_PATH')
|| define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));

// Define application environment
defined('APPLICATION_ENV')
|| define('APPLICATION_ENV', 'production');

/** Zend_Application */
require_once 'vendor/autoload.php';
// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

$application->bootstrap();
class RouterCli
    extends Zend_Controller_Router_Abstract
    implements Zend_Controller_Router_Interface {
    public function assemble($userParams, $name = null, $reset = false, $encode = true) { }
    public function route(Zend_Controller_Request_Abstract $dispatcher) {}
}

try {
    $opts = new Zend_Console_Getopt(
        array(
            'help|h' => 'Displays usage information.',
            'action|a=s' => 'Action to perform in format of module.controller.action',
            'verbose|v' => 'Verbose messages will be dumped to the default output.',
            'development|d' => 'Enables development mode.',
        )
    );
    $opts->parse();
} catch (Zend_Console_Getopt_Exception $e) {
    exit($e->getMessage() ."\n\n". $e->getUsageMessage());
}

if (isset($opts->h)) {
    echo $opts->getUsageMessage();
    exit;
}
if (isset($opts->a)) {
    $reqRoute = array_reverse(explode('::',$opts->a));
    @list($action, $controller) = $reqRoute;
    $request = new Zend_Controller_Request_Simple();
    $request->setControllerName($controller);
    $request->setActionName($action);
    $request->setModuleName('cli');
    $front = Zend_Controller_Front::getInstance();
    $front->setRequest($request);
    $front->setRouter(new RouterCli());
    $front->setResponse(new Zend_Controller_Response_Cli());
    $front->throwExceptions(true);
    $front->addModuleDirectory(APPLICATION_PATH.'/modules/');
    $front->dispatch();
}