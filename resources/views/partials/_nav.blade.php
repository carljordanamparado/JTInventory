<header class="main-header">
  <!-- Logo -->
  <a href="{{ route('Dashboard') }}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>INV</b></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>Inventory</b></span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>

</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MENU NAVIGATION</li>
      <li
        class=" {{ (request()->is('Customer')) || (request()->is('Pricelist')) || (request()->is('Purchase_Order'))   ? 'active' : '' }} treeview">
        <a>
          <i class="fa fa-users"></i> <span>Customer Masterfile</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ (request()->is('Customer')) ? 'active' : '' }}"><a href="{{ route('Customer') }}"><i
                class="fa fa-user"></i> Customers List </a></li>
          <li class="{{ (request()->is('Pricelist')) ? 'active' : '' }}"><a href="{{ route('Pricelist') }}"><i
                class="fa fa-product-hunt"></i> Product Pricelist </a></li>
          {{-- <li class="{{ (request()->is('Cylinder')) ? 'active' : '' }}"><a href="{{ route('Cylinder') }}"><i
              class="fa fa-cubes"></i> Cylinder Balance </a>
      </li> --}}
      <li class="{{ (request()->is('Purchase_Order')) ? 'active' : '' }}"><a href="{{ route('Purcase_Order') }}"><i
            class="fa fa-shopping-cart"></i> Purchase Order </a></li>
    </ul>
    </li>
    <li class=" {{ (request()->is('SystemUtilities/SystemUsers')) ? 'active' : '' }} treeview">
      <a>
        <i class="fa fa-wrench"></i> <span>System Utilities</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li class="{{ (request()->is('SystemUtilities/SystemUsers')) ? 'active' : '' }}"><a
            href="{{ route('SystemUsers') }}"><i class="fa fa-user"></i> System User </a></li>
        <li class=""><a href=""><i class="fa fa-history"></i> Audit Trail Monitoring </a></li>
        <li class=""><a href="{{ route('SalesRepController.index') }}"><i class="fa fa-address-card"></i> Sales
            Representative </a></li>
        <li class=""><a href="{{ route('SalesInvoice.index') }}"><i class="fa fa-clipboard-list"></i> Sales Invoice
            Decleration </a></li>
        <li class=""><a href="{{ route('ICRDeclaration.index') }}"><i class="fa fa-clipboard-list"></i> ICR Decleration
          </a></li>
        <li class=""><a href="{{ route('CLCDeclaration.index') }}"><i class="fa fa-clipboard-list"></i> CLC Declaration
          </a></li>
        <li class=""><a href="{{ route('DRDeclaration.index') }}"><i class="fa fa-clipboard-list"></i> DR Decleration
          </a></li>
        <li class=""><a href="{{ route('ORDeclaration.index')}}"><i class="fa fa-clipboard-list"></i> OR Decleration
          </a></li>
      </ul>
    </li>
    <li class=" {{ (request()->is('Sales') || request()->is('CylinderReceipt'))  ? 'active' : '' }} treeview">
      <a>
        <i class="fa fa-wrench"></i> <span>Sales Record</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li class="{{ (request()->is('Sales')) ? 'active' : '' }}"><a href="{{ route('Sales.index') }}"><i
              class="fa fa-user"></i> Sales Invoice </a></li>
        <li class="{{ (request()->is('CylinderReceipt')) ? 'active' : '' }}"><a
            href="{{ route('CylinderReceipt.index') }}"><i class="fa fa-user"></i> Incoming Cylinder Receipt </a></li>
        <li class="{{ (request()->is('CylinderLoan')) ? 'active' : '' }}"><a href="{{ route('CylinderLoan.index') }}"><i
              class="fa fa-user"></i> Cylinder Loan Contract </a></li>
        <li class="{{ (request()->is('Deliver')) ? 'active' : '' }}"><a href="{{ route('Deliver.index') }}"><i
              class="fa fa-user"></i> Delivery Receipt </a></li>
        <li class="{{ (request()->is('OfficialReceipt')) ? 'active' : '' }}"><a
            href="{{ route('OfficialReceipt.index') }}"><i class="fa fa-user"></i> Official Receipt </a></li>
      </ul>
    </li>
      <li class="treeview menu-open" style="height: auto;">
        <a>
          <i class="fa fa-share"></i> <span>Reports</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu" style="display: block;">
          <li class="treeview menu-open" style="height: auto;">
            <a><i class="fa fa-circle-o"></i> Customer Reports
              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu" style="display: block;">
              <li><a href="#"><i class="fa fa-circle-o"></i> Pricelist Report </a></li>
              <li><a data-toggle="modal" data-target="#agingAccount"><i class="fa fa-circle-o"></i> Aging Report </a></li>
              <li><a data-toggle="modal" data-target="#statementAccount"> <i class="fa fa-circle-o"></i> Statement of Account </a></li>
              <li><a href="#"><i class="fa fa-circle-o"></i> Summary of Account </a></li>


            </ul>
          </li>
        </ul>
      </li>
      <li class="treeview">
        <a>
          <i class="fa fa-wrench"></i> <span>System User</span>
          <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ (request()->is('Sales')) ? 'active' : '' }}"><a href="{{ route('Logout') }}"><i
                      class="fa fa-user"></i> Logout </a></li>
        </ul>
      </li>
    </ul>
  </section>

    {{-- For Reports --}}



  <!-- /.sidebar -->
</aside>