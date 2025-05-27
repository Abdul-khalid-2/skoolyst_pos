<div class="iq-sidebar sidebar-default">
    <div class="iq-sidebar-logo d-flex align-items-center justify-content-between">
        <a href="{{ route('admin.dashboard') }}" class="header-logo">
            <img src="{{ asset('Backend/assets/images/MDLogo.jpg') }}" 
                 class="img-fluid rounded-normal light-logo" alt="logo">
            <h5 class="logo-title light-logo ml-3">MD-Autos</h5>
        </a>
        <div class="iq-menu-bt-sidebar ml-0">
            <i class="las la-bars wrapper-menu"></i>
        </div>
    </div>
    <div class="data-scrollbar" data-scroll="1">
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="iq-menu">
                <!-- Dashboard -->
                <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="svg-icon">
                        <svg class="svg-icon" id="p-dash1" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                        <span class="ml-4">Dashboard</span>
                    </a>
                </li>

                <!-- Sales -->
                <li class="{{ request()->is('sales*') ? 'active' : '' }}">
                    <a href="#sale" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg class="svg-icon" id="p-dash4" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                            <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                        </svg>
                        <span class="ml-4">Sales</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="sale" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="{{ request()->routeIs('sales.index') ? 'active' : '' }}">
                            <a href="{{ route('sales.index') }}">
                                <i class="las la-minus"></i><span>Sales List</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('pos.index') ? 'active' : '' }}">
                            <a href="{{ route('pos.index') }}">
                                <i class="las la-minus"></i><span>POS Terminal</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('invoices.index') ? 'active' : '' }}">
                            <a href="{{ route('invoices.index') }}">
                                <i class="las la-minus"></i><span>Invoices</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Products -->
                <li class="{{ request()->is('products*') || request()->is('categories*') || request()->is('brands*') ? 'active' : '' }}">
                    <a href="#product" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg class="svg-icon" id="p-dash2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        <span class="ml-4">Products</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="product" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="{{ request()->routeIs('products.index') ? 'active' : '' }}">
                            <a href="{{ route('products.index') }}">
                                <i class="las la-minus"></i><span>Products List</span>
                            </a>
                        </li>
                        {{-- <li class="{{ request()->is('product-variants*') ? 'active' : '' }}">
                            <a href="{{ route('product-variants.index') }}">
                                <i class="las la-minus"></i><span>Product Variants</span>
                            </a>
                        </li> --}}
                        <li class="{{ request()->routeIs('categories.index') ? 'active' : '' }}">
                            <a href="{{ route('categories.index') }}">
                                <i class="las la-minus"></i><span>Categories</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('brands.index') ? 'active' : '' }}">
                            <a href="{{ route('brands.index') }}">
                                <i class="las la-minus"></i><span>Brands</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Inventory -->
                <li class="{{ request()->is('inventory*') ? 'active' : '' }}">
                    <a href="#inventory" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg class="svg-icon" id="p-dash-inv" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                        </svg>
                        <span class="ml-4">Inventory</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="inventory" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="{{ request()->routeIs('inventory-logs.index') ? 'active' : '' }}">
                            <a href="{{ route('inventory-logs.index') }}">
                                <i class="las la-minus"></i><span>Inventory Logs</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('stock-transfers.index') ? 'active' : '' }}">
                            <a href="{{ route('stock-transfers.index') }}">
                                <i class="las la-minus"></i><span>Stock Transfers</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('stock-adjustments.index') ? 'active' : '' }}">
                            <a href="{{ route('stock-adjustments.index') }}">
                                <i class="las la-minus"></i><span>Stock Adjustments</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('low-stock-alerts') ? 'active' : '' }}">
                            <a href="{{ route('low-stock-alerts') }}">
                                <i class="las la-minus"></i><span>Low Stock Alerts</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Purchases -->
                <li class="{{ request()->is('purchases*') ? 'active' : '' }}">
                    <a href="#purchase" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg class="svg-icon" id="p-dash5" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                            <line x1="1" y1="10" x2="23" y2="10"></line>
                        </svg>
                        <span class="ml-4">Purchases</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="purchase" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="{{ request()->routeIs('purchases.index') ? 'active' : '' }}">
                            <a href="{{ route('purchases.index') }}">
                                <i class="las la-minus"></i><span>Purchases List</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('purchases.create') ? 'active' : '' }}">
                            <a href="{{ route('purchases.create') }}">
                                <i class="las la-minus"></i><span>New Purchase</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('purchase-returns.index') ? 'active' : '' }}">
                            <a href="{{ route('purchase-returns.index') }}">
                                <i class="las la-minus"></i><span>Purchase Returns</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- People -->
                <li class="{{ request()->is('customers*') || request()->is('suppliers*') || request()->is('users*') ? 'active' : '' }}">
                    <a href="#people" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg class="svg-icon" id="p-dash8" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span class="ml-4">People</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="people" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="{{ request()->routeIs('customers.index') ? 'active' : '' }}">
                            <a href="{{ route('customers.index') }}">
                                <i class="las la-minus"></i><span>Customers</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('suppliers.index') ? 'active' : '' }}">
                            <a href="{{ route('suppliers.index') }}">
                                <i class="las la-minus"></i><span>Suppliers</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('users.index') ? 'active' : '' }}">
                            <a href="{{ route('users.index') }}">
                                <i class="las la-minus"></i><span>Users</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Reports -->
                <li class="{{ request()->is('reports*') ? 'active' : '' }}">
                    <a href="#reports" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg class="svg-icon" id="p-dash7" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        <span class="ml-4">Reports</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="reports" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="{{ request()->routeIs('reports.sales') ? 'active' : '' }}">
                            <a href="{{ route('reports.sales') }}">
                                <i class="las la-minus"></i><span>Sales Reports</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('reports.inventory') ? 'active' : '' }}">
                            <a href="{{ route('reports.inventory') }}">
                                <i class="las la-minus"></i><span>Inventory Reports</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('reports.profit-loss') ? 'active' : '' }}">
                            <a href="{{ route('reports.profit-loss') }}">
                                <i class="las la-minus"></i><span>Profit & Loss</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('reports.customer') ? 'active' : '' }}">
                            <a href="{{ route('reports.customer') }}">
                                <i class="las la-minus"></i><span>Customer Reports</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Settings -->
                <li class="{{ request()->is('settings*') ? 'active' : '' }}">
                    <a href="#settings" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg class="svg-icon" id="p-dash-settings" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                        </svg>
                        <span class="ml-4">Settings</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="settings" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="{{ request()->routeIs('settings.general') ? 'active' : '' }}">
                            <a href="{{ route('settings.general') }}">
                                <i class="las la-minus"></i><span>General Settings</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('settings.pos') ? 'active' : '' }}">
                            <a href="{{ route('settings.pos') }}">
                                <i class="las la-minus"></i><span>POS Settings</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('settings.tax') ? 'active' : '' }}">
                            <a href="{{ route('settings.tax') }}">
                                <i class="las la-minus"></i><span>Tax Settings</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('settings.business') ? 'active' : '' }}">
                            <a href="{{ route('settings.business') }}">
                                <i class="las la-minus"></i><span>Business Settings</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ request()->routeIs('database.backup') ? 'active' : '' }}">
                    <a href="{{ route('database.backup') }}" class="svg-icon">
                        <svg class="svg-icon" id="p-dash1" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                        <span class="ml-4">Data Backup</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>