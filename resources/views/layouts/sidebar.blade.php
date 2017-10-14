<!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>{{ Auth::user()->name }}</p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
                  <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                  </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>
            <li><a href="/series/create"><i class="fa fa-circle-o text-red"></i>Series</a></li>
            <li><a href="/categories/create"><i class="fa fa-circle-o text-purple"></i>Categories</a></li>
            <li><a href="/products/create"><i class="fa fa-circle-o text-blue"></i>Products</a></li>
            <li><a href="/options/create"><i class="fa fa-circle-o text-green"></i>Options</a></li>
            <li><a href="/colors/create"><i class="fa fa-circle-o text-yellow"></i>Colors</a></li>
            <li><a href="/accessories/create"><i class="fa fa-circle-o text-maroon"></i>Accessories</a></li>
            <li><a href="/galleries/create"><i class="fa fa-circle-o text-teal"></i>Galleries</a></li>
            <li><a href="/optiongroups/create"><i class="fa fa-circle-o text-orange"></i>Option groups</a></li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->
