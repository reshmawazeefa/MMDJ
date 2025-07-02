<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\QuotationController;
use App\Http\Controllers\Admin\QuotationListController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CategoryAttributeController;
use App\Http\Controllers\CronController;
use App\Http\Controllers\Admin\PDFController;
use App\Http\Controllers\Admin\CustomQuotationController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Admin\SalesOrderListController;
use App\Http\Controllers\Admin\SalesOrderController;
use App\Http\Controllers\Admin\SalesInvoiceListController;
use App\Http\Controllers\Admin\SalesInvoiceController;
use App\Http\Controllers\Admin\SalesReturnListController;
use App\Http\Controllers\Admin\SalesReturnController;
use App\Http\Controllers\Admin\GoodsReceiptPOListController;
use App\Http\Controllers\Admin\GoodsReceiptPOController;
use App\Http\Controllers\Admin\GoodsReturnListController;
use App\Http\Controllers\Admin\GoodsReturnController;
use App\Http\Controllers\Admin\PurchaseInvoiceListController;
use App\Http\Controllers\Admin\PurchaseInvoiceController;
use App\Http\Controllers\Admin\PurchaseReturnListController;
use App\Http\Controllers\Admin\PurchaseReturnController;
use App\Http\Controllers\Admin\StockInController;
use App\Http\Controllers\Admin\StockOutController;
use App\Http\Controllers\Admin\StockTransferController;
use App\Http\Controllers\Admin\BankingPaymentController;
use App\Http\Controllers\Admin\OutgoingPaymentController;
use App\Http\Controllers\Admin\DayclosingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\CompanyinfoController;

