{"version":3,"sources":["dynamic_cards_form.js"],"names":["BX","namespace","Landing","UI","Form","DynamicCardsForm","data","BaseForm","apply","this","arguments","type","code","presets","sync","forms","id","replace","Utils","random","onSourceChangeHandler","onSourceChange","dynamicParams","settingFieldsSelectors","sourceField","createSourceField","pagesField","createPagesField","addField","detailPageGroup","createFieldsGroup","createLinkField","addCard","prototype","constructor","__proto__","getSources","Main","getInstance","options","sources","getSourceItems","map","item","name","value","url","filter","sort","items","sortItem","settings","sourceItems","source","isPlainObject","Field","SourceField","selector","title","Loc","getMessage","onValueChange","field","getValue","find","setTimeout","isDetailPageAllowed","style","layout","bind","Pages","pagesCount","content","text","href","detailPage","Link","textOnly","disableCustomURL","disableBlocks","disallowType","allowedTypes","LinkURL","TYPE_PAGE","detailPageMode","fields","siteId","site_id","landingId","=TYPE","params","createUseSefField","Checkbox","multiple","checked","Card","DynamicFieldsGroup","isReference","isArray","some","references","reference","serialize","reduce","acc","includes","Dropdown","stubs","DynamicImage","src","alt","isString"],"mappings":"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","file":"dynamic_cards_form.map.js"}