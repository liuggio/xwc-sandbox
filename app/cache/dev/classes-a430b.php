<?php
namespace Symfony\Component\Routing;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
interface RouterInterface extends UrlMatcherInterface, UrlGeneratorInterface { }
namespace Symfony\Component\Routing;
use Symfony\Component\Routing\Loader\LoaderInterface;
class Router implements RouterInterface {
    protected $matcher;
    protected $generator;
    protected $options;
    protected $defaults;
    protected $context;
    protected $loader;
    protected $collection;
    protected $resource;
    public function __construct(LoaderInterface $loader, $resource, array $options = array(), array $context = array(), array $defaults = array()) {
        $this->loader = $loader;
        $this->resource = $resource;
        $this->context = $context;
        $this->defaults = $defaults;
        $this->options = array(
            'cache_dir'              => null,
            'debug'                  => false,
            'generator_class'        => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator',
            'generator_base_class'   => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator',
            'generator_dumper_class' => 'Symfony\\Component\\Routing\\Generator\\Dumper\\PhpGeneratorDumper',
            'generator_cache_class'  => 'ProjectUrlGenerator',
            'matcher_class'          => 'Symfony\\Component\\Routing\\Matcher\\UrlMatcher',
            'matcher_base_class'     => 'Symfony\\Component\\Routing\\Matcher\\UrlMatcher',
            'matcher_dumper_class'   => 'Symfony\\Component\\Routing\\Matcher\\Dumper\\PhpMatcherDumper',
            'matcher_cache_class'    => 'ProjectUrlMatcher',
        );
                if ($diff = array_diff(array_keys($options), array_keys($this->options))) {
            throw new \InvalidArgumentException(sprintf('The Router does not support the following options: \'%s\'.', implode('\', \'', $diff))); }
        $this->options = array_merge($this->options, $options); }
    public function getRouteCollection() {
        if (null === $this->collection) {
            $this->collection = $this->loader->load($this->resource); }
        return $this->collection; }
    public function setContext(array $context = array()) {
        $this->context = $context; }
    public function setDefaults(array $defaults = array()) {
        $this->defaults = $defaults; }
    public function generate($name, array $parameters = array(), $absolute = false) {
        return $this->getGenerator()->generate($name, $parameters, $absolute); }
    public function match($url) {
        return $this->getMatcher()->match($url); }
    public function getMatcher() {
        if (null !== $this->matcher) {
            return $this->matcher; }
        if (null === $this->options['cache_dir'] || null === $this->options['matcher_cache_class']) {
            return $this->matcher = new $this->options['matcher_class']($this->getRouteCollection(), $this->context, $this->defaults); }
        $class = $this->options['matcher_cache_class'];
        if ($this->needsReload($class)) {
            $dumper = new $this->options['matcher_dumper_class']($this->getRouteCollection());
            $options = array(
                'class'      => $class,
                'base_class' => $this->options['matcher_base_class'],
            );
            $this->updateCache($class, $dumper->dump($options)); }
        require_once $this->getCacheFile($class);
        return $this->matcher = new $class($this->context, $this->defaults); }
    public function getGenerator() {
        if (null !== $this->generator) {
            return $this->generator; }
        if (null === $this->options['cache_dir'] || null === $this->options['generator_cache_class']) {
            return $this->generator = new $this->options['generator_class']($this->getRouteCollection(), $this->context, $this->defaults); }
        $class = $this->options['generator_cache_class'];
        if ($this->needsReload($class)) {
            $dumper = new $this->options['generator_dumper_class']($this->getRouteCollection());
            $options = array(
                'class'      => $class,
                'base_class' => $this->options['generator_base_class'],
            );
            $this->updateCache($class, $dumper->dump($options)); }
        require_once $this->getCacheFile($class);
        return $this->generator = new $class($this->context, $this->defaults); }
    protected function updateCache($class, $dump) {
        $this->writeCacheFile($this->getCacheFile($class), $dump);
        if ($this->options['debug']) {
            $this->writeCacheFile($this->getCacheFile($class, 'meta'), serialize($this->getRouteCollection()->getResources())); } }
    protected function needsReload($class) {
        $file = $this->getCacheFile($class);
        if (!file_exists($file)) {
            return true; }
        if (!$this->options['debug']) {
            return false; }
        $metadata = $this->getCacheFile($class, 'meta');
        if (!file_exists($metadata)) {
            return true; }
        $time = filemtime($file);
        $meta = unserialize(file_get_contents($metadata));
        foreach ($meta as $resource) {
            if (!$resource->isUptodate($time)) {
                return true; } }
        return false; }
    protected function getCacheFile($class, $extension = 'php') {
        return $this->options['cache_dir'].'/'.$class.'.'.$extension; }
    protected function writeCacheFile($file, $content) {
        $tmpFile = tempnam(dirname($file), basename($file));
        if (false !== @file_put_contents($tmpFile, $content) && @rename($tmpFile, $file)) {
            chmod($file, 0644);
            return; }
        throw new \RuntimeException(sprintf('Failed to write cache file "%s".', $file)); } }
namespace Symfony\Component\Routing\Matcher;
interface UrlMatcherInterface {
    function match($url); }
namespace Symfony\Component\Routing\Matcher;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
class UrlMatcher implements UrlMatcherInterface {
    protected $routes;
    protected $defaults;
    protected $context;
    public function __construct(RouteCollection $routes, array $context = array(), array $defaults = array()) {
        $this->routes = $routes;
        $this->context = $context;
        $this->defaults = $defaults; }
    public function match($url) {
        $url = $this->normalizeUrl($url);
        foreach ($this->routes->all() as $name => $route) {
            $compiledRoute = $route->compile();
            if (isset($this->context['method']) && (($req = $route->getRequirement('_method')) && !preg_match(sprintf('#^(%s)$#xi', $req), $this->context['method']))) {
                continue; }
                        if ('' !== $compiledRoute->getStaticPrefix() && 0 !== strpos($url, $compiledRoute->getStaticPrefix())) {
                continue; }
            if (!preg_match($compiledRoute->getRegex(), $url, $matches)) {
                continue; }
            return array_merge($this->mergeDefaults($matches, $route->getDefaults()), array('_route' => $name)); }
        return false; }
    protected function mergeDefaults($params, $defaults) {
        $parameters = array_merge($this->defaults, $defaults);
        foreach ($params as $key => $value) {
            if (!is_int($key)) {
                $parameters[$key] = urldecode($value); } }
        return $parameters; }
    protected function normalizeUrl($url) {
                if ('/' !== substr($url, 0, 1)) {
            $url = '/'.$url; }
                if (false !== $pos = strpos($url, '?')) {
            $url = substr($url, 0, $pos); }
                return preg_replace('#/+#', '/', $url); } }
namespace Symfony\Component\Routing\Generator;
interface UrlGeneratorInterface {
    function generate($name, array $parameters, $absolute = false); }
