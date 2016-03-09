<?php
class Forum extends DataMapper {
	var $has_one = array();
	var $has_many = array ('thread', 'pforum');

    function __construct($id = NULL) 
    {
    	parent::__construct($id);
    }
}
