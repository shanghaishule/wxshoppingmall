<?php
class Wetall_addressAction extends UserAction{
	public function _initialize() {
		parent::_initialize();
		$this->_mod = D('address');
	}
	
	
	public function index(){
		$tokenTall = $this->getTokenTall();
		$map = array();
		$map['tokenTall'] = $tokenTall;
		$mod = $this->_mod;
		!empty($mod) && $this->_list($mod, $map);
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
			
			//如果自己是默认，则先更新所有人为非默认
			if ($data['isno'] == "1") {
				$this->_mod->where('id != 0')->save(array('isno'=>0));
			}
			
			if ($_POST['id'] != "") {
				//编辑
				$result = $this->_mod->save($data);
			} else {
				//新增
				$result = $this->_mod->add($data);
			}

			if ($result !== false) {
				
				$this->success('成功！', U('Wetall_address/index'));
			} else {
				$this->error('失败！');
			}
			
		} 
		//非提交，有id为编辑展示，无id为新增展示
		else {
			if ($id) {
				$myaction = "编辑";
				$info = $this->_mod->where(array('id'=>$id))->find();
				$this->assign('info',$info);
				
			}else{
				$myaction = "新增";
			}
						
			$this->assign('myaction',$myaction);
			$this->display();
		}
	}
	
	public function del()
	{
	
		$ids = $this->_get('id');
		if ($ids) { 
			if (false !== $this->_mod->delete($ids)) {
				$this->success('删除成功！');
			} else {
				$this->error('删除失败！');
			}
		} else {
			$this->error('参数错误！');
		}
	}

}
?>