namespace Symfony\Component\Routing\Generator;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
class UrlGenerator implements UrlGeneratorInterface {
    protected $routes;
    protected $defaults;
    protected $context;
    protected $cache;
    public function __construct(RouteCollection $routes, array $context = array(), array $defaults = array()) {
        $this->routes = $routes;
        $this->context = $context;
        $this->defaults = $defaults;
        $this->cache = array(); }
    public function generate($name, array $parameters, $absolute = false) {
        if (null === $route = $this->routes->get($name)) {
            throw new \InvalidArgumentException(sprintf('Route "%s" does not exist.', $name)); }
        if (!isset($this->cache[$name])) {
            $this->cache[$name] = $route->compile(); }
        return $this->doGenerate($this->cache[$name]->getVariables(), $route->getDefaults(), $route->getRequirements(), $this->cache[$name]->getTokens(), $parameters, $name, $absolute); }
    protected function doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $absolute) {
        $defaults = array_merge($this->defaults, $defaults);
        $tparams = array_merge($defaults, $parameters);
                if ($diff = array_diff_key($variables, $tparams)) {
            throw new \InvalidArgumentException(sprintf('The "%s" route has some missing mandatory parameters (%s).', $name, implode(', ', $diff))); }
        $url = '';
        $optional = true;
        foreach ($tokens as $token) {
            if ('variable' === $token[0]) {
                if (false === $optional || !isset($defaults[$token[3]]) || (isset($parameters[$token[3]]) && $parameters[$token[3]] != $defaults[$token[3]])) {
                                        if (isset($requirements[$token[3]]) && !preg_match('#^'.$requirements[$token[3]].'$#', $tparams[$token[3]])) {
                        throw new \InvalidArgumentException(sprintf('Parameter "%s" for route "%s" must match "%s" ("%s" given).', $token[3], $name, $requirements[$token[3]], $tparams[$token[3]])); }
                    $url = $token[1].urlencode($tparams[$token[3]]).$url;
                    $optional = false; } } elseif ('text' === $token[0]) {
                $url = $token[1].$token[2].$url;
                $optional = false; } else {
                                if ($segment = call_user_func_array(array($this, 'generateFor'.ucfirst(array_shift($token))), array_merge(array($optional, $tparams), $token))) {
                    $url = $segment.$url;
                    $optional = false; } } }
        if (!$url) {
            $url = '/'; }
                if ($extra = array_diff_key($parameters, $variables, $defaults)) {
            $url .= '?'.http_build_query($extra); }
        $url = (isset($this->context['base_url']) ? $this->context['base_url'] : '').$url;
        if ($absolute && isset($this->context['host'])) {
            $url = 'http'.(isset($this->context['is_secure']) && $this->context['is_secure'] ? 's' : '').'://'.$this->context['host'].$url; }
        return $url; } }
namespace Symfony\Component\Routing\Loader;
use Symfony\Component\Routing\Loader\LoaderResolver;
interface LoaderInterface {
    function load($resource, $type = null);
    function supports($resource, $type = null);
    function getResolver();
    function setResolver(LoaderResolver $resolver); }
namespace Symfony\Bundle\FrameworkBundle\Routing;
use Symfony\Component\Routing\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Loader\LoaderResolver as BaseLoaderResolver;
class LazyLoader implements LoaderInterface {
    protected $container;
    protected $service;
    public function __construct(ContainerInterface $container, $service) {
        $this->container = $container;
        $this->service = $service; }
    public function load($resource, $type = null) {
        return $this->container->get($this->service)->load($resource, $type); }
    public function supports($resource, $type = null) {
        return $this->container->get($this->service)->supports($resource, $type); }
    public function getResolver() {
        return $this->container->get($this->service)->getResolver(); }
    public function setResolver(BaseLoaderResolver $resolver) {
        $this->container->get($this->service)->setResolver($resolver); } }
namespace Symfony\Component\Templating\Loader;
interface LoaderInterface {
    function load($template, array $options = array());
    function isFresh($template, array $options = array(), $time); }
namespace Symfony\Component\Templating\Loader;
use Symfony\Component\Templating\DebuggerInterface;
abstract class Loader implements LoaderInterface {
    protected $debugger;
    protected $defaultOptions;
    public function __construct() {
        $this->defaultOptions = array('renderer' => 'php'); }
    public function setDebugger(DebuggerInterface $debugger) {
        $this->debugger = $debugger; }
    public function setDefaultOption($name, $value) {
        $this->defaultOptions[$name] = $value; }
    protected function mergeDefaultOptions(array $options) {
        return array_merge($this->defaultOptions, $options); } }
namespace Symfony\Component\Templating\Loader;
use Symfony\Component\Templating\Storage\Storage;
use Symfony\Component\Templating\Storage\FileStorage;
class FilesystemLoader extends Loader {
    protected $templatePathPatterns;
    public function __construct($templatePathPatterns) {
        if (!is_array($templatePathPatterns)) {
            $templatePathPatterns = array($templatePathPatterns); }
        $this->templatePathPatterns = $templatePathPatterns;
        parent::__construct(); }
    public function load($template, array $options = array()) {
        if (self::isAbsolutePath($template) && file_exists($template)) {
            return new FileStorage($template); }
        $options = $this->mergeDefaultOptions($options);
        $options['name'] = $template;
        $replacements = array();
        foreach ($options as $key => $value) {
            $replacements['%'.$key.'%'] = $value; }
        $logs = array();
        foreach ($this->templatePathPatterns as $templatePathPattern) {
            if (is_file($file = strtr($templatePathPattern, $replacements))) {
                if (null !== $this->debugger) {
                    $this->debugger->log(sprintf('Loaded template file "%s" (renderer: %s)', $file, $options['renderer'])); }
                return new FileStorage($file); }
            if (null !== $this->debugger) {
                $logs[] = sprintf('Failed loading template file "%s" (renderer: %s)', $file, $options['renderer']); } }
        if (null !== $this->debugger) {
            foreach ($logs as $log) {
                $this->debugger->log($log); } }
        return false; }
    public function isFresh($template, array $options = array(), $time) {
        if (false === $template = $this->load($template, $options)) {
            return false; }
        return filemtime((string) $template) < $time; }
    static protected function isAbsolutePath($file) {
        if ($file[0] == '/' || $file[0] == '\\'
            || (strlen($file) > 3 && ctype_alpha($file[0])
                && $file[1] == ':'
                && ($file[2] == '\\' || $file[2] == '/')
            )
        ) {
            return true; }
        return false; } }
