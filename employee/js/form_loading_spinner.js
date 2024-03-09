$(document).ready(function () {
    $("#btnSubmit").click(function () {
        // disable button
        $(this).prop("disabled", true);
        // add spinner to button
        $(this).html(
            `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...`
        );
        $("#emailForm").submit();
    });
});