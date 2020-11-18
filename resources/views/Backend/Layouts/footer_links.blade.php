<script> window.baseUrl = '{{url('/')}}';</script>
<script> window.storageUrl = '{{env('STORAGE_URL')}}';</script>
<script> window.publicUrl = '{{env('PUBLIC_PATH')}}';</script>
<script> window.token = '{{@csrf_token()}}';</script>
<script> window.id = '';</script>


<script src="{{env('PUBLIC_PATH')}}/js/app.js" type="text/javascript"></script>
<script src="{{env('PUBLIC_PATH')}}/backend/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{env('PUBLIC_PATH')}}/backend/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="{{env('PUBLIC_PATH')}}/backend/js/sb-admin-2.min.js"></script>
<!-- <script src="{{env('PUBLIC_PATH')}}/backend/vendor/chart.js/Chart.min.js"></script> -->
<!-- <script src="{{env('PUBLIC_PATH')}}/backend/js/demo/chart-area-demo.js"></script> -->
<!-- <script src="{{env('PUBLIC_PATH')}}/backend/js/demo/chart-pie-demo.js"></script> -->
<script src="{{env('PUBLIC_PATH')}}/backend/js/custom.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!-- <script src="{{asset('js/app.js')}}" ></script> -->
<!-- <script src="{{env('PUBLIC_PATH')}}/js/download/dist/jszip.js"></script> -->