namespace Symfony\Component\Templating;
use Symfony\Component\Templating\Loader\LoaderInterface;
use Symfony\Component\Templating\Renderer\PhpRenderer;
use Symfony\Component\Templating\Renderer\RendererInterface;
use Symfony\Component\Templating\Helper\HelperInterface;
class Engine implements \ArrayAccess {
    protected $loader;
    protected $renderers;
    protected $current;
    protected $currentRenderer;
    protected $helpers;
    protected $parents;
    protected $stack;
    protected $charset;
    protected $cache;
    protected $escapers;
    public function __construct(LoaderInterface $loader, array $renderers = array(), array $helpers = array(), array $escapers = array()) {
        $this->loader    = $loader;
        $this->renderers = $renderers;
        $this->helpers   = array();
        $this->parents   = array();
        $this->stack     = array();
        $this->charset   = 'UTF-8';
        $this->cache     = array();
        $this->addHelpers($helpers);
        if (!isset($this->renderers['php'])) {
            $this->renderers['php'] = new PhpRenderer(); }
        foreach ($this->renderers as $renderer) {
            $renderer->setEngine($this); }
        $this->initializeEscapers();
        foreach ($this->escapers as $context => $escaper) {
            $this->setEscaper($context, $escaper); } }
    public function render($name, array $parameters = array()) {
        if (isset($this->cache[$name])) {
            list($tpl, $options, $template) = $this->cache[$name]; } else {
            list($tpl, $options) = $this->splitTemplateName($name);
                        $template = $this->loader->load($tpl, $options);
            if (false === $template) {
                throw new \InvalidArgumentException(sprintf('The template "%s" does not exist (renderer: %s).', $name, $options['renderer'])); }
            $this->cache[$name] = array($tpl, $options, $template); }
                $renderer = $template->getRenderer() ? $template->getRenderer() : $options['renderer'];
                if (null !== $this->currentRenderer && $renderer !== $this->currentRenderer) {
            throw new \LogicException(sprintf('A "%s" template cannot extend a "%s" template.', $this->currentRenderer, $renderer)); }
        if (!isset($this->renderers[$options['renderer']])) {
            throw new \InvalidArgumentException(sprintf('The renderer "%s" is not registered.', $renderer)); }
        $this->current = $name;
        $this->parents[$name] = null;
                if (false === $content = $this->renderers[$renderer]->evaluate($template, $parameters)) {
            throw new \RuntimeException(sprintf('The template "%s" cannot be rendered (renderer: %s).', $name, $renderer)); }
                if ($this->parents[$name]) {
            $slots = $this->get('slots');
            $this->stack[] = $slots->get('_content');
            $slots->set('_content', $content);
            $this->currentRenderer = $renderer;
            $content = $this->render($this->parents[$name], $parameters);
            $this->currentRenderer = null;
            $slots->set('_content', array_pop($this->stack)); }
        return $content; }
    public function exists($name) {
        return false !== $this->load($name); }
    public function load($name) {
        if (isset($this->cache[$name])) {
            list($tpl, $options, $template) = $this->cache[$name]; } else {
            list($tpl, $options) = $this->splitTemplateName($name);
                        $template = $this->loader->load($tpl, $options);
            if (false === $template) {
                return false; }
            $this->cache[$name] = array($tpl, $options, $template); }
        return $template; }
    public function output($name, array $parameters = array()) {
        echo $this->render($name, $parameters); }
    public function offsetGet($name) {
        return $this->$name = $this->get($name); }
    public function offsetExists($name) {
        return isset($this->helpers[$name]); }
    public function offsetSet($name, $value) {
        $this->set($name, $value); }
    public function offsetUnset($name) {
        throw new \LogicException(sprintf('You can\'t unset a helper (%s).', $name)); }
    public function addHelpers(array $helpers = array()) {
        foreach ($helpers as $alias => $helper) {
            $this->set($helper, is_int($alias) ? null : $alias); } }
    public function set(HelperInterface $helper, $alias = null) {
        $this->helpers[$helper->getName()] = $helper;
        if (null !== $alias) {
            $this->helpers[$alias] = $helper; }
        $helper->setCharset($this->charset); }
    public function has($name) {
        return isset($this->helpers[$name]); }
    public function get($name) {
        if (!isset($this->helpers[$name])) {
            throw new \InvalidArgumentException(sprintf('The helper "%s" is not defined.', $name)); }
        return $this->helpers[$name]; }
    public function extend($template) {
        $this->parents[$this->current] = $template; }
    public function escape($value, $context = 'html') {
        return call_user_func($this->getEscaper($context), $value); }
    public function setCharset($charset) {
        $this->charset = $charset; }
    public function getCharset() {
        return $this->charset; }
    public function getLoader() {
        return $this->loader; }
    public function setRenderer($name, RendererInterface $renderer) {
        $this->renderers[$name] = $renderer;
        $renderer->setEngine($this); }
    public function splitTemplateName($name) {
        if (false !== $pos = strpos($name, ':')) {
            $renderer = substr($name, $pos + 1);
            $name = substr($name, 0, $pos); } else {
            $renderer = 'php'; }
        return array($name, array('renderer' => $renderer)); }
    public function setEscaper($context, $escaper) {
        $this->escapers[$context] = $escaper; }
    public function getEscaper($context) {
        if (!isset($this->escapers[$context])) {
            throw new \InvalidArgumentException(sprintf('No registered escaper for context "%s".', $context)); }
        return $this->escapers[$context]; }
    protected function initializeEscapers() {
        $that = $this;
        $this->escapers = array(
            'html' =>
                function ($value) use ($that) {
                                                            return is_string($value) ? htmlspecialchars($value, ENT_QUOTES, $that->getCharset(), false) : $value; },
            'js' =>
                function ($value) use ($that) {
                    if ('UTF-8' != $that->getCharset()) {
                        $string = $that->convertEncoding($string, 'UTF-8', $that->getCharset()); }
                    $callback = function ($matches) use ($that) {
                        $char = $matches[0];
                                                if (!isset($char[1])) {
                            return '\\x'.substr('00'.bin2hex($char), -2); }
                                                $char = $that->convertEncoding($char, 'UTF-16BE', 'UTF-8');
                        return '\\u'.substr('0000'.bin2hex($char), -4); };
                    if (null === $string = preg_replace_callback('#[^\p{L}\p{N} ]#u', $callback, $string)) {
                        throw new \InvalidArgumentException('The string to escape is not a valid UTF-8 string.'); }
                    if ('UTF-8' != $that->getCharset()) {
                        $string = $that->convertEncoding($string, $that->getCharset(), 'UTF-8'); }
                    return $string; },
        ); }
    public function convertEncoding($string, $to, $from) {
        if (function_exists('iconv')) {
            return iconv($from, $to, $string); } elseif (function_exists('mb_convert_encoding')) {
            return mb_convert_encoding($string, $to, $from); } else {
            throw new \RuntimeException('No suitable convert encoding function (use UTF-8 as your encoding or install the iconv or mbstring extension).'); } } }
namespace Symfony\Component\Templating\Renderer;
use Symfony\Component\Templating\Engine;
use Symfony\Component\Templating\Storage\Storage;
interface RendererInterface {
    function evaluate(Storage $template, array $parameters = array());
    function setEngine(Engine $engine); }
namespace Symfony\Component\Templating\Renderer;
use Symfony\Component\Templating\Engine;
abstract class Renderer implements RendererInterface {
    protected $engine;
    public function setEngine(Engine $engine) {
        $this->engine = $engine; } }
namespace Symfony\Component\Templating\Renderer;
use Symfony\Component\Templating\Storage\Storage;
use Symfony\Component\Templating\Storage\FileStorage;
use Symfony\Component\Templating\Storage\StringStorage;
class PhpRenderer extends Renderer {
    public function evaluate(Storage $template, array $parameters = array()) {
        $__template__ = $template;
        if ($__template__ instanceof FileStorage) {
            extract($parameters);
            $view = $this->engine;
            ob_start();
            require $__template__;
            return ob_get_clean(); } elseif ($__template__ instanceof StringStorage) {
            extract($parameters);
            $view = $this->engine;
            ob_start();
            eval('; ?>'.$__template__.'<?php ;');
            return ob_get_clean(); }
        return false; } }
namespace Symfony\Component\Templating\Storage;
abstract class Storage {
    protected $renderer;
    protected $template;
    public function __construct($template, $renderer = null) {
        $this->template = $template;
        $this->renderer = $renderer; }
    public function __toString() {
        return (string) $this->template; }
    abstract public function getContent();
    public function getRenderer() {
        return $this->renderer; } }
namespace Symfony\Component\Templating\Storage;
class FileStorage extends Storage {
    public function getContent() {
        return file_get_contents($this->template); } }
namespace Symfony\Bundle\FrameworkBundle\Templating;
use Symfony\Component\Templating\Engine as BaseEngine;
use Symfony\Component\Templating\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
class Engine extends BaseEngine {
    protected $container;
    public function __construct(ContainerInterface $container, LoaderInterface $loader) {
        $this->container = $container;
        parent::__construct($loader);
        foreach ($this->container->findTaggedServiceIds('templating.renderer') as $id => $attributes) {
            if (isset($attributes[0]['alias'])) {
                $this->renderers[$attributes[0]['alias']] = $this->container->get($id);
                $this->renderers[$attributes[0]['alias']]->setEngine($this); } }
        $this->helpers = array();
        foreach ($this->container->findTaggedServiceIds('templating.helper') as $id => $attributes) {
            if (isset($attributes[0]['alias'])) {
                $this->helpers[$attributes[0]['alias']] = $id; } } }
    public function renderResponse($view, array $parameters = array(), Response $response = null) {
        if (null === $response) {
            $response = $this->container->get('response'); }
        $response->setContent($this->render($view, $parameters));
        return $response; }
    public function has($name) {
        return isset($this->helpers[$name]); }
    public function get($name) {
        if (!isset($this->helpers[$name])) {
            throw new \InvalidArgumentException(sprintf('The helper "%s" is not defined.', $name)); }
        if (is_string($this->helpers[$name])) {
            $this->helpers[$name] = $this->container->get($this->helpers[$name]);
            $this->helpers[$name]->setCharset($this->charset); }
        return $this->helpers[$name]; }
            public function splitTemplateName($name, array $defaults = array()) {
        $parts = explode(':', $name);
        if (3 !== count($parts)) {
            throw new \InvalidArgumentException(sprintf('Template name "%s" is not valid.', $name)); }
        $options = array_replace(
            array(
                'format' => '',
            ),
            $defaults,
            array(
                'bundle'     => str_replace('\\', '/', $parts[0]),
                'controller' => $parts[1],
            )
        );
        $elements = explode('.', $parts[2]);
        if (3 === count($elements)) {
            $parts[2] = $elements[0];
            if ('html' !== $elements[1]) {
                $options['format'] = '.'.$elements[1]; }
            $options['renderer'] = $elements[2]; } elseif (2 === count($elements)) {
            $parts[2] = $elements[0];
            $options['renderer'] = $elements[1];
            $format = $this->container->get('request')->getRequestFormat();
            if (null !== $format && 'html' !== $format) {
                $options['format'] = '.'.$format; } } else {
            throw new \InvalidArgumentException(sprintf('Template name "%s" is not valid.', $name)); }
        return array($parts[2], $options); } }
