'use strict';
BX.ready(function()
{
	BX.bind(BX('catalog_add2cart_link'), 'click', function()
	{
		this.text = BX.message('CATALOG_IN_BASKET');
	});
});
