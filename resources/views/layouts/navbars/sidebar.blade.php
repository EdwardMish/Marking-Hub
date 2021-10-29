<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                @if (Auth::check())
                    <div class="dropdown profile-element">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="block m-t-xs font-bold">{{ auth()->user()->name }}</span>
                        </a>
                    </div>
                @endif
            </li>

            {{--            <li class="{{ Route::is('dashboard') ? 'active' : '' }}">--}}
            {{--                <a href="{{ Route('dashboard') }}"><i class="fa fa-dashboard"></i> <span--}}
            {{--                        class="nav-label">Dashboard</span></a>--}}
            {{--            </li>--}}
            <li class="{{ Route::is('gettingStarted') ? 'active' : '' }}">
                <a href="{{ Route('gettingStarted') }}"><i class="fa fa-hand-o-right"></i> <span
                        class="nav-label">Getting Started</span></a>
            </li>

            <li class="{{ Route::is('viewCampaigns') ? 'active' : '' }}">
                <a href="{{ Route('viewCampaigns') }}"><i class="fa fa-bullhorn"></i> <span
                        class="nav-label">Automated Retargeting</span></a>
            </li>
            {{--            <li class="{{ (Route::is('viewCampaigns', 'createCampaign', 'selectPostcard')) ? 'active' : '' }}">--}}
            {{--                <a href="{{ Route('viewCampaigns') }}"><i class="fa fa-bullhorn"></i> <span class="nav-label">Automated Retargeting</span><span--}}
            {{--                        class="fa arrow"></span></a>--}}
            {{--                <ul class="nav nav-second-level collapse">--}}
            {{--                    <li class="{{ Route::is('viewCampaigns') ? 'active' : '' }}"><a href="{{ Route('viewCampaigns') }}">View--}}
            {{--                            Campaigns</a></li>--}}
            {{--                </ul>--}}
            {{--            </li>--}}
        </ul>
    </div>
</nav>
