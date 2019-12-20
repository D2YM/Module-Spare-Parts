jQuery(document).ready(function() {
    /** Function select2 */
    if (document.getElementById('searchProductSelect2')) {
        $('#searchProductSelect2').select2({
            ajax: {
                url: queryVariantProduct,
                dataType: 'json',
                method: 'POST',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term, // search term
                    };
                },
                processResults: function(data) {
                    return {
                        results: jQuery.map(data, function(obj) {
                            return { id: obj.id, text: obj.name, ref: obj.ref, image: obj.image };
                        })
                    };
                }
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
            placeholder: 'Select spare parts of nevel 3',
            minimumInputLength: 1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });
        
        jQuery('#searchProductSelect2').on("select2:select", function(e) {
            //console.log(e.params.data);
            jQuery('#box-termin').append('<div id="box_piece_' + e.params.data.id +
                '" class="mt-4 d-flex flex-wrap position-relative box-piece"><div class="box-img-span"><img src="' + e.params.data.image +
                '" ></div><div class="data-ref"><span class = "d-none id-piece" data-id = "' + e.params.data.id +
                '" > </span><span class="text-inp d-block">' + e.params.data.text +
                '</span ><span class="ref-inp d-block">Ref: ' + e.params.data.ref +
                '</span ></div><button type="button" data-id="' + e.params.data.id + '"  data-box="box_piece_' + e.params.data.id + '" onclick="eraseProductSpareparts(this, this.dataset.id, this.dataset.box)" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        });
        function formatRepo(repo) {
            console.log(repo);
            if (repo.loading) {
                return repo.text;
            }
            var $container = jQuery(
                "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__avatar img__avatar__piece'><img src='" + repo.image + "' /></div>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title img__avatar__text'>" + repo.text + "</div>" +
                "<div class='select2-result-repository__description img__avatar__ref'>" + repo.ref + "</div>" +
                "</div>" +
                "</div>"
            );

            $container.find(".select2-result-repository__title").text(repo.text);
            $container.find(".select2-result-repository__description").text(repo.ref);

            return $container;
        }
        function formatRepoSelection(repo) {
            return repo.text;
        }
    }
    
    jQuery("#save-spareparts").click(function() {
        var itemPiece = document.querySelectorAll('#box-termin .box-piece .data-ref .id-piece');
        var idPieceLevelTwo = document.getElementById('id_product_spareparts_level_two').value;
        var namePieceLevelTwo = document.getElementById('name_product_spareparts_level_two').value;
        var id_product_spareparts = document.getElementById('id_product_spareparts').value;
        var piece = [];

        for (var i = 0; i < itemPiece.length; i++) {
            piece.push(itemPiece[i].dataset.id);
        }
        var jsonString = JSON.stringify(piece);

        jQuery.ajax({
            type: "POST",
            url: ajax_spareparts,
            data: { data: jsonString, idProduct: id_product_spareparts, namePieceLevelTwo: namePieceLevelTwo, idPieceLevelTwo: idPieceLevelTwo},
            cache: false,

            success: function(entry) {
                var ans = JSON.parse(entry);
                console.log(ans);
                if(ans){
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
        });
    });
});