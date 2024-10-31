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