namespace Symfony\Component\Templating\Helper;
abstract class Helper implements HelperInterface {
    protected $charset = 'UTF-8';
    public function setCharset($charset) {
        $this->charset = $charset; }
    public function getCharset() {
        return $this->charset; } }
namespace Symfony\Component\Templating\Helper;
class SlotsHelper extends Helper {
    protected $slots = array();
    protected $openSlots = array();
    public function start($name) {
        if (in_array($name, $this->openSlots)) {
            throw new \InvalidArgumentException(sprintf('A slot named "%s" is already started.', $name)); }
        $this->openSlots[] = $name;
        $this->slots[$name] = '';
        ob_start();
        ob_implicit_flush(0); }
    public function stop() {
        if (!$this->openSlots) {
            throw new \LogicException('No slot started.'); }
        $name = array_pop($this->openSlots);
        $this->slots[$name] = ob_get_clean(); }
    public function has($name) {
        return isset($this->slots[$name]); }
    public function get($name, $default = false) {
        return isset($this->slots[$name]) ? $this->slots[$name] : $default; }
    public function set($name, $content) {
        $this->slots[$name] = $content; }
    public function output($name, $default = false) {
        if (!isset($this->slots[$name])) {
            if (false !== $default) {
                echo $default;
                return true; }
            return false; }
        echo $this->slots[$name];
        return true; }
    public function getName() {
        return 'slots'; } }
namespace Symfony\Bundle\FrameworkBundle\Templating\Helper;
use Symfony\Component\Templating\Helper\Helper;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerResolver;
class ActionsHelper extends Helper {
    protected $resolver;
    public function __construct(ControllerResolver $resolver) {
        $this->resolver = $resolver; }
    public function output($controller, array $attributes = array(), array $options = array()) {
        echo $this->render($controller, $attributes, $options); }
    public function render($controller, array $attributes = array(), array $options = array()) {
        $options['attributes'] = $attributes;
        if (isset($options['query'])) {
            $options['query'] = $options['query']; }
        return $this->resolver->render($controller, $options); }
    public function getName() {
        return 'actions'; } }
namespace Symfony\Bundle\FrameworkBundle\Templating\Helper;
use Symfony\Component\Templating\Helper\Helper;
use Symfony\Component\Routing\Router;
class RouterHelper extends Helper {
    protected $generator;
    public function __construct(Router $router) {
        $this->generator = $router->getGenerator(); }
    public function generate($name, array $parameters = array(), $absolute = false) {
        return $this->generator->generate($name, $parameters, $absolute); }
    public function getName() {
        return 'router'; } }
namespace Symfony\Component\HttpFoundation;
use Symfony\Component\HttpFoundation\SessionStorage\SessionStorageInterface;
class Session implements \Serializable {
    protected $storage;
    protected $attributes;
    protected $oldFlashes;
    protected $started;
    protected $options;
    public function __construct(SessionStorageInterface $storage, array $options = array()) {
        $this->storage = $storage;
        $this->options = $options;
        $this->attributes = array('_flash' => array(), '_locale' => $this->getDefaultLocale());
        $this->started = false; }
    public function start() {
        if (true === $this->started) {
            return; }
        $this->storage->start();
        $this->attributes = $this->storage->read('_symfony2');
        if (!isset($this->attributes['_flash'])) {
            $this->attributes['_flash'] = array(); }
        if (!isset($this->attributes['_locale'])) {
            $this->attributes['_locale'] = $this->getDefaultLocale(); }
                $this->oldFlashes = array_flip(array_keys($this->attributes['_flash']));
        $this->started = true; }
    public function has($name) {
        return array_key_exists($name, $this->attributes); }
    public function get($name, $default = null) {
        return array_key_exists($name, $this->attributes) ? $this->attributes[$name] : $default; }
    public function set($name, $value) {
        if (false === $this->started) {
            $this->start(); }
        $this->attributes[$name] = $value; }
    public function getAttributes() {
        return $this->attributes; }
    public function setAttributes($attributes) {
        if (false === $this->started) {
            $this->start(); }
        $this->attributes = $attributes; }
    public function remove($name) {
        if (false === $this->started) {
            $this->start(); }
        if (array_key_exists($name, $this->attributes)) {
            unset($this->attributes[$name]); } }
    public function clear() {
        if (false === $this->started) {
            $this->start(); }
        $this->attributes = array(); }
    public function invalidate() {
        $this->clear();
        $this->storage->regenerate(); }
    public function getLocale() {
        return $this->attributes['_locale']; }
    public function setLocale($locale) {
        if (false === $this->started) {
            $this->start(); }
        $this->attributes['_locale'] = $locale; }
    public function getFlashes() {
        return $this->attributes['_flash']; }
    public function setFlashes($values) {
        if (false === $this->started) {
            $this->start(); }
        $this->attributes['_flash'] = $values; }
    public function getFlash($name, $default = null) {
        return array_key_exists($name, $this->attributes['_flash']) ? $this->attributes['_flash'][$name] : $default; }
    public function setFlash($name, $value) {
        if (false === $this->started) {
            $this->start(); }
        $this->attributes['_flash'][$name] = $value;
        unset($this->oldFlashes[$name]); }
    public function hasFlash($name) {
        return array_key_exists($name, $this->attributes['_flash']); }
    public function save() {
        if (true === $this->started) {
            if (isset($this->attributes['_flash'])) {
                $this->attributes['_flash'] = array_diff_key($this->attributes['_flash'], $this->oldFlashes); }
            $this->storage->write('_symfony2', $this->attributes); } }
    public function __destruct() {
        $this->save(); }
    public function serialize() {
        return serialize(array($this->storage, $this->options)); }
    public function unserialize($serialized) {
        list($this->storage, $this->options) = unserialize($serialized);
        $this->attributes = array();
        $this->started = false; }
    protected function getDefaultLocale() {
        return isset($this->options['default_locale']) ? $this->options['default_locale'] : 'en'; } }
namespace Symfony\Component\HttpFoundation\SessionStorage;
interface SessionStorageInterface {
    function start();
    function read($key);
    function remove($key);
    function write($key, $data);
    function regenerate($destroy = false); }
