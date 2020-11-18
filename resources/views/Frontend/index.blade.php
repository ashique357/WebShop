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
        @include('Frontend.Layouts.banner')
        @include('Frontend.Layouts.featured')
        @include('Frontend.Layouts.offer')
        @include('Frontend.Layouts.sale_off')
        @include('Frontend.Layouts.top_sale')
        @include('Frontend.Layouts.testimonial')
        @include('Frontend.Layouts.blog')
        @include('Frontend.Layouts.contact')
        @include('Frontend.Layouts.subscribe')
        @include('Frontend.Layouts.footer')
    </main>
    @include('Frontend.Layouts.footer_link')
</body>
</html>