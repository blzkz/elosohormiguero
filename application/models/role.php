<?php
class Role extends DataMapper {
	/*var $has_one = array ('User', 'Forum');
	var $has_many = array ('Post');*/
    var $has_many = array('pforum','user');

    function __construct($id = NULL) 
    {
    	parent::__construct($id);
    }
}
