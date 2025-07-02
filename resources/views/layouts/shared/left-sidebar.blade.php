<!-- ========== Left Sidebar Start ========== -->

<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!-- User box -->
        <div class="user-box text-center">
            <img src="{{asset('assets/images/users/user-9.jpg')}}" alt="user-img" title="Mat Helme" class="rounded-circle avatar-md">
            <div class="dropdown">
                <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block" data-bs-toggle="dropdown">James Kennedy</a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user me-1"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings me-1"></i>
                        <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock me-1"></i>
                        <span>Lock Screen</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out me-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>
            <p class="text-muted">Admin Head</p>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li class="menu-title">Navigation</li>

                <li>
                    <a href="{{route('any', 'index')}}">
                        <i data-feather="airplay"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li>
                    <a href="{{url('admin/customers')}}">
                        <i data-feather="users"></i>
                        <span> Customers | Suppliers</span>
                    </a>
                </li>

                <!-- <li>
                    <a href="{{url('admin/partners')}}">
                    <i data-feather="clipboard"></i>
                        <span> Partners </span>
                    </a>
                </li> -->
            @if(auth()->user()->role == 'Admin')
                <li>
                    <a href="{{url('admin/products')}}">
                        <i data-feather="box"></i>
                        <span> Products </span>
                    </a>
                </li>
                @can('manage-user')
                <li>
                    <a href="{{url('admin/users')}}">
                        <i data-feather="users"></i>
                        <span> Users </span>
                    </a>
                </li>
                @endcan
                @endif
                <!-- <li>
                    <a href="{{url('admin/categories')}}">
                        <i data-feather="calendar"></i>
                        <span> Categories </span>
                    </a>
                </li>

                <li>
                    <a href="{{url('admin/cat_attributes')}}">
                        <i data-feather="message-square"></i>
                        <span> Category Attributes </span>
                    </a>
                </li> 

                <li>
                    <a href="{{url('admin/quotations')}}">
                        <i data-feather="activity"></i>
                        <span> Quotations </span>
                    </a>
                </li>
                <li>
                    <a href="#sidebarBaseui" data-bs-toggle="collapse">
                        <i data-feather="pocket"></i>
                        <span> Approval List </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarBaseui">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{url('admin/approvals/open')}}">Open</a>
                            </li>
                            <li>
                                <a href="{{url('admin/approvals/approve')}}">Approved</a>
                            </li>
                        </ul>
                    </div>
                </li>-->

                <li>
                    <a href="#sidebarBaseuiforpurchase" data-bs-toggle="collapse">
                        <i data-feather="pocket"></i>
                        <span> Purchase </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarBaseuiforpurchase">
                        <ul class="nav-second-level">
                            <li>
                            <a href="{{url('admin/goods-receipt')}}">Purchase Order</a>
                            </li>
                            <li>
                            <a href="{{url('admin/goods-expense')}}">Other Expense</a>
                            </li>
                            <!-- <li>
                            <a href="{{url('admin/goods-return')}}">Goods Return</a>
                            </li>-->
                            <li>
                            <a href="{{url('admin/purchase-invoice')}}">Purchase Invoice</a>
                            </li>
                            <li>
                            <a href="{{url('admin/purchase-return')}}">Purchase Return</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#sidebarBaseuiforsales" data-bs-toggle="collapse">
                        <i data-feather="tag"></i>
                        <span> Sales </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarBaseuiforsales">
                        <ul class="nav-second-level">
                            <li>
                            <a href="{{url('admin/sales-order')}}">Sales Order</a>
                            </li>
                            <li>
                            <a href="{{url('admin/sales-invoice')}}">Sales Invoice</a>
                            </li>
                            <!-- <li>
                            <a href="{{url('admin/sales-return')}}">Sales Return</a>
                            </li> -->
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#sidebarBaseuiforbanking" data-bs-toggle="collapse">
                        <i data-feather="credit-card"></i>
                        <span> Banking </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarBaseuiforbanking">
                        <ul class="nav-second-level">
                            <li>
                            <a href="{{url('admin/incoming-payment')}}">Incoming Payment</a>
                            </li>
                             <li>
                            <a href="{{url('admin/outgoing-payment')}}">Outgoing Payment</a>
                            </li>
                           <!-- <li>
                            <a href="{{url('admin/dayend-closing')}}">Day End Closing</a>
                            </li> -->
                        </ul>
                    </div>
                </li>
                <!-- <li>
                    <a href="#sidebarBaseuiforinventory" data-bs-toggle="collapse">
                        <i data-feather="pocket"></i>
                        <span> Inventory </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarBaseuiforinventory">
                        <ul class="nav-second-level">
                            <li>
                            <a href="{{url('admin/stock-in')}}">Stock In</a>
                            </li>
                            <li>
                            <a href="{{url('admin/stock-out')}}">Stock Out</a>
                            </li>
                            <li>
                            <a href="{{url('admin/stock-transfer-request')}}">Stock Transfer Request</a>
                            </li>
                        </ul>
                    </div>
                </li> -->

                

                @if(auth()->user()->role == 'Admin')

                <li>
                    <a href="#sidebarBaseuiforreports" data-bs-toggle="collapse">
                        <i data-feather="file-text"></i>
                        <span> Reports </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarBaseuiforreports">
                        <ul class="nav-second-level">
                        <li>
                            <a href="{{url('admin/saleorderreport')}}">Sale Order Item Report</a>
                            </li>
                            <li>
                            <a href="{{url('admin/invoicereport')}}">Invoice Report</a>
                            </li>
                           
                            <li>
                            <a href="{{url('admin/balancereport')}}">Balance Report</a>
                            </li>
                            <!-- <li>
                            <a href="{{url('admin/stockregister')}}">Stock Register</a>
                            </li>
                            <li>
                            <a href="{{url('admin/item_history')}}">Item History</a>
                            </li>
                            <li>
                            <a href="{{url('admin/cashbook')}}">Cash Book</a>
                            </li> -->
                          
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarBaseuiforcompanyinfo" data-bs-toggle="collapse">
                        <i data-feather="settings"></i>
                        <span> Settings </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarBaseuiforcompanyinfo">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{url('admin/company')}}">Company Informations</a>
                            </li>
                            
                          
                        </ul>
                    </div>
                </li>
                @endif


             
                <!-- <li>
                    <a href="{{url('admin/custom_quotations')}}">
                    <i data-feather="aperture"></i>
                        <span>Custom Quotations</span>
                    </a>
                </li>
                <li>
                    <a href="#sidebarLayouts" data-bs-toggle="collapse">
                    <i data-feather="layout"></i>
                        <span>Custom Approval List </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarLayouts">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{url('admin/custom_approvals/open')}}">Open</a>
                            </li>
                            <li>
                                <a href="{{url('admin/custom_approvals/approve')}}">Approved</a>
                            </li>
                        </ul>
                    </div>
                </li> -->
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->