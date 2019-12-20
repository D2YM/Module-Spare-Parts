jQuery('.mod-pieces table .fila-piece .number-piece a').click(function(event){
	event.preventDefault();
	document.documentElement.querySelector(`[idsrc="${jQuery(this).attr('imageidsrc')}"]`).setAttribute('src',jQuery(this).attr('image'))
});
jQuery('.mod-pieces table .fila-piece .bootstrap-touchspin .btn-touchspin').click(function(event){
    event.preventDefault();
    let count = jQuery(jQuery(this).attr('id_count')).attr('value');
    if(jQuery(this).hasClass('bootstrap-touchspin-up')){
        count++;
    }else{
        count--;
    }
    if(count<0)count=0;
    jQuery(jQuery(this).attr('id_count')).attr('value',count);
    jQuery(jQuery(this).attr('id_count')+'_2').attr('value',count);
});
jQuery(jQuery('.mod-pieces .panel .panel-title .title-panel-piece.collapsed')[0]).click()
let pre_url=window.location.href.split('?')[0].split('/')[window.location.href.split('?')[0].split('/').length-1];
let pos_url=window.location.href.split('slug=')[1];
//history.pushState(null, "", `${pre_url}/${pos_url}`);
