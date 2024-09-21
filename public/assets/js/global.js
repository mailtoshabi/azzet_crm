$(document).ready(function() {

    $(document).on('click','[data-plugin="delete-data"]',function(e) {
		e.preventDefault();
        var targetForm = $(this).data('target-form');
        if (!confirm('Are you sure you want to delete?')) return;
        e.preventDefault();
        $(targetForm).submit();
	});

    $(document).on('click','[data-plugin="submit-form"]',function(e) {
		e.preventDefault();
        var targetForm = $(this).data('target-form');
        var confMessage = $(this).data('conf');
        if (!confirm(confMessage)) return;
        e.preventDefault();
        $(targetForm).submit();
	});

    table_min_height();

});


function goLink(url) {
    location.href = url
}

function refreshPage() {
    location.reload();
}

function goBack() {
    window.history.back();
}

function table_min_height() {
    $("div.table-responsive").addClass("table_min_height");
}

