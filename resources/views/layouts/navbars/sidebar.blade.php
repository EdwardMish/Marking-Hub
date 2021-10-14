<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">{{ auth()->user()->name }}</span>
                    </a>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li class="{{ Route::is('dashboard') ? 'active' : '' }}">
                <a href="{{ Route('dashboard') }}"><i class="fa fa-th-large"></i> <span
                        class="nav-label">Dashboard</span></a>
            </li>
            <li class="{{ (Route::is('viewCampaigns', 'createCampaign', 'selectPostcard')) ? 'active' : '' }}">
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Campaign</span><span
                        class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ Route::is('viewCampaigns') ? 'active' : '' }}"><a href="{{ Route('viewCampaigns') }}">View
                            Campaigns</a></li>
                    <li class="{{ Route::is('selectPostcard') ? 'active' : '' }}"><a
                            href="{{ Route('selectPostcard') }}">Design a Postcard</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
