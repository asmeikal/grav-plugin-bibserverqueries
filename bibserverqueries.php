<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;

/**
 * Class BibserverQueriesPlugin
 * @package Grav\Plugin
 */
class BibserverQueriesPlugin extends Plugin
{
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0]
        ];
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized()
    {
        // Don't proceed if we are in the admin plugin
        if ($this->isAdmin()) {
            return;
        }

        // Enable the main event we are interested in
        $this->enable([
            'onPageProcessed' => ['onPageProcessed', 0],
            'onTwigExtensions' => ['onTwigExtensions', -100],
        ]);
    }

    public function onPageProcessed(Event $e)
    {
        // get page and header
        $page = $e['page'];
        $header = (array) $page->header();
        // check if we have to make a query
        if (isset($header['bibserver'])) {
            // get query
            $query_url = isset($header['bibserver']['query_url']) ?
                         $header['bibserver']['query_url'] :
                         'query';
            $query = $header['bibserver']['query'];
            // get token
            $url = $this->grav['config']->get('plugins.bibserverqueries.url') . '/' . $query_url;
            $token = $this->grav['config']->get('plugins.bibserverqueries.token');
            // make query
            $ch = curl_init($url);
            $json_data = json_encode($query);
            // set POST options
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            // exec POST
            $result = curl_exec($ch); 
            $result = json_decode($result, true);
            // inject result
            $header = new \Grav\Common\Page\Header($header);
            $header->set('bibserver_result', $result);
            $page->header($header->items);
        }
    }

    public function onTwigExtensions()
    {
        require_once(__DIR__ . '/twig/BibtexTwigExtension.php');
        $this->grav['twig']->twig->addExtension(new \BibtexTwigExtension());
    }
}
