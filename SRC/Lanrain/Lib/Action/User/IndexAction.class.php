<?php
class IndexAction extends UserAction{
	public function index(){
		$where['id']=session('uid');
		$info = M('users')->where($where)->find();
		
		$tokenTall = $this->getTokenTall();
		$this->assign('tokenTall', $tokenTall);
		
		$shopinfo = M('wecha_shop')->where(array('tokenTall'=>$tokenTall))->find();
		$this->assign('shopinfo', $shopinfo);
		
		
		if ($info){
			if ($info['contact'] == "" or $info['phone'] == "" or $info['email'] == "" or $info['address'] == ""){
				$this->success('请先完善您的资料！', U('Myinfo/info'));
			}else{
				$wherestr = " resource like '%weTall%' ";
				if(IS_POST){
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
					$wherestr .= " and dt >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 7 DAY)) ";
				}
				
				
				
				$Model = M();
				$stat_PV = $Model->query("SELECT FROM_UNIXTIME(dt,'%Y-%m-%d') DT, COUNT(1) CNT FROM slimstat where ".$wherestr." and resource like '%".$tokenTall."%' group by FROM_UNIXTIME(dt,'%Y-%m-%d');");
				//dump($stat_PV);exit;
				$this->assign('stat_PV', $stat_PV);
				
				$stat_UV = $Model->query("SELECT FROM_UNIXTIME(dt,'%Y-%m-%d') DT, COUNT(DISTINCT remote_ip) CNT FROM slimstat where ".$wherestr." and resource like '%".$tokenTall."%' group by FROM_UNIXTIME(dt,'%Y-%m-%d');");
				//dump($stat);exit;
				$this->assign('stat_UV', $stat_UV);
				
				
				$buycount= M('item')->where(array('status'=>1,'tokenTall'=>$tokenTall))->count();
				$nobuycount= M('item')->where(array('status'=>0,'tokenTall'=>$tokenTall))->count();
				$fukuan= M('item_order')->where(array('status'=>1,'tokenTall'=>$tokenTall))->count();
				$fahuo= M('item_order')->where(array('status'=>2,'tokenTall'=>$tokenTall))->count();
				$yfahuo= M('item_order')->where(array('status'=>3,'tokenTall'=>$tokenTall))->count();
				$end = M('item_order')->where(array('status'=>4,'tokenTall'=>$tokenTall))->count();
				$totalamt = M('item_order')->where(array('status'=>4,'tokenTall'=>$tokenTall))->sum('order_sumPrice');
				$this->assign('count',
						array(	'fukuan'=>$fukuan,
								'fahuo'=>$fahuo,
								'yfahuo'=>$yfahuo,
								'end'=>$end,
								'buycount'=>$buycount,
								'nobuycount'=>$nobuycount,
								'totalamt'=>$totalamt
						)
				);
				
				
				$info_notice = M('info_notice')->where(array('status'=>1))->select();
				$this->assign('info_notice', $info_notice);
				
				$this->display();
			}
		}
	}
}
?>