<?php
class Wetall_wecha_shopAction extends UserAction{
	public function _initialize() {
		parent::_initialize();
		$this->_mod = D('wecha_shop');
	}
	
	public function index(){
		if (IS_POST){
			//dump($_POST);exit;
			$result = $this->_mod->save($_POST);
			if ($result !== false){
				$this->success('修改成功!');
			}else{
				$this->error('修改失败！');
			}
		}else{
			$tokenTall = $this->getTokenTall();
			$map = array();
			$map['tokenTall'] = $tokenTall;
			$mod = $this->_mod;
			$info = $mod->where($map)->find();
			$this->assign('info', $info);
			$this->display();
		}
	}
}
?>