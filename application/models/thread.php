<?php
class Thread extends DataMapper {
	/*var $has_one = array ('User', 'Forum');
	var $has_many = array ('Post');*/
	var $has_one = array('user', 'forum');
    var $has_many = array('post');

    function __construct($id = NULL) 
    {
    	parent::__construct($id);
    }
}