Route::group(['prefix' => 'admin'], function () {    

    Route::get('cache', function() {
        $status = Artisan::call('optimize:clear');
        return '<h1>Cache cleared</h1>';
    });
    Route::group(['middleware' => ['auth', 'permission:role-list']], function () {
        Route::resource('roles', RoleController::class);
    });
    Route::group(['middleware' => ['auth']], function () {
        Route::post('code',[CustomerController::class, 'generateBarcodeNumber']);
        Route::resource('customers', CustomerController::class);
        Route::post('customer/status', [CustomerController::class, 'status']);
        Route::post('customers/close/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');

        Route::resource('warehouses', WarehouseController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('cat_attributes', CategoryAttributeController::class);
        Route::resource('partners', PartnerController::class);
        Route::get('change/password', [SettingsController::class, 'change_password']);
        Route::post('change/password', [SettingsController::class, 'update_password']);
        Route::get('custom_quote', [CustomQuotationController::class, 'create']);
        Route::post('custom_quotation/insert', [CustomQuotationController::class, 'insert']);
        Route::get('custom_quotations', [CustomQuotationController::class, 'index']);
        Route::get('custom_quotations/{id}', [CustomQuotationController::class, 'show']);
        Route::get('custom_quotations/{id}/edit', [CustomQuotationController::class, 'edit']);
        Route::post('custom_quotations/{id}/update', [CustomQuotationController::class, 'update']);
        Route::post('custom_quotations/close/{id}', [CustomQuotationController::class, 'close']);
        Route::any('custom_quotations/approve/{id}', [CustomQuotationController::class, 'approve']);
        Route::any('custom_quotations/confirm/{id}', [CustomQuotationController::class, 'confirm']);
        Route::get('custom_quotations/{id}/sendapproval', [CustomQuotationController::class, 'send_for_approval']);
        Route::get('custom_approvals/{status}', [CustomQuotationController::class, 'approval_list']);
        Route::get('quote', [QuotationController::class, 'create']);
        Route::post('quotation/insert', [QuotationController::class, 'insert']);
        Route::get('quotations', [QuotationListController::class, 'index']);
        Route::get('approvals/{status}', [QuotationListController::class, 'approval_list']);
        Route::get('approval/list', [QuotationListController::class, 'approval_list']);
        Route::post('quotations/close/{id}', [QuotationListController::class, 'close']);
        Route::any('quotations/approve/{id}', [QuotationListController::class, 'approve']);
        Route::any('quotations/confirm/{id}', [QuotationListController::class, 'confirm']);
        Route::get('quotations/{id}', [QuotationListController::class, 'show']);
        Route::get('quotations/{id}/edit', [QuotationController::class, 'edit']);
        Route::post('quotations/{id}/update', [QuotationController::class, 'update']);
        Route::post('ajax/customers', [QuotationController::class, 'get_customers']);
        Route::post('ajax/branches', [QuotationController::class, 'get_branches']);
        Route::post('ajax/partners', [QuotationController::class, 'get_partners_all']);
        Route::post('ajax/users', [QuotationController::class, 'get_users']);
        Route::post('ajax/partners/{type}', [QuotationController::class, 'get_partners']);
        Route::post('ajax/products', [QuotationController::class, 'get_products']);
        Route::post('ajax/product_stock', [QuotationController::class, 'get_product_stock']);
        Route::post('ajax/stock', [QuotationController::class, 'get_warehouses']);
        Route::resource('users', UserController::class);
        // Route::post('users/close/{id}', [CustomerController::class, 'destroy'])->name('users.destroy');

        Route::post('ajax/userslist', [UserController::class, 'get_users']);
        Route::get('products', [ProductController::class,'index'])->name('products.index');
        Route::post('products', [ProductController::class,'index'])->name('products.index');
        Route::get('products/{id}', [ProductController::class,'show']);
        Route::post('products/status', [ProductController::class, 'status']);

        Route::get('product/product_details', [ProductController::class, 'get_product_details']);
        Route::get('pcreate', [ProductController::class, 'create']);
        Route::post('products/insert', [ProductController::class, 'insert']);
        Route::get('products/{id}/edit', [ProductController::class,'edit']);
        Route::post('products/{id}/update', [ProductController::class, 'update']);
        Route::delete('products/close/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

        Route::post('ajax/whscode', [ProductController::class, 'get_warehouses']);
        Route::post('product/image', [ProductController::class,'upload_product_image']);
        Route::post('ajax/categories', [ProductController::class, 'get_categories']);
        Route::post('ajax/subcategories', [ProductController::class, 'get_subcategories']);
        Route::post('ajax/types', [ProductController::class, 'get_types']);
        Route::post('ajax/brands', [ProductController::class, 'get_brands']);
        Route::post('ajax/sizes', [ProductController::class, 'get_sizes']);
        Route::post('ajax/colors', [ProductController::class, 'get_colors']);
        Route::post('ajax/finish', [ProductController::class, 'get_finish']);
        Route::get('pdf/{id}', [PDFController::class, 'pdfview']);
        Route::get('purchaseinvoicepdf/{id}', [PDFController::class, 'purchaseinvoicepdfview']);
        Route::get('invoicepdf/{id}', [PDFController::class, 'invoicepdfview']);
        Route::get('orderpdf/{id}', [PDFController::class, 'orderpdfview']);
        Route::get('incomingpdf/{id}', [PDFController::class, 'incomingpdfview']);
        Route::get('custom_pdf/{id}', [PDFController::class, 'custom_pdfview']);
        Route::get('quotations/{id}/sendapproval', [QuotationListController::class, 'send_for_approval']);
        Route::post('quotations/excel', [QuotationListController::class, 'download_excel']);

        //For Sales order  
        Route::get('sales-order', [SalesOrderListController::class, 'index']);
        Route::get('salesorder', [SalesOrderController::class, 'create']);
        Route::post('salesorder/insert', [SalesOrderController::class, 'insert'])->name('admin.salesorder.insert');
        Route::post('ajax/salesorder_close_items', [SalesOrderController::class, 'salesorder_close_items']);

        Route::get('ajax/customer_details', [SalesOrderController::class, 'get_customer_details']);
        Route::get('ajax/customer_open_quotations', [SalesOrderController::class, 'get_customer_open_quotations']);
        Route::get('ajax/quotation_details', [SalesOrderController::class, 'get_quotation_details'])->name('admin.ajax.quotation_details');
        
        Route::get('sales-order/{id}', [SalesOrderListController::class, 'show']);
        Route::get('sales-order/{id}/edit', [SalesOrderController::class, 'edit']);
        Route::post('sales-order/{id}/update', [SalesOrderController::class, 'update']);
        Route::post('sales-order/excel', [SalesOrderListController::class, 'download_excel']);
        Route::post('sales-order/close/{id}', [SalesOrderListController::class, 'close']);
        Route::post('ajax/sodocSelect', [SalesOrderListController::class, 'get_sodoc']);




        //for Sale Invoice
        Route::get('sales-invoice', [SalesInvoiceListController::class, 'index']);
        Route::get('salesinvoice', [SalesInvoiceListController::class, 'create']);
        Route::post('ajax/salesorder-customers', [SalesInvoiceListController::class, 'get_customers']);
        Route::post('ajax/salesinvoice_close_items', [SalesInvoiceController::class, 'salesinvoice_close_items']);
        Route::get('salesinvoice/ajax/customer_details', [SalesInvoiceController::class, 'get_customer_details']);
        Route::get('salesinvoice', [SalesInvoiceController::class, 'create']);
        Route::get('salesinvoice/ajax/customer_open_salesorders', [SalesInvoiceController::class, 'get_customer_open_salesorders']);
        Route::post('salesinvoice/insert', [SalesInvoiceController::class, 'insert']);
        Route::get('sales-invoice/{id}/edit', [SalesInvoiceController::class, 'edit']);
        Route::post('sales-invoice/{id}/update', [SalesInvoiceController::class, 'update']);
         Route::post('ajax/invdocSelect', [SalesInvoiceController::class, 'get_invdoc']);

        // Route::put('admin/sales-invoice/{id}/update', [SalesInvoiceController::class, 'update']);

        Route::get('ajax/salesorder_details', [SalesInvoiceController::class, 'get_salesorder_details'])->name('admin.ajax.salesorder_details');
        Route::get('/api/salesinvoice/your-endpoint', [SalesInvoiceController::class, 'get_salesinvoice_details'])->name('admin.ajax.salesinvoice_details');
        // created in 27-10-2024
        Route::get('sales-invoice/{id}', [SalesInvoiceListController::class, 'show']);
        Route::post('sales-invoice/close/{id}', [SalesInvoiceListController::class, 'close']);
        Route::post('sales-invoice/excel', [SalesInvoiceListController::class, 'download_excel']);
        Route::get('invoice/share/{id}', [PDFController::class, 'downloadAndSharePdf'])->name('invoice.share');



        // Route::get('sales-invoice/{id}/edit', [SalesInvoiceController::class, 'edit']);
        // Route::post('sales-invoice/{id}/update', [SalesInvoiceController::class, 'update']);





        //for Sales Return
        Route::get('sales-return', [SalesReturnController::class, 'index']);
        Route::get('salesreturn', [SalesReturnController::class, 'create']);
        Route::post('ajax/salesinvoice-customers', [SalesReturnController::class, 'get_customers']);
        Route::get('salesreturn/ajax/customer_details', [SalesReturnController::class, 'get_customer_details']);
        Route::get('salesreturn/ajax/customer_open_invoice', [SalesReturnController::class, 'get_customer_open_invoice']);
        Route::post('salesreturn/ajax/salesreturn_close_items', [SalesReturnController::class, 'salesreturn_close_items']);
        Route::post('salesreturn/insert', [SalesReturnController::class, 'insert']);
        Route::get('ajax/invoice_details', [SalesReturnController::class, 'get_invoice_details'])->name('admin.ajax.invoice_details');
        Route::get('sales-return/{id}', [SalesReturnController::class, 'show']);
        Route::get('sales-return/{id}/edit', [SalesReturnController::class, 'edit']);
        Route::post('sales-return/{id}/update', [SalesReturnController::class, 'update']);
        Route::post('sales-return/close/{id}', [SalesReturnController::class, 'close']);
        Route::post('sales-return/excel', [SalesReturnController::class, 'download_excel']);


        //for Stock In
        Route::get('stock-in', [StockInController::class, 'index']);
        Route::get('stockin', [StockInController::class, 'create']);
        Route::get('stockin/ajax/stockout_details', [StockInController::class, 'get_stock_details']);
        Route::get('stockin/ajax/branch_open_stock_details', [StockInController::class, 'get_branch_open_stock']);
        Route::get('ajax/stockin_details', [StockInController::class, 'get_stockout_details'])->name('admin.ajax.stockin_details');
        Route::post('ajax/stockout_close_items', [StockInController::class, 'stockout_close_items']);
        Route::post('stockin/insert', [StockInController::class, 'insert']);
        Route::get('stockin/{id}', [StockInController::class, 'show']);
        Route::post('stockin/excel', [StockInController::class, 'download_excel']);
        Route::post('stockin/close/{id}', [StockInController::class, 'close']);
        Route::get('stockin/{id}/edit', [StockInController::class, 'edit']);
        Route::post('stockin/{id}/update', [StockInController::class, 'update']);
        Route::get('stock-in/get_bproduct_details', [StockInController::class, 'get_bproduct_details']);
        Route::post('stock-in/barcode_vefication_data', [StockInController::class, 'barcode_vefication_data']);


        







        //for Stock Out
        Route::get('stock-out', [StockOutController::class, 'index']);
        Route::get('stockout', [StockOutController::class, 'create']);
        Route::get('stockout/ajax/stock_details', [StockOutController::class, 'get_stock_details']);
        Route::get('stockout/ajax/branch_open_stock_details', [StockOutController::class, 'get_branch_open_stock']);
        Route::get('ajax/stockout_details', [StockOutController::class, 'get_stocktransfer_details'])->name('admin.ajax.stockout_details');
        Route::post('ajax/stocktransfer_close_items', [StockOutController::class, 'stocktransfer_close_items']);
        Route::post('stockout/insert', [StockOutController::class, 'insert']);
        Route::get('stockout/{id}', [StockOutController::class, 'show']);
        Route::post('stockout/excel', [StockOutController::class, 'download_excel']);
        Route::post('stockout/close/{id}', [StockOutController::class, 'close']);
        Route::get('stockout/{id}/edit', [StockOutController::class, 'edit']);
        Route::post('stockout/{id}/update', [StockOutController::class, 'update']);
        Route::post('stockout/branch_product_stock', [StockOutController::class, 'get_branch_product_stock']);
        Route::get('stock-out/get_bproduct_details', [StockOutController::class, 'get_bproduct_details']);






        //for Stock Transfer Request
        Route::get('stock-transfer-request', [StockTransferController::class, 'index']);
        Route::get('stocktransfer', [StockTransferController::class, 'create']);
        Route::post('stocktransfer/insert', [StockTransferController::class, 'insert']);
        Route::get('stocktransfer/{id}', [StockTransferController::class, 'show']);
        Route::post('stocktransfer/branch', [StockTransferController::class, 'get_branches']);
        Route::post('stocktransfer/excel', [StockTransferController::class, 'download_excel']);
        Route::get('stocktransfer/{id}/edit', [StockTransferController::class, 'edit']);
        Route::post('stocktransfer/{id}/update', [StockTransferController::class, 'update']);
        Route::post('stocktransfer/close/{id}', [StockTransferController::class, 'close']);



        Route::post('ajax/supplier', [CustomerController::class, 'get_supplier']);
        Route::post('ajax/posupplier', [CustomerController::class, 'get_posupplier']);
        Route::post('ajax/exsupplier', [CustomerController::class, 'get_exsupplier']);

        //for Goods Receipt PO
        Route::get('goods-receipt', [GoodsReceiptPOController::class, 'index']);
        Route::get('goods_receipt_po', [GoodsReceiptPOController::class, 'create']);
        Route::post('goods-receipt-po/insert', [GoodsReceiptPOController::class, 'insert']);
        Route::get('purchase-order/{id}', [GoodsReceiptPOController::class, 'show']);
        Route::post('purchase-order/excel', [GoodsReceiptPOController::class, 'download_excel']);
        Route::get('purchase-order/{id}/edit', [GoodsReceiptPOController::class, 'edit']);
        Route::post('purchase-order/{id}/update', [GoodsReceiptPOController::class, 'update']);
        Route::post('purchase-order/close/{id}', [GoodsReceiptPOController::class, 'close']);

        //for other expense
                Route::get('goods-expense', [GoodsReceiptPOController::class, 'expenseindex']);
                Route::get('goods_receipt_oe', [GoodsReceiptPOController::class, 'oecreate']);




        //for Goods Return
        Route::get('goods-return', [GoodsReturnController::class, 'index']);
        Route::get('goods_return', [GoodsReturnController::class, 'create']);
        Route::post('ajax/po_supplier', [GoodsReturnController::class, 'get_supplier']);
        Route::get('goods_return/ajax/customer_details', [GoodsReturnController::class, 'get_customer_details']);
        Route::get('ajax/customer_open_grpo', [GoodsReturnController::class, 'get_customer_open_grpo']);
        Route::get('goods_return/ajax/grpo_details', [GoodsReturnController::class, 'get_grpo_details'])->name('admin.goods_return.ajax.grpo_details');
        Route::get('goods_return/ajax/edit_grpo_details', [GoodsReturnController::class, 'get_edit_grpo_details'])->name('admin.goods_return.ajax.edit_grpo_details');
        Route::post('goods_return/ajax/purchaseorder_close_items', [GoodsReturnController::class, 'purchaseorder_close_items']);
        Route::get('goods_return/ajax/edit_customer_details', [GoodsReturnController::class, 'get_edit_customer_details']);
        Route::get('ajax/edit_customer_open_grpo', [GoodsReturnController::class, 'get_edit_customer_open_grpo']);
        Route::post('goods-return/insert', [GoodsReturnController::class, 'insert']);
        Route::get('goods-return/{id}', [GoodsReturnController::class, 'show']);
        Route::post('goods-return/excel', [GoodsReturnController::class, 'download_excel']);
        Route::get('goods-return/{id}/edit', [GoodsReturnController::class, 'edit']);
        Route::post('goods-return/{id}/update', [GoodsReturnController::class, 'update']);
        Route::post('goods-return/close/{id}', [GoodsReturnController::class, 'close']);



        //for Purchase Invoice
        Route::get('purchase-invoice', [PurchaseInvoiceController::class, 'index']);
        Route::get('purchase_invoice', [PurchaseInvoiceController::class, 'create']);
        Route::post('purchase_invoice/insert', [PurchaseInvoiceController::class, 'insert']);
        Route::post('purchase_invoice/excel', [PurchaseInvoiceController::class, 'download_excel']);
        Route::get('purchase_invoice/{id}', [PurchaseInvoiceController::class, 'show']);
        Route::post('purchase-invoice/insert', [PurchaseInvoiceController::class, 'insert']);

        //for Purchase Return
        Route::get('purchase-return', [PurchaseReturnController::class, 'index']);
        Route::get('purchase_return', [PurchaseReturnController::class, 'create']);
        Route::post('ajax/pin_supplier', [PurchaseReturnController::class, 'get_supplier']);
        Route::post('purchase-return/insert', [PurchaseReturnController::class, 'insert']);
        Route::post('purchase-return/excel', [PurchaseReturnController::class, 'download_excel']);
        Route::get('purchase-return/{id}', [PurchaseReturnController::class, 'show']);
        Route::get('purchase-return/ajax/customer_details', [PurchaseReturnController::class, 'get_customer_details']);
        Route::get('ajax/customer_open_purchase_invoice', [PurchaseReturnController::class, 'get_customer_open_purchase_invoice']);
        Route::get('purchase_return/ajax/get_purchase_invoice_details', [PurchaseReturnController::class, 'get_purchase_invoice_details'])->name('admin.purchase_return.ajax.get_purchase_invoice_details');
        Route::get('purchase-return/{id}/edit', [PurchaseReturnController::class, 'edit']);
        Route::post('purchase-return/{id}/update', [PurchaseReturnController::class, 'update']);
        Route::get('purchasereturnpdf/{id}', [PDFController::class, 'purchasereturnpdfview']);



        //for Incoming payment
        Route::get('incoming-payment/get_account_code', [BankingPaymentController::class, 'incoming_get_account_code']);
        Route::get('incoming-payment', [BankingPaymentController::class, 'index']);
        Route::get('incoming-payment-create', [BankingPaymentController::class, 'create']);
        Route::post('incoming-payment/insert', [BankingPaymentController::class, 'insert']);
        Route::post('ajax/incoming-customers', [BankingPaymentController::class, 'get_customers']);
        Route::post('ajax/list-incoming-customers', [BankingPaymentController::class, 'list_customers']);
        Route::get('incoming/ajax/customer_details', [BankingPaymentController::class, 'get_customer_details']);
        Route::post('ajax/accountlist', [BankingPaymentController::class, 'get_accounts']);
        Route::post('incoming-payment/insert', [BankingPaymentController::class, 'insert']);
        Route::get('incoming-payment/{id}', [BankingPaymentController::class, 'show']);
        Route::post('/validate-code-coupon', [BankingPaymentController::class, 'validateCode_coupon'])->name('validate_coupon.code');
        Route::post('/validate-code-voucher', [BankingPaymentController::class, 'validateCode_voucher'])->name('validate_voucher.code');
        Route::post('incomingpayment/excel', [BankingPaymentController::class, 'download_excel']);

        //for reports section
        Route::get('salesregister', [ReportsController::class, 'index']);
        Route::get('salesreturnregister', [ReportsController::class, 'salesreturnregister']);
        Route::get('saleorderreport', [ReportsController::class, 'saleorderreport']);
        Route::get('/saleorder-report/view/{item}', [ReportsController::class, 'saleorderdetailreport'])->name('sales_detail_report.view');
        Route::get('invoicereport', [ReportsController::class, 'index']);
        Route::get('balancereport', [ReportsController::class, 'balancereport']);
        Route::get('/balance-report/view/{doc_num}', [ReportsController::class, 'invoicereport'])->name('balance_report.view');
        Route::get('stockregister', [ReportsController::class, 'stockregister']);
        Route::post('ajax/allproducts', [ReportsController::class, 'get_all_products']);
        Route::get('item_history', [ReportsController::class, 'item_history']);
        Route::get('cashbook', [ReportsController::class, 'cashbook']);


        
        


        //for Outgoing Payment

        Route::get('outgoing-payment/get_account_code', [OutgoingPaymentController::class, 'outgoing_get_account_code']);
        Route::get('outgoing-payment', [OutgoingPaymentController::class, 'index']);
        Route::get('outgoing-payment-create', [OutgoingPaymentController::class, 'create']);
        Route::post('outgoing-payment/insert', [OutgoingPaymentController::class, 'insert']);
        Route::post('ajax/outgoing-customers', [OutgoingPaymentController::class, 'get_customers']);
        Route::post('ajax/list-outgoing-customers', [OutgoingPaymentController::class, 'list_customers']);
        Route::post('ajax/outgoing-cus', [OutgoingPaymentController::class, 'get_cus']);
        Route::get('outgoing/ajax/customer_details', [OutgoingPaymentController::class, 'get_customer_details']);
        Route::get('outgoing/ajax/cust_details', [OutgoingPaymentController::class, 'get_cus_details']);
        Route::post('ajax/accountlist', [OutgoingPaymentController::class, 'get_accounts']);
        Route::post('ajax/accountlist_payment', [OutgoingPaymentController::class, 'get_accounts_payment']);
        Route::post('outgoing-payment/insert', [OutgoingPaymentController::class, 'insert']);
        Route::get('outgoing-payment/{id}', [OutgoingPaymentController::class, 'show']);
        Route::post('/validate-code-coupon', [OutgoingPaymentController::class, 'validateCode_coupon'])->name('validate_coupon.code');
        Route::post('/validate-code-voucher', [OutgoingPaymentController::class, 'validateCode_voucher'])->name('validate_voucher.code');
        Route::post('outgoingpayment/excel', [OutgoingPaymentController::class, 'download_excel']);


        //for Day End Closing

        Route::get('dayend-closing', [DayclosingController::class, 'index']);
        Route::get('dayend-closing-create', [DayclosingController::class, 'create']);
        Route::post('dayend-closing/insert', [DayclosingController::class, 'insert']);
        Route::get('dayend-closing/{id}', [DayclosingController::class, 'show']);
        Route::post('dayend-closing/excel', [DayclosingController::class, 'download_excel']);

        Route::get('/company', [CompanyinfoController::class, 'index'])->name('company.index');
        Route::post('/company', [CompanyinfoController::class, 'store'])->name('company.store');













    });
});
Route::get('admin/barcode', function () {
    return view('admin.barcode');
});
Route::get('cron/category', [CronController::class,'category']);
Route::get('cron/categoryAttribute', [CronController::class,'categoryAttribute']);
Route::get('cron/product', [CronController::class,'product']);
Route::get('cron/warehouse', [CronController::class,'warehouse']);
Route::get('cron/prodPrice', [CronController::class,'prodPrice']);
Route::get('cron/prodStock', [CronController::class,'prodStock']);
Route::get('test/quote', [TestController::class,'create']);
Route::get('test/{id}/edit', [TestController::class,'edit']);
Route::get('test/print/{id}', [TestController::class,'print']);
Route::get('admin/{any}', function () {
    return view('errors.404');
});

Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    Artisan::call('config:cache');    
    Artisan::call('view:clear');
    return "Cache is cleared";
});
Route::get('graphs-pdf', [PDFController::class, 'graphPdf']);