namespace Symfony\Component\HttpFoundation;
class Response {
    public $headers;
    protected $content;
    protected $version;
    protected $statusCode;
    protected $statusText;
    static public $statusTexts = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
    );
    public function __construct($content = '', $status = 200, $headers = array()) {
        $this->setContent($content);
        $this->setStatusCode($status);
        $this->setProtocolVersion('1.0');
        $this->headers = new ResponseHeaderBag($headers); }
    public function __toString() {
        $content = '';
        if (!$this->headers->has('Content-Type')) {
            $this->headers->set('Content-Type', 'text/html'); }
                $content .= sprintf('HTTP/%s %s %s', $this->version, $this->statusCode, $this->statusText)."\n";
                foreach ($this->headers->all() as $name => $values) {
            foreach ($values as $value) {
                $content .= "$name: $value\n"; } }
        $content .= "\n".$this->getContent();
        return $content; }
    public function __clone() {
        $this->headers = clone $this->headers; }
    public function sendHeaders() {
        if (!$this->headers->has('Content-Type')) {
            $this->headers->set('Content-Type', 'text/html'); }
                header(sprintf('HTTP/%s %s %s', $this->version, $this->statusCode, $this->statusText));
                foreach ($this->headers->all() as $name => $values) {
            foreach ($values as $value) {
                header($name.': '.$value); } } }
    public function sendContent() {
        echo $this->content; }
    public function send() {
        $this->sendHeaders();
        $this->sendContent(); }
    public function setContent($content) {
        $this->content = $content; }
    public function getContent() {
        return $this->content; }
    public function setProtocolVersion($version) {
        $this->version = $version; }
    public function getProtocolVersion() {
        return $this->version; }
    public function setStatusCode($code, $text = null) {
        $this->statusCode = (int) $code;
        if ($this->statusCode < 100 || $this->statusCode > 599) {
            throw new \InvalidArgumentException(sprintf('The HTTP status code "%s" is not valid.', $code)); }
        $this->statusText = false === $text ? '' : (null === $text ? self::$statusTexts[$this->statusCode] : $text); }
    public function getStatusCode() {
        return $this->statusCode; }
    public function isCacheable() {
        if (!in_array($this->statusCode, array(200, 203, 300, 301, 302, 404, 410))) {
            return false; }
        if ($this->headers->hasCacheControlDirective('no-store') || $this->headers->getCacheControlDirective('private')) {
            return false; }
        return $this->isValidateable() || $this->isFresh(); }
    public function isFresh() {
        return $this->getTtl() > 0; }
    public function isValidateable() {
        return $this->headers->has('Last-Modified') || $this->headers->has('ETag'); }
    public function setPrivate() {
        $this->headers->removeCacheControlDirective('public');
        $this->headers->addCacheControlDirective('private'); }
    public function setPublic() {
        $this->headers->addCacheControlDirective('public');
        $this->headers->removeCacheControlDirective('private'); }
    public function mustRevalidate() {
        return $this->headers->hasCacheControlDirective('must-revalidate') || $this->headers->has('must-proxy-revalidate'); }
    public function getDate() {
        if (null === $date = $this->headers->getDate('Date')) {
            $date = new \DateTime(null, new \DateTimeZone('UTC'));
            $this->headers->set('Date', $date->format('D, d M Y H:i:s').' GMT'); }
        return $date; }
    public function getAge() {
        if ($age = $this->headers->get('Age')) {
            return $age; }
        return max(time() - $this->getDate()->format('U'), 0); }
    public function expire() {
        if ($this->isFresh()) {
            $this->headers->set('Age', $this->getMaxAge()); } }
    public function getExpires() {
        return $this->headers->getDate('Expires'); }
    public function setExpires(\DateTime $date = null) {
        if (null === $date) {
            $this->headers->remove('Expires'); } else {
            $date = clone $date;
            $date->setTimezone(new \DateTimeZone('UTC'));
            $this->headers->set('Expires', $date->format('D, d M Y H:i:s').' GMT'); } }
    public function getMaxAge() {
        if ($age = $this->headers->getCacheControlDirective('s-maxage')) {
            return $age; }
        if ($age = $this->headers->getCacheControlDirective('max-age')) {
            return $age; }
        if (null !== $this->getExpires()) {
            return $this->getExpires()->format('U') - $this->getDate()->format('U'); }
        return null; }
    public function setMaxAge($value) {
        $this->headers->addCacheControlDirective('max-age', $value); }
    public function setSharedMaxAge($value) {
        $this->headers->addCacheControlDirective('s-maxage', $value); }
    public function getTtl() {
        if ($maxAge = $this->getMaxAge()) {
            return $maxAge - $this->getAge(); }
        return null; }
    public function setTtl($seconds) {
        $this->setSharedMaxAge($this->getAge() + $seconds); }
    public function setClientTtl($seconds) {
        $this->setMaxAge($this->getAge() + $seconds); }
    public function getLastModified() {
        return $this->headers->getDate('LastModified'); }
    public function setLastModified(\DateTime $date = null) {
        if (null === $date) {
            $this->headers->remove('Last-Modified'); } else {
            $date = clone $date;
            $date->setTimezone(new \DateTimeZone('UTC'));
            $this->headers->set('Last-Modified', $date->format('D, d M Y H:i:s').' GMT'); } }
    public function getEtag() {
        return $this->headers->get('ETag'); }
    public function setEtag($etag = null, $weak = false) {
        if (null === $etag) {
            $this->headers->remove('Etag'); } else {
            if (0 !== strpos($etag, '"')) {
                $etag = '"'.$etag.'"'; }
            $this->headers->set('ETag', (true === $weak ? 'W/' : '').$etag); } }
    public function setCache(array $options) {
        if ($diff = array_diff_key($options, array('etag', 'last_modified', 'max_age', 's_maxage', 'private', 'public'))) {
            throw new \InvalidArgumentException(sprintf('Response does not support the following options: "%s".', implode('", "', array_keys($diff)))); }
        if (isset($options['etag'])) {
            $this->setEtag($options['etag']); }
        if (isset($options['last_modified'])) {
            $this->setLastModified($options['last_modified']); }
        if (isset($options['max_age'])) {
            $this->setMaxAge($options['max_age']); }
        if (isset($options['s_maxage'])) {
            $this->setSharedMaxAge($options['s_maxage']); }
        if (isset($options['public'])) {
            if ($options['public']) {
                $this->setPublic(); } else {
                $this->setPrivate(); } }
        if (isset($options['private'])) {
            if ($options['private']) {
                $this->setPrivate(); } else {
                $this->setPublic(); } } }
    public function setNotModified() {
        $this->setStatusCode(304);
        $this->setContent(null);
                foreach (array('Allow', 'Content-Encoding', 'Content-Language', 'Content-Length', 'Content-MD5', 'Content-Type', 'Last-Modified') as $header) {
            $this->headers->remove($header); } }
    public function setRedirect($url, $status = 302) {
        if (empty($url)) {
            throw new \InvalidArgumentException('Cannot redirect to an empty URL.'); }
        $this->setStatusCode($status);
        if (!$this->isRedirect()) {
            throw new \InvalidArgumentException(sprintf('The HTTP status code is not a redirect ("%s" given).', $status)); }
        $this->headers->set('Location', $url);
        $this->setContent(sprintf('<html><head><meta http-equiv="refresh" content="1;url=%s"/></head></html>', htmlspecialchars($url, ENT_QUOTES))); }
    public function hasVary() {
        return (Boolean) $this->headers->get('Vary'); }
    public function getVary() {
        if (!$vary = $this->headers->get('Vary')) {
            return array(); }
        return is_array($vary) ? $vary : preg_split('/[\s,]+/', $vary); }
    public function setVary($headers, $replace = true) {
        $this->headers->set('Vary', $headers, $replace); }
    public function isNotModified(Request $request) {
        $lastModified = $request->headers->get('If-Modified-Since');
        $notModified = false;
        if ($etags = $request->getEtags()) {
            $notModified = (in_array($this->getEtag(), $etags) || in_array('*', $etags)) && (!$lastModified || $this->headers->get('Last-Modified') == $lastModified); } elseif ($lastModified) {
            $notModified = $lastModified == $this->headers->get('Last-Modified'); }
        if ($notModified) {
            $this->setNotModified(); }
        return $notModified; }
        public function isInvalid() {
        return $this->statusCode < 100 || $this->statusCode >= 600; }
    public function isInformational() {
        return $this->statusCode >= 100 && $this->statusCode < 200; }
    public function isSuccessful() {
        return $this->statusCode >= 200 && $this->statusCode < 300; }
    public function isRedirection() {
        return $this->statusCode >= 300 && $this->statusCode < 400; }
    public function isClientError() {
        return $this->statusCode >= 400 && $this->statusCode < 500; }
    public function isServerError() {
        return $this->statusCode >= 500 && $this->statusCode < 600; }
    public function isOk() {
        return 200 === $this->statusCode; }
    public function isForbidden() {
        return 403 === $this->statusCode; }
    public function isNotFound() {
        return 404 === $this->statusCode; }
    public function isRedirect() {
        return in_array($this->statusCode, array(301, 302, 303, 307)); }
    public function isEmpty() {
        return in_array($this->statusCode, array(201, 204, 304)); }
    public function isRedirected($location) {
        return $this->isRedirect() && $location == $this->headers->get('Location'); } }
