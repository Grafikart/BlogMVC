<?php

/**
 * This class holds data about current page, it's number, total pages number,
 * parent page, etc.
 *
 * @property string[] $parent  Returns parent page data (if parent page exists).
 * @property int      $number  Current page number.
 * @property int      $total   Total amount of pages.
 * @property bool     $isFirst Tells if current page is the first one.
 * @property bool     $isLast  Tells if current page is the last one.
 *
 * @version    0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class Page extends \CComponent
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
    public $heading;
    /**
     * Description that is placed right under page heading.
     *
     * @type string
     * @since 0.1.0
     */
    public $headingDescription;
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
     * Format in which page should be represented.
     *
     * @type string
     * @since 0.1.0
     */
    public $format = 'html';
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
        /** @type \CWebApplication $app */
        $app = \Yii::app();
        $this->controller = $controller;
        $this->loadControllerOptions($controller);
        // dirty, dirty hack
        // prevents exception recreation when Yii forwards error to errorAction
        // thus creating new controller and invoking new page object.
        $errorAction = \Yii::app()->getErrorHandler()->errorAction;
        if ($this->controller->route !== $errorAction) {
            $this->loadPageNumber();
            $this->loadPageFormat();
        }
        $this->uri = $app->getRequest()->getRequestUri();
        $this->loadAncestors();
        $this->loadNavigation();
    }

    /**
     * Loads current page number.
     *
     * @throws \EHttpInvalidPageNumberException Thrown if invalid page number is
     *                                          provided,
     *
     * @return int Current page number.
     * @since 0.1.0
     */
    protected function loadPageNumber()
    {
        /** @type \CWebApplication $app */
        $app = \Yii::app();
        $pageNumber = $app->getRequest()->getParam('page');
        if ($pageNumber !== null && (int) $pageNumber < 1) {
            throw new \EHttpInvalidPageNumberException;
        }
        return $this->pageNumber = $pageNumber ? (int) $pageNumber : 1;
    }

    /**
     * Loads format current page should be returned in.
     *
     * @throws \EHttpInvalidPageFormatException Thrown if invalid page format is
     *                                          specified
     * @throws \EHttpRestrictedPagingException  Thrown if end user has specified
     *                                          page number for RSS feed.
     *
     * @return string Current format.
     * @since 0.1.0
     */
    protected function loadPageFormat()
    {
        /** @type \CWebApplication $app */
        $app = \Yii::app();
        $format = strtolower($app->getRequest()->getParam('format', 'html'));
        $pageNumber = $app->getRequest()->getParam('page');
        if ($format === 'rss' && $pageNumber !== null) {
            throw new \EHttpRestrictedPagingException(
                'badRequest.specifiedRssPageNumber'
            );
        }
        if ($format !== 'html'
            && !\Yii::app()->formatter->knownFormat($format)
        ) {
            throw new \EHttpInvalidPageFormatException;
        }
        return $this->format = $format;
    }

    /**
     * Loads pagination options stored in controller.
     *
     * @param \BaseController $controller Controller to be examined.
     *
     * @return void
     * @since 0.1.0
     */
    protected function loadControllerOptions(\BaseController $controller)
    {
        $this->title = $controller->getPageTitle();
        $this->route = $controller->getRoute();
        $this->routeOptions = $_GET; // CHttpRequest cannot into this
    }

    /**
     * Loads up navigation links.
     *
     * @return void
     * @since 0.1.0
     */
    public function loadNavigation()
    {
        $navigation = $this->controller->navigationLinks();
        $action = $this->controller->getAction()->getId();
        if (isset($navigation[$action])) {
            $navRoutes = $navigation[$action];
            foreach ($navRoutes as &$route) {
                if (strpos($route, '/') === false) {
                    $route = $this->controller->getId().'/'.$route;
                }
                $titleKey = 'pageTitle.'.str_replace('/', '.', $route);
                $this->headerNavigation[] = array(
                    'url' => $this->controller->createUrl($route),
                    'title' => \Yii::t('templates', $titleKey),
                );
            }
        }
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
        if (YII_DEBUG) {
            $message = 'built page ancestors list: ' . PHP_EOL;
            $items = array();
            foreach ($this->ancestors as $ancestor) {
                $itemChunks = array('[');
                foreach ($ancestor as $k => $v) {
                    $prefix = "  $k:";
                    $itemChunks[] = str_pad($prefix, 12).$v;
                }
                $itemChunks[] = ']';
                $items[] = implode(PHP_EOL, $itemChunks);
            }
            \Yii::trace($message.implode(','.PHP_EOL, $items));
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
            $bits = array(
                'pageTitle',
                $this->controller->getId(),
                $this->controller->getAction()->getId()
            );
            $key = implode('.', $bits);
        }
        $newTitle = \Yii::t('templates', $key, $data);
        $message = sprintf(
            'Switched page title from [%s] to [%s]',
            $this->title,
            $newTitle
        );
        \Yii::trace($message);
        $this->title = $newTitle;
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
    public function hasAncestor($level=0)
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
    public function getAncestor($level=0)
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
        return $this->hasAncestor();
    }

    /**
     * Returns parent page.
     *
     * @return mixed
     * @since 0.1.0
     */
    public function getParent()
    {
        return $this->getAncestor();
    }

    /**
     * Shortcut to get value of {@link self::$totalPages} by requesting
     * {@link self::$total} property.
     *
     * @return int
     * @since 0.1.0
     */
    public function getTotal()
    {
        return $this->totalPages;
    }

    /**
     * Shortcut to set value of {@link self::$totalPages} by setting
     * {@link self::$total} property.
     *
     * @param int $total Total pages.
     *
     * @return void
     * @since 0.1.0
     */
    public function setTotal($total)
    {
        $this->totalPages = ceil($total);
    }

    /**
     * Shortcut to get value of {@link self::$pageNumber} by requesting
     * {@link self::$number} property.
     *
     * @return int
     * @since 0.1.0
     */
    public function getNumber()
    {
        return $this->pageNumber;
    }

    /**
     * Shortcut to set value of {@link self::$pageNumber} by setting
     * {@link self::$pageNumber} property
     *
     * @param int $number Current page number.
     *
     * @return void
     * @since 0.1.0
     */
    public function setNumber($number)
    {
        $this->pageNumber = $number;
    }

    /**
     * Tells if current page is the first one.
     *
     * @return bool
     * @since 0.1.0
     */
    public function isFirstPage()
    {
        return $this->pageNumber === 1;
    }

    /**
     * Shortcut to check if this page is the first one via {@link self::isFirst}
     * property.
     *
     * @return bool
     * @since 0.1.0
     */
    public function getIsFirst()
    {
        return $this->pageNumber === 1;
    }

    /**
     * Tells if current page is the lasst one.
     *
     * @return bool
     * @since 0.1.0
     */
    public function isLastPage()
    {
        return $this->pageNumber === $this->totalPages;
    }

    /**
     * Shortcut to check if this page is the first one via {@link self::isLast}
     * property.
     *
     * @return bool
     * @since 0.1.0
     */
    public function getIsLast()
    {
        return $this->pageNumber === $this->totalPages;
    }

    /**
     * Creates header for currently selected format.
     *
     * @return string
     * @since 0.1.0
     */
    public function generateFormatHeader()
    {
        switch ($this->format) {
            case 'json':
                $contentType = 'application/json';
                break;
            case 'xml':
                $contentType = 'application/xml';
                break;
            case 'rss':
                $contentType = 'application/rss+xml';
                break;
            case 'html':
            default:
                $contentType = 'text/html';
                break;
        }
        return sprintf(
            'Content-Type: %s; charset=%s',
            $contentType,
            \Yii::app()->charset
        );
    }
}
