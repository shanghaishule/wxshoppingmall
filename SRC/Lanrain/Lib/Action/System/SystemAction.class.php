<?php
/**
 *网站后台
 *@package YiCms
 *@author YiCms
 **/
class SystemAction extends BackAction{
	
	public function index(){
		$where['display']=1;
		$where['status']=1;
		$order['sort']='asc';
		$nav=M('node')->where($where)->order($order)->select();	
		$roleid["role_id"] = session('roleid');
		$roleid["level"] = array(array('eq',0),array('eq',1), 'or');
		$access = M('access')->where($roleid)->select();   
		foreach ($nav as $menuNav){
			foreach ($access as $acessnav){
				if($menuNav["id"] == $acessnav["node_id"]){
					$navNode[] = $menuNav;
				}
			}
		}
		$this->assign('nav',$navNode);
		$this->display();
	}
	
	public function menu(){
		if(empty($_GET['pid'])){
			/*
			$where['display']=2;
			$where['status']=1;
			$where['pid']=2;
			$where['level']=2;
			$order['sort']='asc';
			$nav=M('node')->where($where)->order($order)->select();
			$this->assign('nav',$nav);
			
			$title = M('node')->where('id=2')->find();
			$this->assign('title',$title[title]);
			*/
			$this->assign('title',"欢迎页");
		}else{
			$roleid["pid"] = $_GET['pid'];
			$roleid["role_id"] = session('roleid');
			$roleid["level"] = array(array('neq',0),array('neq',1), 'and');
			$access = M('access')->where($roleid)->select();
			$where['title'] = array(array('neq',"首页"));
			$where['display'] = array('neq',0);
			$nav=M('node')->where($where)->select();
			foreach ($nav as $menuNav){
				foreach ($access as $acessnav){
					if($menuNav['id'] == $acessnav["node_id"]){
						$navNode[] = $menuNav;
					}
				}
			}
			$this->assign('nav',$navNode);
		}
		$this->display();
	}
	
	public function main(){
		$shop_mod = M('wecha_shop');
		$shop_cnt = $shop_mod->count();
		//$shop_info = $shop_mod->select();
		
		$order_mod = M('item_order');
		$order_cnt = $order_mod->where('status=4')->count();
		$order_amt = $order_mod->where('status=4')->sum('order_sumPrice');
		
		$this->assign('shop_cnt',$shop_cnt);
		$this->assign('order_amt',$order_amt);
		
		
		if(IS_POST){
			$wherestr = " 1=1 ";
			$start_time = $this->_post('start_time');
			if ($start_time != "") {
				$start_time .= " 00:00:00";
				$wherestr .= " and dt >= UNIX_TIMESTAMP('".$start_time."') ";
			}
			$search['start_time'] = $start_time;
		
			$end_time = $this->_post('end_time');
			if ($end_time != "") {
				$end_time .= " 23:59:59";
				$wherestr .= " and dt <= UNIX_TIMESTAMP('".$end_time."') ";
			}
			$search['end_time'] = $end_time;
		
			$this->assign('searcharr',$search);
			//dump($wherestr);exit;
			//dump($search);exit;
		}else{
			$wherestr = "dt >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 7 DAY))";
		}
		$Model = M();
		$stat_PV = $Model->query("SELECT FROM_UNIXTIME(dt,'%Y-%m-%d') DT, COUNT(1) CNT FROM slimstat where ".$wherestr." group by FROM_UNIXTIME(dt,'%Y-%m-%d');");
		//dump($stat_PV);exit;
		$this->assign('stat_PV', $stat_PV);
		
		$stat_UV = $Model->query("SELECT FROM_UNIXTIME(dt,'%Y-%m-%d') DT, COUNT(DISTINCT remote_ip) CNT FROM slimstat where ".$wherestr." group by FROM_UNIXTIME(dt,'%Y-%m-%d');");
		//dump($stat_UV);exit;
		$this->assign('stat_UV', $stat_UV);
		
	
		
		$this->display();
	}
}