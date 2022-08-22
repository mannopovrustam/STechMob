<x-app-layout xmlns:wire="http://www.w3.org/1999/xhtml">

@section('css')
    <!-- DataTables -->
        <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
              type="text/css"/>
        <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
              type="text/css"/>
        <!-- Responsive datatable examples -->
        <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
              rel="stylesheet" type="text/css"/>
    @endsection

    <x-slot name="header">Mijozlar</x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div class="searching__container">
                                @livewire('search-client')
                            </div>
                        </div>
                    </div>

                    @livewire('client')
                </div>
            </div>
            <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->

    @section('script')

    <!-- Required datatable js -->
        <script src="/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <!-- Responsive examples -->
        <script src="/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

        <!-- Datatable init js -->
        <script src="/assets/js/pages/datatables.init.js"></script>

        {{--<script>--}}
        {{--$(document).ready(function () {--}}
        {{--$("#datatable1").DataTable(), $("#datatable2").DataTable(), $("#datatable3").DataTable(), $("#datatable4").DataTable(), $("#datatable5").DataTable({--}}
        {{--"order": [[0, "desc"]],--}}
        {{--lengthChange: !1,--}}
        {{--buttons: ["copy", "excel", "pdf", "colvis"]--}}
        {{--}).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"), $(".dataTables_length select").addClass("form-select form-select-sm")--}}
        {{--});--}}
        {{--</script>--}}

        <script src="/assets/libs/table-edits/build/table-edits.min.js"></script>

        <script src="/assets/js/pages/table-editable.int.js"></script>

    @endsection

</x-app-layout>

