<script src="../../node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
<script src="../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../../node_modules/jquery/dist/jquery.min.js"></script>
<script src="../../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="../../node_modules/datatables.net/js/jquery.dataTables.js"></script>
<script>
    <?php
    if (Session::hasSession('success')) {
    ?>
        Swal.fire(
            'Success',
            `<?= Session::getSuccess() ?>`,
            'success'
        )
    <?php
    } else if (Session::hasSession('error')) {
    ?>
        Swal.fire(
            'Error',
            `<?= Session::getError() ?>`,
            'error'
        )
    <?php
    }
    ?>
</script>