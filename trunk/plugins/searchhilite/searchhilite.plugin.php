<?php
/**
 * Search Hilite plugin for Habari.
 *
 * @package searchhilite
 */

class Searchhilite extends Plugin
{
	
	/**
	 * Apply the default Formatters on init.
	 */
	public function action_init()
	{
		Format::apply( 'do_searchhilite', 'post_content_out' );
		Format::apply( 'do_searchhilite', 'comment_content_out' );
	}
	
	/**
	* Get search terms as array
	*/
	private function get_search_query_terms($engine)
	{
		$referer = urldecode($_SERVER['HTTP_REFERER']);
        $query_array = array();
        switch ($engine) {
        case 'google':
                // Google query parsing code adapted from Dean Allen's
                // Google Hilite 0.3. http://textism.com
                $query_terms = preg_replace('/^.*(\&q=|\?q=)([^&]+)&?.*$/i','$2', $referer);
                $query_terms = preg_replace('/\'|"/', '', $query_terms);
                $query_array = preg_split ("/[\s,\+\.]+/", $query_terms);
                break;
        case 'baidu':
                $referer = iconv('gb2312', 'utf-8', $referer);
                $query_terms = preg_replace('/^.*(wd=|word=)([^&]+)&?.*$/i','$2', $referer);
                $query_terms = preg_replace('/\'|"/', '', $query_terms);
                $query_array = preg_split ("/[\s,\+\.]+/", $query_terms);
                break;

        case 'lycos':
                $query_terms = preg_replace('/^.*query=([^&]+)&?.*$/i','$1', $referer);
                $query_terms = preg_replace('/\'|"/', '', $query_terms);
                $query_array = preg_split ("/[\s,\+\.]+/", $query_terms);
                break;

        case 'yahoo':
                $query_terms = preg_replace('/^.*p=([^&]+)&?.*$/i','$1', $referer);
                $query_terms = preg_replace('/\'|"/', '', $query_terms);
                $query_array = preg_split ("/[\s,\+\.]+/", $query_terms);
                break;

		case 'soso':
		        $query_terms = preg_replace('/^.*w=([^&]+)&?.*$/i','$1', $referer);
		        $query_terms = preg_replace('/\'|"/', '', $query_terms);
		        $query_array = preg_split ("/[\s,\+\.]+/", $query_terms);
		        break;
		
		case 'habari':
				if(!empty($_GET['criteria'])){
					//$query_terms = preg_replace('/^.*criteria=([^&]+)&?.*$/i','$1', $referer);
                    //$query_terms = preg_replace('/\'|"/', '', $query_terms);
					$query_terms = $_GET['criteria'];
                    $query_array = preg_split ("/[\s,\+\.]+/", $query_terms);
					//$query_array = array("mac","apple");
				}
				break;
        }

        return $query_array;
	}
	
	/**
	* Check from which searchengine
	*/
	private function is_referer_search_engine($engine)
	{
		if( empty($_SERVER['HTTP_REFERER']) && 'habari' != $engine ) {
                return false;
        }

        $referer = urldecode($_SERVER['HTTP_REFERER']);

        if ( ! $engine ) {
                return false;
        }

        switch ($engine) {
        	case 'google':
	                if (preg_match('/^http:\/\/(?:www|images)?\.google.*/i', $referer)) {
	                        return true;
	                }
	                break;

	        case 'lycos':
	                if (preg_match('|^http://search\.lycos.*|i', $referer)) {
	                        return true;
	                }
	                break;

	        case 'yahoo':
	                if (preg_match('|^http://search\.yahoo.*|i', $referer)) {
	                        return true;
	                }
	                break;

	        case 'baidu':
	                if (preg_match('/^http:\/\/(?:www|www1|image|cache)?\.baidu.*/i', $referer)) {
	                        return true;
	                }
	                break;
			case 'soso':
					if (preg_match('|^http://(www)?\.?soso.com|i', $referer)) {
							return true;
					}
					break;
			case 'habari':
					if ( URL::get_matched_rule()->name == "display_search" )
	                        return true;

	                /*$siteurl = Site::get_url( 'habari' );;
	                if (preg_match("#^$siteurl#i", $referer))
	                        return true;*/

	                break;
        }

        return false;
	}
	
	/**
	* Hiliting Conversion
	*/
	public function filter_search_hilite($content)
	{
		$search_engines = array('google', 'lycos', 'yahoo', 'baidu', 'soso', 'habari');
	    foreach ($search_engines as $engine) {
	            if ($this->is_referer_search_engine($engine)) {
	                    $query_terms = $this->get_search_query_terms($engine);
	                    foreach ($query_terms as $term) {
	                            if (!empty($term) && $term != ' ') {
	                    			$term = preg_quote($term, '/');
	                                if (!preg_match('/<.+>/',$content)) {
	                                        $content = preg_replace('/('.$term.')/i','<span class="hilite">$1</span>',$content);
	                                } else {
	                                        $content = preg_replace('/(?<=>)([^<]+)?('.$term.')/i','$1<span class="hilite">$2</span>',$content);  //taken out the \b option to also mark substrings
	                                }
	                            }
	                    }
	                    break;
	            }
	    }
	    return $content;
	}

}

class SearchhiliteFormat extends Format
{
	public function do_searchhilite( $content )
	{
		return Plugins::filter( 'search_hilite', $content );
	}
}

?>