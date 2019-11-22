<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\SessionManager;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;

class Module {

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $this->initSession([
            'remember_me_seconds' => 180,
            'use_cookies' => true,
            //'cookie_httponly' => true,
        ]);

        // Why this code is necessary will be the secret of the Zend Developers
        // instead of logging, they hide exception and just show meaningless
        // error messages
        //
        //Attach render errors
        $eventManager->attach(MvcEvent::EVENT_RENDER_ERROR, function($e) {
            if ($e->getParam('exception')) {
                error_log($e->getParam('exception')); //Custom error render function.
            }
        });
        //Attach dispatch errors
        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, function($e) {
            if ($e->getParam('exception')) {
                error_log($e->getParam('exception')); //Custom error render function.
            }
        });
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function initSession($config) {
        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions($config);
        $sessionManager = new SessionManager($sessionConfig);
        $sessionManager->start();
        Container::setDefaultManager($sessionManager);
    }
}
