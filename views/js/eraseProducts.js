jQuery(document).ready(function() {
    /** Function select2 */
    var Ity;
});
function eraseProductSpareparts(obj, idSpareParts, idBoxSpareParts) {
    var ans = confirm("Seguro de eliminar el Repuesto?");
    if (ans == true) {
        var idproduct = document.getElementById('id_product_spareparts_level_two').value;
        if(idproduct === ""){
            jQuery("#" + idBoxSpareParts).remove();
        } else {
            idPieceLevelTwo = obj.parentElement.parentElement.previousElementSibling.getElementsByClassName('id_product_spareparts_level_two').item(0).value;
            
            jQuery.ajax({
                type: "POST",
                url: ajax_spareparts_delete,
                data: { idProductLevelTree: idSpareParts, idPieceLevelTwo: idPieceLevelTwo},
                cache: false,
                success: function(entry) {
                    jQuery("#" + idBoxSpareParts).remove();
                }
            });
        }
    }
}

function eraseLevelTwoSpareparts(obj)
{
    var ans = confirm("Seguro de eliminar el Repuesto?");
    if (ans == true)
    {
        idPieceLevelTwo = obj.dataset.boxTwoId;
        jQuery.ajax({
            type: "POST",
            url: ajax_spareparts_delete,
            data: { idPieceLevelTwo: idPieceLevelTwo},
            cache: false,
            success: function(entry) {
                jQuery(entry);
                if(entry){
                    var ans = JSON.parse(entry);
                    if(ans){
                        boxDoc = document.documentElement.querySelector('[idtwopp="'+idPieceLevelTwo+'"]');
                        boxDoc.remove();
                    }
                    else{

                    }
                }
            }
        });
    }
}

function eraseProductThreeSpareparts(obj) 
{
    Ity = obj;
    var ans = confirm("Seguro de eliminar el Repuesto?");
    if (ans == true)
    {
        var objO = obj.parentElement;
        var idptwo = objO.getAttribute('idptwo');
        var idpthree = objO.getAttribute('idpthree');
        var objOE = objO.parentElement;
        //idPieceLevelThree = obj.dataset.box;
        //console.log(idPieceLevelThree);
        jQuery.ajax(
        {
            type: "POST",
            url: ajax_spareparts_delete,
            data: { idPieceLevelTwo: idptwo, idPieceLevelThree: idpthree},
            cache: false,
            success: function(entry) {
                jQuery(entry);
                if(entry){
                    var ans = JSON.parse(entry);
                    if(ans){
                        objOE.remove();
                        if( document.getElementById('id_product_spareparts_level_two') && document.getElementById('id_product_spareparts'))
                        {
                            idProductLevelOne = document.getElementById('id_product_spareparts').value;
                            idProductLevelTwo = document.getElementById('id_product_spareparts_level_two').value;
                            jQuery.ajax({
                                type: "POST",
                                url: ajax_spareparts_list,
                                data: { idProductLevelOne: idProductLevelOne, idProductLevelTwo: idProductLevelTwo},
                                cache: false,
                                success: function(entryDev) {
                                    carga_panel_2(entryDev);
                                }
                            });
                        }
                    }
                    else{
                        
                    }
                }
            }
        });
    }
}