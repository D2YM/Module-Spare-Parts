<div id="growls-default_2"><div class="growl growl-notice growl-medium">
    <div class="growl-close">×</div>
    <div class="growl-title"></div>
    <div class="growl-message"></div>
    </div>
</div>
<div class="panel piece" id="piece">
   <div id="related-content" class="content pl-3 pr-3 { form.vars.value.data|length == 0 ? 'hide':'' }">
        <div class="col-md-12">
            <div id="alert-request"></div>
            <h2>Select Spare Parts Products</h2>
        </div>

        <div class="pather-box row flex-wrap">
            <div class="box-piece-level-2 mb-3 col-md-5">
                <input id="id_product_spareparts_level_two" class="id_product_spareparts_level_two" type="hidden" value="">
                <input id="name_product_spareparts_level_two" type="text" placeholder="Write name piece nevel 2" class="piece-nevel-2 form-control">
            </div>
            <div class="box-piece-level-3 col-md-5">
                <div class="box-piece-select" style="width: max-content;">
                    <select id="searchProductSelect2" class="piece-nevel-3 js-states form-control">{l s='Select the pieces of the list products' mod='productpiece'}</select>
                </div>
                <div data-form="sendPiece" class="col-12">
                    <input id="id_product_spareparts" type="hidden" value="{$id_productmain_spareparts}"/>
                </div>
            </div>
            <div class="col-md-2">
                <a class="clase_f" href="javascript:void(0);">
                    <i class="material-icons">
                        add_circle_outline
                    </i>
                </a>
            </div>
        </div>
        <div id="box-termin"></div>
        <div class="btn-group mt-4">
            <a id="save-spareparts" class="btn btn-primary text-white">{l s='Salve' mod='productpiece'}</a>
            {*
            <a id="test" class="btn btn-primary text-white">Test</a>
            *}
        </div>
    </div>
</div>
<div id='content_panel_list_piece' style="display: flex; flex-wrap: wrap;"></div>