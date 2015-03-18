<?php

    /**
     * glue Masquerade Circus' version.
     *
     * Provides an easy way to map URLs to classes. URLs can be literal
     * strings or regular expressions.
     *
     * When the URLs are processed:
     *      * delimiter (/) are automatically escaped: (\/)
     *      * The beginning and end are anchored (^ $)
     *      * An optional end slash is added (/?)
     *	    * The i option is added for case-insensitive searches
     *
     * This script was modified by Masquerade Circus
	 * 
	 * With this version you can include the script in a subdir and will work from it.
	 * Also, you will recive the matches as coma separated vars.
     *
     * Example:
     *
     * $urls = array(
     *     '/' => 'index',
     *  	'/catalog' => 'catalog'
     *     '/catalog/(\w+)' => 'catalog'
     *  	'/catalog/(\w+)/(\w+)' => 'catalog'
     * );
     *
     * class catalog {
     *      function GET($category = null, $item = null) {
     *  		if ($item !== null)
	 *          	echo "Your requested an item named $item on the category $category " ;
	 *  		else if ($category !== null)
	 *          	echo "Your requested the category $category " ;
	 *  		else
	 *          	echo "Your requested the main catalog section" ;
     *      }
     * }
     *
     * glue::stick($urls);
     *
     */
	 
    class glue {

        /**
         * stick
         *
         * the main static function of the glue class.
         *
         * @param   array    	$urls  	    The regex-based url to class mapping
         * @throws  Exception               Thrown if corresponding class is not found
         * @throws  Exception               Thrown if no match is found
         * @throws  BadMethodCallException  Thrown if a corresponding GET,POST is not found
         *
         */
        static function stick ($urls) {

            $method = strtoupper($_SERVER['REQUEST_METHOD']);
			
			/**
			 *  This will take as base url the directory where the script is included, so you can put it in a subdir.
			 */
            $path = str_replace(str_replace(array('/index.php', ' '), array('', '%20'), $_SERVER['SCRIPT_NAME']), '', $_SERVER['REQUEST_URI']);

            $found = false;

            krsort($urls);

            foreach ($urls as $regex => $class) {
                $regex = str_replace('/', '\/', $regex);
                $regex = '^' . $regex . '\/?$';
                if (preg_match("/$regex/i", $path, $matches)) {
                    $found = true;
                    if (class_exists($class)) {
                        $obj = new $class;
                        if (method_exists($obj, $method)) {
							/**
							 *  This will pass the matches as coma separated vars so you can do this.
							 *  	function GET($hola = null, $mundo = null){
							 *  		echo $hola; 
							 *  		echo $mundo;
							 *  	}
							 */
							$matches = isset($matches[1]) ? explode("/", preg_replace("/\/$/", "", $matches[1])) : array();
							call_user_func_array(array($obj, $method), $matches);
                        } else {
                            throw new BadMethodCallException("Method, $method, not supported.");
                        }
                    } else {
                        throw new Exception("Class, $class, not found.");
                    }
                    break;
                }
            }
            if (!$found) {
                throw new Exception("URL, $path, not found.");
            }
        }
    }