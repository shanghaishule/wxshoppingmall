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
					$start_z = $start_time;
					$end_z = $end_time;
				}else{
					$wherestr .= " and dt >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 7 DAY)) ";
					
					$end_z = date("Y-m-d");
					$d=strtotime('-6 days');
					$start_z = date('Y-m-d',$d);
				}
				
				//dump($start_z); dump($end_z); exit;
				for ($i = strtotime($start_z); $i <= strtotime($end_z); $i = $i + 86400){
					$all[] = array('DT'=>date('Y-m-d',$i), 'CNT'=>0);
				}
				//dump($all);exit;
				$all2 = $all;
				$all3 = $all;
				
				$Model = M();
				$query_pv = "SELECT FROM_UNIXTIME(dt,'%Y-%m-%d') DT, COUNT(1) CNT FROM slimstat where ".$wherestr." and resource like '%".$tokenTall."%' group by FROM_UNIXTIME(dt,'%Y-%m-%d');";
				$stat_PV = $Model->query($query_pv);
				foreach ($all as $key => $all_each_one){
					foreach ($stat_PV as $each_one){
						if ($each_one['DT'] == $all_each_one['DT']) {
							//dump($each_one['DT']);
							$all2[$key]['CNT'] = $each_one['CNT'];
						}
					}
				}
				//dump($all2);exit;
				
				$query_uv = "SELECT FROM_UNIXTIME(dt,'%Y-%m-%d') DT, COUNT(DISTINCT remote_ip) CNT FROM slimstat where ".$wherestr." and resource like '%".$tokenTall."%' group by FROM_UNIXTIME(dt,'%Y-%m-%d');";
				$stat_UV = $Model->query($query_uv);
				foreach ($all as $key => $all_each_one){
					foreach ($stat_UV as $each_one){
						if ($each_one['DT'] == $all_each_one['DT']) {
							//dump($each_one['DT']);
							$all3[$key]['CNT'] = $each_one['CNT'];
						}
					}
				}
				//dump($all3);exit;
				
				$this->assign('stat_PV', $all2);
				$this->assign('stat_UV', $all3);
				
				
				//$this->assign('stat_PV', $stat_PV);
				//$this->assign('stat_UV', $stat_UV);
				
				//dump($query_pv); dump($stat_PV); dump($query_uv); dump($stat_UV);exit;
				
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