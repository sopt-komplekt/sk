(function (window) {

if (!!window.JCCatalogCompareList)
{
	return;
}

window.JCCatalogCompareList = function (params)
{
	this.obCompare = null;
	this.visual = params.VISUAL;
	this.visual.LIST = this.visual.ID + '_tbl';
	this.visual.ROW = this.visual.ID + '_row_';
	this.visual.COUNT = this.visual.ID + '_count';
	this.ajax = params.AJAX;

	BX.ready(BX.proxy(this.init, this));
};

window.JCCatalogCompareList.prototype.init = function()
{
	this.obCompare = BX(this.visual.ID);
	if (!!this.obCompare)
	{
		BX.addCustomEvent(window, "OnCompareChange", BX.proxy(this.reload, this));
		// BX.bindDelegate(this.obCompare, 'click', {tagName : 'a'}, BX.proxy(this.deleteCompare, this));
	}
};

window.JCCatalogCompareList.prototype.reload = function()
{
	BX.showWait(this.obCompare);
	BX.ajax.post(
		this.ajax.url,
		this.ajax.reload,
		BX.proxy(this.reloadResult, this)
	);
};

window.JCCatalogCompareList.prototype.reloadResult = function(result)
{
	BX.closeWait();
	this.obCompare.innerHTML = result;
	BX.style(this.obCompare, 'display', 'block');
};

// window.JCCatalogCompareList.prototype.deleteCompare = function()
// {
// 	var target = BX.proxy_context,
// 		itemID,
// 		url;

// 	if (!!target && target.hasAttribute('data-id'))
// 	{
// 		itemID = parseInt(target.getAttribute('data-id'), 10);
// 		if (!isNaN(itemID))
// 		{
// 			BX.showWait(this.obCompare);
// 			url = this.ajax.url + this.ajax.templates.delete + itemID.toString();
// 			BX.ajax.loadJSON(
// 				url,
// 				this.ajax.params,
// 				BX.proxy(this.deleteCompareResult, this)
// 			);
// 		}
// 	}
// };

// window.JCCatalogCompareList.prototype.deleteCompareResult = function(result)
// {
// 	var tbl,
// 		i,
// 		deleteID,
// 		cnt,
// 		newCount;

// 	BX.closeWait();
// 	if (typeof result === 'object')
// 	{
// 		if (!!result.STATUS && result.STATUS === 'OK' && !!result.ID)
// 		{
// 			BX.onCustomEvent('onCatalogDeleteCompare', [result.ID]);

// 			tbl = BX(this.visual.LIST);
// 			if (tbl)
// 			{
// 				if (tbl.rows.length > 1)
// 				{
// 					deleteID = this.visual.ROW + result.ID;
// 					for (i = 0; i < tbl.rows.length; i++)
// 					{
// 						if (tbl.rows[i].id === deleteID)
// 						{
// 							tbl.deleteRow(i);
// 						}
// 					}
// 					tbl = null;
// 					if (BX.type.isNotEmptyString(result.COUNT) || BX.type.isNumber(result.COUNT))
// 					{
// 						newCount = parseInt(result.COUNT, 10);
// 						if (!isNaN(newCount))
// 						{
// 							cnt = BX(this.visual.COUNT);
// 							if (!!cnt)
// 							{
// 								cnt.innerHTML = newCount.toString();
// 								cnt = null;
// 							}
// 							BX.style(this.obCompare, 'display', (newCount > 0 ? 'block' : 'none'));
// 						}
// 					}
// 				}
// 				else
// 				{
// 					this.reload();
// 				}
// 			}
// 		}
// 	}
// };

})(window);