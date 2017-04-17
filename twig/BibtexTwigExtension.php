<?php

function invert_names($e) {
	$names = explode(", ", $e);
	$last_name = $names[0];
	$first_name = $names[1];
	return $first_name . " " . $last_name;
}

class BibtexTwigExtension extends Twig_Extension
{

    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('print_authors', array($this, 'print_authors_filter')),
        );
    }

    public function print_authors_filter($authors) {
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
}

