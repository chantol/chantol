<?php

Route::get('/','LoginController@getlogin')->name('/');
Route::post('/login','LoginController@postlogin')->name('login');
Route::get('/logout','LoginController@getlogout')->name('logout');
Route::get('/register', 'LoginController@create')->name('userregister');
Route::post('/register', 'LoginController@store');
Route::get('/noPermission',function(){
	return view('noentry');
});

Route::group(['middleware'=>['authen','roles']],function(){
	Route::get('/dashboard','DashboardController@dashboard')->name('dashboard');
});

Route::group(['middleware'=>['authen','roles'],'roles'=>['admin']],function(){

	// route product
	Route::group(['prefix'=>'product'],function(){
		Route::get('/create','ProductController@Product_Create')->name('createproduct');
		Route::get('/score','ProductController@product_score')->name('productscore');
		Route::get('/getproductunit','ProductController@productunit')->name('productunit');
		Route::post('/postproductscore','ProductController@postproductscore')->name('postproductscore');
		Route::post('/updateproductscore','ProductController@updateproductscore')->name('updateproductscore');
		Route::post('/deleteproductscore','ProductController@deleteproductscore')->name('deleteproductscore');
		Route::get('/getproductscorelisthistory','ProductController@getproductscorelisthistory')->name('getproductscorelisthistory');
		Route::get('/getinfobyscoreid','ProductController@getinfobyscoreid')->name('getinfobyscoreid');
		Route::post('/category/add','ProductController@category_add')->name('postcategory');
		Route::post('/brand/add','ProductController@brand_add')->name('postbrand');
		Route::post('/create','ProductController@Store')->name('postproduct');
		Route::get('/edit','ProductController@edit')->name('editproduct');
		Route::post('/update1','ProductController@update1')->name('productupdate1');
		Route::post('/destroy','ProductController@destroy')->name('productdestroy');
		Route::get('/checkproductcode','ProductController@checkproductcode')->name('check_exist_prcode');
		Route::get('/all','ProductController@allproduct')->name('showallproduct');
		Route::get('/product_edit/{id}','ProductController@product_edit')->name('product_edit');
		Route::get('/barcode','ProductController@viewbarcode')->name('viewbarcode');
		Route::post('/unit','ProductController@unit_add')->name('add_unit');
		Route::get('/search','ProductController@productsearch')->name('productsearch');
		Route::get('/searchscore','ProductController@productsearchscore')->name('productsearchscore');
		Route::get('/checkexistbarcode','ProductController@checkexistbarcode')->name('checkexistbarcode');
		Route::get('/autocomplete','ProductController@autocomplete')->name('autocomplete');
		Route::get('/getsaveproduct','ProductController@getsavedproduct')->name('getsavedproduct');
		Route::get('/getproductbycategory','ProductController@getproductbycategory')->name('getproductbycategory');
		Route::get('/getproductallcategory','ProductController@getproductallcategory')->name('getproductallcategory');
		Route::get('/getproductbycategoryscore','ProductController@getproductbycategoryscore')->name('getproductbycategoryscore');
		Route::get('/getproductallcategoryscore','ProductController@getproductallcategoryscore')->name('getproductallcategoryscore');
		Route::get('/getbrandid','ProductController@getbrandid')->name('getbrandid');
		Route::get('/getlastbarcodelist','ProductController@getlastbarcodelist')->name('getlastbarcodelist');
		Route::get('/printproduct','ProductController@printproduct')->name('printproduct');
		
		Route::post('/productrestore','ProductController@productrestore')->name('productrestore');
		Route::post('/deletefrombin','ProductController@deletefrombin')->name('deletefrombin');
	});
	
	//route purchase
	Route::group(['prefix'=>'purchase'],function(){
		Route::get('/order','PurchaseController@index')->name('purchaseorder');
		Route::get('/invoice/search/barcode','PurchaseController@SearchItemBarcode')->name('Barcode.Search');
		Route::get('/invoice/search/product','PurchaseController@product_search')->name('product.search');
		Route::post('/invoice/supplier/add','PurchaseController@postsupplier')->name('postsupplier');
		Route::post('/invoice/delivery/add','PurchaseController@postdelivery')->name('postdelivery');
		Route::post('/invoice/save','PurchaseController@storepurchase')->name('storepurchase');
		Route::post('/invoice/update','PurchaseController@updatepurchase')->name('updatepurchase');
		Route::post('/invoice/delete','PurchaseController@destroypurchase')->name('destroypurchase');
		Route::get('/invoice/print/{id}','PurchaseController@purchaseprint')->name('purchaseprint');
		Route::get('/invoice/edit','PurchaseController@editpurchaseinv')->name('editpurchaseinv');
		Route::get('/invoicelist','PurchaseController@invoiceLists')->name('purchaseinvoice');
		Route::get('/invoicelist/search','PurchaseController@invoicelistsearch')->name('invoicelistsearch');
		Route::get('/invoicelist-edit/{id}','PurchaseController@invoicelistedit')->name('invoicelistedit');
		Route::post('/edititemaftersubmitin','PurchaseController@edititemaftersubmitin')->name('edititemaftersubmitin');
		Route::get('/pagination/fetch_data','PurchaseController@paginate_fetch_data');
		Route::get('/paid','PurchaseController@paid')->name('purchasepaid');
		Route::post('/savepaid','PurchaseController@savepaid')->name('savepurchasepayment');
		Route::get('/invoicelist/searchpaid','PurchaseController@invoicelistsearchpaid')->name('invoicelistsearchpaid');
		Route::get('/totalinvpaid','PurchaseController@totalinvpaid')->name('totalinvpaid');
		Route::get('/showpurchasedetail','PurchaseController@showpurchasedetail')->name('showpurchasedetail');
		Route::get('/showpaiddetail','PurchaseController@showpaiddetail')->name('showpaiddetail');
		Route::post('/delpaid','PurchaseController@delpaid')->name('delpaid');
		Route::get('/printallinv','PurchaseController@printallinv')->name('printallinv');
		Route::get('/accountpay','PurchaseController@accountpay')->name('accountpay');
		Route::get('/invoicelist/invoicelistsearchforpay','PurchaseController@invoicelistsearchforpay')->name('invoicelistsearchforpay');
		
	});

	//route sale
	Route::group(['prefix'=>'sale'],function(){
		Route::get('/getbuyinvtotal','SaleController@getbuyinvtotal')->name('getbuyinvtotal');
		Route::get('/getbuyinv','SaleController@getbuyinv')->name('getbuyinv');
		Route::get('/getcostfrombuyinv','SaleController@getcostfrombuyinv')->name('getcostfrombuyinv');
		Route::get('/order','SaleController@index')->name('saleout');
		Route::get('/invoice/search/barcode','SaleController@SearchItemBarcode')->name('sale.barcode.search');
		Route::get('/invoice/search/product','SaleController@product_search')->name('saleproductsearch');
		
		Route::post('/invoice/supplier/add','SaleController@postsupplier')->name('postsupplierinsale');
		Route::post('/invoice/delivery/add','SaleController@postdelivery')->name('postdeliveryinsale');
		Route::post('/invoice/save','SaleController@storesale')->name('storesale');
		Route::post('/invoice/update','SaleController@updatesale')->name('updatesale');
		Route::post('/invoice/delete','SaleController@destroysale')->name('destroysale');
		Route::get('/invoice/print/{id}','SaleController@saleprint')->name('saleprint');
		Route::get('/invoice/printall','SaleController@saleprintall')->name('saleprintall');
		Route::get('/invoice/edit','SaleController@editsaleinv')->name('editsaleinv');
		Route::get('/invoicelist','SaleController@invoiceLists')->name('saleinvoice');
		Route::get('/invoicelist/search','SaleController@invoicelistsearch')->name('invoicelistsearchinsale');
		Route::get('/invoicelist-edit/{id}','SaleController@invoicelistedit')->name('invoicelisteditinsale');
		Route::get('/pagination/fetch_data','SaleController@paginate_fetch_data');
		Route::post('/edititemaftersubmit','SaleController@edititemaftersubmit')->name('edititemaftersubmit');

		Route::get('/paid','SaleController@customerpaid')->name('salepaid');
		Route::get('/paiddelivery','SaleController@paid_delivery')->name('salepaid_delivery');
		Route::get('/paidlaw','SaleController@paid_law')->name('salepaid_law');
		
		Route::post('/savepaid','SaleController@savepaid')->name('savesalepayment');
		Route::get('/invoicelist/searchpaid','SaleController@invoicelistsearchpaid')->name('saleinvoicesearchpaid');
		Route::get('/invoicelist/invoicelistsearchfordebt','SaleController@invoicelistsearchfordebt')->name('invoicelistsearchfordebt');
		Route::get('/invoicelist/searchpaid-delivery','SaleController@invoicelistsearchpaidfordelivery')->name('invoicelistsearchpaidfordelivery');
		Route::get('/invoicelist/searchpaid-law','SaleController@invoicelistsearchpaidforlaw')->name('invoicelistsearchpaidforlaw');
		Route::get('/totalinvpaid','SaleController@totalinvpaid')->name('totalsaleinvoicepaid');
		Route::get('/invoicedetail','SaleController@showsaledetail')->name('showsaledetail');
		Route::get('/showpaiddetail','SaleController@showpaiddetail')->name('showsalepaiddetail');
		Route::post('/delpaid','SaleController@delpaid')->name('delsalepaid');
		Route::post('/invoice/co/add','SaleController@postco')->name('postco');
		Route::get('/closesaleinvoice','SaleController@closesaleinvoice')->name('closesaleinvoice');
		Route::get('/closesaleinvoicepayment','SaleController@closesaleinvoicepayment')->name('closesaleinvoicepayment');
		Route::get('/closesaleinvoicereport','SaleController@closesaleinvoicereport')->name('closesaleinvoicereport');
		Route::get('/searchcustomermodal','SaleController@searchcustomermodal')->name('searchcustomermodal');
		Route::get('/searchcustomer','SaleController@searchcustomer')->name('searchcustomer');
		Route::get('/searchcustomeroldlist','SaleController@searchcustomeroldlist')->name('searchcustomeroldlist');
		Route::get('/searchcustomercloselist','SaleController@searchcustomercloselist')->name('searchcustomercloselist');
		
		Route::get('/searchcategoryinsale','SaleController@searchcategory')->name('searchcategory');
		Route::get('/getsaleinvoice','SaleController@getsaleinvoice')->name('getsaleinvoice');
		Route::get('/getsaleinvoice1','SaleController@getsaleinvoice1')->name('getsaleinvoice1');
		Route::get('/getlastcloselist','SaleController@getlastcloselist')->name('getlastcloselist');
		Route::get('/getpaidlistdetail','SaleController@getpaidlistdetail')->name('getpaidlistdetail');
		Route::get('/getclosesaleinvoice','SaleController@getclosesaleinvoice')->name('getclosesaleinvoice');
		
		Route::post('/savesalecloselist','SaleController@savecloselist')->name('savecloselist');
		Route::post('/savesalecloselistpaid','SaleController@savecloselistpaid')->name('savecloselistpaid');
		Route::post('/deletepaidlist','SaleController@deletepaidlist')->name('deletepaidlist');
		Route::post('/deletecloselist','SaleController@deletecloselist')->name('deletecloselist');
		Route::get('/searchitemcode','SaleController@searchitemcode')->name('searchitemcode');
		Route::get('/accountreceive','SaleController@accountreceive')->name('accountreceive');
		Route::get('/readcustomerdebtname','SaleController@readcustomerdebtname')->name('readcustomerdebtname');
		Route::get('/getcusvalue','SaleController@getcusvalue')->name('getcusvalue');
		Route::get('/printallcustomerdebtinvoice','SaleController@printallcustomerdebtinvoice')->name('printallcustomerdebtinvoice');
		
	});
	Route::group(['prefix'=>'closelist'],function(){
		Route::get('/closelistreport','CloseListController@closereport')->name('closelists.showreport');
		Route::get('/showreportpay','CloseListController@showreportpay')->name('closelists.showreportpay');
		Route::get('/showreportpay1','CloseListController@showreportpay1')->name('closelists.showreportpay1');
	});
	//route stock
	Route::group(['prefix'=>'stock'],function(){
		Route::get('/info','StockController@index')->name('stockinfo');
		Route::get('/search/stock','StockController@search')->name('searchstock');
		Route::get('/search/mainstock','StockController@searchmain')->name('searchmainstock');
		Route::get('/mainstock/print','StockController@printmainstock')->name('printmainstock');
		Route::get('/search/mainstock2','StockController@searchmain2')->name('searchmainstock2');
		Route::get('/mainstock2/print','StockController@printmainstock2')->name('printmainstock2');
		Route::get('/history','StockController@stockhistory')->name('stockhistory');
		Route::get('/showstockproccess','StockController@showstockproccess')->name('showstockprocess');
		Route::post('/removestockprocess','StockController@removestockprocess')->name('removestockprocess');
		Route::post('/saveclosestock','StockController@saveclosestock')->name('saveclosestock');
	});

	Route::group(['prefix'=>'/cutstock'],function(){
		Route::get('/cutstock','CutStockController@cutstock')->name('cutstock');
		Route::get('/summaryitemsale','CutStockController@summaryitemsale')->name('summaryitemsale');
		Route::get('/submititemsale','CutStockController@submititemsale')->name('submititemsale');
		Route::POST('/delstockandsave','CutStockController@delstockandsave')->name('delstockandsave');
		Route::post('/submitbyitem','CutStockController@submitbyitem')->name('submitbyitem');
		Route::post('/delandsubmitbyitem','CutStockController@delandsubmitbyitem')->name('delandsubmitbyitem');
	});
	Route::group(['prefix'=>'addstock'],function(){
		Route::get('/index','AddStockController@addstock')->name('addstock');
		Route::get('/summaryitembuy','AddStockController@summaryitembuy')->name('summaryitembuy');
		Route::get('/submititembuy','AddStockController@submititembuy')->name('submititembuy');
		Route::POST('/delstockandsave','AddStockController@delstockandsave')->name('delstockandsave');
		Route::post('/submitbyitem','AddStockController@submitbyitem')->name('submitbyitembuy');
		Route::post('/delandsubmitbyitem','AddStockController@delandsubmitbyitem')->name('delandsubmitbyitembuy');
	});
	Route::group(['prefix'=>'exchange'],function(){
		Route::get('/index','ExchangeController@index')->name('exchangerate');
		Route::post('/saveexchange','ExchangeController@saveexchange')->name('save-exchange');

		Route::post('/saveexchange1','ExchangeController@saveexchange1')->name('save-exchange1');

	});
	Route::group(['prefix'=>'expanse'],function(){
		Route::get('/index','ExpanseController@index')->name('expanserecord');
		Route::post('/saveexpanse','ExpanseController@saveexpanse')->name('saveexpanse');
		Route::post('/updateexpanse','ExpanseController@updateexpanse')->name('updateexpanse');
		Route::post('/deleteexpanse','ExpanseController@deleteexpanse')->name('deleteexpanse');
		Route::get('/getexpanse','ExpanseController@getexpanse')->name('getexpanse');
		Route::get('/readexpanseid','ExpanseController@readexpanseid')->name('readexpanseid');
		Route::get('/report/print','ExpanseController@expansereportprint')->name('expansereportprint');
		
	});
	Route::group(['prefix'=>'/supplier'],function(){
		Route::get('/autosearchname/{type}','SupplierController@autocomplete_suppliername')->name('autocomplete_suppliername');
		
	});
	Route::group(['prefix'=>'report'],function(){
		Route::get('/sale/print','ReportController@reportsaleprint')->name('salereportprint');
		Route::get('/salereport','ReportController@salereport')->name('salereport');
		Route::get('/getitemsale','ReportController@getitemsale')->name('getitemsale');
		Route::get('/exportsalereport','ReportController@exportsalereport')->name('exportsalereport');
		Route::get('/export_excel/excel', 'ReportController@excel')->name('export_excel.excel');
		Route::get('/getitemsaleforelephan','ReportController@getitemsaleforeq')->name('getitemsaleforeq');
		Route::get('/getitemsalebycustomer','ReportController@getitemsalebycustomer')->name('getitemsalebycustomer');
		Route::get('/getitemsalebyitem','ReportController@getitemsalebyitem')->name('getitemsalebyitem');
		Route::get('/salereport/showdetail/{pid}/{invdate}/{supid}','ReportController@salereportshowdetail')->name('salereport.showdetail');
		
		Route::get('/buyreport','ReportController@buyreport')->name('buyreport');
		Route::get('/getitembuy','ReportController@getitembuy')->name('getitembuy');
		Route::get('/getitembuyforelephan','ReportController@getitembuyforeq')->name('getitembuyforeq');
		Route::get('/getitembuybycustomer','ReportController@getitembuybycustomer')->name('getitembuybycustomer');
		Route::get('/getitembuybyitem','ReportController@getitembuybyitem')->name('getitembuybyitem');
		Route::get('/buyreport/showdetail/{pid}/{invdate}/{supid}','ReportController@buyreportshowdetail')->name('buyreport.showdetail');
		Route::get('/autoprinttest','ReportController@autoprinttest')->name('autoprinttest');

		Route::get('/scorereport','ReportController@scorereport')->name('scorereport');
		Route::get('/getitemsalescore','ReportController@getitemsalescore')->name('getitemsalescore');
	});
	Route::group(['prefix'=>'category'],function(){
		Route::get('/categoryset','CategoryController@categoryset')->name('categoryset');
		Route::post('/savecategory','CategoryController@savecategory')->name('savecategory');
		Route::post('/updatecategory','CategoryController@updatecategory')->name('updatecategory');
		Route::post('/savebrand','CategoryController@savebrand')->name('savebrand');
		Route::post('/updatebrand','CategoryController@updatebrand')->name('updatebrand');
		Route::post('/delcategory','CategoryController@delcategory')->name('delcategory');
		Route::post('/delbrand','CategoryController@delbrand')->name('delbrand');
		Route::get('/getcategory','CategoryController@getcategory')->name('getcategory');
		Route::get('/getbrand','CategoryController@getbrand')->name('getbrand');
		Route::get('/categorysearch','CategoryController@categorysearch')->name('categorysearch');
		Route::get('/brandsearch','CategoryController@brandsearch')->name('brandsearch');
		Route::get('/autocomplete_category','CategoryController@autocomplete_category')->name('autocomplete_category');
		Route::get('/autocomplete_brand','CategoryController@autocomplete_brand')->name('autocomplete_brand');
		Route::post('/saveunit','CategoryController@saveunit')->name('saveunit');
		Route::post('/updateunit','CategoryController@updateunit')->name('updateunit');
		Route::post('/deleteunit','CategoryController@deleteunit')->name('deleteunit');
		Route::get('/getunit','CategoryController@getunit')->name('getunit');
		
	});
	Route::group(['prefix'=>'user'],function(){
		Route::post('/storeuser','LoginController@store')->name('saveuser');
		Route::post('/updateuser','LoginController@update')->name('updateuser');
		Route::post('/deleteuser','LoginController@destroy')->name('deleteuser');
		Route::get('/refreshuser', 'LoginController@refreshuser')->name('refreshuser');
		Route::get('/change-password', 'LoginController@indexpwd')->name('changepwd');
		Route::post('/change-password', 'LoginController@storepwd')->name('change.password');
		Route::post('/reset-password', 'LoginController@resetpassword')->name('resetpwd');
	});
	Route::group(['prefix'=>'register'],function(){
		Route::get('/company', 'SupplierController@companyregister')->name('company.register');
		Route::post('/company-save', 'SupplierController@savecompany')->name('company.store');
		Route::post('/company-update', 'SupplierController@updatecompany')->name('company.update');
		Route::post('/company-destroy', 'SupplierController@destroycompany')->name('company.destroy');
		
		Route::get('/company-readdata', 'SupplierController@companydata')->name('company.readdata');
		Route::get('/company-getinfobyid', 'SupplierController@getcompanyinfobyid')->name('company.getinfobyid');
		Route::get('/supplier/{status}', 'SupplierController@supplierregister')->name('supplier.register');
		Route::post('/supplier-save', 'SupplierController@savesupplier')->name('supplier.save');
		Route::post('/supplier-update', 'SupplierController@updatesupplier')->name('supplier.update');
		Route::post('/supplier-destroy', 'SupplierController@deletesupplier')->name('supplier.delete');
		Route::post('/supplier-restore', 'SupplierController@restoresupplier')->name('supplier.restore');
		Route::get('/supplier-readdata', 'SupplierController@supplierdata')->name('supplier.readdata');
		Route::get('/supplier-search', 'SupplierController@suppliersearch')->name('supplier.search');
		Route::get('/autocomplete-supplier','SupplierController@autocomplete')->name('autocomplete.supplier');
		Route::get('/autocomplete-customercode','SupplierController@autocompletecustomercode')->name('autocomplete.customercode');
	});
	Route::group(['prefix'=>'delivery'],function(){
		Route::get('/delivery', 'DeliveryController@deliveryregister')->name('delivery.register');
		Route::post('/savedelivery','DeliveryController@savedelivery')->name('savedelivery');
		Route::post('/updatedelivery','DeliveryController@updatedelivery')->name('updatedelivery');
		Route::post('/deldelivery','DeliveryController@deldelivery')->name('deldelivery');
		Route::post('/restoredelivery','DeliveryController@restoredelivery')->name('restoredelivery');
		Route::get('/getdelivery','DeliveryController@getdelivery')->name('getdelivery');
		
		Route::post('/saveco','DeliveryController@saveco')->name('saveco');
		Route::post('/updateco','DeliveryController@updateco')->name('updateco');
		Route::post('/delco','DeliveryController@delco')->name('delco');
		Route::post('/restoreco','DeliveryController@restoreco')->name('restoreco');
		Route::get('/getco','DeliveryController@getco')->name('getco');
	});

});
