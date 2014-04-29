<?php
class Wetall_wxpayAction extends UserAction{
	public function _initialize() {
		parent::_initialize();
		$this->_mod = D('wxpay');
	}
	
	
	public function index(){
		$tokenTall = $this->getTokenTall();
		$map = array();
		$map['tokenTall'] = $tokenTall;
		
		$info = $this->_mod->where($map)->find();
		$this->assign('info',$info);
		$this->display();
	}

	public function edit() {
		$id = $this->_get('id');
		$tokenTall = $this->getTokenTall();
		
		//提交，有id则为编辑，无id则为新增
		if (IS_POST) {
			//dump($_POST);exit;
			 
			//获取数据
			if (false === $data = $this->_mod->create()) {
				$this->error($this->_mod->getError());
			}
			$data['tokenTall'] = $tokenTall;
			
			if ($_POST['id'] != "") {
				//编辑
				$result = $this->_mod->save($data);
			} else {
				//新增
				$result = $this->_mod->add($data);
			}

			if ($result !== false) {
				$this->success('成功！', U('Wetall_wxpay/index'));
			} else {
				$this->error('失败！');
			}
			
		} 
		
	}
	
	public function del()
	{
	
		$tokenTall = $this->getTokenTall();
		if (false !== $this->_mod->where(array('tokenTall'=>$tokenTall))->delete()) {
			$this->success('删除成功！');
		} else {
			$this->error('删除失败！');
		}
	}

}
?>