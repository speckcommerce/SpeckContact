<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace SpeckContact;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use ZfcBase\Mapper\AbstractDbMapper;

class Module implements AutoloaderProviderInterface
{
    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                'SpeckContact\Mapper\AddressMapper' => 'SpeckContact\Mapper\AddressMapper',
                'SpeckContact\Mapper\CompanyMapper' => 'SpeckContact\Mapper\CompanyMapper',
                'SpeckContact\Mapper\ContactMapper' => 'SpeckContact\Mapper\ContactMapper',
                'SpeckContact\Mapper\EmailMapper'   => 'SpeckContact\Mapper\EmailMapper',
                'SpeckContact\Mapper\PhoneMapper'   => 'SpeckContact\Mapper\PhoneMapper',
                'SpeckContact\Mapper\UrlMapper'     => 'SpeckContact\Mapper\UrlMapper',
            ),

            'initializers' => array(
                function ($instance, $sm) {
                    if ($instance instanceof AbstractDbMapper) {
                        $instance->setDbAdapter($sm->get('speckcontact_db_adapter'));
                    }
                },
            ),

            'factories' => array(
                'SpeckContact\Service\ContactService' => function($sm) {
                    $service = new Service\ContactService;
                    $service->setAddressMapper($sm->get('SpeckContact\Mapper\AddressMapper'))
                        ->setCompanyMapper($sm->get('SpeckContact\Mapper\CompanyMapper'))
                        ->setContactMapper($sm->get('SpeckContact\Mapper\ContactMapper'))
                        ->setEmailMapper($sm->get('SpeckContact\Mapper\EmailMapper'))
                        ->setPhoneMapper($sm->get('SpeckContact\Mapper\PhoneMapper'))
                        ->setUrlMapper($sm->get('SpeckContact\Mapper\UrlMapper'))
                        ->setServiceManager($sm);
                    return $service;
                },
            ),
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap($e)
    {
        if($e->getRequest() instanceof \Zend\Console\Request){
            return;
        }

        $app = $e->getParam('application');
        $em  = $app->getEventManager()->getSharedManager();

        //install event listener
        $em->attach('SpeckInstall\Controller\InstallController', 'install.create_tables', array($this, 'createTables'));
    }

    public function createTables($e)
    {
        $mapper = $e->getParam('mapper');
        $create = file_get_contents(__DIR__ .'/data/schema.sql');
        $mapper->query($create);

        return "SpeckContact created tables";
    }
}
