<?php

/**
 * This class holds data about current page, it's number, total pages number,
 * parent page, etc.
 *
 * @version    0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class Page
{
    /**
     * List of parent pages in descendent order (parent page goes first, then
     * parent of parent, etc.).
     *
     * @type array
     * @since 0.1.0
     */
    public $ancestors = array();
    /**
     * Current page slug.
     *
     * @type string
     * @since 0.1.0
     */
    public $slug;
    /**
     * Full current page uri.
     *
     * @type string
     * @since 0.1.0
     */
    public $uri;
    /**
     * Current page title.
     *
     * @type string
     * @since 0.1.0
     */
    public $title;
    /**
     * Alternative page title for <title> tag. Default title will be used if
     * left blank.
     *
     * @type string
     * @since 0.1.0
     */
    public $headingTitle;
    /**
     * Current page number.
     *
     * @type int
     * @since 0.1.0
     */
    public $pageNumber = 1;
    /**
     * Total pages amount.
     *
     * @type int
     * @since 0.1.0
     */
    public $totalPages = 1;
    /**
     * List of navigation links to be placed under page header in [url => text]
     * form.
     *
     * @type string[]
     * @since 0.1.0
     */
    public $headerNavigation = array();
    /**
     * Current route. Used by pagination.
     *
     * @type string
     * @since 0.1.0
     */
    public $route;
    /**
     * Additional pagination options.
     *
     * @type array
     * @since 0.1.0
     */
    public $routeOptions;
    /**
     * Parent controller.
     *
     * @type \BaseController
     * @since 0.1.0
     */
    protected $controller;
    /**
     * Runtime cache for storing 'heavy' data such as controllers instances.
     *
     * @type array
     * @since 0.1.0
     */
    protected $cache = array(
        'controllers' => array(),
    );

    /**
     * Typical initializer. Sets up ancestor list.
     *
     * @param \BaseController $controller Parent controller.
     *
     * @since 0.1.0
     */
    public function __construct(\BaseController $controller)
    {
        $this->controller = $controller;
        $this->title = $controller->getPageTitle();
        $this->route = $controller->getRoute();
        $this->routeOptions = $_GET; // CHttpRequest cannot into this
        /** @type \CWebApplication $app */
        $app = \Yii::app();
        $this->pageNumber = $app->getRequest()->getParam('page', 1);
        $this->uri = $app->getRequest()->getRequestUri();
        $this->loadAncestors();
    }

    /**
     * Loads page ancestors.
     *
     * @return void
     * @since 0.1.0
     */
    public function loadAncestors()
    {
        $ancestor = $this->controller->getAction()->getId();
        while ($ancestor = $this->getActionAncestor($ancestor)) {
            $titleKey = 'pageTitle.'.str_replace('/', '.', $ancestor);
            $this->ancestors[] = array(
                'action' => $ancestor,
                'title' => \Yii::t('templates', $titleKey),
            );
        }
        $segments = array_reverse(explode('/', trim($this->uri, '/')));
        // deleting current page
        array_shift($segments);
        $hierarchySize = sizeof($this->ancestors);
        // hierarchy root element is not listed in segments
        if (sizeof($segments) === $hierarchySize - 1) {
            // then dirty optimization comes in place and removes necessity of
            // calling `createUrl()`.
            $uri = '';
            for ($i = $hierarchySize - 2; $i >= 0; $i--) {
                $this->ancestors[$i]['uri'] = ($uri .= '/'.$segments[$i]);
                $this->ancestors[$i]['slug'] = $segments[$i];
            }
            $this->ancestors[$hierarchySize - 1]['uri'] = '/';
            $this->ancestors[$hierarchySize - 1]['slug'] = null;
        } else {
            foreach ($this->ancestors as &$page) {
                $page['uri'] = $this->controller->createUrl($page['action']);
                $page['slug'] = basename($page['uri']);
            }
        }
    }

    /**
     * Gets action ancestor.
     *
     * @param string $route Standard Yii route in `controller/action` form (or
     *                      just `action`, current controller will be used
     *                      then).
     *
     * @todo This method doesn't cover all possible cases, modules, for example.
     *       This should be fixed even if this project won't see modules
     * integration.
     *
     * @return null|string Null if root/non-hierarchy action is hit or ancestor
     *                     action root.
     * @since 0.1.0
     */
    public function getActionAncestor($route)
    {
        if (strpos($route, '/') === false) {
            $controller = $this->controller->getId();
            $action = $route;
        } else {
            list($controller, $action) = explode('/', $route);
        }
        if (!isset($this->cache['controllers'][$controller])) {
            /** @type \BaseController $instance */
            if ($controller === $this->controller->getId()) {
                $instance = $this->controller;
            } else {
                $class = ucfirst($controller) . 'Controller';
                $instance = new $class($controller);
            }
            $this->cache['controllers'][$controller] = array(
                'instance' => $instance,
                'actions' => $instance->getActionAncestors(),
            );
        }
        $actions = $this->cache['controllers'][$controller]['actions'];
        if (!isset($actions[$action])) {
            return null;
        }
        $ancestor = $actions[$action];
        if (strpos($ancestor, '/') === false) {
            return $controller.'/'.$ancestor;
        }
        return $ancestor;
    }

    /**
     * Sets title to <var>key</var> translation formatted with <var>$data</var>.
     *
     * @param array  $data Additional data to format translation.
     * @param string $key  Translation key.
     *
     * @return void
     * @since 0.1.0
     */
    public function resetTitle(array $data=array(), $key=null)
    {
        if (!$key) {
            $implodable = array(
                'pageTitle',
                $this->controller->getId(),
                $this->controller->getAction()->getId()
            );
            $key = implode('.', $implodable);
        }
        $this->title = \Yii::t('templates', $key, $data);
    }

    /**
     * Replaces ancestor title.
     *
     * @param int    $ancestor Ancestor level.
     * @param string $newTitle New ancestor title.
     *
     * @throws \InvalidArgumentException
     *
     * @return void
     * @since 0.1.0
     */
    public function renameAncestor($ancestor, $newTitle)
    {
        if (!$this->hasAncestor($ancestor)) {
            $message = 'Requested ancestor doesn\'t exist';
            throw new \InvalidArgumentException($message);
        }
        if ($ancestor < 0) {
            $ancestor = sizeof($this->ancestors) + $ancestor;
        }
        $this->ancestors[$ancestor]['title'] = $newTitle;
    }

    /**
     * Renames ancestor with provided slug.
     *
     * @param string $slug     Slug to find ancestor by.
     * @param string $newTitle New ancestor title.
     *
     * @return true Returns true on success (and fires exception on error).
     * @since 0.1.0
     */
    public function renameAncestorBySlug($slug, $newTitle)
    {
        foreach ($this->ancestors as &$ancestor) {
            if ($ancestor['slug'] === $slug) {
                $ancestor['title'] = $newTitle;
                return true;
            }
        }
        $message = 'There is no ancestor with such slug';
        throw new \BadMethodCallException($message);
    }

    /**
     * Checks if ancestor with selected level exists.
     *
     * @param int $level Checked ancestor level.
     *
     * @return bool
     * @since 0.1.0
     */
    public function hasAncestor($level)
    {
        if ($level < 0) {
            $level = sizeof($this->ancestors) + $level;
        };
        return sizeof($this->ancestors) > $level && $level >= 0;
    }

    /**
     * Returns ancestor of selected level or fires InvalidArgumentException.
     *
     * @param int $level Ancestor level.
     *
     * @throws \InvalidArgumentException
     *
     * @return mixed
     * @since
     */
    public function getAncestor($level)
    {
        if ($level < 0) {
            $level = sizeof($this->ancestors) + $level;
        }
        if (!$this->hasAncestor($level)) {
            $message = 'Requested ancestor doesn\'t exist';
            throw new \InvalidArgumentException($message);
        }
        return $this->ancestors[$level];
    }

    /**
     * Checks if current page has direct ancestor.
     *
     * @return bool
     * @since 0.1.0
     */
    public function hasParent()
    {
        return $this->hasAncestor(-1);
    }

    /**
     * Returns parent page.
     *
     * @return mixed
     * @since 0.1.0
     */
    public function getParent()
    {
        return $this->getAncestor(-1);
    }
}
