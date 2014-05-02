<?php
class UserAction extends BaseAction{
	protected function _initialize(){
		parent::_initialize();
		$userinfo=M('User_group')->where(array('id'=>session('gid')))->find();
		$users=M('Users')->where(array('id'=>$_SESSION['uid']))->find();
		$this->assign('thisUser',$users);
		//dump($users);
		$this->assign('viptime',$users['viptime']);
		if(session('uid')){
			if($users['viptime']<time()){
				session(null);
				session_destroy();
				unset($_SESSION);
				$this->error('您的帐号已经到期，请联系您的总代理。');
			}
		}
		
		$this->assign('userinfo',$userinfo);
		if(session('uid')==false){
			$this->redirect('Home/Index/login');
		}
		
		$allfunction = M('Function')->where(array('belonguser'=>session('belonguser')))->order('id')->select();
		$allfunctiontype = M('Function')->Distinct(true)->field('funtype')->where(array('belonguser'=>session('belonguser'),'funtype'=>array('neq','默认')))->order('usenum')->select();
		$this->assign('allfunction',$allfunction);
		$this->assign('allfunctiontype',$allfunctiontype);
		
		$where['uid']=session('uid');
		$info=M('Wxuser')->where($where)->find();
		session('token',$info['token']);
		session('wxid',$info['id']);
		
		$wecha=M('Wxuser')->field('wxname,wxid,headerpic,weixin')->where(array('token'=>session('token'),'uid'=>session('uid')))->find();
		$this->assign('wecha',$wecha);
		$this->assign('token',session('token'));
		
		
		//dump(session('token'));exit;
		
	}
	
	public function checkauth($funname, $modname){
		//dump($_SESSION);exit;
		//检查权限
		$func = M('Function')->where(array('funname'=>$funname,'belonguser'=>session('belonguser')))->find();
		if ($func) {
			if ($func['gid'] > session('gid')) {
				$this->error('您没有该模块的使用权限,请升级您的账号！');
			}
		}else{
			$this->error('您没有配置该模块,请联系您的总代理！');
		}
		
		/*
		//检查模块是否勾选
		$token_open=M('token_open')->field('queryname')->where(array('token'=>session('token')))->find();
		if(!strpos($token_open['queryname'],$modname)){
			$this->error('您还未开启该模块的使用,请到功能模块中添加！',U('Function/index',array('token'=>session('token'),'id'=>session('wxid'))));
		}
		*/
	}
	
	/*取商家token值，取不到则默认为空*/
	public function getTokenTall(){
		$tokenTall = $this->_request('tokenTall', 'trim', '');
		if($tokenTall == "" && $_SESSION["tokenTall"] != "") {$tokenTall = $_SESSION["tokenTall"];}
		if($tokenTall == "" && $_SESSION["token"] != "") {$tokenTall = $_SESSION["token"];}
		if($tokenTall != "") {$_SESSION["tokenTall"]=$tokenTall;}
		 
		return $tokenTall;
	}
	
	/*取当前用户微信号加密值，取不到则默认为空*/
	public function getWechaId(){
		$wecha_id = $this->_request('wecha_id', 'trim', '');
		if($wecha_id != "") {$_SESSION["wecha_id"]=$wecha_id;}
		if($wecha_id == "" && $_SESSION["wecha_id"] != "") {$wecha_id = $_SESSION["wecha_id"];}
		return $wecha_id;
	}
	
	protected function _list($model, $map = array(), $sort_by='', $order_by='', $field_list='*', $pagesize=20)
    {
        //排序
        $mod_pk = $model->getPk();
      
        if ($this->_request("sort", 'trim')) {
            $sort = $this->_request("sort", 'trim');
        } else if (!empty($sort_by)) {
            $sort = $sort_by;
        } else if ($this->sort) {
            $sort = $this->sort;
        } else {
            $sort = $mod_pk;
        }
        if ($this->_request("order", 'trim')) {
            $order = $this->_request("order", 'trim');
        } else if (!empty($order_by)) {
            $order = $order_by;
        } else if ($this->order) {
            $order = $this->order;
        } else {
            $order = 'DESC';
        }

        //如果需要分页
        if ($pagesize) {
            $count = $model->where($map)->count($mod_pk);
            $pager = new Page($count, $pagesize);
        }
        $select = $model->field($field_list)->where($map)->order($sort . ' ' . $order);
        $this->list_relation && $select->relation(true);
        if ($pagesize) {
            $select->limit($pager->firstRow.','.$pager->listRows);
            $page = $pager->show();
            $this->assign("page", $page);
        }
        $list = $select->select();
        $this->assign('list', $list);
        $this->assign('list_table', true);
    }
}
