<?php
class WeTallAction extends UserAction{
	public function index(){
		//检查权限和功能
		$this->checkauth('WeTall','WeTall');
		
		$r=__ROOT__.'/weTall/index.php?g=admin&m=index&a=index&tokenTall='.session('token');
		header("Location: $r");

	}
}


?>