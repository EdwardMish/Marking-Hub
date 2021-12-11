<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" class="w-100-p b-r-10" src="../images/simplepost_logo_01.jpg" />
                </div>
                <div class="logo-element">
                <img alt="image" class="w-100-p b-r-10" src="../images/simplepost_logo_01.jpg" />
                </div>
                @if (Auth::check())
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">{{ auth()->user()->name }}</span>
                    </a>
                </div>
                @endif
            </li>
            {{-- <li class="{{ Route::is('dashboard') ? 'active' : '' }}">--}}
            {{-- <a href="{{ Route('dashboard') }}"><i class="fa fa-dashboard"></i>
            <span--}} {{--                        class="nav-label">Dashboard</span></a>--}} {{--            </li>--}} <li class="{{ Route::is('gettingStarted') ? 'active' : '' }}">
                <a href="{{ Route('gettingStarted') }}"><i class="fa fa-hand-o-right"></i> <span class="nav-label">Getting Started</span></a>
                </li>
                <li class="{{ Route::is('account') ? 'active' : '' }}">
                    <a href="{{ Route('account') }}"><i class="fa fa-cog"></i> <span class="nav-label">Account</span></a>
                </li>

                <li class="{{ Route::is('viewCampaigns') ? 'active' : '' }}">
                    <a href="{{ Route('viewCampaigns') }}"><i class="fa fa-bullhorn"></i> <span class="nav-label">Automated Retargeting</span></a>
                </li>

                <li class="{{ Route::is('analyticsDashboard') ? 'active' : '' }}">
                    <a href="{{ Route('analyticsDashboard') }}"><i class="fa fa-line-chart"></i> <span class="nav-label">Analytics Dashboard</span></a>
                </li>

                {{-- <li class="{{ (Route::is('viewCampaigns', 'createCampaign', 'selectPostcard')) ? 'active' : '' }}">--}}
                {{-- <a href="{{ Route('viewCampaigns') }}"><i class="fa fa-bullhorn"></i> <span class="nav-label">Automated Retargeting</span>
                <span--}} {{--                        class="fa arrow"></span></a>--}} {{--                <ul class="nav nav-second-level collapse">--}} {{--                    <li class="{{ Route::is('viewCampaigns') ? 'active' : '' }}"><a href="{{ Route('viewCampaigns') }}">View--}}
                        {{-- Campaigns</a></li>--}}
                        {{-- </ul>--}}
                        {{-- </li>--}}

        </ul>

    </div>
</nav>