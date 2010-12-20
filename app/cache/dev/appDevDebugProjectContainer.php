<?php

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\TaggedContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;

/**
 * appDevDebugProjectContainer
 *
 * This class has been auto-generated
 * by the Symfony Dependency Injection Component.
 */
class appDevDebugProjectContainer extends Container implements TaggedContainerInterface
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct(new FrozenParameterBag($this->getDefaultParameters()));
    }

    /**
     * Gets the 'controller_name_converter' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %controller_name_converter.class% instance.
     */
    protected function getControllerNameConverterService()
    {
        return $this->services['controller_name_converter'] = new \Symfony\Bundle\FrameworkBundle\Controller\ControllerNameConverter($this->get('kernel'), $this->get('logger', ContainerInterface::NULL_ON_INVALID_REFERENCE));
    }

    /**
     * Gets the 'controller_resolver' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %controller_resolver.class% instance.
     */
    protected function getControllerResolverService()
    {
        return $this->services['controller_resolver'] = new \Symfony\Bundle\FrameworkBundle\Controller\ControllerResolver($this, $this->get('controller_name_converter'), $this->get('logger', ContainerInterface::NULL_ON_INVALID_REFERENCE));
    }

    /**
     * Gets the 'request_listener' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %request_listener.class% instance.
     */
    protected function getRequestListenerService()
    {
        return $this->services['request_listener'] = new \Symfony\Bundle\FrameworkBundle\RequestListener($this, $this->get('router'), $this->get('logger', ContainerInterface::NULL_ON_INVALID_REFERENCE));
    }

    /**
     * Gets the 'esi' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %esi.class% instance.
     */
    protected function getEsiService()
    {
        return $this->services['esi'] = new \Symfony\Component\HttpKernel\Cache\Esi();
    }

    /**
     * Gets the 'esi_listener' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %esi_listener.class% instance.
     */
    protected function getEsiListenerService()
    {
        return $this->services['esi_listener'] = new \Symfony\Component\HttpKernel\Cache\EsiListener($this->get('esi', ContainerInterface::NULL_ON_INVALID_REFERENCE));
    }

    /**
     * Gets the 'response_listener' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %response_listener.class% instance.
     */
    protected function getResponseListenerService()
    {
        return $this->services['response_listener'] = new \Symfony\Component\HttpKernel\ResponseListener();
    }

    /**
     * Gets the 'exception_listener' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %exception_listener.class% instance.
     */
    protected function getExceptionListenerService()
    {
        return $this->services['exception_listener'] = new \Symfony\Component\HttpKernel\Debug\ExceptionListener('Symfony\\Bundle\\FrameworkBundle\\Controller\\ExceptionController::exceptionAction', $this->get('logger', ContainerInterface::NULL_ON_INVALID_REFERENCE));
    }

    /**
     * Gets the 'event_dispatcher' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %debug.event_dispatcher.class% instance.
     */
    protected function getEventDispatcherService()
    {
        $this->services['event_dispatcher'] = $instance = new \Symfony\Bundle\FrameworkBundle\Debug\EventDispatcher($this->get('logger', ContainerInterface::NULL_ON_INVALID_REFERENCE));
        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'error_handler' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %error_handler.class% instance.
     */
    protected function getErrorHandlerService()
    {
        $this->services['error_handler'] = $instance = new \Symfony\Component\HttpKernel\Debug\ErrorHandler(NULL);
        $instance->register();

        return $instance;
    }

    /**
     * Gets the 'http_kernel' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %http_kernel.class% instance.
     */
    protected function getHttpKernelService()
    {
        return $this->services['http_kernel'] = new \Symfony\Component\HttpKernel\HttpKernel($this->get('event_dispatcher'), $this->get('controller_resolver'));
    }

    /**
     * Gets the 'request' service.
     *
     * @return Object An instance returned by http_kernel::getRequest().
     */
    protected function getRequestService()
    {
        return $this->get('http_kernel')->getRequest();
    }

    /**
     * Gets the 'response' service.
     *
     * @return Object A %response.class% instance.
     */
    protected function getResponseService()
    {
        return new \Symfony\Component\HttpFoundation\Response();
    }

    /**
     * Gets the 'routing.resolver' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %routing.resolver.class% instance.
     */
    protected function getRouting_ResolverService()
    {
        return $this->services['routing.resolver'] = new \Symfony\Bundle\FrameworkBundle\Routing\LoaderResolver($this);
    }

    /**
     * Gets the 'routing.loader.xml' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %routing.loader.xml.class% instance.
     */
    protected function getRouting_Loader_XmlService()
    {
        return $this->services['routing.loader.xml'] = new \Symfony\Component\Routing\Loader\XmlFileLoader(array('Application' => '/var/www/xwc-sandbox/app/../src/Application', 'Bundle' => '/var/www/xwc-sandbox/app/../src/Bundle', 'Symfony\\Bundle' => '/var/www/xwc-sandbox/app/../src/vendor/symfony/src/Symfony/Bundle'));
    }

    /**
     * Gets the 'routing.loader.yml' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %routing.loader.yml.class% instance.
     */
    protected function getRouting_Loader_YmlService()
    {
        return $this->services['routing.loader.yml'] = new \Symfony\Component\Routing\Loader\YamlFileLoader(array('Application' => '/var/www/xwc-sandbox/app/../src/Application', 'Bundle' => '/var/www/xwc-sandbox/app/../src/Bundle', 'Symfony\\Bundle' => '/var/www/xwc-sandbox/app/../src/vendor/symfony/src/Symfony/Bundle'));
    }

    /**
     * Gets the 'routing.loader.php' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %routing.loader.php.class% instance.
     */
    protected function getRouting_Loader_PhpService()
    {
        return $this->services['routing.loader.php'] = new \Symfony\Component\Routing\Loader\PhpFileLoader(array('Application' => '/var/www/xwc-sandbox/app/../src/Application', 'Bundle' => '/var/www/xwc-sandbox/app/../src/Bundle', 'Symfony\\Bundle' => '/var/www/xwc-sandbox/app/../src/vendor/symfony/src/Symfony/Bundle'));
    }

    /**
     * Gets the 'routing.loader.real' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %routing.loader.class% instance.
     */
    protected function getRouting_Loader_RealService()
    {
        return $this->services['routing.loader.real'] = new \Symfony\Bundle\FrameworkBundle\Routing\DelegatingLoader($this->get('controller_name_converter'), $this->get('logger', ContainerInterface::NULL_ON_INVALID_REFERENCE), $this->get('routing.resolver'));
    }

    /**
     * Gets the 'routing.loader' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Bundle\FrameworkBundle\Routing\LazyLoader A Symfony\Bundle\FrameworkBundle\Routing\LazyLoader instance.
     */
    protected function getRouting_LoaderService()
    {
        return $this->services['routing.loader'] = new \Symfony\Bundle\FrameworkBundle\Routing\LazyLoader($this, 'routing.loader.real');
    }

    /**
     * Gets the 'router' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %router.class% instance.
     */
    protected function getRouterService()
    {
        return $this->services['router'] = new \Symfony\Component\Routing\Router($this->get('routing.loader'), '/var/www/xwc-sandbox/app/config/routing_dev.yml', array('cache_dir' => '/var/www/xwc-sandbox/app/cache/dev', 'debug' => true, 'generator_class' => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator', 'generator_base_class' => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator', 'generator_dumper_class' => 'Symfony\\Component\\Routing\\Generator\\Dumper\\PhpGeneratorDumper', 'generator_cache_class' => 'app'.'_'.'dev'.'UrlGenerator', 'matcher_class' => 'Symfony\\Component\\Routing\\Matcher\\UrlMatcher', 'matcher_base_class' => 'Symfony\\Component\\Routing\\Matcher\\UrlMatcher', 'matcher_dumper_class' => 'Symfony\\Component\\Routing\\Matcher\\Dumper\\PhpMatcherDumper', 'matcher_cache_class' => 'app'.'_'.'dev'.'UrlMatcher'));
    }

    /**
     * Gets the 'validator' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %validator.class% instance.
     */
    protected function getValidatorService()
    {
        return $this->services['validator'] = new \Symfony\Component\Validator\Validator($this->get('validator.mapping.class_metadata_factory'), $this->get('validator.validator_factory'));
    }

    /**
     * Gets the 'validator.mapping.class_metadata_factory' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %validator.mapping.class_metadata_factory.class% instance.
     */
    protected function getValidator_Mapping_ClassMetadataFactoryService()
    {
        return $this->services['validator.mapping.class_metadata_factory'] = new \Symfony\Component\Validator\Mapping\ClassMetadataFactory($this->get('validator.mapping.loader.loader_chain'));
    }

    /**
     * Gets the 'validator.validator_factory' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %validator.validator_factory.class% instance.
     */
    protected function getValidator_ValidatorFactoryService()
    {
        $this->services['validator.validator_factory'] = $instance = new \Symfony\Bundle\FrameworkBundle\Validator\ConstraintValidatorFactory($this);
        $instance->loadTaggedServiceIds($this);

        return $instance;
    }

    /**
     * Gets the 'validator.mapping.loader.loader_chain' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %validator.mapping.loader.loader_chain.class% instance.
     */
    protected function getValidator_Mapping_Loader_LoaderChainService()
    {
        return $this->services['validator.mapping.loader.loader_chain'] = new \Symfony\Component\Validator\Mapping\Loader\LoaderChain(array(0 => $this->get('validator.mapping.loader.annotation_loader'), 1 => $this->get('validator.mapping.loader.static_method_loader'), 2 => $this->get('validator.mapping.loader.xml_files_loader'), 3 => $this->get('validator.mapping.loader.yaml_files_loader')));
    }

    /**
     * Gets the 'validator.mapping.loader.static_method_loader' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %validator.mapping.loader.static_method_loader.class% instance.
     */
    protected function getValidator_Mapping_Loader_StaticMethodLoaderService()
    {
        return $this->services['validator.mapping.loader.static_method_loader'] = new \Symfony\Component\Validator\Mapping\Loader\StaticMethodLoader('loadValidatorMetadata');
    }

    /**
     * Gets the 'validator.mapping.loader.xml_files_loader' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Component\Validator\Mapping\Loader\XmlFilesLoader A Symfony\Component\Validator\Mapping\Loader\XmlFilesLoader instance.
     */
    protected function getValidator_Mapping_Loader_XmlFilesLoaderService()
    {
        return $this->services['validator.mapping.loader.xml_files_loader'] = new \Symfony\Component\Validator\Mapping\Loader\XmlFilesLoader(array(0 => '/var/www/xwc-sandbox/src/vendor/symfony/src/Symfony/Bundle/FrameworkBundle/DependencyInjection/../../../Component/Form/Resources/config/validation.xml'));
    }

    /**
     * Gets the 'validator.mapping.loader.yaml_files_loader' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Component\Validator\Mapping\Loader\YamlFilesLoader A Symfony\Component\Validator\Mapping\Loader\YamlFilesLoader instance.
     */
    protected function getValidator_Mapping_Loader_YamlFilesLoaderService()
    {
        return $this->services['validator.mapping.loader.yaml_files_loader'] = new \Symfony\Component\Validator\Mapping\Loader\YamlFilesLoader(array());
    }

    /**
     * Gets the 'validator.mapping.loader.annotation_loader' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Component\Validator\Mapping\Loader\AnnotationLoader A Symfony\Component\Validator\Mapping\Loader\AnnotationLoader instance.
     */
    protected function getValidator_Mapping_Loader_AnnotationLoaderService()
    {
        return $this->services['validator.mapping.loader.annotation_loader'] = new \Symfony\Component\Validator\Mapping\Loader\AnnotationLoader(array('validation' => 'Symfony\\Component\\Validator\\Constraints\\'));
    }

    /**
     * Gets the 'templating.engine' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %templating.engine.class% instance.
     */
    protected function getTemplating_EngineService()
    {
        $this->services['templating.engine'] = $instance = new \Symfony\Bundle\FrameworkBundle\Templating\Engine($this, $this->get('templating.loader.filesystem'));
        $instance->setCharset('UTF-8');

        return $instance;
    }

    /**
     * Gets the 'templating.loader.filesystem' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %templating.loader.filesystem.class% instance.
     */
    protected function getTemplating_Loader_FilesystemService()
    {
        $this->services['templating.loader.filesystem'] = $instance = new \Symfony\Component\Templating\Loader\FilesystemLoader(array(0 => '/var/www/xwc-sandbox/app/views/%bundle%/%controller%/%name%%format%.%renderer%', 1 => '/var/www/xwc-sandbox/app/../src/Application/%bundle%/Resources/views/%controller%/%name%%format%.%renderer%', 2 => '/var/www/xwc-sandbox/app/../src/Bundle/%bundle%/Resources/views/%controller%/%name%%format%.%renderer%', 3 => '/var/www/xwc-sandbox/app/../src/vendor/symfony/src/Symfony/Bundle/%bundle%/Resources/views/%controller%/%name%%format%.%renderer%'));
        if ($this->has('templating.debugger')) {
            $instance->setDebugger($this->get('templating.debugger', ContainerInterface::NULL_ON_INVALID_REFERENCE));
        }

        return $instance;
    }

    /**
     * Gets the 'templating.loader.cache' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %templating.loader.cache.class% instance.
     */
    protected function getTemplating_Loader_CacheService()
    {
        $this->services['templating.loader.cache'] = $instance = new \Symfony\Component\Templating\Loader\CacheLoader($this->get('templating.loader.wrapped'), NULL);
        if ($this->has('templating.debugger')) {
            $instance->setDebugger($this->get('templating.debugger', ContainerInterface::NULL_ON_INVALID_REFERENCE));
        }

        return $instance;
    }

    /**
     * Gets the 'templating.loader.chain' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %templating.loader.chain.class% instance.
     */
    protected function getTemplating_Loader_ChainService()
    {
        $this->services['templating.loader.chain'] = $instance = new \Symfony\Component\Templating\Loader\ChainLoader();
        if ($this->has('templating.debugger')) {
            $instance->setDebugger($this->get('templating.debugger', ContainerInterface::NULL_ON_INVALID_REFERENCE));
        }

        return $instance;
    }

    /**
     * Gets the 'templating.helper.javascripts' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %templating.helper.javascripts.class% instance.
     */
    protected function getTemplating_Helper_JavascriptsService()
    {
        return $this->services['templating.helper.javascripts'] = new \Symfony\Component\Templating\Helper\JavascriptsHelper($this->get('templating.helper.assets'));
    }

    /**
     * Gets the 'templating.helper.stylesheets' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %templating.helper.stylesheets.class% instance.
     */
    protected function getTemplating_Helper_StylesheetsService()
    {
        return $this->services['templating.helper.stylesheets'] = new \Symfony\Component\Templating\Helper\StylesheetsHelper($this->get('templating.helper.assets'));
    }

    /**
     * Gets the 'templating.helper.slots' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %templating.helper.slots.class% instance.
     */
    protected function getTemplating_Helper_SlotsService()
    {
        return $this->services['templating.helper.slots'] = new \Symfony\Component\Templating\Helper\SlotsHelper();
    }

    /**
     * Gets the 'templating.helper.assets' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %templating.helper.assets.class% instance.
     */
    protected function getTemplating_Helper_AssetsService()
    {
        return $this->services['templating.helper.assets'] = new \Symfony\Bundle\FrameworkBundle\Templating\Helper\AssetsHelper($this->get('request'), array(), NULL);
    }

    /**
     * Gets the 'templating.helper.request' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %templating.helper.request.class% instance.
     */
    protected function getTemplating_Helper_RequestService()
    {
        return $this->services['templating.helper.request'] = new \Symfony\Bundle\FrameworkBundle\Templating\Helper\RequestHelper($this->get('request'));
    }

    /**
     * Gets the 'templating.helper.session' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %templating.helper.session.class% instance.
     */
    protected function getTemplating_Helper_SessionService()
    {
        return $this->services['templating.helper.session'] = new \Symfony\Bundle\FrameworkBundle\Templating\Helper\SessionHelper($this->get('request'));
    }

    /**
     * Gets the 'templating.helper.router' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %templating.helper.router.class% instance.
     */
    protected function getTemplating_Helper_RouterService()
    {
        return $this->services['templating.helper.router'] = new \Symfony\Bundle\FrameworkBundle\Templating\Helper\RouterHelper($this->get('router'));
    }

    /**
     * Gets the 'templating.helper.actions' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %templating.helper.actions.class% instance.
     */
    protected function getTemplating_Helper_ActionsService()
    {
        return $this->services['templating.helper.actions'] = new \Symfony\Bundle\FrameworkBundle\Templating\Helper\ActionsHelper($this->get('controller_resolver'));
    }

    /**
     * Gets the 'templating.helper.code' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %templating.helper.code.class% instance.
     */
    protected function getTemplating_Helper_CodeService()
    {
        return $this->services['templating.helper.code'] = new \Symfony\Bundle\FrameworkBundle\Templating\Helper\CodeHelper(NULL, '/var/www/xwc-sandbox/app');
    }

    /**
     * Gets the 'templating.helper.translator' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %templating.helper.translator.class% instance.
     */
    protected function getTemplating_Helper_TranslatorService()
    {
        return $this->services['templating.helper.translator'] = new \Symfony\Bundle\FrameworkBundle\Templating\Helper\TranslatorHelper($this->get('translator'));
    }

    /**
     * Gets the 'templating.helper.security' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %templating.helper.security.class% instance.
     */
    protected function getTemplating_Helper_SecurityService()
    {
        return $this->services['templating.helper.security'] = new \Symfony\Bundle\FrameworkBundle\Templating\Helper\SecurityHelper($this->get('security.context', ContainerInterface::NULL_ON_INVALID_REFERENCE));
    }

    /**
     * Gets the 'templating.helper.form' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %templating.helper.form.class% instance.
     */
    protected function getTemplating_Helper_FormService()
    {
        return $this->services['templating.helper.form'] = new \Symfony\Bundle\FrameworkBundle\Templating\Helper\FormHelper($this->get('templating.engine'));
    }

    /**
     * Gets the 'templating.debugger' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %templating.debugger.class% instance.
     */
    protected function getTemplating_DebuggerService()
    {
        return $this->services['templating.debugger'] = new \Symfony\Bundle\FrameworkBundle\Templating\Debugger($this->get('logger', ContainerInterface::NULL_ON_INVALID_REFERENCE));
    }

    /**
     * Gets the 'session' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %session.class% instance.
     */
    protected function getSessionService()
    {
        $this->services['session'] = $instance = new \Symfony\Component\HttpFoundation\Session($this->get('session.storage.native'), array('default_locale' => 'en'));
        $instance->start();

        return $instance;
    }

    /**
     * Gets the 'session.storage.native' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %session.storage.native.class% instance.
     */
    protected function getSession_Storage_NativeService()
    {
        return $this->services['session.storage.native'] = new \Symfony\Component\HttpFoundation\SessionStorage\NativeSessionStorage(array('lifetime' => 3600));
    }

    /**
     * Gets the 'session.storage.pdo' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %session.storage.pdo.class% instance.
     */
    protected function getSession_Storage_PdoService()
    {
        return $this->services['session.storage.pdo'] = new \Symfony\Component\HttpFoundation\SessionStorage\PdoSessionStorage($this->get('pdo_connection'), array());
    }

    /**
     * Gets the 'translator.real' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %translator.class% instance.
     */
    protected function getTranslator_RealService()
    {
        $this->services['translator.real'] = $instance = new \Symfony\Bundle\FrameworkBundle\Translation\Translator($this, $this->get('translator.selector'), array('cache_dir' => '/var/www/xwc-sandbox/app/cache/dev'.'/translations', 'debug' => true), $this->get('session', ContainerInterface::NULL_ON_INVALID_REFERENCE));
        $instance->setFallbackLocale('en');

        return $instance;
    }

    /**
     * Gets the 'translator' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %translator.class% instance.
     */
    protected function getTranslatorService()
    {
        $this->services['translator'] = $instance = new \Symfony\Bundle\FrameworkBundle\Translation\Translator($this, $this->get('translator.selector'), array('cache_dir' => '/var/www/xwc-sandbox/app/cache/dev'.'/translations', 'debug' => true), $this->get('session', ContainerInterface::NULL_ON_INVALID_REFERENCE));
        $instance->setFallbackLocale('en');

        return $instance;
    }

    /**
     * Gets the 'translator.selector' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %translator.selector.class% instance.
     */
    protected function getTranslator_SelectorService()
    {
        return $this->services['translator.selector'] = new \Symfony\Component\Translation\MessageSelector();
    }

    /**
     * Gets the 'translation.loader.php' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %translation.loader.php.class% instance.
     */
    protected function getTranslation_Loader_PhpService()
    {
        return $this->services['translation.loader.php'] = new \Symfony\Component\Translation\Loader\PhpFileLoader();
    }

    /**
     * Gets the 'translation.loader.yml' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %translation.loader.yml.class% instance.
     */
    protected function getTranslation_Loader_YmlService()
    {
        return $this->services['translation.loader.yml'] = new \Symfony\Component\Translation\Loader\YamlFileLoader();
    }

    /**
     * Gets the 'translation.loader.xliff' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %translation.loader.xliff.class% instance.
     */
    protected function getTranslation_Loader_XliffService()
    {
        return $this->services['translation.loader.xliff'] = new \Symfony\Component\Translation\Loader\XliffFileLoader();
    }

    /**
     * Gets the 'profiler' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %profiler.class% instance.
     */
    protected function getProfilerService()
    {
        return $this->services['profiler'] = new \Symfony\Bundle\FrameworkBundle\Profiler($this, $this->get('profiler.storage'), $this->get('logger', ContainerInterface::NULL_ON_INVALID_REFERENCE));
    }

    /**
     * Gets the 'profiler.storage' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %profiler.storage.class% instance.
     */
    protected function getProfiler_StorageService()
    {
        return $this->services['profiler.storage'] = new \Symfony\Component\HttpKernel\Profiler\SQLiteProfilerStorage('/var/www/xwc-sandbox/app/cache/dev/profiler.db', 86400);
    }

    /**
     * Gets the 'profiler_listener' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %profiler_listener.class% instance.
     */
    protected function getProfilerListenerService()
    {
        return $this->services['profiler_listener'] = new \Symfony\Component\HttpKernel\Profiler\ProfilerListener($this->get('profiler'), $this->get('profiler.request_matcher', ContainerInterface::NULL_ON_INVALID_REFERENCE), false);
    }

    /**
     * Gets the 'data_collector.config' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %data_collector.config.class% instance.
     */
    protected function getDataCollector_ConfigService()
    {
        return $this->services['data_collector.config'] = new \Symfony\Bundle\FrameworkBundle\DataCollector\ConfigDataCollector($this->get('kernel'), $this->get('router', ContainerInterface::NULL_ON_INVALID_REFERENCE));
    }

    /**
     * Gets the 'data_collector.request' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %data_collector.request.class% instance.
     */
    protected function getDataCollector_RequestService()
    {
        return $this->services['data_collector.request'] = new \Symfony\Bundle\FrameworkBundle\DataCollector\RequestDataCollector();
    }

    /**
     * Gets the 'data_collector.security' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %data_collector.security.class% instance.
     */
    protected function getDataCollector_SecurityService()
    {
        return $this->services['data_collector.security'] = new \Symfony\Component\HttpKernel\DataCollector\SecurityDataCollector($this->get('security.context', ContainerInterface::NULL_ON_INVALID_REFERENCE));
    }

    /**
     * Gets the 'data_collector.exception' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %data_collector.exception.class% instance.
     */
    protected function getDataCollector_ExceptionService()
    {
        return $this->services['data_collector.exception'] = new \Symfony\Component\HttpKernel\DataCollector\ExceptionDataCollector();
    }

    /**
     * Gets the 'data_collector.events' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %data_collector.events.class% instance.
     */
    protected function getDataCollector_EventsService()
    {
        $this->services['data_collector.events'] = $instance = new \Symfony\Component\HttpKernel\DataCollector\EventDataCollector();
        $instance->setEventDispatcher($this->get('event_dispatcher'));

        return $instance;
    }

    /**
     * Gets the 'data_collector.logger' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %data_collector.logger.class% instance.
     */
    protected function getDataCollector_LoggerService()
    {
        return $this->services['data_collector.logger'] = new \Symfony\Component\HttpKernel\DataCollector\LoggerDataCollector($this->get('logger', ContainerInterface::NULL_ON_INVALID_REFERENCE));
    }

    /**
     * Gets the 'data_collector.timer' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %data_collector.timer.class% instance.
     */
    protected function getDataCollector_TimerService()
    {
        return $this->services['data_collector.timer'] = new \Symfony\Bundle\FrameworkBundle\DataCollector\TimerDataCollector($this->get('kernel'));
    }

    /**
     * Gets the 'data_collector.memory' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %data_collector.memory.class% instance.
     */
    protected function getDataCollector_MemoryService()
    {
        return $this->services['data_collector.memory'] = new \Symfony\Component\HttpKernel\DataCollector\MemoryDataCollector();
    }

    /**
     * Gets the 'twig' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %twig.class% instance.
     */
    protected function getTwigService()
    {
        return $this->services['twig'] = new \Symfony\Bundle\TwigBundle\Environment($this, $this->get('twig.loader'), array('charset' => 'UTF-8', 'debug' => true, 'cache' => '/var/www/xwc-sandbox/app/cache/dev/twig', 'strict_variables' => true));
    }

    /**
     * Gets the 'twig.loader' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %twig.loader.class% instance.
     */
    protected function getTwig_LoaderService()
    {
        $this->services['twig.loader'] = $instance = new \Symfony\Bundle\TwigBundle\Loader\Loader();
        $instance->setEngine($this->get('templating.engine'));

        return $instance;
    }

    /**
     * Gets the 'twig.renderer' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %twig.renderer.class% instance.
     */
    protected function getTwig_RendererService()
    {
        return $this->services['twig.renderer'] = new \Symfony\Bundle\TwigBundle\Renderer\Renderer($this->get('twig'));
    }

    /**
     * Gets the 'twig.extension.trans' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Bundle\TwigBundle\Extension\TransExtension A Symfony\Bundle\TwigBundle\Extension\TransExtension instance.
     */
    protected function getTwig_Extension_TransService()
    {
        return $this->services['twig.extension.trans'] = new \Symfony\Bundle\TwigBundle\Extension\TransExtension($this->get('translator'));
    }

    /**
     * Gets the 'twig.extension.helpers' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Bundle\TwigBundle\Extension\TemplatingExtension A Symfony\Bundle\TwigBundle\Extension\TemplatingExtension instance.
     */
    protected function getTwig_Extension_HelpersService()
    {
        return $this->services['twig.extension.helpers'] = new \Symfony\Bundle\TwigBundle\Extension\TemplatingExtension($this);
    }

    /**
     * Gets the 'twig.extension.form' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Bundle\TwigBundle\Extension\FormExtension A Symfony\Bundle\TwigBundle\Extension\FormExtension instance.
     */
    protected function getTwig_Extension_FormService()
    {
        return $this->services['twig.extension.form'] = new \Symfony\Bundle\TwigBundle\Extension\FormExtension(array(0 => 'TwigBundle::form.twig'));
    }

    /**
     * Gets the 'twig.security.form' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Bundle\TwigBundle\Extension\SecurityExtension A Symfony\Bundle\TwigBundle\Extension\SecurityExtension instance.
     */
    protected function getTwig_Security_FormService()
    {
        return $this->services['twig.security.form'] = new \Symfony\Bundle\TwigBundle\Extension\SecurityExtension($this->get('security.context', ContainerInterface::NULL_ON_INVALID_REFERENCE));
    }

    /**
     * Gets the 'debug.toolbar' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %debug.toolbar.class% instance.
     */
    protected function getDebug_ToolbarService()
    {
        return $this->services['debug.toolbar'] = new \Symfony\Bundle\WebProfilerBundle\WebDebugToolbarListener($this->get('controller_resolver'), true);
    }

    /**
     * Gets the 'zend.logger' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %zend.logger.class% instance.
     */
    protected function getZend_LoggerService()
    {
        $this->services['zend.logger'] = $instance = new \Symfony\Bundle\ZendBundle\Logger\Logger();
        $instance->addWriter($this->get('zend.logger.writer.filesystem'));
        $instance->addWriter($this->get('zend.logger.writer.debug'));

        return $instance;
    }

    /**
     * Gets the 'zend.logger.writer.filesystem' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %zend.logger.writer.filesystem.class% instance.
     */
    protected function getZend_Logger_Writer_FilesystemService()
    {
        $this->services['zend.logger.writer.filesystem'] = $instance = new \Zend\Log\Writer\Stream('/var/www/xwc-sandbox/app/logs/dev.log');
        $instance->addFilter($this->get('zend.logger.filter'));
        $instance->setFormatter($this->get('zend.formatter.filesystem'));

        return $instance;
    }

    /**
     * Gets the 'zend.formatter.filesystem' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %zend.formatter.filesystem.class% instance.
     */
    protected function getZend_Formatter_FilesystemService()
    {
        return $this->services['zend.formatter.filesystem'] = new \Zend\Log\Formatter\Simple('%timestamp% %priorityName%: %message%
');
    }

    /**
     * Gets the 'zend.logger.writer.debug' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Object A %zend.logger.writer.debug.class% instance.
     */
    protected function getZend_Logger_Writer_DebugService()
    {
        $this->services['zend.logger.writer.debug'] = $instance = new \Symfony\Bundle\ZendBundle\Logger\DebugLogger();
        $instance->addFilter($this->get('zend.logger.filter'));

        return $instance;
    }

    /**
     * Gets the 'zend.logger.filter' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Zend\Log\Filter\Priority A Zend\Log\Filter\Priority instance.
     */
    protected function getZend_Logger_FilterService()
    {
        return $this->services['zend.logger.filter'] = new \Zend\Log\Filter\Priority(7);
    }

    /**
     * Gets the debug.event_dispatcher service alias.
     *
     * @return Object An instance of the event_dispatcher service
     */
    protected function getDebug_EventDispatcherService()
    {
        return $this->get('event_dispatcher');
    }

    /**
     * Gets the templating.loader service alias.
     *
     * @return Object An instance of the templating.loader.filesystem service
     */
    protected function getTemplating_LoaderService()
    {
        return $this->get('templating.loader.filesystem');
    }

    /**
     * Gets the templating service alias.
     *
     * @return Object An instance of the templating.engine service
     */
    protected function getTemplatingService()
    {
        return $this->get('templating.engine');
    }

    /**
     * Gets the session.storage service alias.
     *
     * @return Object An instance of the session.storage.native service
     */
    protected function getSession_StorageService()
    {
        return $this->get('session.storage.native');
    }

    /**
     * Gets the logger service alias.
     *
     * @return Object An instance of the zend.logger service
     */
    protected function getLoggerService()
    {
        return $this->get('zend.logger');
    }

    /**
     * Returns service ids for a given tag.
     *
     * @param string $name The tag name
     *
     * @return array An array of tags
     */
    public function findTaggedServiceIds($name)
    {
        static $tags = array(
            'kernel.listener' => array(
                'request_listener' => array(
                    0 => array(

                    ),
                ),
                'esi_listener' => array(
                    0 => array(

                    ),
                ),
                'response_listener' => array(
                    0 => array(

                    ),
                ),
                'exception_listener' => array(
                    0 => array(
                        'priority' => 128,
                    ),
                ),
                'profiler_listener' => array(
                    0 => array(

                    ),
                ),
                'debug.toolbar' => array(
                    0 => array(
                        'priority' => 128,
                    ),
                ),
            ),
            'routing.loader' => array(
                'routing.loader.xml' => array(
                    0 => array(

                    ),
                ),
                'routing.loader.yml' => array(
                    0 => array(

                    ),
                ),
                'routing.loader.php' => array(
                    0 => array(

                    ),
                ),
            ),
            'templating.helper' => array(
                'templating.helper.javascripts' => array(
                    0 => array(
                        'alias' => 'javascripts',
                    ),
                ),
                'templating.helper.stylesheets' => array(
                    0 => array(
                        'alias' => 'stylesheets',
                    ),
                ),
                'templating.helper.slots' => array(
                    0 => array(
                        'alias' => 'slots',
                    ),
                ),
                'templating.helper.assets' => array(
                    0 => array(
                        'alias' => 'assets',
                    ),
                ),
                'templating.helper.request' => array(
                    0 => array(
                        'alias' => 'request',
                    ),
                ),
                'templating.helper.session' => array(
                    0 => array(
                        'alias' => 'session',
                    ),
                ),
                'templating.helper.router' => array(
                    0 => array(
                        'alias' => 'router',
                    ),
                ),
                'templating.helper.actions' => array(
                    0 => array(
                        'alias' => 'actions',
                    ),
                ),
                'templating.helper.code' => array(
                    0 => array(
                        'alias' => 'code',
                    ),
                ),
                'templating.helper.translator' => array(
                    0 => array(
                        'alias' => 'translator',
                    ),
                ),
                'templating.helper.security' => array(
                    0 => array(
                        'alias' => 'security',
                    ),
                ),
                'templating.helper.form' => array(
                    0 => array(
                        'alias' => 'form',
                    ),
                ),
            ),
            'translation.loader' => array(
                'translation.loader.php' => array(
                    0 => array(
                        'alias' => 'php',
                    ),
                ),
                'translation.loader.yml' => array(
                    0 => array(
                        'alias' => 'yml',
                    ),
                ),
                'translation.loader.xliff' => array(
                    0 => array(
                        'alias' => 'xliff',
                    ),
                ),
            ),
            'data_collector' => array(
                'data_collector.config' => array(
                    0 => array(
                        'template' => 'WebProfilerBundle:Collector:config',
                    ),
                ),
                'data_collector.request' => array(
                    0 => array(
                        'template' => 'WebProfilerBundle:Collector:request',
                    ),
                ),
                'data_collector.security' => array(
                    0 => array(
                        'template' => 'WebProfilerBundle:Collector:security',
                    ),
                ),
                'data_collector.exception' => array(
                    0 => array(
                        'template' => 'WebProfilerBundle:Collector:exception',
                    ),
                ),
                'data_collector.events' => array(
                    0 => array(
                        'template' => 'WebProfilerBundle:Collector:events',
                    ),
                ),
                'data_collector.logger' => array(
                    0 => array(
                        'template' => 'WebProfilerBundle:Collector:logger',
                    ),
                ),
                'data_collector.timer' => array(
                    0 => array(
                        'template' => 'WebProfilerBundle:Collector:timer',
                    ),
                ),
                'data_collector.memory' => array(
                    0 => array(
                        'template' => 'WebProfilerBundle:Collector:memory',
                    ),
                ),
            ),
            'templating.renderer' => array(
                'twig.renderer' => array(
                    0 => array(
                        'alias' => 'twig',
                    ),
                ),
            ),
            'twig.extension' => array(
                'twig.extension.trans' => array(
                    0 => array(

                    ),
                ),
                'twig.extension.helpers' => array(
                    0 => array(

                    ),
                ),
                'twig.extension.form' => array(
                    0 => array(

                    ),
                ),
                'twig.security.form' => array(
                    0 => array(

                    ),
                ),
            ),
        );

        return isset($tags[$name]) ? $tags[$name] : array();
    }

    /**
     * Gets the default parameters.
     *
     * @return array An array of the default parameters
     */
    protected function getDefaultParameters()
    {
        return array(
            'kernel.root_dir' => '/var/www/xwc-sandbox/app',
            'kernel.environment' => 'dev',
            'kernel.debug' => true,
            'kernel.name' => 'app',
            'kernel.cache_dir' => '/var/www/xwc-sandbox/app/cache/dev',
            'kernel.logs_dir' => '/var/www/xwc-sandbox/app/logs',
            'kernel.bundle_dirs' => array(
                'Application' => '/var/www/xwc-sandbox/app/../src/Application',
                'Bundle' => '/var/www/xwc-sandbox/app/../src/Bundle',
                'Symfony\\Bundle' => '/var/www/xwc-sandbox/app/../src/vendor/symfony/src/Symfony/Bundle',
            ),
            'kernel.bundles' => array(
                0 => 'Symfony\\Bundle\\FrameworkBundle\\FrameworkBundle',
                1 => 'Symfony\\Bundle\\TwigBundle\\TwigBundle',
                2 => 'Symfony\\Bundle\\ZendBundle\\ZendBundle',
                3 => 'Symfony\\Bundle\\SwiftmailerBundle\\SwiftmailerBundle',
                4 => 'Symfony\\Bundle\\DoctrineBundle\\DoctrineBundle',
                5 => 'Bundle\\TangentLabs\\XwcCoreBundle\\XwcCoreBundle',
                6 => 'Symfony\\Bundle\\WebProfilerBundle\\WebProfilerBundle',
            ),
            'kernel.charset' => 'UTF-8',
            'request_listener.class' => 'Symfony\\Bundle\\FrameworkBundle\\RequestListener',
            'controller_resolver.class' => 'Symfony\\Bundle\\FrameworkBundle\\Controller\\ControllerResolver',
            'controller_name_converter.class' => 'Symfony\\Bundle\\FrameworkBundle\\Controller\\ControllerNameConverter',
            'response_listener.class' => 'Symfony\\Component\\HttpKernel\\ResponseListener',
            'exception_listener.class' => 'Symfony\\Component\\HttpKernel\\Debug\\ExceptionListener',
            'exception_listener.controller' => 'Symfony\\Bundle\\FrameworkBundle\\Controller\\ExceptionController::exceptionAction',
            'esi.class' => 'Symfony\\Component\\HttpKernel\\Cache\\Esi',
            'esi_listener.class' => 'Symfony\\Component\\HttpKernel\\Cache\\EsiListener',
            'csrf_secret' => 'xxxxxxxxxx',
            'event_dispatcher.class' => 'Symfony\\Bundle\\FrameworkBundle\\EventDispatcher',
            'http_kernel.class' => 'Symfony\\Component\\HttpKernel\\HttpKernel',
            'response.class' => 'Symfony\\Component\\HttpFoundation\\Response',
            'error_handler.class' => 'Symfony\\Component\\HttpKernel\\Debug\\ErrorHandler',
            'error_handler.level' => NULL,
            'debug.event_dispatcher.class' => 'Symfony\\Bundle\\FrameworkBundle\\Debug\\EventDispatcher',
            'router.class' => 'Symfony\\Component\\Routing\\Router',
            'routing.loader.class' => 'Symfony\\Bundle\\FrameworkBundle\\Routing\\DelegatingLoader',
            'routing.resolver.class' => 'Symfony\\Bundle\\FrameworkBundle\\Routing\\LoaderResolver',
            'routing.loader.xml.class' => 'Symfony\\Component\\Routing\\Loader\\XmlFileLoader',
            'routing.loader.yml.class' => 'Symfony\\Component\\Routing\\Loader\\YamlFileLoader',
            'routing.loader.php.class' => 'Symfony\\Component\\Routing\\Loader\\PhpFileLoader',
            'router.options.generator_class' => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator',
            'router.options.generator_base_class' => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator',
            'router.options.generator_dumper_class' => 'Symfony\\Component\\Routing\\Generator\\Dumper\\PhpGeneratorDumper',
            'router.options.matcher_class' => 'Symfony\\Component\\Routing\\Matcher\\UrlMatcher',
            'router.options.matcher_base_class' => 'Symfony\\Component\\Routing\\Matcher\\UrlMatcher',
            'router.options.matcher_dumper_class' => 'Symfony\\Component\\Routing\\Matcher\\Dumper\\PhpMatcherDumper',
            'routing.resource' => '/var/www/xwc-sandbox/app/config/routing_dev.yml',
            'kernel.compiled_classes' => array(
                0 => 'Symfony\\Component\\Routing\\RouterInterface',
                1 => 'Symfony\\Component\\Routing\\Router',
                2 => 'Symfony\\Component\\Routing\\Matcher\\UrlMatcherInterface',
                3 => 'Symfony\\Component\\Routing\\Matcher\\UrlMatcher',
                4 => 'Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface',
                5 => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator',
                6 => 'Symfony\\Component\\Routing\\Loader\\LoaderInterface',
                7 => 'Symfony\\Bundle\\FrameworkBundle\\Routing\\LazyLoader',
                8 => 'Symfony\\Component\\Templating\\Loader\\LoaderInterface',
                9 => 'Symfony\\Component\\Templating\\Loader\\Loader',
                10 => 'Symfony\\Component\\Templating\\Loader\\FilesystemLoader',
                11 => 'Symfony\\Component\\Templating\\Engine',
                12 => 'Symfony\\Component\\Templating\\Renderer\\RendererInterface',
                13 => 'Symfony\\Component\\Templating\\Renderer\\Renderer',
                14 => 'Symfony\\Component\\Templating\\Renderer\\PhpRenderer',
                15 => 'Symfony\\Component\\Templating\\Storage\\Storage',
                16 => 'Symfony\\Component\\Templating\\Storage\\FileStorage',
                17 => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Engine',
                18 => 'Symfony\\Component\\Templating\\Helper\\Helper',
                19 => 'Symfony\\Component\\Templating\\Helper\\SlotsHelper',
                20 => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\ActionsHelper',
                21 => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\RouterHelper',
                22 => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\RouterHelper',
                23 => 'Symfony\\Component\\HttpFoundation\\Session',
                24 => 'Symfony\\Component\\HttpFoundation\\SessionStorage\\SessionStorageInterface',
                25 => 'Symfony\\Component\\HttpFoundation\\ParameterBag',
                26 => 'Symfony\\Component\\HttpFoundation\\HeaderBag',
                27 => 'Symfony\\Component\\HttpFoundation\\Request',
                28 => 'Symfony\\Component\\HttpFoundation\\Response',
                29 => 'Symfony\\Component\\HttpFoundation\\ResponseHeaderBag',
                30 => 'Symfony\\Component\\HttpKernel\\HttpKernel',
                31 => 'Symfony\\Component\\HttpKernel\\ResponseListener',
                32 => 'Symfony\\Component\\HttpKernel\\Controller\\ControllerResolver',
                33 => 'Symfony\\Component\\HttpKernel\\Controller\\ControllerResolverInterface',
                34 => 'Symfony\\Bundle\\FrameworkBundle\\RequestListener',
                35 => 'Symfony\\Bundle\\FrameworkBundle\\Controller\\ControllerNameConverter',
                36 => 'Symfony\\Bundle\\FrameworkBundle\\Controller\\ControllerResolver',
                37 => 'Symfony\\Bundle\\FrameworkBundle\\Controller\\Controller',
                38 => 'Symfony\\Component\\EventDispatcher\\Event',
                39 => 'Symfony\\Component\\EventDispatcher\\EventDispatcher',
                40 => 'Symfony\\Bundle\\FrameworkBundle\\EventDispatcher',
                41 => 'Symfony\\Component\\Form\\FormConfiguration',
                42 => 'Symfony\\Component\\Routing\\RouterInterface',
                43 => 'Symfony\\Component\\Routing\\Router',
                44 => 'Symfony\\Component\\Routing\\Matcher\\UrlMatcherInterface',
                45 => 'Symfony\\Component\\Routing\\Matcher\\UrlMatcher',
                46 => 'Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface',
                47 => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator',
                48 => 'Symfony\\Component\\Routing\\Loader\\LoaderInterface',
                49 => 'Symfony\\Bundle\\FrameworkBundle\\Routing\\LazyLoader',
                50 => 'Symfony\\Component\\HttpFoundation\\Session',
                51 => 'Symfony\\Component\\HttpFoundation\\SessionStorage\\SessionStorageInterface',
                52 => 'Symfony\\Component\\HttpFoundation\\ParameterBag',
                53 => 'Symfony\\Component\\HttpFoundation\\HeaderBag',
                54 => 'Symfony\\Component\\HttpFoundation\\Request',
                55 => 'Symfony\\Component\\HttpFoundation\\Response',
                56 => 'Symfony\\Component\\HttpFoundation\\ResponseHeaderBag',
                57 => 'Symfony\\Component\\HttpKernel\\HttpKernel',
                58 => 'Symfony\\Component\\HttpKernel\\ResponseListener',
                59 => 'Symfony\\Component\\HttpKernel\\Controller\\ControllerResolver',
                60 => 'Symfony\\Component\\HttpKernel\\Controller\\ControllerResolverInterface',
                61 => 'Symfony\\Bundle\\FrameworkBundle\\RequestListener',
                62 => 'Symfony\\Bundle\\FrameworkBundle\\Controller\\ControllerNameConverter',
                63 => 'Symfony\\Bundle\\FrameworkBundle\\Controller\\ControllerResolver',
                64 => 'Symfony\\Bundle\\FrameworkBundle\\Controller\\Controller',
                65 => 'Symfony\\Component\\EventDispatcher\\Event',
                66 => 'Symfony\\Component\\EventDispatcher\\EventDispatcher',
                67 => 'Symfony\\Bundle\\FrameworkBundle\\EventDispatcher',
                68 => 'Symfony\\Component\\Form\\FormConfiguration',
            ),
            'validator.class' => 'Symfony\\Component\\Validator\\Validator',
            'validator.mapping.class_metadata_factory.class' => 'Symfony\\Component\\Validator\\Mapping\\ClassMetadataFactory',
            'validator.mapping.loader.loader_chain.class' => 'Symfony\\Component\\Validator\\Mapping\\Loader\\LoaderChain',
            'validator.mapping.loader.static_method_loader.class' => 'Symfony\\Component\\Validator\\Mapping\\Loader\\StaticMethodLoader',
            'validator.mapping.loader.annotation_loader.class' => 'Symfony\\Component\\Validator\\Mapping\\Loader\\AnnotationLoader',
            'validator.mapping.loader.xml_file_loader.class' => 'Symfony\\Component\\Validator\\Mapping\\Loader\\XmlFileLoader',
            'validator.mapping.loader.yaml_file_loader.class' => 'Symfony\\Component\\Validator\\Mapping\\Loader\\YamlFileLoader',
            'validator.mapping.loader.xml_files_loader.class' => 'Symfony\\Component\\Validator\\Mapping\\Loader\\XmlFilesLoader',
            'validator.mapping.loader.yaml_files_loader.class' => 'Symfony\\Component\\Validator\\Mapping\\Loader\\YamlFilesLoader',
            'validator.mapping.loader.static_method_loader.method_name' => 'loadValidatorMetadata',
            'validator.validator_factory.class' => 'Symfony\\Bundle\\FrameworkBundle\\Validator\\ConstraintValidatorFactory',
            'validator.annotations.namespaces' => array(
                'validation' => 'Symfony\\Component\\Validator\\Constraints\\',
            ),
            'templating.engine.class' => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Engine',
            'templating.loader.filesystem.class' => 'Symfony\\Component\\Templating\\Loader\\FilesystemLoader',
            'templating.loader.cache.class' => 'Symfony\\Component\\Templating\\Loader\\CacheLoader',
            'templating.loader.chain.class' => 'Symfony\\Component\\Templating\\Loader\\ChainLoader',
            'templating.helper.javascripts.class' => 'Symfony\\Component\\Templating\\Helper\\JavascriptsHelper',
            'templating.helper.stylesheets.class' => 'Symfony\\Component\\Templating\\Helper\\StylesheetsHelper',
            'templating.helper.slots.class' => 'Symfony\\Component\\Templating\\Helper\\SlotsHelper',
            'templating.helper.assets.class' => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\AssetsHelper',
            'templating.helper.actions.class' => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\ActionsHelper',
            'templating.helper.router.class' => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\RouterHelper',
            'templating.helper.request.class' => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\RequestHelper',
            'templating.helper.session.class' => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\SessionHelper',
            'templating.helper.code.class' => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\CodeHelper',
            'templating.helper.translator.class' => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\TranslatorHelper',
            'templating.helper.security.class' => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\SecurityHelper',
            'templating.helper.form.class' => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\FormHelper',
            'templating.assets.version' => NULL,
            'templating.assets.base_urls' => array(

            ),
            'debug.file_link_format' => NULL,
            'templating.debugger.class' => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Debugger',
            'templating.loader.filesystem.path' => array(
                0 => '/var/www/xwc-sandbox/app/views/%bundle%/%controller%/%name%%format%.%renderer%',
                1 => '/var/www/xwc-sandbox/app/../src/Application/%bundle%/Resources/views/%controller%/%name%%format%.%renderer%',
                2 => '/var/www/xwc-sandbox/app/../src/Bundle/%bundle%/Resources/views/%controller%/%name%%format%.%renderer%',
                3 => '/var/www/xwc-sandbox/app/../src/vendor/symfony/src/Symfony/Bundle/%bundle%/Resources/views/%controller%/%name%%format%.%renderer%',
            ),
            'templating.loader.cache.path' => NULL,
            'session.class' => 'Symfony\\Component\\HttpFoundation\\Session',
            'session.default_locale' => 'en',
            'session.storage.native.class' => 'Symfony\\Component\\HttpFoundation\\SessionStorage\\NativeSessionStorage',
            'session.storage.native.options' => array(
                'lifetime' => 3600,
            ),
            'session.storage.pdo.class' => 'Symfony\\Component\\HttpFoundation\\SessionStorage\\PdoSessionStorage',
            'session.storage.pdo.options' => array(

            ),
            'translator.class' => 'Symfony\\Bundle\\FrameworkBundle\\Translation\\Translator',
            'translator.identity.class' => 'Symfony\\Component\\Translation\\IdentityTranslator',
            'translator.selector.class' => 'Symfony\\Component\\Translation\\MessageSelector',
            'translation.loader.php.class' => 'Symfony\\Component\\Translation\\Loader\\PhpFileLoader',
            'translation.loader.yml.class' => 'Symfony\\Component\\Translation\\Loader\\YamlFileLoader',
            'translation.loader.xliff.class' => 'Symfony\\Component\\Translation\\Loader\\XliffFileLoader',
            'translator.fallback_locale' => 'en',
            'translation.resources' => array(
                0 => array(
                    0 => 'xliff',
                    1 => '/var/www/xwc-sandbox/src/vendor/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/translations/validators.fr.xliff',
                    2 => 'fr',
                    3 => 'validators',
                ),
            ),
            'profiler.class' => 'Symfony\\Bundle\\FrameworkBundle\\Profiler',
            'profiler.storage.class' => 'Symfony\\Component\\HttpKernel\\Profiler\\SQLiteProfilerStorage',
            'profiler.storage.file' => '/var/www/xwc-sandbox/app/cache/dev/profiler.db',
            'profiler.storage.lifetime' => 86400,
            'profiler_listener.class' => 'Symfony\\Component\\HttpKernel\\Profiler\\ProfilerListener',
            'profiler_listener.only_exceptions' => false,
            'data_collector.config.class' => 'Symfony\\Bundle\\FrameworkBundle\\DataCollector\\ConfigDataCollector',
            'data_collector.request.class' => 'Symfony\\Bundle\\FrameworkBundle\\DataCollector\\RequestDataCollector',
            'data_collector.security.class' => 'Symfony\\Component\\HttpKernel\\DataCollector\\SecurityDataCollector',
            'data_collector.exception.class' => 'Symfony\\Component\\HttpKernel\\DataCollector\\ExceptionDataCollector',
            'data_collector.events.class' => 'Symfony\\Component\\HttpKernel\\DataCollector\\EventDataCollector',
            'data_collector.logger.class' => 'Symfony\\Component\\HttpKernel\\DataCollector\\LoggerDataCollector',
            'data_collector.timer.class' => 'Symfony\\Bundle\\FrameworkBundle\\DataCollector\\TimerDataCollector',
            'data_collector.memory.class' => 'Symfony\\Component\\HttpKernel\\DataCollector\\MemoryDataCollector',
            'twig.class' => 'Symfony\\Bundle\\TwigBundle\\Environment',
            'twig.options' => array(
                'charset' => 'UTF-8',
                'debug' => true,
                'cache' => '/var/www/xwc-sandbox/app/cache/dev/twig',
                'strict_variables' => true,
            ),
            'twig.loader.class' => 'Symfony\\Bundle\\TwigBundle\\Loader\\Loader',
            'twig.renderer.class' => 'Symfony\\Bundle\\TwigBundle\\Renderer\\Renderer',
            'twig.form.resources' => array(
                0 => 'TwigBundle::form.twig',
            ),
            'debug.toolbar.class' => 'Symfony\\Bundle\\WebProfilerBundle\\WebDebugToolbarListener',
            'debug.toolbar.intercept_redirects' => true,
            'zend.logger.class' => 'Symfony\\Bundle\\ZendBundle\\Logger\\Logger',
            'zend.logger.priority' => 7,
            'zend.logger.log_errors' => true,
            'zend.logger.writer.debug.class' => 'Symfony\\Bundle\\ZendBundle\\Logger\\DebugLogger',
            'zend.logger.writer.filesystem.class' => 'Zend\\Log\\Writer\\Stream',
            'zend.formatter.filesystem.class' => 'Zend\\Log\\Formatter\\Simple',
            'zend.formatter.filesystem.format' => '%timestamp% %priorityName%: %message%
',
            'zend.logger.path' => '/var/www/xwc-sandbox/app/logs/dev.log',
        );
    }
}
