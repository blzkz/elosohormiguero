<?php
class Post extends DataMapper {
	var $has_one = array ('thread', 'user');
	var $has_many = array('notice');
}
