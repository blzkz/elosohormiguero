<?php
class Pforum extends DataMapper {
    var $has_one = array(
        'forum' => array(
            'class' => 'forum',
            'other_field' => 'forum'
        ),
        'permission' => array(
            'class' => 'permission',
            'other_field' => 'permission'
        ),
        'role' => array (
        	'class' => 'role',
        	'other_field' => 'role'
        )
       
    );
}