<script src="{{ asset('assets/backend') }}/libs/jquery/jquery.min.js"></script>
<script src="{{ asset('assets/backend') }}/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/backend') }}/libs/metismenu/metisMenu.min.js"></script>
<script src="{{ asset('assets/backend') }}/libs/simplebar/simplebar.min.js"></script>
<script src="{{ asset('assets/backend') }}/libs/node-waves/waves.min.js"></script>
<!-- apexcharts -->
<script src="{{ asset('assets/backend') }}/libs/apexcharts/apexcharts.min.js"></script>
<!-- dashboard init -->
<script src="{{ asset('assets/backend') }}/js/pages/dashboard.init.js"></script>
<!-- App js -->
<script src="{{ asset('assets/backend') }}/js/app.js"></script>
<!-- Required datatable js -->
<script src="{{ asset('assets/backend') }}/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets/backend') }}/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="{{ asset('assets/backend') }}/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('assets/backend') }}/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('assets/backend') }}/libs/jszip/jszip.min.js"></script>
<script src="{{ asset('assets/backend') }}/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="{{ asset('assets/backend') }}/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="{{ asset('assets/backend') }}/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('assets/backend') }}/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('assets/backend') }}/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<!-- Responsive examples -->
<script src="{{ asset('assets/backend') }}/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('assets/backend') }}/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js">
</script>
<!-- Datatable init js -->
<script src="{{ asset('assets/backend') }}/js/pages/datatables.init.js"></script>
<!-- sweetalert2-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- select2 js -->
<script src="{{ asset('assets/backend') }}/libs/select2/js/select2.min.js"></script>
<!-- Logout confirmation-->
<script>
    $(document).ready(function() {
        $('#logout').on('submit', function(event) {
            event.preventDefault();
            var link = $(this).attr('href')
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, logout!"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>


@stack('script')
