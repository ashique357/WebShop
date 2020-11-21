<!DOCTYPE html>
<html lang="en">
@include('Backend.Layouts.header')
<body id="page-top">
  <div id="wrapper">
  @include('Backend.Layouts.sidebar')
  
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content" id="app">

      @include('Backend.Layouts.nav')

        @yield('page_content')
        
      </div>
      <!-- End of Main Content -->

      @include('Backend.Layouts.footer')

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>  
@include('Backend.Layouts.logout_modal')
@include('Backend.Layouts.footer_links')

@stack('scripts')

<script src="{{env('PUBLIC_PATH')}}/node_modules/tinymce/tinymce.js"></script>
<script type="text/javascript">
   tinymce.init({
       selector:'textarea.tiny-mce',
       width: 900,
       height: 300,
       plugins : ["advlist autolink lists link image charmap print preview anchor pagebreak", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste jbimages tinymcespellchecker"],
        toolbar : "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages |spellchecker",
        spellchecker_language: 'en',
       link_default_protocol: 'https',
   });
</script>

<script>
    window.Laravel = <?php echo json_encode([
      'csrfToken' => csrf_token(),
      'adminId' => Auth::guard('admin')->user()->id,
      'permissions' => Auth::guard('admin')->user()->permissions()->pluck('name')->toArray()
  ]);

  ?>
</script>
</body>
</html>