namespace Symfony\Component\HttpFoundation;
class ResponseHeaderBag extends HeaderBag {
    protected $computedCacheControl = array();
    public function replace(array $headers = array()) {
        parent::replace($headers);
        if (!isset($this->headers['cache-control'])) {
            $this->set('cache-control', ''); } }
    public function set($key, $values, $replace = true) {
        parent::set($key, $values, $replace);
        if ('cache-control' === strtr(strtolower($key), '_', '-')) {
            $computed = $this->computeCacheControlValue();
            $this->headers['cache-control'] = array($computed);
            $this->computedCacheControl = $this->parseCacheControl($computed); } }
    public function remove($key) {
        parent::remove($key);
        if ('cache-control' === strtr(strtolower($key), '_', '-')) {
            $this->computedCacheControl = array(); } }
    public function setCookie($name, $value, $domain = null, $expires = null, $path = '/', $secure = false, $httponly = true) {
        $this->validateCookie($name, $value);
        $cookie = sprintf('%s=%s', $name, urlencode($value));
        if (null !== $expires) {
            if (is_numeric($expires)) {
                $expires = (int) $expires; } elseif ($expires instanceof \DateTime) {
                $expires = $expires->getTimestamp(); } else {
                $expires = strtotime($expires);
                if (false === $expires || -1 == $expires) {
                    throw new \InvalidArgumentException(sprintf('The "expires" cookie parameter is not valid.', $expires)); } }
            $cookie .= '; expires='.substr(\DateTime::createFromFormat('U', $expires, new \DateTimeZone('UTC'))->format('D, d-M-Y H:i:s T'), 0, -5); }
        if ($domain) {
            $cookie .= '; domain='.$domain; }
        $cookie .= '; path='.$path;
        if ($secure) {
            $cookie .= '; secure'; }
        if ($httponly) {
            $cookie .= '; httponly'; }
        $this->set('Set-Cookie', $cookie, false); }
    public function hasCacheControlDirective($key) {
        return array_key_exists($key, $this->computedCacheControl); }
    public function getCacheControlDirective($key) {
        return array_key_exists($key, $this->computedCacheControl) ? $this->computedCacheControl[$key] : null; }
    protected function computeCacheControlValue() {
        if (!$this->cacheControl && !$this->has('ETag') && !$this->has('Last-Modified') && !$this->has('Expires')) {
            return 'no-cache'; }
        if (!$this->cacheControl) {
                        return 'private, max-age=0, must-revalidate'; }
        $header = $this->getCacheControlHeader();
        if (isset($this->cacheControl['public']) || isset($this->cacheControl['private'])) {
            return $header; }
                if (!isset($this->cacheControl['s-maxage'])) {
            return $header.', private'; }
        return $header; } }
namespace Symfony\Component\HttpKernel;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
class HttpKernel implements HttpKernelInterface {
    protected $dispatcher;
    protected $resolver;
    protected $request;
    public function __construct(EventDispatcher $dispatcher, ControllerResolverInterface $resolver) {
        $this->dispatcher = $dispatcher;
        $this->resolver = $resolver; }
    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true) {
                $previousRequest = $this->request;
        $this->request = $request;
        try {
            $response = $this->handleRaw($request, $type); } catch (\Exception $e) {
            if (false === $catch) {
                $this->request = $previousRequest;
                throw $e; }
                        $event = new Event($this, 'core.exception', array('request_type' => $type, 'request' => $request, 'exception' => $e));
            $this->dispatcher->notifyUntil($event);
            if (!$event->isProcessed()) {
                $this->request = $previousRequest;
                throw $e; }
            $response = $this->filterResponse($event->getReturnValue(), $request, 'A "core.exception" listener returned a non response object.', $type); }
                $this->request = $previousRequest;
        return $response; }
    public function getRequest() {
        return $this->request; }
    protected function handleRaw(Request $request, $type = self::MASTER_REQUEST) {
                $event = new Event($this, 'core.request', array('request_type' => $type, 'request' => $request));
        $this->dispatcher->notifyUntil($event);
        if ($event->isProcessed()) {
            return $this->filterResponse($event->getReturnValue(), $request, 'A "core.request" listener returned a non response object.', $type); }
                if (false === $controller = $this->resolver->getController($request)) {
            throw new NotFoundHttpException('Unable to find the controller.'); }
        $event = new Event($this, 'core.controller', array('request_type' => $type, 'request' => $request));
        $this->dispatcher->filter($event, $controller);
        $controller = $event->getReturnValue();
                if (!is_callable($controller)) {
            throw new \LogicException(sprintf('The controller must be a callable (%s).', var_export($controller, true))); }
                $arguments = $this->resolver->getArguments($request, $controller);
                $retval = call_user_func_array($controller, $arguments);
                $event = new Event($this, 'core.view', array('request_type' => $type, 'request' => $request));
        $this->dispatcher->filter($event, $retval);
        return $this->filterResponse($event->getReturnValue(), $request, sprintf('The controller must return a response (instead of %s).', is_object($event->getReturnValue()) ? 'an object of class '.get_class($event->getReturnValue()) : is_array($event->getReturnValue()) ? 'an array' : str_replace("\n", '', var_export($event->getReturnValue(), true))), $type); }
    protected function filterResponse($response, $request, $message, $type) {
        if (!$response instanceof Response) {
            throw new \RuntimeException($message); }
        $event = $this->dispatcher->filter(new Event($this, 'core.response', array('request_type' => $type, 'request' => $request)), $response);
        $response = $event->getReturnValue();
        if (!$response instanceof Response) {
            throw new \RuntimeException('A "core.response" listener returned a non response object.'); }
        return $response; } }
namespace Symfony\Component\HttpKernel;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Response;
class ResponseListener {
    public function register(EventDispatcher $dispatcher, $priority = 0) {
        $dispatcher->connect('core.response', array($this, 'filter'), $priority); }
    public function filter(Event $event, Response $response) {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->get('request_type') || $response->headers->has('Content-Type')) {
            return $response; }
        $request = $event->get('request');
        $format = $request->getRequestFormat();
        if ((null !== $format) && $mimeType = $request->getMimeType($format)) {
            $response->headers->set('Content-Type', $mimeType); }
        return $response; } }
namespace Symfony\Component\HttpKernel\Controller;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
class ControllerResolver implements ControllerResolverInterface {
    protected $logger;
    public function __construct(LoggerInterface $logger = null) {
        $this->logger = $logger; }
    public function getController(Request $request) {
        if (!$controller = $request->attributes->get('_controller')) {
            if (null !== $this->logger) {
                $this->logger->err('Unable to look for the controller as the "_controller" parameter is missing'); }
            return false; }
        if ($controller instanceof \Closure) {
            return $controller; }
        list($controller, $method) = $this->createController($controller);
        if (!method_exists($controller, $method)) {
            throw new \InvalidArgumentException(sprintf('Method "%s::%s" does not exist.', get_class($controller), $method)); }
        if (null !== $this->logger) {
            $this->logger->info(sprintf('Using controller "%s::%s"', get_class($controller), $method)); }
        return array($controller, $method); }
    public function getArguments(Request $request, $controller) {
        $attributes = $request->attributes->all();
        if (is_array($controller)) {
            list($controller, $method) = $controller;
            $m = new \ReflectionMethod($controller, $method);
            $parameters = $m->getParameters();
            $repr = sprintf('%s::%s()', get_class($controller), $method); } else {
            $f = new \ReflectionFunction($controller);
            $parameters = $f->getParameters();
            $repr = 'Closure'; }
        $arguments = array();
        foreach ($parameters as $param) {
            if (array_key_exists($param->getName(), $attributes)) {
                $arguments[] = $attributes[$param->getName()]; } elseif ($param->isDefaultValueAvailable()) {
                $arguments[] = $param->getDefaultValue(); } else {
                throw new \RuntimeException(sprintf('Controller "%s" requires that you provide a value for the "$%s" argument (because there is no default value or because there is a non optional argument after this one).', $repr, $param->getName())); } }
        return $arguments; }
    protected function createController($controller) {
        if (false === strpos($controller, '::')) {
            throw new \InvalidArgumentException(sprintf('Unable to find controller "%s".', $controller)); }
        list($class, $method) = explode('::', $controller);
        if (!class_exists($class)) {
            throw new \InvalidArgumentException(sprintf('Class "%s" does not exist.', $class)); }
        return array(new $class(), $method); } }
