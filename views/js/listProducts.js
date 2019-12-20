let idProductLevelOne,idProductLevelTwo;
let info_u='';
jQuery(document).ready(function() {
    if( document.getElementById('id_product_spareparts_level_two') && document.getElementById('id_product_spareparts')){
        idProductLevelOne = document.getElementById('id_product_spareparts').value;
        idProductLevelTwo = document.getElementById('id_product_spareparts_level_two').value;
        jQuery.ajax({
            type: "POST",
            url: ajax_spareparts_list,
            data: { idProductLevelOne: idProductLevelOne, idProductLevelTwo: idProductLevelTwo},
            cache: false,
            error: function(entry) {
                carga_panel_2('error');
            },
            success: function(entry) {
                carga_panel_2(entry);
            }
        });
    }

jQuery("#test").click(function() {    
    if( document.getElementById('id_product_spareparts_level_two') && document.getElementById('id_product_spareparts')){
        idProductLevelOne = document.getElementById('id_product_spareparts').value;
        idProductLevelTwo = document.getElementById('id_product_spareparts_level_two').value;
        jQuery.ajax({
            type: "POST",
            url: ajax_spareparts_list,
            data: { idProductLevelOne: idProductLevelOne, idProductLevelTwo: idProductLevelTwo},
            cache: false,
            error: function(entry) {
                carga_panel_2('error');
            },
            success: function(entry) {
                carga_panel_2(entry);
            }
        });
    }
});
});


















