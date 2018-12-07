<?php
class Functions
{
	function debug($statement, array $params = [])
	{
		$statement = preg_replace_callback(
			'/[?]/',
			function ($k) use ($params) {
            static $i = 0;
            return sprintf("'%s'", $params[$i++]);
			},
			$statement
		);
		echo '<pre>Query Debug:<br>', $statement, '</pre>';
	}
}	
?>