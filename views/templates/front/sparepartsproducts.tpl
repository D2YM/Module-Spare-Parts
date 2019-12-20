{extends file="page.tpl"}
{block name="content"}
{*
<pre style='height:150px;overflow: hidden;'>
    {var_dump($json)}
</pre>
*}
<div class="mod-pieces">
    <h1 class='title_pp'>
        {l s='Spareparts' mod='sparepartsproducts'}
    </h1>
	<div class="container">
		<div id="pieces-drop" role="tablist" aria-multiselectable="true">
            {foreach from=$json item=item_two}
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="piece-{$item_two.two.idPtwo}">
					<h5 class="panel-title">
						<a class="title-panel-piece collapsed" data-toggle="collapse" data-parent="#pieces-drop-{$item_two.two.idPtwo}" href="#cont-piece-{$item_two.two.idPtwo}" aria-expanded="false" aria-controls="cont-piece-{$item_two.two.idPtwo}">
						{$item_two.two.namePLevelTwo}
							<i class="material-icons a">
								keyboard_arrow_down
							</i>
							<i class="material-icons b">
								keyboard_arrow_up
							</i>
						</a>
						
					</h5>
				</div>
				{*
                <pre>
                    {var_dump($item_two.three)}
                </pre>
                *}
				<div id="cont-piece-{$item_two.two.idPtwo}" class="panel-collapse collapse " role="tabpanel" aria-labelledby="piece-{$item_two.two.idPtwo}">
					<div class="panel-body">
						<div class="row row-piece">
							<div class="col-md-6 col-sm-12 img">	
								<img idsrc='{$item_two.two.idPtwo}' src="{$item_two.three[0].image}" alt="imagen de pieza">	
							</div>

							<div class="col-md-6 col-sm-12 col-table">	
								<table>
									<tr class="header">
										<th class="numeral">#</th>
										<th class="description-th">Descripción</th>
										<th class="price-th">Precio</th>
										<th>Cantidad</th>
										<th></th>
									</tr>
									<div style='display:none'>
									{counter start=0 skip=1}
									</div>
                                    {foreach from=$item_two.three item=item_three}
									<tr class="fila-piece">
										<td class="number-piece">
											<p class="text-center">
											    {counter}
												<a href="#" image='{$item_three.image}' imageidsrc='{$item_two.two.idPtwo}'><i class="material-icons">visibility</i></a>
											</p>
										</td>
										<td class="data-piece">
											<p class="name-piece">
												<a href="{$item_three.url}">
												{$item_three.productSparePart->name}
												</a>
											</p>
											<p class="name-piece-2"><span>ref: </span>{$item_three.productSparePart->reference}</p>
										</td>
										<td class="data-price">
											<p class="price-piece">{$item_three.productSparePart->price|string_format:"%.2f"|number_format:2:",":"."} <span>
											    
											    {$currency.iso_code}
											</span></p>
										</td>
										<td class="data-cant">
											<div class="list-group-piece-qty w-18 clearfix">
                                    		<div class="input-group bootstrap-touchspin">
												<input id='count_{$item_three.productSparePart->id}_{$item_two.two.idPtwo}' type="text" class="input-group form-control js-cart-line-product-quantity form-control" min="1" aria-label="Cantidad" style="display: block;padding: 0;text-align: center;" data-min="1" value='1'>
	                    						<span class="input-group-btn-vertical">
	                                            <button id_count='#count_{$item_three.productSparePart->id}_{$item_two.two.idPtwo}' class="btn btn-touchspin js-touchspin bootstrap-touchspin-up" type="button"><i class="material-icons touchspin-up"></i></button>
	                                            <button id_count='#count_{$item_three.productSparePart->id}_{$item_two.two.idPtwo}' class="btn btn-touchspin js-touchspin bootstrap-touchspin-down" type="button"><i class="material-icons touchspin-down"></i></button>
                                        		</span>
                                    		</div>
                                			</div>
										</td>
										<td class="boton-fil">
											<form name="addtocart" id="addtocart_form_{$item_three.productSparePart->id}" method="POST" action="{$urls.pages.cart}">
												<input type="text" name="qty" id="count_{$item_three.productSparePart->id}_{$item_two.two.idPtwo}_2" value="1" class="input-group form-control qty qty_product qty_product_{$item_three.productSparePart->id} js-cart-line-product-quantity form-control" min="1" aria-label="Cantidad"
														style="display: none;" data-min="1">
												<input type="hidden" name="id_product" id="product_id_{$item_three.productSparePart->id}" value="{$item_three.productSparePart->id}">
												<button class="btn btn-primary btn-product add-to-cart leo-bt-cart leo-bt-cart_115 leo-enable" data-button-action="add-to-cart" type="submit">
													<span class="leo-bt-cart-content">
														<i class="icon-btn-product icon-cart material-icons shopping-cart"></i>
														<span class="name-btn-product">Añadir</span>
													</span>
												</button>
											</form>
										</td>
									</tr>
                                    {/foreach}
								</table>
							</div>
						</div>	
					</div>
				</div>
			</div>
            {/foreach}
	</div>
</div>
{/block}