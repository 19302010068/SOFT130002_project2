$(".browse-advanced .action").click(e =>
{
    data.search.init(e.target);
    let columns = ["content", "country", "city"];
    $.post({
        url: "query.php",
        data: {
            db: "travelimage",
            columns,
            data: columns.map(item => $("[name=" + item + "]").val()),},
        success: function(result)
        {
            data.query = parseInt(result);
            $(".load-pages").click();
        },
    });
});