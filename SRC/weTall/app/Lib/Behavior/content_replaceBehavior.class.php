<?php

defined('THINK_PATH') or exit();
/**
 * 行为扩展：模板内容输出替换
 */
class content_replaceBehavior extends Behavior {

    public function run(&$content){
        $content = $this->_replace($content);
    }

    private function _replace($content) {
        $replace = array();
        //静态资源地址
        $statics_url = C('pin_statics_url');
        if ($statics_url != '') {
            $replace['__STATIC__'] = $statics_url;
        } else {
            $replace['__STATIC__'] = __ROOT__.'/static';
        }
        
    	//父资源地址
        $parent_url = C('PARENT_URL');
        if ($parent_url != '') {
            $replace['__PARENTURL__'] = $parent_url;
        } else {
            $replace['__PARENTURL__'] = rtrim(__ROOT__,'weTall/');
        }
        $parent_res = C('PARENT_RES');
        if ($parent_url != '') {
        	$replace['__PARENTRES__'] = $parent_res;
        } else {
        	$replace['__PARENTRES__'] = rtrim(__ROOT__,'weTall/').'/tpl/User/default/common';
        }
        
        //附件地址
        $replace['__UPLOAD__'] = __ROOT__.'/data/upload';
        $content = str_replace(array_keys($replace),array_values($replace),$content);
        return $content;
    }
}