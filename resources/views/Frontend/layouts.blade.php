<!DOCTYPE html>
<html lang="en">
    @include('Frontend.Layouts.header')
<body class="ps-loading">
    <div class="header--sidebar"></div>
    <header class="header">
        @include('Frontend.Layouts.top_menu')
        @include('Frontend.Layouts.main_menu')
        @include('Frontend.Layouts.header_services')
    </header>
    <main class="ps-main">
        @yield('page_content')
        @include('Frontend.Layouts.footer')
    </main>
    @include('Frontend.Layouts.footer_link')
</body>
</html>