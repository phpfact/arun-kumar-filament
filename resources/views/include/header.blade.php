<header>
  <div class="container-fluid">
    <div class="header-content">
      <div class="logo">
        <h2>
          <a href="{{route('home')}}" title="" class="white-logo"><img
              src="{{ asset('assets\images\resources\logo\favicon.png') }}" alt="" width="70"></a>
        </h2>
      </div>
      <!--logo end-->
      <nav>
        <ul>
          <li class="active">
            <a href="{{route('home')}}" title="">HOME</a>
          </li>
          <li>
            <a href="javascript:;" title="">Our Services</a>
            <ul>
              <li><a href="javascript:;" title="">Music Distribution</a></li>
              <li><a href="javascript:;" title="">Caller Tune Distribution</a></li>
              <li>
                <a href="javascript:;" title="">Music Video Distribution in India & Worldwide</a>
              </li>
            </ul>
          </li>
          <li><a href="javascript:;" title="">Pricing</a></li>
          <li><a href="javascript:;" title="">Contact</a></li>
          @if (isCustomerLoggedIn())
            <li><a target="_blank" href="{{ route('filament.customer.auth.login') }}" title="">Dashboard</a></li>
          @else
            <li><a target="_blank" href="{{ route('filament.customer.auth.login') }}" title="">Register/ Login</a></li>
          @endif
        </ul>
      </nav>
      <!--navigation end-->
      <ul class="social-links hd-v">
        <li>
          <a href="javascript:;" title=""><i class="fab fa-facebook-square"></i></a>
        </li>
        <li>
          <a href="javascript:;" title=""><i class="fab fa-twitter"></i></a>
        </li>
        <li>
          <a href="javascript:;" title=""><i class="fab fa-instagram"></i></a>
        </li>
        <li>
          <a href="javascript:;" title=""><i class="fab fa-youtube"></i></a>
        </li>
      </ul>
      <!--social-links end-->
      <div class="menu-btn">
        <span class="bar1"></span>
        <span class="bar2"></span>
        <span class="bar3"></span>
      </div>
    </div>
    <!--header-content end-->
  </div>
</header>
<!--header end-->

<div class="responsive-mobile-menu">
  <ul>
    <li class="active">
      <a href="{{ route('home') }}" title="">HOME</a>
    </li>
    <li>
      <a href="javascript:;" title="">Our Services</a>
      <ul>
        <li><a href="javascript:;" title="">Music Distribution</a></li>
        <li><a href="javascript:;" title="">Caller Tune Distribution</a></li>
        <li>
          <a href="javascript:;" title="">Music Video Distribution in India & Worldwide</a>
        </li>
      </ul>
    </li>
    <li><a href="javascript:;" title="">Pricing</a></li>
    <li><a href="javascript:;" title="">Contact</a></li>
    @if (isCustomerLoggedIn())
      <li><a target="_blank" href="{{ route('filament.customer.auth.login') }}" title="">Dashboard</a></li>
    @else
      <li><a target="_blank" href="{{ route('filament.customer.auth.login') }}" title="">Register/ Login</a></li>
    @endif
  </ul>
</div>
<!--responsive-menu end-->
