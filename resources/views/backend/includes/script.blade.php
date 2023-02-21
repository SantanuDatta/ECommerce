    <script src="{{ asset('backend/lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/lib/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <script src="{{ asset('backend/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('backend/lib/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('backend/lib/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('backend/lib/rickshaw/vendor/d3.min.js') }}"></script>
    <script src="{{ asset('backend/lib/rickshaw/vendor/d3.layout.min.js') }}"></script>
    <script src="{{ asset('backend/lib/rickshaw/rickshaw.min.js') }}"></script>
    <script src="{{ asset('backend/lib/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('backend/lib/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('backend/lib/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
    <script src="{{ asset('backend/lib/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('backend/lib/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('backend/lib/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('backend/lib/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyAq8o5-8Y5pudbJMJtDFzb8aHiWJufa5fg"></script>
    <script src="{{ asset('bakend/lib/gmaps/gmaps.min.js') }}"></script>

    <script src="{{ asset('backend/js/bracket.js') }}"></script>
    <script src="{{ asset('backend/js/map.shiftworker.js') }}"></script>
    <script src="{{ asset('backend/js/ResizeSensor.js') }}"></script>
    <script src="{{ asset('backend/js/dashboard.dark.js') }}"></script>

    {{-- Ck Editor --}}
    <script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('short_desc', {
            height: '6em',
            enterMode: CKEDITOR.ENTER_BR,
            shiftEnterMode: CKEDITOR.ENTER_P
        });

        CKEDITOR.replace('long_desc', {
            height: '25em',
            enterMode: CKEDITOR.ENTER_BR,
            shiftEnterMode: CKEDITOR.ENTER_P
        });

        CKEDITOR.replace('add_info', {
            height: '25em',
            enterMode: CKEDITOR.ENTER_BR,
            shiftEnterMode: CKEDITOR.ENTER_P
        });


        // Datepicker
        $('.fc-datepicker').datepicker({
            showOtherMonths: true,
            selectOtherMonths: true
        });
    </script>

    {{-- Data Table --}}
    <script src="{{ asset('backend/lib/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/lib/datatables.net-dt/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/lib/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript">
        $('#data').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });
        // Select2
        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity
        });
    </script>

    {{-- Toastr --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="text/javascript">
        var jq = jQuery.noConflict();
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";

            switch (type) {
                case 'info':
                    toastr.info("{{ Session::get('message') }}");
                    break;
                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                    break;
                case 'warning':
                    toastr.warning("{{ Session::get('message') }}");
                    break;
                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                    break;
            }
        @endif
    </script>

    <script type="text/javascript">
        $(function() {

            'use strict';

            $('.inputfile').each(function() {
                var $input = $(this),
                    $label = $input.next('label'),
                    labelVal = $label.html();

                $input.on('change', function(e) {
                    var fileName = '';

                    if (this.files && this.files.length > 1)
                        fileName = (this.getAttribute('data-multiple-caption') || '').replace(
                            '{count}', this.files.length);
                    else if (e.target.value)
                        fileName = e.target.value.split('\\').pop();

                    if (fileName)
                        $label.find('span').html(fileName);
                    else
                        $label.html(labelVal);
                });

                // Firefox bug fix
                $input
                    .on('focus', function() {
                        $input.addClass('has-focus');
                    })
                    .on('blur', function() {
                        $input.removeClass('has-focus');
                    });
            });

        });
    </script>
