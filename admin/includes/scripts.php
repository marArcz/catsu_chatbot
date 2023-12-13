<script src="../../node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
<script src="../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- <script src="../../node_modules/jquery/dist/jquery.min.js"></script> -->
<script src="
https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.min.js
"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

    $("#menu-toggler").on("click", function(e) {
        $("#sidebar").toggleClass("closed")
        $("#main").toggleClass("expanded")
        $("#sidebar-overlay").toggleClass("show")

        if ($("#sidebar").hasClass("closed")) {
            console.log('closed')
            $.post("../app/add_session.php",{key:'closed_sidebar',value:true},(res) => {
                console.log(res)
            });
        }else{
            $.post("../app/remove_session.php",{key:'closed_sidebar'},(res) => {
                console.log(res)
            });
        }
    })

    $("#sidebar-overlay").on('click', function(e) {
        $("#sidebar").toggleClass("closed")
        $("#main").toggleClass("expanded")
        $("#sidebar-overlay").toggleClass("show")

        if ($("#sidebar").hasClass("closed")) {
            console.log('closed')
            $.post("../app/add_session.php",{key:'closed_sidebar',value:true},(res) => {
                console.log(res)
            });
        }else{
            $.post("../app/remove_session.php",{key:'closed_sidebar'},(res) => {
                console.log(res)
            });
        }
    })
</script>