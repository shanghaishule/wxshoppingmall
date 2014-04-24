<?php

class MemberAction extends BackAction
{	
	public $_mod_;
	public function _initialize() {
        $this->_mod_ = M('user');
    }

	public function index() {
    	$mod = $this->_mod_;
    	$map = array();
    	$map['role']  = array('eq',0);
    	 
    	//dump($mod);exit;
    	$this->_list($mod, $map);
    	$this->display();
    }


}
?>