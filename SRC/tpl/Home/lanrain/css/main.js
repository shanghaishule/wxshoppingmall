(function(){
var oHead = document.getElementsByTagName('head')[0];
var sBlock = 'header,footer,section,aside,article,nav,hgroup,figure,figcaption,details,summary';
var sInline = 'time,mark,ruby,rt,rp,output,keygen,meter,progress,command,source';
var sOther = 'video,audio,canvas,datalist';
var oStyle = document.createElement('style');
oStyle.type = 'text/css';
sCSS = sBlock + '{display:block;margin:0;padding:0;border:none}' + sInline + '{text-decoration:none;font-style:normal;font-weight:normal}';

if(oStyle.styleSheet){
	var aTags = (sBlock + ',' + sInline + ',' + sOther).split(',');
	for(var i=0;i<aTags.length;i++){
		document.createElement(aTags[i]);
	}
	oStyle.styleSheet.cssText = sCSS;
}else{
	oStyle.innerHTML = sCSS;
}

oHead.appendChild(oStyle);
})();