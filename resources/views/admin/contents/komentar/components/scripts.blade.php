<script>
    $("input[type='checkbox']").change(function (e) { 
        e.preventDefault();
        let data = $(this).data('link');
        if (data) {
            $.ajax({
                type: "GET",
                url: `/api/change_status/`+data,
                dataType: "JSON",
                success: function (response) {
                }
            });
        }
    });
</script>