<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
  <div class="sidebar-brand-icon rotate-n-15">
    <i class="fas fa-laugh-wink"></i>
  </div>
  <div class="sidebar-brand-text mx-3">Web Shop</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
  <a class="nav-link" href="">
    <i class="fas fa-fw fa-tachometer-alt"></i>
    <span>Dashboard</span></a>
</li>

  @foreach($menus as $key=>$menu)
  <li class="nav-item">
  @if($menu['childs'] == null && $menu['parent_id'] == 0)
      <a class="nav-link" href="{{env('APP_URL')}}{{$menu['slug']}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>{{$menu['name']}}</span>
      </a>
    @endif

    @if($menu['childs'] != null)
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="true" aria-controls="collapseTwo{{$key}}">
            <i class="fas fa-fw fa-cog"></i>
            <span>{{$menu['childs']['name']}}</span>
        </a>
        <div id="collapse{{$key}}" class="collapse" aria-labelledby="heading{{$key}}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              @if($menu['childs'] != null)
                @foreach($menu['childs']['menu'] as $submenu)
                <span>   
                  <a  class="collapse-item" href="{{env('APP_URL')}}{{$submenu['slug']}}">{{$submenu['name'] }}</a>
                </span>
                @endforeach
              @endif
            </div>
        </div>
      
    @endif
</li>
  @endforeach

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
  <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->