<?php
class Wetall_adAction extends UserAction{
	public function _initialize() {
		parent::_initialize();
		$this->_mod = D('ad');
		
		$adboard = M('adboard')->where(array('status'=>1))->select();
		foreach ($adboard as $val){
			$adboard_list[$val['id']]=$val['name'].'('.$val['width'].'*'.$val['height'].')';
		}
		$this->assign('adboard_list',$adboard_list);
		
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
			$data['type'] = 'image';
			$data['start_time']=strtotime($this->_post('start_time'));
			$data['end_time']=strtotime($this->_post('end_time'));
			///dump($data);exit;
			
			if ($_POST['id'] != "") {
				//编辑
				$result = $this->_mod->save($data);
			} else {
				//新增
				$result = $this->_mod->add($data);
			}

			if ($result !== false) {
				$this->success('成功！', U('Wetall_ad/index'));
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