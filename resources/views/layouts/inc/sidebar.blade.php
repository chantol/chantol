 <aside>
<div id="sidebar" class="nav-collapse " style="overflow:auto;">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">
          <li class="active">
            <a class="" href="index.html">
                          <i class="icon_house_alt"></i>
                          <span>Dashboard</span>
                      </a>
          </li>
          
          
          <li class="sub-menu">
            <a href="javascript:;" class="">
                          <i class="fa fa-cube"></i>
                          <span>Product</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
            <ul class="sub">
              <li><a class="" href="{{ route('createproduct') }}">Product Register</a></li>
              <li><a class="" href="{{ route('showallproduct') }}">Product List</a></li>
              <li><a class="" href="{{ route('categoryset') }}">Category Set</a></li>
              <li><a class="" href="{{ route('productscore') }}">Product Score</a></li>
            </ul>
          </li>

          <li class="sub-menu">
            <a href="javascript:;" class="">
                <i class="fa fa-industry"></i>
                <span>Purchase</span>
                <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
              <li><a class="" href="{{ route('purchaseorder') }}">New Purchase</a></li>
              <li><a class="" href="{{ route('purchaseinvoice') }}">Purchase Invoice</a></li>
              
              <li><a class="" href="{{ route('purchasepaid') }}">Paid</a></li>
              
            </ul>
          </li>
          
          <li class="sub-menu">
            <a href="javascript:;" class=""​>
                <i class="fa fa-shopping-bag"></i>
                <span>Sale</span>
                <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
              <li><a class="" href="{{ route('saleout') }}">New Sale</a></li>
              <li><a class="" href="{{ route('saleinvoice') }}">Sold Invoice</a></li>
              
            </ul>
          </li>
          
          
           <li class="sub-menu">
              <a href="javascript:;" class=""​>
                  <i class="fa fa-money"></i>
                  <span>Sale Payment</span>
                  <span class="menu-arrow arrow_carrot-right"></span>
              </a>
              <ul class="sub">
                  <li><a class="" href="{{ route('salepaid') }}">Customer Payment</a></li>
                  <li><a class="" href="{{ route('salepaid_delivery') }}">Delivery Payment</a></li>
                  <li><a class="" href="{{ route('salepaid_law') }}">Law Payment</a></li>
              </ul>
          </li>

          <li class="sub-menu">
              <a href="javascript:;" class=""​>
                  <i class="fa fa-book"></i>
                  <span>Close Sale</span>
                  <span class="menu-arrow arrow_carrot-right"></span>
              </a>
              <ul class="sub">
                 <li><a class="" href="{{ route('closesaleinvoice') }}">Close Invoice</a></li>
                  <li><a class="" href="{{ route('closesaleinvoicepayment') }}">List's Payment</a></li>
                  <li><a class="" href="{{ route('closesaleinvoicereport') }}">Report</a></li>
              </ul>
          </li>

          <li class="sub-menu">
            <a href="javascript:;" class=""​>
                <i class="fa fa-institution"></i>
                <span>Inventory</span>
                <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
              <li><a class="" href="{{ route('stockinfo') }}">Stock Info</a></li>
              <li><a class="" href="{{ route('stockhistory') }}">Stock History</a></li>
              <li><a class="" href="{{ route('addstock') }}">Stock in </a></li>
              <li><a class="" href="{{ route('cutstock') }}">Stock Out</a></li>
            </ul>
          </li>

          <li class="sub-menu">
            <a href="javascript:;" class=""​>
                <i class="fa fa-line-chart"></i>
                <span>Report</span>
                <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
              <li><a class="" href="{{ route('salereport') }}">Sale Report</a></li>
              <li><a class="" href="{{ route('buyreport') }}">Purchase Report</a></li>
              <li><a class="" href="{{ route('scorereport') }}">Score Report</a></li>
              {{-- <li><a class="" href="{{ route('autoprinttest') }}">Test Auto Print</a></li> --}}
            </ul>
          </li>

          

          <li class="sub-menu">
            <a href="javascript:;" class="">
                <i class="fa fa-bars"></i>
                <span>Account</span>
                <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
              <li><a class="" href="{{ route('accountreceive') }}">Account Receive</a></li>
              <li><a class="" href="{{ route('accountpay') }}">Account Payable</a></li>
            </ul>
          </li>
          <li class="sub-menu">
            <a href="javascript:;" class="">
                <i class="fa fa-address-book-o"></i>
                <span>Register</span>
                <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
              <li><a class="" href="{{ route('company.register') }}">Company</a></li>
              <li><a class="" href="{{ route('supplier.register',[0]) }}">Supplier</a></li>
              <li><a class="" href="{{ route('supplier.register',[1]) }}">Customer</a></li>
              <li><a class="" href="{{ route('delivery.register') }}">Delivery and CO</a></li>
            </ul>
          </li>
          <li class="sub-menu">
            <a href="javascript:;" class="">
                <i class="fa fa-user"></i>
                <span>Users</span>
                <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
              <li><a class="" href="{{ route('userregister') }}">Register</a></li>
              <li><a class="" href="">User Permission</a></li>
            </ul>
          </li>
          
          <li class="sub-menu">
            <a href="javascript:;" class="">
                          <i class="fa fa-cube"></i>
                          <span>Others</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
            <ul class="sub">
              <li><a class="" href="{{ route('exchangerate') }}">Exchange Rate</a></li>
              <li><a class="" href="{{ route('expanserecord') }}">Expanse Record</a></li>
              
            </ul>
          </li>

         
         

        </ul>
        <!-- sidebar menu end-->
      </div>
      </aside>