namespace Symfony\Component\HttpKernel\Controller;
use Symfony\Component\HttpFoundation\Request;
interface ControllerResolverInterface {
    function getController(Request $request);
    function getArguments(Request $request, $controller); }
namespace Symfony\Bundle\FrameworkBundle;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
class RequestListener {
    protected $router;
    protected $logger;
    protected $container;
    public function __construct(ContainerInterface $container, RouterInterface $router, LoggerInterface $logger = null) {
        $this->container = $container;
        $this->router = $router;
        $this->logger = $logger; }
    public function register(EventDispatcher $dispatcher, $priority = 0) {
        $dispatcher->connect('core.request', array($this, 'handle'), $priority); }
    public function handle(Event $event) {
        $request = $event->get('request');
        $master = HttpKernelInterface::MASTER_REQUEST === $event->get('request_type');
        $this->initializeSession($request, $master);
        $this->initializeRequestAttributes($request, $master); }
    protected function initializeSession(Request $request, $master) {
        if (!$master) {
            return; }
                if (null === $request->getSession()) {
            $request->setSession($this->container->get('session')); }
                if ($request->hasSession()) {
            $request->getSession()->start(); } }
    protected function initializeRequestAttributes(Request $request, $master) {
        if ($master) {
                                    $this->router->setContext(array(
                'base_url'  => $request->getBaseUrl(),
                'method'    => $request->getMethod(),
                'host'      => $request->getHost(),
                'is_secure' => $request->isSecure(),
            )); }
        if ($request->attributes->has('_controller')) {
                        return; }
                if (false !== $parameters = $this->router->match($request->getPathInfo())) {
            if (null !== $this->logger) {
                $this->logger->info(sprintf('Matched route "%s" (parameters: %s)', $parameters['_route'], str_replace("\n", '', var_export($parameters, true)))); }
            $request->attributes->add($parameters);
            if ($locale = $request->attributes->get('_locale')) {
                $request->getSession()->setLocale($locale); } } elseif (null !== $this->logger) {
            $this->logger->err(sprintf('No route found for %s', $request->getPathInfo())); } } }
namespace Symfony\Bundle\FrameworkBundle\Controller;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
class ControllerNameConverter {
    protected $kernel;
    protected $logger;
    protected $namespaces;
    public function __construct(Kernel $kernel, LoggerInterface $logger = null) {
        $this->kernel = $kernel;
        $this->logger = $logger;
        $this->namespaces = array_keys($kernel->getBundleDirs()); }
    public function toShortNotation($controller) {
        if (2 != count($parts = explode('::', $controller))) {
            throw new \InvalidArgumentException(sprintf('The "%s" controller is not a valid class::method controller string.', $controller)); }
        list($class, $method) = $parts;
        if ('Action' != substr($method, -6)) {
            throw new \InvalidArgumentException(sprintf('The "%s::%s" method does not look like a controller action (it does not end with Action)', $class, $method)); }
        $action = substr($method, 0, -6);
        if (!preg_match('/Controller\\\(.*)Controller$/', $class, $match)) {
            throw new \InvalidArgumentException(sprintf('The "%s" class does not look like a controller class (it does not end with Controller)', $class)); }
        $controller = $match[1];
        $bundle = null;
        $namespace = substr($class, 0, strrpos($class, '\\'));
        foreach ($this->namespaces as $prefix) {
            if (0 === $pos = strpos($namespace, $prefix)) {
                                $bundle = substr($namespace, strlen($prefix) + 1, -11); } }
        if (null === $bundle) {
            throw new \InvalidArgumentException(sprintf('The "%s" class does not belong to a known bundle namespace.', $class)); }
        return $bundle.':'.$controller.':'.$action; }
    public function fromShortNotation($controller) {
        if (3 != count($parts = explode(':', $controller))) {
            throw new \InvalidArgumentException(sprintf('The "%s" controller is not a valid a:b:c controller string.', $controller)); }
        list($bundle, $controller, $action) = $parts;
        $bundle = strtr($bundle, array('/' => '\\'));
        $class = null;
        $logs = array();
        foreach ($this->namespaces as $namespace) {
            $try = $namespace.'\\'.$bundle.'\\Controller\\'.$controller.'Controller';
            if (!class_exists($try)) {
                if (null !== $this->logger) {
                    $logs[] = sprintf('Failed finding controller "%s:%s" from namespace "%s" (%s)', $bundle, $controller, $namespace, $try); } } else {
                if (!$this->kernel->isClassInActiveBundle($try)) {
                    throw new \LogicException(sprintf('To use the "%s" controller, you first need to enable the Bundle "%s" in your Kernel class.', $try, $namespace.'\\'.$bundle)); }
                $class = $try;
                break; } }
        if (null === $class) {
            if (null !== $this->logger) {
                foreach ($logs as $log) {
                    $this->logger->info($log); } }
            throw new \InvalidArgumentException(sprintf('Unable to find controller "%s:%s".', $bundle, $controller)); }
        return $class.'::'.$action.'Action'; } }
