<?php
class User extends DataMapper {
  var $has_one = array();
  var $has_many = array('thread', 'post','role');

  function __construct($id = NULL) 
  {
     parent::__construct($id);
  }
}