<div class="offcanvas offcanvas-end rounded-start-4 shadow-sm" data-bs-scroll="true" style="width: 270px;" tabindex="-1" id="userOffCanvas" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header border-bottom border-light">
    <img src="{{ asset('images/avator.png') }}" alt="" style="width: 15%;" class="rounded-circle border border-light shadow-sm" />
    <h5 class="offcanvas-title text-start text-capitalize w-75 px-2" id="">
      <small class="font-16 fw-bold">{{ auth()->user()->name }} </small><br class="mb-0" />
      <small>{{ auth()->user()->usertype->first_name.' '.auth()->user()->usertype->last_name }} </small>
    </h5>
    <button type="button" class="btn-close text-reset font-12" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body px-2 py-2">
    <ul class="list-group">

      <li class="list-group-item border-0 pb-1">
        <a class="nav-link" href="{{ route('account.profile') }}">
            <i class="mdi mdi-account fa fa-user menu-icon fw-bold font-16 text-primary"></i>
            <span class="menu-title px-2 font-14 text-muted">{{ __('Account Profile') }}</span>
        </a>
      </li>
      <li class="list-group-item border-0 pb-1">
        <a class="nav-link" href="{" >
            <i class="mdi mdi-settings fa fa-cog menu-icon fw-bold font-16 text-primary"></i>
            <span class="menu-title px-2 font-14 text-muted">{{ __('Account Settings') }}</span>
        </a>
      </li>
      <li class="list-group-item border-0">
        <a class="nav-link" href="" >
            <i class="mdi mdi-bell menu-icon fa fa-bell fw-bold font-16 text-primary"></i>
            <span class="menu-title px-2 font-14 text-muted">{{ __('Your Notifications') }}</span>
        </a>
      </li>
      
      <li class="list-group-item border-0 ">
        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="mdi mdi-logout fa fa-signout-alt menu-icon fw-bold font-16 text-primary"></i>
            <span class="menu-title px-2 font-14 text-muted">{{ __('Logout') }}</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form> 
      </li>
    </ul>

    
    
  </div>
</div>