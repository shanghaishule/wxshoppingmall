<?php
class Wetall_importAction extends UserAction{
	public function _initialize() {
		parent::_initialize();
		$this->_mod = D('item');
		
		$catelist = M('item_cate')->where(array('status'=>1, 'tokenTall'=>$this->getTokenTall()))->order('ordid asc,id asc')->select();
		foreach ($catelist as $val){
			$cate_list[$val['id']]=$val['name'];
		}
		$this->assign('cate_list',$cate_list);
		
		$brandlist= $this->_brand=M('brandlist')->where(array('status'=>1, 'tokenTall'=>$this->getTokenTall()))->order('ordid asc,id asc')->select();
		foreach ($brandlist as $val){
			$brand_list[$val['id']]=$val['name'];
		}
		$this->assign('brand_list',$brand_list);
		
		$this->assign("im_message",M("message_check")->field("text")->find());
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

			$data['tokenTall'] = $tokenTall;
			
			//dump($data);exit;	
			
			if ($_POST['id'] != "") {
				//编辑
				$result = $this->_mod->save($data);
				if ($result !== false) {
					
					$this->success('成功！', U('Wetall_import/index'));
				} else {
					$this->error('失败！');
				}
			} else {
				//新增
				$data['add_time'] = time();
				$result = $this->_mod->add($data);
				if ($result !== false) {
					
					$this->success('成功！', U('Wetall_import/index'));
				} else {
					$this->error('失败！');
				}
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
			
			$this->assign('tokenTall',$tokenTall);
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

	
	public function data_excel() {
		$mod_taobao = D("item");
		$message = M("message_check");
		if (IS_POST) {
			if (false === $data = $mod_taobao->create()) {
				$this->error('出错啦！');
			}
	
			if (isset($_POST['url'])):
			
			$tianmao_urls = $_POST['url'];
			
			$item["brand"] = "";
			
			 
			/**
			 * 取得店铺所有商品的ID
			 */
			//$this->get_good_attr($tianmao_urls);/*
			$item_search = $tianmao_urls."/search.htm?spm=a1z10.5.0.0.RbNzaQ&search=y";
			if (strstr($tianmao_urls,"tmall") == true) {
				$content_page = file_get_contents($item_search);
				preg_match('/class=\"ui-page-s-len\".*b>/',$content_page,$total_page);
				 
			}elseif(strstr($tianmao_urls,"taobao") == true){
				$content_page = file_get_contents($item_search);
				preg_match('/<a class=\"J_SearchAsync.*<\/a>/',$content_page,$total_page);
				$total_page[0] = "1/10";
			}else{
				$total_page1 = 0;
			}
			$total_page1 = explode("/",$total_page[0]);
	
			$total_pages = $total_page1[1];
	
			$pageNo = 1;
			$current_url = $item_search; //初始url
			$url_array = array();
			for($pageNo=1;$pageNo <= $total_pages;$pageNo++){
				$current_url = $item_search."&pageNo=".$pageNo;
				$result_url_arr = $this->crawler($current_url);
				if ($result_url_arr) {
					foreach ($result_url_arr as $url) {
						$url10 = explode("\"",$url);
						$url_array[] = $url10[0];
					}
				}
	
			}
			//var_dump($url_array);die();
			$failed_num = 0;
			$success_num = 0;
			$have = 0;
			$fake_id = 0;
			foreach ($url_array as $good_url){
				if($success_num >= 1) {
					break;
				}
	
				if($this->get_good_attr($good_url,$item["brand"]) == "H"){//已经存在
					$have = $have + 1;
				}elseif ($this->get_good_attr($good_url,$item["brand"])) { //成功导入
					$success_num = $success_num + 1;
				}elseif($this->get_good_attr($good_url,$item["brand"]) == "N"){//商品id不正确
					$fake_id ++;
				}else{
					$failed_num = $failed_num + 1; //导入失败
				}
			}
			 
			$msg_su = "此店铺有".$have."个商品。此次成功导入".$success_num."个，有".$failed_num."个失败了！";

			if ($success_num > 0) {
				$messge = $message->find();
				if(!empty($messge["id"])){
					$datamessage["text"]=$msg_su;
					$message->where("1 = 1")->save($datamessage);
				}else{
					$datamessage["text"]=$msg_su;
					$message->add($datamessage);
				}
	
				IS_AJAX && $this->ajaxReturn(1, $msg_su, '', 'add');
				$this->success($msg_su);
			}else{
				$msg_su = "没有数据可更新！";
				$messge = $message->find();
				if(!empty($messge["id"])){
					$datamessage["text"]=$msg_su;
					$message->where("1 = 1")->save($datamessage);
				}else{
					$datamessage["text"]=$msg_su;
					$message->add($datamessage);
				}
	
				IS_AJAX && $this->ajaxReturn(0, L('operation_failure'));
				$this->error("没有数据可更新！");
			}
			endif;
		} else {
			$this->display();
		}
	}
	/**
	 * *验证数据是否可以更新
	 */
	public function check_good_attr($url){
		//商品货号
		$url_id = explode("id=",$url);
		if (strpos($url_id[1], "&")) {
			$url_id_real = explode("&",$url_id[1]);
			$item["Uninum"] = $url_id_real[0];
		}else{
			$item["Uninum"] = $url_id[1];
		}
		 
		if (!empty($item["Uninum"])) {
			if( M("item")->where($item)->find() ){
				return "Y";
			} else {
				return "M";
			}
		}else{
			return "N";
		}
	}
	/**
	 * *获取商品数据
	 */
	public function get_good_attr($url,$brand){
		$mod_taobao = M("item");
		if($this->check_good_attr($url) == "M"){//正常商品未同步至数据库
			$text=file_get_contents($url);
			//商品货号
			$url_id = explode("id=",$url);
			$url_id_real = explode("&",$url_id[1]);
	
			$item["Uninum"] = $url_id_real[0];
			//获取商品图片
			preg_match('/<img[^>]*id="J_ImgBooth"[^r]*rc=\"([^"]*)\"[^>]*>/', $text, $img);
			$result_imgs = preg_match_all('/<a href=\"#\"><img.*\/>/', $text,$imgs60);
			$i = 0;
			foreach ($imgs60[0] as $imgurl){
				$i = $i + 1;
				//str_replace("60x60","460x460",$imgurl);
				$imgreal_url0=preg_replace('/<a.*><img/',"",$imgurl);  //去掉regular expression匹配出来的多余的东西
				$imgreal_url1=preg_replace('/.*src=\"/',"",$imgreal_url0);
				$imgreal_url2=preg_replace('/\" \/>/',"",$imgreal_url1);
				$imgreal_url=preg_replace('/60x60/',"460x460",$imgreal_url2);
		   
				$data = file_get_contents($imgreal_url); // 读文件内容
				$data = iconv('GB2312', 'UTF-8', $data);
				$filetime = $item["Uninum"]; //得到时间戳
				$filepath = "./Uploads/items/images/".$filetime."/";//图片保存的路径目录
				if(!is_dir($filepath)){
					mkdir($filepath,0777, true);
				}
				$filename = "100".$i.'.jpg'; //生成文件名，
				ob_start(); //打开浏览器的缓冲区
				readfile($imgreal_url); //将图片读入缓冲区
				$data = ob_get_contents(); //获取缓冲区的内容复制给变量$img
				ob_end_clean(); //关闭并清空缓冲
				$fp = @fopen($filepath.$filename,"w"); //以写方式打开文件
				@fwrite($fp,$data); //
				fclose($fp);
		   
				//Http::curlDownload($imgreal_url,$newfile);  // 远程图片保存至本地
				//$imgsurl = $imgreal_url;
			}
			//var_dump($imgsurl);die();
	
			//商品尺码
			preg_match_all('/<li data-value=\".*>.*<\/span><\/a><\/li>/', $text, $size);
			foreach ($size[0] as $size1){
				$sizeurl = explode("<span>", $size1);
				$real_size = preg_replace('/<\/span><\/a><\/li>/',"",$sizeurl[1]);  //去掉regular expression匹配出来的多余的东西
				$result_size = $result_size."|".$real_size;
			}
			//var_dump($result_size);die();
	
			//获取商品名称
			preg_match('/<title>([^<>]*)<\/title>/', $text, $title);
			//$title=iconv('GBK','UTF-8',$title);var_dump($title);
			//获取商品价格
			preg_match('/<strong class=\"J_originalPrice\">.*<\/strong>/',$text,$price); //正则表示获取包含价格的 HTML 标签
			$price1 = preg_replace('/<strong class=\"J_originalPrice\">/',"",$price[0]);
			$price2 = preg_replace('/<\/strong>/',"",$price1);
	
			//获取商品属性
			preg_match('/<(div)[^c]*class=\"attributes\"[^>]*>.*<\/\\1>/is', $text, $text0);
			$text1=preg_replace("/<\/div>[^<]*<(div)[^c]*id=\"description\"[^>]*>.*<\/\\1>/is","",$text0);
			$attributes=preg_replace("/<\/div>[^<]*<(div)[^c]*class=\"box J_TBox\"[^>]*>.*<\/\\1>/is","",$text1);
			$attributes1 = iconv('GB2312', 'UTF-8', $attributes[0]);
			$attributes2 = preg_replace("/\\r\\n/","",$attributes1);
	
			//货号
			preg_match_all('/<li title=.*>.*&nbsp;.*<\/li>/', $text, $huohao);
			foreach ($huohao[0] as $var_co) {
				$var_huohao = iconv('GB2312', 'UTF-8', $var_co);
				if (strpos($var_huohao,"货号")) {
					$huohaoarr = $var_co;
				}
			}
			$huohao0 = explode(":",$huohaoarr);
			$huohao1 = explode("&nbsp;",$huohao0[1]);
			foreach ($huohao1 as $var_huohao){
	
				if (!empty($var_huohao) and strlen($var_huohao) > 7) {
					$huohaoresult = $var_huohao;
				}
			}
	
			//商品颜色
			preg_match_all('/<li title=.*>.*&nbsp;.*<\/li>/', $text, $color);
			foreach ($color[0] as $var_co) {
				$var_color = iconv('GB2312', 'UTF-8', $var_co);
				if (strpos($var_color,"颜色")) {
					$colorarr = $var_co;
				}
			}
			$color0 = explode(":",$colorarr);
			$color1 = explode("&nbsp;",$color0[1]);
			foreach ($color1 as $var_color){
	
				if (!empty($var_color) and strlen($var_color) > 7) {
					$colorresult = $colorresult."|".$var_color;
				}
			}
	
			 
			//获取商品描述
			preg_match_all('/<script[^>]*>[^<]*<\/script>/is', $text, $content);//页面js脚本
			$content=$content[0];
			$description='<div id="detail" class="box"> </div>
			        <div id="description" class="J_DetailSection">
			          <div class="content" id="J_DivItemDesc">描述加载中</div>
			        </div>';
			 
	
			foreach ($content as &$v){
				$description.=iconv('GBK','UTF-8',$v);
	
			};
			$img_real_url0=preg_replace('/<a.*><img/',"",$img[0]);  //去掉regular expression匹配出来的多余的东西
			$img_real_url1=preg_replace('/.*src=\"/',"",$img_real_url0);
			$imgurlzhu =preg_replace('/\".* \/>/',"",$img_real_url1);
	
			//主图下载
			$data = file_get_contents($imgurlzhu); // 读文件内容
			$data = iconv('GB2312', 'UTF-8', $data);
			$filetime = $item["Uninum"]; //得到时间戳
			$filepath = $_SERVER['DOCUMENT_ROOT']."/Uploads/items/images/";//图片保存的路径目录
			if(!is_dir($filepath)){
				mkdir($filepath,0777, true);
			}
			$filename = $filetime.'.jpg'; //生成文件名，
			ob_start(); //打开浏览器的缓冲区
			readfile($imgurlzhu); //将图片读入缓冲区
			$data = ob_get_contents(); //获取缓冲区的内容复制给变量$img
			ob_end_clean(); //关闭并清空缓冲
			$fp = @fopen($filepath.$filename,"w"); //以写方式打开文件
			@fwrite($fp,$data); //
			fclose($fp);
	
			$item["img"] = "/Uploads/items/images/".$filetime.".jpg";
	
			$title_real = explode("-",$title[1]);
			$item["title"] = iconv('GB2312', 'UTF-8', $title_real[0]);
			$item["price"] = (float)$price2;
			$item["info"] = $attributes2;
			$item["size"] = iconv('GB2312', 'UTF-8', $result_size);
			$item["color"] = preg_replace('/<\/li>/',"",$colorresult);
			$item["Huohao"] = preg_replace('/<\/li>/',"",$huohaoresult);
			$item["brand"] = $brand;
			$item["add_time"] = time();
			$item["tokenTall"] = $this->getTokenTall();
			//$item["imagesDetail"] = $description;
			//var_dump($item);die();
	
			if (!empty($item["Uninum"])) {
				if( $mod_taobao->add($item) ){
					return true;
				} else {
					return false;
				}
			}
		}elseif($this->check_good_attr($url) == "Y"){
			return "H"; //商品已经存在
		}else{
			return "N"; //id不正确
		}
	}
	/**
	 * 爬虫程序 -- 原型
	 *
	 * 从给定的url获取html内容
	 *
	 * @param string $url
	 * @return string
	 */
	public function getUrlContent($url) {
		$handle = fopen($url, "r");
		if ($handle) {
			$content = stream_get_contents($handle, 1024 * 1024);
			return $content;
		} else {
			return false;
		}
	}
	/**
	 * 从html内容中筛选链接
	 *
	 * @param string $web_content
	 * @return array
	 */
	public function _filterUrl($web_content) {
		$reg_tag_a = '/<[a|A].*?href=[\'\"]{0,1}([^>\'\"\ ]*[\?|&]id=.*).*?>/';
		$result = preg_match_all($reg_tag_a, $web_content, $match_result);
		if ($result) {
			return $match_result[1];
		}
	}
	/**
	 * 修正相对路径
	 *
	 * @param string $base_url
	 * @param array $url_list
	 * @return array
	 */
	public function _reviseUrl( $url_list) {
	
		$result = array();
		foreach ($url_list as $url){
			$url_id = explode("id=",$url);
			if (strpos($url_id[1], "&")) {
				$url_id_real = explode("&",$url_id[1]);
				$item_id = $url_id_real[0];
			}else{
				$item_id = $url_id[1];
			}
	
			$flag = "X";
			foreach ($result as $haveid){
	
				if(strpos($haveid,$item_id ) == true ){
					$flag = "Y";
					break;
				}
			}
			//if($i == 2) echo $flag;
			if($flag == "X") $result[] = $url;
		}
		return $result;
	}
	/**
	 * 爬虫
	 *
	 * @param string $url
	 * @return array
	 */
	public function crawler($url) {
		$content = $this->getUrlContent($url);//echo $content;
		if ($content) {
			$url_list = $this->_reviseUrl($this->_filterUrl($content));
			if ($url_list) {
				return $url_list;
			} else {
				return ;
			}
		} else {
			return ;
		}
	}
	
	public function deletemessage()
	{
		$datamessage["text"]="";
		$message = M("message_check");
		if($message->where("1 = 1")->save($datamessage)){
			$this->success("message被清空！");
		}
	}
	
	public function data_update() {
		$mod_taobao = D("item");
		$message = M("message_check");
		if (IS_POST) {
			if (false === $data = $mod_taobao->create()) {
				$this->error('出错啦！');
			}
	
			if (isset($_POST['url'])):
			$tianmao_urls = $_POST['url'];
			/**
			 * 取得店铺所有商品的ID
			 */
			//$this->get_good_attr($tianmao_urls);/*
			$item_search = $tianmao_urls."/search.htm?spm=a1z10.5.0.0.RbNzaQ&search=y";
			if (strstr($tianmao_urls,"tmall") == true) {
				$content_page = file_get_contents($item_search);
				preg_match('/class=\"ui-page-s-len\".*b>/',$content_page,$total_page);
				 
			}elseif(strstr($tianmao_urls,"taobao") == true){
				$content_page = file_get_contents($item_search);
				preg_match('/class=\"page-info\".*span>/',$content_page,$total_page);
			}else{
				$total_page1 = 0;
			}
			$total_page1 = explode("/",$total_page[0]);
			$total_pages = intval($total_page1[1]);
	
			$pageNo = 1;
			$current_url = $item_search; //初始url
			$url_array = array();
			for($pageNo=1;$pageNo <= $total_pages;$pageNo++){
				$current_url = $item_search."&pageNo=".$pageNo;
				$result_url_arr = $this->crawler($current_url);
				if ($result_url_arr) {
					foreach ($result_url_arr as $url) {
						$url10 = explode("\"",$url);
						$url_array[] = $url10[0];
					}
				}
		   
			}
	
			$failed_num = 0;
			$success_num = 0;
			foreach ($url_array as $good_url){
				 
				if($this->check_good_attr($good_url,$item["brand"]) == "M"){//已经存在
					$fake_id ++;//导入失败
				}elseif ($this->check_good_attr($good_url,$item["brand"])) { //已经存在
					$failed_num = $failed_num + 1;
				}elseif($this->check_good_attr($good_url,$item["brand"]) == false){//商品id不正确
					$success_num ++;
				}else{
						
				}
			}
			//echo $failed_num."===".$success_num; die();
			$msg_su = "没有数据可以更新";
			$haveupdate = "已有".$failed_num."个商品，你有".$success_num."个商品可以同步下来";
			//  	*/
			if ($success_num == 0) {
				$messge = $message->find();
				if(!empty($messge["id"])){
					$datamessage["text"]=$msg_su;
					$message->where("1 = 1")->save($datamessage);
				}else{
					$datamessage["text"]=$msg_su;
					$message->add($datamessage);
				}
				$this->success($msg_su, U('Wetall_import/index'));
			}else{
				$messge = $message->find();
				if(!empty($messge["id"])){
					$datamessage["text"]=$haveupdate;
					$message->where("1 = 1")->save($datamessage);
				}else{
					$datamessage["text"]=$haveupdate;
					$message->add($datamessage);
				}
				$this->success($haveupdate, U('Wetall_import/index'));
			}
			endif;
		} else {
			$this->assign('open_validator', true);
			$this->display();
		}
	}
}
?>