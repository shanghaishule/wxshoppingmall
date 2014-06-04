/*
 * YayaTemplate - A fast javascript template engine
 * https://github.com/zinkey/YayaTemplate
 * @copyright yaya&jihu
 * 2012 MIT License
 */
(function(b,a,c){if(typeof module!="undefined"&&module.exports){module.exports=a()}else{if(typeof c.define==="function"&&c.define.amd){define(b,a)}else{c[b]=a()}}})("YayaTemplate",function(){var o,p,l,e,n,h,g,m,k,c,j,i,f,b;if(typeof document==="object"&&typeof navigator==="object"){o=/msie (\d+\.\d+)/i.test(navigator.userAgent)?(document||+RegExp["$1"])>=8:true}else{o=true}if(o){p="+=";e="''";l=""}else{p=".push";e="[]";l=".join('')"}function a(q){f=false;switch(q.length){case 2:f=(q==="if")||(q==="in")||(q==="do");break;case 3:f=(q==="var")||(q==="for")||(q==="new")||(q==="try")||(q==="let");break;case 4:f=(q==="this")||(q==="else")||(q==="case")||(q==="void")||(q==="with")||(q==="enum");break;case 5:f=(q==="while")||(q==="break")||(q==="catch")||(q==="throw")||(q==="const")||(q==="yield")||(q==="class")||(q==="export")||(q==="import")||(q==="super");break;case 6:f=(q==="return")||(q==="typeof")||(q==="delete")||(q==="switch")||(q==="public")||(q==="static");break;case 7:f=(q==="default")||(q==="finally")||(q==="package")||(q==="private")||(q==="extends");break;case 8:f=(q==="function")||(q==="continue")||(q==="debugger");break;case 9:f=(q==="interface")||(q==="protected");break;case 10:f=(q==="instanceof")||(q==="implements");break}return f}function d(q){j=-1;i=[];n=q.replace(/{\%([\s\S]*?)\%}/g,function(s,r){i[++j]='");_YayaTemplateString'+p+"("+r+");_YayaTemplateString"+p+'("';return"YayaTemplateFLAG"+j}).replace(/{\$([\s\S]*?)\$}/g,function(s,r){return"_YayaTemplateString"+p+'("'+r.replace(/("|\\|\r|\n)/g,"\\$1")+'");'}).replace(/YayaTemplateFLAG(\d+)/g,function(s,r){return i[r]});h=n.replace(/"([^\\"]|\\[\s\S])*"|'([^\\']|\\[\s\S])*'/g,"").replace(/\.[\_\$\w]+/g,"").match(/[\_\$a-zA-Z]+[0-9]*/g);g=h.length;c={};m="";while(g--){k=h[g];if(!c[k]&&!a(k)){m+=k+'=_YayaTemplateObject["'+k+'"],';c[k]=true}}return"var "+m+"_YayaTemplateString="+e+";"+n+" return _YayaTemplateString"+l+";"}return function(q){return{render:new Function("_YayaTemplateObject",d(q))}}},this);(function(){window.gAdTemplate={_template:{lt:'{$ <a href="{%promTextClickCountUrl%}&_r_ignore_uid={%uid%}" target="_blank" style="">{%promText%}</a> <img src="{%openUrl%}&uid={%uid%}" style="position:absolute;z-index:0;right:0;width:1px;height:1px;" /> $}'},parse:function(oData){var result={};for(var propName in oData){if(propName=="ver"){result[propName]=oData[propName]}else{if(propName=="lt"){result[propName]=this.parseArrayData(oData[propName])}else{result[propName]=oData[propName]}}}return result},parseObjectData:function(item){var data={};var tplName="";var tplData={};for(var propName in item){if(propName=="pid"){data[propName]=item[propName]}else{if(propName=="div"){data[propName]=item[propName]}else{if(propName=="tpl"){tplName=item[propName]}else{tplData[propName]=item[propName]}}}}if(tplName===""){return data}var tpl=this._template[tplName];if(tpl==null){return data}data.div=this.renderHtml(tpl,tplData);return data},parseArrayData:function(items){var datas=[];for(var key in items){var item=items[key];datas.push(this.parseObjectData(item))}return datas},renderHtml:function(template,data){return YayaTemplate(template).render(data)}}})();