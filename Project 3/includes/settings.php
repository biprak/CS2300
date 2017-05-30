<?php
	//Array of fields used
	$fields = array(
		array( 
			'term' => 'title',
			'heading' => 'Title',
			'filter' => FILTER_SANITIZE_STRING,
		),
		array( 
			'term' => 'description',
			'heading' => 'Description',
			'filter' => FILTER_SANITIZE_STRING,
		),
	);

?>