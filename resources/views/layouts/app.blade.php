<!DOCTYPE html>
<html lang="en">

@include('layouts.partials.head')

<body data-sidebar="{{ session('theme', 'light') }}" data-layout-mode="{{ session('theme', 'light') }}">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">


        <header id="page-topbar">
            @livewire('component.page.header', key('header-component'))
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">
                <!--- Sidemenu -->
                @livewire('component.page.sidebar', key('sidebar-component'))
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    {{ $slot }}
                    <!-- end row -->
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                @livewire('component.page.footer', key('footer-component'))
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    {{-- <livewire:component.page.right-bar /> --}}
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    {{-- <div class="rightbar-overlay"></div> --}}

    <!-- JAVASCRIPT -->
    @include('layouts.partials.plugin')
</body>

</html>
