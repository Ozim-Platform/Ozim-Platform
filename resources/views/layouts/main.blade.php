<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="/images/favicon.ico">

    <title>Ozim @yield('title')</title>

    <!-- Vendors Style-->
    <link rel="stylesheet" href="/css/vendors_css.css">

    <!-- Style-->
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/skin_color.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

</head>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary fixed">

    <div class="wrapper">

        @include('partials.nav')

        @include('partials.menu')

        <div class="content-wrapper">
            <div class="container-full">
                @yield('content')
            </div>
        </div>

        @include('partials.footer')

    </div>

    <div class="modal modal-info fade" role="dialog" id="modal-message">
        <div class="modal-dialog">
            <div class="modal-content bg-info">
                <div class="modal-header">
                    <h4 class="modal-title">Подождите пожалуйста</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Удаление записи&hellip;</p>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal modal-danger fade" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Удаление</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Вы действительно хотите удалить?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-danger" data-dismiss="modal">Нет</button>

                    <button type="button" class="btn btn-rounded btn-info float-right" id="deleteOrder" data-dismiss="modal"
                        data-toggle="modal" data-target="#modal-message">Да</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <script>
        function destroyProduct(productID, url) {
            console.log(productID);
            $("#deleteOrder").click(function() {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "DELETE",
                    url: url,
                    // data:  { productID: productID },
                    success: function( data ) {
                    }
                }).done(function(responseData) {
                    location.reload();
                }).fail(function() {
                    console.log('Failed');
                });
            });
        }
    </script>

    <!-- Vendor JS -->
    <script src="/js/vendors.min.js"></script>
    <script src="/assets/icons/feather-icons/feather.min.js"></script>
    <script src="/assets/vendor_components/easypiechart/dist/jquery.easypiechart.js"></script>
    <script src="/assets/vendor_components/apexcharts-bundle/irregular-data-series.js"></script>
    <script src="/assets/vendor_components/datatable/datatables.min.js"></script>
    <script src="/js/pages/data-table.js"></script>
    <script src="/js/pages/advanced-form-element.js"></script>
    <script src="/assets/vendor_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
    <script src="/assets/vendor_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.js"></script>
    <script src="/assets/vendor_components/select2/dist/js/select2.full.js"></script>
    <script src="/assets/vendor_plugins/input-mask/jquery.inputmask.js"></script>
    <script src="/assets/vendor_plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="/assets/vendor_plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <script src="/assets/vendor_components/moment/min/moment.min.js"></script>
    <script src="/assets/vendor_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="/assets/vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="/assets/vendor_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
    <script src="/assets/vendor_plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="/assets/vendor_plugins/iCheck/icheck.min.js"></script>
    <script src="/assets/vendor_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.js"></script>
    <script src="/assets/vendor_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    @stack('footer_scripts')

    <script src="/assets/vendor_components/apexcharts-bundle/dist/apexcharts.js"></script>

    <!-- Sunny Admin App -->
    <script src="/js/template.js"></script>
    <script src="/js/form.js"></script>
    <script>
        $(document).ready(function() {
            $('#tiny').summernote({
                height: 200
            });
        });
    </script>
    {{--<script src="/js/pages/dashboard.js"></script>--}}


</body>
</html>