namespace Symfony\Bundle\FrameworkBundle\Controller;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolver as BaseControllerResolver;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerNameConverter;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
class ControllerResolver extends BaseControllerResolver {
    protected $container;
    protected $converter;
    protected $esiSupport;
    public function __construct(ContainerInterface $container, ControllerNameConverter $converter, LoggerInterface $logger = null) {
        $this->container = $container;
        $this->converter = $converter;
        parent::__construct($logger); }
    protected function createController($controller) {
        if (false === strpos($controller, '::')) {
            $count = substr_count($controller, ':');
            if (2 == $count) {
                                $controller = $this->converter->fromShortNotation($controller); } elseif (1 == $count) {
                                list($service, $method) = explode(':', $controller);
                return array($this->container->get($service), $method); } else {
                throw new \LogicException(sprintf('Unable to parse the controller name "%s".', $controller)); } }
        list($class, $method) = explode('::', $controller);
        if (!class_exists($class)) {
            throw new \InvalidArgumentException(sprintf('Class "%s" does not exist.', $class)); }
        $controller = new $class();
        if ($controller instanceof ContainerAwareInterface) {
            $controller->setContainer($this->container); }
        return array($controller, $method); }
    public function forward($controller, array $attributes = array(), array $query = array()) {
        $attributes['_controller'] = $controller;
        $subRequest = $this->container->get('request')->duplicate($query, null, $attributes);
        return $this->container->get('kernel')->handle($subRequest, HttpKernelInterface::SUB_REQUEST); }
    public function render($controller, array $options = array()) {
        $options = array_merge(array(
            'attributes'    => array(),
            'query'         => array(),
            'ignore_errors' => !$this->container->getParameter('kernel.debug'),
            'alt'           => array(),
            'standalone'    => false,
            'comment'       => '',
        ), $options);
        if (!is_array($options['alt'])) {
            $options['alt'] = array($options['alt']); }
        if (null === $this->esiSupport) {
            $this->esiSupport = $this->container->has('esi') && $this->container->get('esi')->hasSurrogateEsiCapability($this->container->get('request')); }
        if ($this->esiSupport && $options['standalone']) {
            $uri = $this->generateInternalUri($controller, $options['attributes'], $options['query']);
            $alt = '';
            if ($options['alt']) {
                $alt = $this->generateInternalUri($options['alt'][0], isset($options['alt'][1]) ? $options['alt'][1] : array(), isset($options['alt'][2]) ? $options['alt'][2] : array()); }
            return $this->container->get('esi')->renderIncludeTag($uri, $alt, $options['ignore_errors'], $options['comment']); }
        $request = $this->container->get('request');
                if (0 === strpos($controller, '/')) {
            $subRequest = Request::create($controller, 'get', array(), $request->cookies->all(), array(), $request->server->all());
            $subRequest->setSession($request->getSession()); } else {
            $options['attributes']['_controller'] = $controller;
            $options['attributes']['_format'] = $request->getRequestFormat();
            $subRequest = $request->duplicate($options['query'], null, $options['attributes']); }
        try {
            $response = $this->container->get('kernel')->handle($subRequest, HttpKernelInterface::SUB_REQUEST, true);
            if (200 != $response->getStatusCode()) {
                throw new \RuntimeException(sprintf('Error when rendering "%s" (Status code is %s).', $request->getUri(), $response->getStatusCode())); }
            return $response->getContent(); } catch (\Exception $e) {
            if ($options['alt']) {
                $alt = $options['alt'];
                unset($options['alt']);
                $options['attributes'] = isset($alt[1]) ? $alt[1] : array();
                $options['query'] = isset($alt[2]) ? $alt[2] : array();
                return $this->render($alt[0], $options); }
            if (!$options['ignore_errors']) {
                throw $e; } } }
    public function generateInternalUri($controller, array $attributes = array(), array $query = array()) {
        if (0 === strpos($controller, '/')) {
            return $controller; }
        $uri = $this->container->get('router')->generate('_internal', array(
            'controller' => $controller,
            'path'       => $attributes ? http_build_query($attributes) : 'none',
            '_format'    => $this->container->get('request')->getRequestFormat(),
        ), true);
        if ($query) {
            $uri = $uri.'?'.http_build_query($query); }
        return $uri; } }
namespace Symfony\Bundle\FrameworkBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerAware;
class Controller extends ContainerAware {
    public function createResponse($content = '', $status = 200, array $headers = array()) {
        $response = $this->container->get('response');
        $response->setContent($content);
        $response->setStatusCode($status);
        foreach ($headers as $name => $value) {
            $response->headers->set($name, $value); }
        return $response; }
    public function generateUrl($route, array $parameters = array(), $absolute = false) {
        return $this->container->get('router')->generate($route, $parameters, $absolute); }
    public function forward($controller, array $path = array(), array $query = array()) {
        return $this->container->get('controller_resolver')->forward($controller, $path, $query); }
    public function redirect($url, $status = 302) {
        $response = $this->container->get('response');
        $response->setRedirect($url, $status);
        return $response; }
    public function renderView($view, array $parameters = array()) {
        return $this->container->get('templating')->render($view, $parameters); }
    public function render($view, array $parameters = array(), Response $response = null) {
        return $this->container->get('templating')->renderResponse($view, $parameters, $response); }
    public function has($id) {
        return $this->container->has($id); }
    public function get($id) {
        return $this->container->get($id); } }
namespace Symfony\Component\EventDispatcher;
class Event {
    protected $value = null;
    protected $processed = false;
    protected $subject;
    protected $name;
    protected $parameters;
    public function __construct($subject, $name, $parameters = array()) {
        $this->subject = $subject;
        $this->name = $name;
        $this->parameters = $parameters; }
    public function getSubject() {
        return $this->subject; }
    public function getName() {
        return $this->name; }
    public function setReturnValue($value) {
        $this->value = $value; }
    public function getReturnValue() {
        return $this->value; }
    public function setProcessed($processed) {
        $this->processed = (boolean) $processed; }
    public function isProcessed() {
        return $this->processed; }
    public function all() {
        return $this->parameters; }
    public function has($name) {
        return array_key_exists($name, $this->parameters); }
    public function get($name) {
        if (!array_key_exists($name, $this->parameters)) {
            throw new \InvalidArgumentException(sprintf('The event "%s" has no "%s" parameter.', $this->name, $name)); }
        return $this->parameters[$name]; }
    public function set($name, $value) {
        $this->parameters[$name] = $value; } }
namespace Symfony\Component\EventDispatcher;
class EventDispatcher {
    protected $listeners = array();
    public function connect($name, $listener, $priority = 0) {
        if (!isset($this->listeners[$name][$priority])) {
            if (!isset($this->listeners[$name])) {
                $this->listeners[$name] = array(); }
            $this->listeners[$name][$priority] = array(); }
        $this->listeners[$name][$priority][] = $listener; }
    public function disconnect($name, $listener = null) {
        if (!isset($this->listeners[$name])) {
            return false; }
        if (null === $listener) {
            unset($this->listeners[$name]);
            return; }
        foreach ($this->listeners[$name] as $priority => $callables) {
            foreach ($callables as $i => $callable) {
                if ($listener === $callable) {
                    unset($this->listeners[$name][$priority][$i]); } } } }
    public function notify(Event $event) {
        foreach ($this->getListeners($event->getName()) as $listener) {
            call_user_func($listener, $event); }
        return $event; }
    public function notifyUntil(Event $event) {
        foreach ($this->getListeners($event->getName()) as $listener) {
            if (call_user_func($listener, $event)) {
                $event->setProcessed(true);
                break; } }
        return $event; }
    public function filter(Event $event, $value) {
        foreach ($this->getListeners($event->getName()) as $listener) {
            $value = call_user_func($listener, $event, $value); }
        $event->setReturnValue($value);
        return $event; }
    public function hasListeners($name) {
        return (Boolean) count($this->getListeners($name)); }
    public function getListeners($name) {
        if (!isset($this->listeners[$name])) {
            return array(); }
        $listeners = array();
        $all = $this->listeners[$name];
        ksort($all);
        foreach ($all as $l) {
            $listeners = array_merge($listeners, $l); }
        return $listeners; } }
namespace Symfony\Bundle\FrameworkBundle;
use Symfony\Component\EventDispatcher\EventDispatcher as BaseEventDispatcher;
use Symfony\Component\DependencyInjection\ContainerInterface;
class EventDispatcher extends BaseEventDispatcher {
    public function setContainer(ContainerInterface $container) {
        foreach ($container->findTaggedServiceIds('kernel.listener') as $id => $attributes) {
            $priority = isset($attributes[0]['priority']) ? $attributes[0]['priority'] : 0;
            $container->get($id)->register($this, $priority); } } }
namespace Symfony\Component\Form;
class FormConfiguration {
    protected static $defaultCsrfSecret = null;
    protected static $defaultCsrfProtection = false;
    protected static $defaultCsrfFieldName = '_token';
    protected static $defaultLocale = null;
    static public function setDefaultLocale($defaultLocale) {
        self::$defaultLocale = $defaultLocale; }
    static public function getDefaultLocale() {
        return self::$defaultLocale; }
    static public function enableDefaultCsrfProtection() {
        self::$defaultCsrfProtection = true; }
    static public function isDefaultCsrfProtectionEnabled() {
        return self::$defaultCsrfProtection; }
    static public function disableDefaultCsrfProtection() {
        self::$defaultCsrfProtection = false; }
    static public function setDefaultCsrfFieldName($name) {
        self::$defaultCsrfFieldName = $name; }
    static public function getDefaultCsrfFieldName() {
        return self::$defaultCsrfFieldName; }
    static public function setDefaultCsrfSecret($secret) {
        self::$defaultCsrfSecret = $secret; }
    static public function getDefaultCsrfSecret() {
        return self::$defaultCsrfSecret; } }
