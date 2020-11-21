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

@foreach($menus as $menu)
    @if((count($menu['relations']) ==0) AND ($menu['parent_id'] ==0))
      <li class="nav-item active">
        <a class="nav-link" href="{{env('APP_URL')}}{{$menu['slug']}}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>{{$menu['name']}}</span></a>
      </li>
      
      @elseif((count($menu['relations']) > 0) AND ($menu['parent_id'] == 0))
      <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse{{$menu['id']}}" aria-expanded="true" aria-controls="collapse{{$menu['id']}}">
            <i class="fas fa-wrench"></i>
            <span>{{$menu['name']}}</span>
          </a>
          @if(count($menu['relations']) >0 )
            <div id="collapse{{$menu['id']}}" class="collapse" aria-labelledby="heading{{$menu['id']}}" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">    
                  @include('Backend.Layouts.submenu',['childs' => $menu['relations']])
                </div>
            </div>
          @endif
      </li>
    @endif
@endforeach

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
  <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>
</ul>
<!-- End of Sidebar -->