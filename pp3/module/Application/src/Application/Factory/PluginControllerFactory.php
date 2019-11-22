<?php

namespace Application\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Application\Repository\PluginRepository;
use Application\Repository\PluginVersionRepository;
use Application\Repository\CategoryRepository;
use Application\Controller\PluginController;
use Application\Repository\UserRepository;
use Application\Repository\NbVersionRepository;

class PluginControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $em = $serviceLocator->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $repository = new PluginRepository();
        $repository->setEntityManager($em);
        
        $pvRepository = new PluginVersionRepository();
        $pvRepository->setEntityManager($em);

        $categRepository = new CategoryRepository();
        $categRepository->setEntityManager($em);

        $config = $serviceLocator->getServiceLocator()->get('config');

        $userRepository = new UserRepository();
        $userRepository->setEntityManager($em);

        $nbVersionRepository = new NbVersionRepository();
        $nbVersionRepository->setEntityManager($em);

        return new PluginController($repository, $pvRepository, $categRepository, $config, $nbVersionRepository, $userRepository);
    }
}