/**
    codios Francisco
*/
function show_msj(){
    jQuery('#growls-default_2').addClass('active').delay(1000).queue(function(next){
        $(this).removeClass("active");
        jQuery('#growls-default_2 .growl').attr('style','');
        next();
    });
}
//variables 
let product_two,product_three;
function carga_panel_2(info_u){
    if(info_u=='error'){
        jQuery('#growls-default_2 .growl-message').html('Algo fallo, Intente denuevo');
        jQuery('#growls-default_2 .growl').attr('style','background:red');
        show_msj();
        return;
    }
	//si no existe contenido no haga nada 
    if(info_u=='')return;
    
    var cplp = jQuery('#content_panel_list_piece');
    cplp.html('');
    for(item_two_aux in info_u){
    	item_two= info_u[item_two_aux];
    	cplp.append(`
    <div idtwopp='${item_two.two.idPtwo}'  box_two_id='${item_two.two.idPtwo}' >
		<div class='panel list-piece'>
    		<div id='item_two_${item_two.two.idPtwo}' class='content col-12'>
		        <div id='product_two_${item_two.two.idPtwo}' class='product_two'>
		            <a class='delete' data-box-two-id='${item_two.two.idPtwo}'
		                onclick="eraseLevelTwoSpareparts(this)"
		                style='cursor:pointer'
		            >
		                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash-alt" class="svg-inline--fa fa-trash-alt fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg>    
		            </a>
		            <span class='name'>
		            ${item_two.two.namePLevelTwo}
		            </span>
		            <a href='#piece' class='edit' idtwoppedit='${item_two.two.idPtwo}' item_two_aux='${item_two_aux}'>
		                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pencil-alt" class="svg-inline--fa fa-pencil-alt fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path></svg>
		            </a>
		        </div>
		        <div class='form_bus'>
		            <input type='search' id='bus_p2_${item_two.two.idPtwo}' value='' idtwoppbusinput='${item_two.two.idPtwo}' >
		            <a id='seach_p2_${item_two.two.idPtwo}' idtwoppbus='${item_two.two.idPtwo}'>
		                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search" class="svg-inline--fa fa-search fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path></svg>
		            </a>
		        </div>
		        <div id='content_info_p2_three_${item_two.two.idPtwo}' class='content_info'>
		            
		        </div>
		    </div>
		</div>
	</div>
    	`);
    var formatNumber = {
     separador: ",", // separador para los miles
     sepDecimal: '.', // separador para los decimales
     formatear:function (num){
     num +='';
     var splitStr = num.split('.');
     var splitLeft = splitStr[0];
     var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
     var regx = /(\d+)(\d{3})/;
     while (regx.test(splitLeft)) {
     splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
     }
     return this.simbol + splitLeft +splitRight;
     },
     new:function(num, simbol){
     this.simbol = simbol ||'';
     return this.formatear(num);
     }
    }
    	for(aux in item_two.three){
	    	array_aux= item_two.three[aux];
	    	//creo elementos de array (con el primero activo )
	    	//se le agrega idPthree, idPtwo, name en lowercase y text
	    	console.dir(array_aux.productSparePart.category);
	    	jQuery(`#content_info_p2_three_${item_two.two.idPtwo}`).append(`
	    		<div class='item_three' item_three='${array_aux.idPthree}'>
		    		<div class='name_item d-flex' 
		    		idPthree='${array_aux.idPthree}'
		    		idPtwo='${array_aux.idPtwo}'
		    		name='${array_aux.productSparePart.name.toLowerCase()} ${array_aux.productSparePart.reference.toLowerCase()}'
		    		id='box_piece_s_${array_aux.idPthree}'
		    		>
    		    		<a href='#' class='delete_sub_item'
    		    		        item_two_check='${item_two.two.idPtwo}'
    		    		     data-id="${array_aux.idPthree}" data-box="box_piece_s_${array_aux.idPthree}" 
    		    		     onclick="eraseProductThreeSpareparts(this);"
    		    		     style='margin-right: 10px;'
    		    		>
    		                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash-alt" class="svg-inline--fa fa-trash-alt fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg>    
    		            </a>
			    		<span style='width:100%;'>
			    		    ${array_aux.productSparePart.name}
    			    		<div style="font-size: 0.6em;">
    			    		    Ref: ${array_aux.productSparePart.reference}
    			    		</div>
			    		</span>
		    		</div>
		    		<div class='info'>
		    			<span close='${array_aux.idPthree}'>close</span>
		    			<div class='d-flex'>
			    			<img class='img' src='${array_aux.image}'>
			    			<div class='reference'>
			    			    ${array_aux.productSparePart.name}
			    			    <span class='d-block' style='font-size:.7em;'>Ref: ${array_aux.productSparePart.reference}<span>
			    			</div>
			    		</div>
		    			<div class='price'>
		    			    ${currency.sign} 
		    			    ${formatNumber.new(array_aux.productSparePart.price.split('.')[0]+'.'
		    			    +array_aux.productSparePart.price.split('.')[1][0]+''+array_aux.productSparePart.price.split('.')[1][1])} 
		    			    <span style='font-size:.5em;'>${currency.iso_code}</span>
		    			</div>
		    			<div class='category'>${array_aux.productSparePart.category}</div>
		    			<div class='condition d-none'>${array_aux.productSparePart.condition}</div>
		    			<div class='description_short'>${array_aux.productSparePart.description_short}</div>
		    		</div>
	    		</div>
	    	`);
	    }
    }
    
    //funcion click para agregar active 
    jQuery('.panel.list-piece .content_info .item_three .name_item').click(function(){
    	jQuery('.panel.list-piece .content_info .item_three').removeClass('active');
    	jQuery(this).parent().addClass('active');
    });
    //click de buscar   
    jQuery('[idtwoppbus]').click(function(){
    	//el valor en lowercase para la comparacion
    	let valor = jQuery(`[idtwoppbusinput='${this.attributes.idtwoppbus.value}']`).val().toLowerCase();
    	//activa el resulatado de busqueda
    	jQuery(buscar_panel_2(valor,this.attributes.idtwoppbus.value)[0]).click();
    });
    jQuery('.panel.list-piece [close]').click(function(){
    	jQuery(`[item_three='${this.attributes.close.value}']`).removeClass('active');
    });
    
    jQuery('[idtwopp] .edit').click(function(){
    	let newinfo = info_u[this.attributes.item_two_aux.value];
    	jQuery('#name_product_spareparts_level_two').val(newinfo.two.namePLevelTwo);
    	jQuery('#id_product_spareparts_level_two').val(newinfo.two.idPtwo);
    	jQuery('#box-termin').html('');
    	for(aux in newinfo.three){
	    	array_aux= newinfo.three[aux];
    		jQuery('#box-termin').append(`
    			<div id="box_piece_${array_aux.idPthree}" class="mt-4 d-flex flex-wrap position-relative box-piece">
				    <div class="box-img-span">
				    	<img src="${array_aux.image}">
				    </div>
				    <div class="data-ref">
				    	<span class="d-none id-piece" data-id="${array_aux.idPthree}"> </span>
				    	<span class="text-inp d-block">
				    		${array_aux.productSparePart.name}
				    	</span>
				    	<span class="ref-inp d-block">
				    		${array_aux.productSparePart.reference}
				    	</span>
				    </div>
				    <button type="button" data-id="${array_aux.idPthree}" data-box="box_piece_${array_aux.idPthree}" onclick="eraseProductSpareparts(this, this.dataset.id, this.dataset.box)" class="close" aria-label="Close"><span aria-hidden="true">×</span>
				    </button>
				</div>	
    		`);
	    }
	    var aux_img = jQuery('#module_sparepartsproducts .box-img-span img');
	    for(var i=0;i<aux_img.length;i++){
	        if(existeUrl(jQuery(aux_img[i]).attr('src'))){
	            /*
	            jQuery(aux_img[i]).parent().attr('style',`
	                padding-left:0;
	                padding-right:0;
	                width:0;
	            `);
	            aux_img[i].outerHTML=''
	            */
	        }
	    }
    });
    jQuery('.panel.list-piece .delete_sub_item').click(function(){
        var aux = jQuery(`#item_two_${jQuery(this).attr('item_two_check')} .item_three`);
        if(aux.length<1){
            jQuery(`[data-box-two-id='${jQuery(this).attr('item_two_check')}']`).click();
        }
        jQuery('#growls-default_2 .growl-message').html('Producto eliminado');
        jQuery('#growls-default_2 .growl').attr('style','background:red');
        show_msj();
    });
    jQuery('.panel.list-piece .product_two a.delete').click(function(){
        jQuery('#growls-default_2 .growl-message').html('Producto eliminado');
        jQuery('#growls-default_2 .growl').attr('style','background:red');
        show_msj();
    });
    jQuery('.panel.list-piece .form_bus input').keyup(function(e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == 13) {
            jQuery('#'+jQuery(this).attr('id').split('bus').join('seach')).click();
        }
    });
    jQuery('#growls-default_2 .growl-message').html('Configuracion actualizada');
    show_msj();
}
function buscar_panel_2(valor,idtwopp){
	//busca por el valor resivido 
	return jQuery(`[idtwopp='${idtwopp}'] .panel.list-piece .content_info .item_three .name_item[name*="${valor}"]`);
}
function existeUrl(url) {
   var http = new XMLHttpRequest();
   http.open('HEAD', url, false);
   http.send();
   return http.status!=404;
}
jQuery(window).ready(function(){
    jQuery('#module_sparepartsproducts .clase_f').click(function(){
        jQuery('#save-spareparts').click();
    });
});