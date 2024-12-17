<script src="js/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="js/dataTables.bootstrap5.min.js"></script>
<!-- <script>
    $(document).ready( function () {
        $('#myDataTable').DataTable();
    } );
</script>

<script src="js/scripts.js"></script>

    <!-- Summer note JS - CDN Link -->
<!-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#summernote").summernote({
                placeholder: 'Type Your Description',
                height: 300,
            });
            $('.dropdown-toggle').dropdown();
        });
    </script> --> -->
<!-- //Summer note JS - CDN Link -->

<script>
    document.getElementById("sidebarToggle").addEventListener("click", function() {
        const sidebar = document.getElementById("layoutSidenav_nav");
        const content = document.getElementById("layoutSidenav_content");
        sidebar.classList.toggle("toggled");
        content.classList.toggle("toggled");
    });
</script>
</body>

</html>