<style></style>
<header class="topbar">

    <div class="with-vertical"><!-- ---------------------------------- -->
        <!-- Start Vertical Layout Header -->
        <!-- ---------------------------------- -->
        <nav class="navbar navbar-expand-lg p-0">
            <ul class="navbar-nav">
                <li class="nav-item nav-icon-hover-bg rounded-circle ms-n2">
                    <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                @php
                    $sessionchargedel = session('charge');
                    $sessionuserdel = session('user');
                    $dga_roletypecode = $DGA_roletypecode;
                @endphp
                <li class="mt-2">
                    <b>
                        <?php
                        // print_r($sessionchargedel);
                        if ($sessionchargedel->usertypecode == 'A') {
                            if ($sessionchargedel->deptesname) {
                                echo ' Department : ' . $sessionchargedel->deptesname;
                            }
                            if ($sessionchargedel->regionename) {
                                echo ' | Region : ' . $sessionchargedel->regionename;
                            }
                            if ($sessionchargedel->distename) {
                                echo ' | District : ' . $sessionchargedel->distename;
                            }
                        } else {

                            if ($sessionchargedel->instename) {
                                echo ' Institution Name : ' . $sessionchargedel->instename . ' , ' . $sessionchargedel->distename;
                            }
                            // if ($sessionchargedel->regionename) {
                            //     echo ' | Region : ' . $sessionchargedel->regionename;
                            // }
                            // if ($sessionchargedel->distename) {
                            //     echo ' | District : ' . $sessionchargedel->distename;
                            // }
                        }
                        // if ($sessionchargedel->usertypecode == 'A') {
                        //     if ($sessionchargedel->desigelname) {
                        //         echo '| Designation : ' . $sessionchargedel->desigelname;
                        //     }
                        // }
                        ?>
                        <div class="text-start">
                            <?php
                            if ($sessionuserdel->lastlogin) {
                                echo ' Last Login: ' . ($sessionuserdel->lastlogin ? \Carbon\Carbon::parse($sessionuserdel->lastlogin)->format('d-m-Y h:i A') : 'N/A');
                            } ?>
                        </div>

                    </b>
                </li>
            </ul>

            <div class="d-block d-lg-none py-4">

            </div>
            <a class="navbar-toggler nav-icon-hover-bg rounded-circle p-0 mx-0 border-0" href="javascript:void(0)"
                data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="ti ti-dots fs-7"></i>
            </a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex align-items-center justify-content-between">
                    <a href="javascript:void(0)"
                        class="nav-link nav-icon-hover-bg rounded-circle mx-0 ms-n1 d-flex d-lg-none align-items-center justify-content-center"
                        type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar"
                        aria-controls="offcanvasWithBothOptions">
                        <i class="ti ti-align-justified fs-7"></i>
                    </a>
                    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">

                        <!-- ------------------------------- -->
                        <!-- start profile Dropdown -->
                        <!-- ------------------------------- -->
                        <li class="mt-2">
                            <b>
                                <div class="text-end"><?php echo htmlspecialchars($sessionuserdel->username); ?></div>
                                <?php
                                if ($sessionchargedel->usertypecode == 'A') {
                                    if ($sessionchargedel->desigelname) {
                                        echo '' . $sessionchargedel->desigelname;
                                    }
                                } ?>
                            </b>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <div class="user-profile-img">
                                        <img src="../assets/images/profile/user-1.jpg" class="rounded-circle"
                                            width="35" height="35" alt="modernize-img" />
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                aria-labelledby="drop1">
                                <div class="profile-dropdown position-relative" data-simplebar>
                                    <div class="py-3 px-7 pb-0">
                                        <h5 class="mb-0 fs-5 fw-semibold">User Profile</h5>
                                    </div>
                                    <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                        <img src="../assets/images/profile/user-1.jpg" class="rounded-circle"
                                            width="80" height="80" alt="modernize-img" />
                                        <div class="ms-3">
                                            <h5 class="mb-1 fs-3"><?php echo $sessionuserdel->username; ?></h5>
                                            <p class="mb-0 d-flex align-items-center gap-2">
                                                <i class="ti ti-mail fs-4"></i> <?php echo $sessionuserdel->email; ?>
                                            </p>


                                        </div>
                                    </div>

                                    <div class="d-grid py-4 px-7 pt-8">

                                        @if (session()->has('user'))
                                            <!-- Hidden Logout Form -->
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                            </form>

                                            <!-- Log Out Button -->
                                            <a href="javascript:void(0)" class="btn btn-outline-primary"
                                                onclick="document.getElementById('logout-form').submit();">
                                                Log Out
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                        <select class=" custom-select custom-select-sm ms-4" style="width: auto; " id="translate">
                            <option value="en">English</option>
                            <option value="ta">தமிழ்</option>
                        </select>
                        <!-- ------------------------------- -->
                        <!-- end profile Dropdown -->
                        <!-- ------------------------------- -->
                    </ul>
                </div>
            </div>
        </nav>
        <hr>
        <!-- ---------------------------------- -->
        <!-- End Vertical Layout Header -->
        <!-- ---------------------------------- -->

        <!-- ------------------------------- -->
        <!-- apps Dropdown in Small screen -->
        <!-- ------------------------------- -->
        <!--  Mobilenavbar -->

    </div>

</header>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="../common/js_common.js"></script>
