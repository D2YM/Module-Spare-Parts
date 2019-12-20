<div class="tab-pane fade in" id="product-sparepartsproducts">
    <h3 class="h3">{l s=$title_tab_spareparts mod='sparepartsproducts'}</h3>
    {if isset($content_tab_spareparts)} 
    {$content_tab_spareparts|unescape: "html" nofilter} 
    {/if}
    <a clas="btn btn-primary" href="/spareparts?id={$idProductValue}&slug={$productSlug}">{l s=$btn_tab_spareparts mod='sparepartsproducts'}</a>
</div>