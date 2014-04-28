<?php
class WeTall_ItemAction extends UserAction{
	public function _initialize() {
		parent::_initialize();
		$this->_mod = D('item');
		$catelist = M('item_cate')->where(array('status'=>1, 'tokenTall'=>$this->getTokenTall()))->order('ordid asc,id asc')->select();
		foreach ($catelist as $val){
			$cate_list[$val['id']]=$val['name'];
		}
		$brandlist= $this->_brand=M('brandlist')->where(array('status'=>1, 'tokenTall'=>$this->getTokenTall()))->order('ordid asc,id asc')->select();
		foreach ($brandlist as $val){
			$brand_list[$val['id']]=$val['name'];
		}
		$this->assign('cate_list',$cate_list);
		$this->assign('brand_list',$brand_list);
	}
	
	
	public function index(){
		$map = array();
		$mod = $this->_mod;
		!empty($mod) && $this->_list($mod, $map);
		$this->display();
	}

	public function edit() {
		$id = $this->_get('id');
		$tokenTall = $this->getTokenTall();
		
		//提交，有id则为编辑，无id则为新增
		if (IS_POST) {
			dump($_POST);exit;
			
			//得到商品的尺码和颜色
			$colors = $_POST['color'];
			$colorstr = "";
			foreach($colors as $val){
				$colorstr = $colorstr."|".$val;
			}
			$sizes = $_POST['size'];
			$sizestr = "";
			foreach($sizes as $val2){
				$sizestr = $sizestr."|".$val2;
			}
			 
			//获取数据
			if (false === $data = $this->_mod->create()) {
				$this->error($this->_mod->getError());
			}
			if( !$data['cate_id']||!trim($data['cate_id']) ){
				$this->error('请选择商品分类');
			}
			 
			if($_POST['brand']==''){
				$this->error('请选择品牌');
			}
			 
	
			//必须上传图片
			if (empty($_POST['img'])) {
				$this->error('请上传商品图片');
			}
			if(isset($_POST['news']))
			{
				$data['news']=1;
			}else {
				$data['news']=0;
			}
			if(isset($_POST['tuijian']))
			{
				$data['tuijian']=1;
			}else {
				$data['tuijian']=0;
			}
	
			if($_POST['free']==1)
			{
				$data['free']=1;
			}else if($_POST['free']==2)
			{
				$data['free']=2;
				$data['pingyou']=$this->_post('pingyou');
				$data['kuaidi']=$this->_post('kuaidi');
				$data['ems']=$this->_post('ems');
			}

			//保存一份到相册
			$data['imgs'] =  array('url' => $data['img']);
			$data['tokenTall'] = $tokenTall;
			//加入颜色和尺码
			$data["size"]=$sizestr;
			$data["color"]=$colorstr;
			dump($data);exit;	
			
			$this->_mod->create($data);
			$item_id = $this->_mod->add();

			if ($item_id) {
				//商品相册处理
				if (isset($data['imgs']) && $data['imgs']) {
					$item_img_mod = D('item_img');
					foreach ($data['imgs'] as $_img) {
						$_img['item_id'] = $item_id;
						$item_img_mod->create($_img);
						$item_img_mod->add();
					}
				}
			
				$this->success(L('operation_success'));
			} else {
				$this->error(L('operation_failure'));
				
			}
			
			
			
		} 
		//非提交，有id为编辑展示，无id为新增展示
		else {
			if ($id) {
				$myaction = "编辑";
			}else{
				$myaction = "新增";
			}
			
			$this->assign('tokenTall',$tokenTall);
			$this->assign('myaction',$myaction);
			$this->display();
		}
	}






}
?>