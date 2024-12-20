@php
    $sessionchargedel = session('charge', collect([])); // Default to empty collection
    $userMenuIds = array_unique($sessionchargedel->menu ?? []); // Get menu IDs
    $usertypecode = session('usertypecode');
@endphp

<input type="hidden" id="usertypecode" name="usertypecode" value="<?php echo $sessionchargedel->usertypecode; ?>">
<?php
// Fetch child menus
$childMenus = DB::table('audit.mst_menu as m1')->leftJoin('audit.mst_menu as m2', 'm1.parentid', '=', 'm2.menuid')->whereIn('m1.menuid', $userMenuIds)->select('m1.menuid as menuid', 'm1.menuename as menuename', 'm1.menutname as menutname', 'm1.parentid as parentid', 'm1.parentorderid as parentorderid', 'm1.orderid as orderid', 'm1.menuurl as menuurl', 'm1.iconname')->get();

// Group child menus by parentid
$childMenusByParent = $childMenus->groupBy('parentid');

// Get parent menus
$parentIdsQuery = DB::table('audit.mst_menu')->selectRaw('DISTINCT CASE WHEN parentid = 0 THEN menuid ELSE parentid END AS parentid')->whereIn('menuid', $userMenuIds);

$parentMenus = DB::table('audit.mst_menu as m1')
    ->joinSub($parentIdsQuery, 'parentid', function ($join) {
        $join->on('m1.menuid', '=', 'parentid.parentid');
    })
    ->select('m1.menuid', 'm1.menuename', 'm1.menutname', 'm1.parentid', 'm1.parentorderid', 'm1.iconname', 'm1.orderid', 'm1.levelid', 'm1.menuurl')
    ->orderBy('m1.parentorderid')
    ->orderBy('m1.orderid')
    ->get();
?>


<aside class="left-sidebar with-vertical" style="background-color: #3782ce;  height: 100%; position: fixed; ">
    {{-- <img src="{{ asset('site/image/tn__logo.png') }}" class="cams_logo ms-2 me-3">
    <b class="text-white h4"> CAMS </b> --}}
    <div>
        <div class="brand-logo d-flex align-items-center ">
            <img src="{{ asset('site/image/tn__logo.png') }}" class="cams_logo ms-2 me-3">
            <b class="text-white h4"> CAMS </b>
            <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
                <i class="ti ti-x"></i>
            </a>
        </div>

        <nav class="sidebar-nav scroll-sidebar" data-simplebar>
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Menu</span>
                </li>

                @foreach ($parentMenus as $parent)
                    @php
                        $parentId = $parent->menuid;
                        $parentname = $parent->menuename;
                        $parentmenuurl = $parent->menuurl;
                    @endphp

                    @if ($parent->levelid == 1)
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ url($parentmenuurl) }}" id="get-url"
                                aria-expanded="false">
                                <span><i class="ti <?php echo $parent->iconname; ?>"></i></span>
                                <span class="hide-menu">{{ $parentname }}</span>
                            </a>
                        </li>
                    @else
                        @php
                            $childMenusForParent = $childMenusByParent->get($parentId, collect())->sortBy('orderid');
                        @endphp

                        @if ($childMenusForParent->isNotEmpty())
                            <li class="sidebar-item">
                                <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                    <span class="d-flex"><i class="ti ti-layout-grid"></i></span>
                                    <span class="hide-menu">{{ $parentname }}</span>
                                </a>
                                <ul aria-expanded="false" class="collapse first-level">
                                    @foreach ($childMenusForParent as $child)
                                        <li class="sidebar-item">
                                            <a href="{{ url($child->menuurl) }}" class="sidebar-link">
                                                <div class="round-16 d-flex align-items-center justify-content-center">
                                                    <i class="ti <?php echo $child->iconname; ?>"></i>
                                                </div>
                                                <span class="hide-menu">{{ $child->menuename }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>
</aside>
