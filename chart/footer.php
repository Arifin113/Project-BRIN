<footer class="main-footer">
    <strong>Copyright &copy <?= date('Y') ?> Muhammad Zaenal Arifin .</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.2.0
    </div>
</footer>

<aside class="control-sidebar control-sidebar-dark">
</aside>

</div>

<!-- Perbaikan path untuk file JavaScript -->
<script src="/assets-template/plugins/jquery/jquery.min.js"></script>
<script src="/assets-template/plugins/jquery-ui/jquery-ui.min.js"></script>

<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>

<script src="/assets-template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets-template/plugins/chart.js/Chart.min.js"></script>
<script src="/assets-template/plugins/sparklines/sparkline.js"></script>
<script src="/assets-template/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="/assets-template/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="/assets-template/plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="/assets-template/plugins/moment/moment.min.js"></script>
<script src="/assets-template/plugins/daterangepicker/daterangepicker.js"></script>
<script src="/assets-template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="/assets-template/plugins/summernote/summernote-bs4.min.js"></script>
<script src="/assets-template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="/assets-template/dist/js/adminlte.js?v=3.2.0"></script>
<script src="/assets-template/dist/js/pages/dashboard.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- DataTables JavaScript -->
<!-- <script src="/assets-template/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/assets-template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/assets-template/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/assets-template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/assets-template/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/assets-template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi DataTables setelah dokumen selesai dimuat
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true, // Memastikan fitur sorting diaktifkan
            "info": true,
            "autoWidth": false,
            "responsive": true
        });
    });
</script> -->


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- asset plugin datatables -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.7/js/dataTables.bootstrap5.js"></script>

<script>
    $(document).ready(function() {
        $('#table').DataTable({
            "order": [
                [0, 'asc']
            ], // Default sort by "No" column (id)
            "columnDefs": [{
                    "targets": 0,
                    "orderable": false // Kolom "No" tidak bisa diurutkan
                },
                {
                    "targets": 1,
                    "orderable": true // Kolom "Nama" tetap bisa diurutkan
                },
                {
                    "targets": 2,
                    "orderable": true // Kolom "Username" tetap bisa diurutkan
                }
            ]
        });
    });
</script>

</body>

</html>