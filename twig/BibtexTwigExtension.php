<?php
namespace Grav\Plugin\BibserverQueries;

use Grav\Common\Grav;

function invert_names($e) {
    $names = explode(", ", $e);
    $last_name = $names[0];
    $first_name = $names[1];
    return $first_name . " " . $last_name;
}

class BibtexTwigExtension extends \Twig_Extension
{
    protected $grav;

    public function __construct()
    {
        $this->grav = Grav::instance();
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('bibserver_print_authors', array($this, 'bibserver_print_authors_filter')),
            new \Twig_SimpleFilter('bibserver_group_year', array($this, 'bibserver_group_year_filter')),
        );
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('bibserver_query', array($this, 'bibserver_query_function')),
        );
    }

    public function bibserver_print_authors_filter($authors) {
        // split authors string
        $authors_list = explode(" and ", $authors);
        $n_authors = count($authors_list);
        if ($n_authors == 1) {
            return invert_names($authors);
        } else {
            // swap first and last name, removing commas
            $authors_list = array_map(invert_names, $authors_list);
            // join authors with commas, 'and'
            $res = implode(", ", array_slice($authors_list, 0, $n_authors-1)) . " and " . $authors_list[$n_authors-1];
            return $res;
        }
    }

    public function bibserver_query_function($query, $url='query') {
        // get token and url
        $url = $this->grav['config']->get('plugins.bibserverqueries.url') . '/' . $url;
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
        return json_decode($result, true)['entries'];
    }

    public function bibserver_group_year_filter($entries) {
        $result = array();
        foreach ($entries as $entry) {
            $year = $entry['year'];
            if (!array_key_exists($year, $result)) {
                $result[$year] = array();
            }
            $result[$year][] = $entry;
        }
        return $result;
    }
}
