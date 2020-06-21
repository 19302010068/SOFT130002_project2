let v = new Vue(
    {
        el: "#v-search-parameters",
        data: {
            where: "title",
            what: "",},
        methods: {search},
    });

function search()
{
    let columns = ["where", "what"];
    $.post({
        url: "query.php",
        data: {
            db: "travelimage",
            columns,
            data: columns.map(key => v[key]),},
        success: function(result)
        {
            data.query = parseInt(result);
            $(".load-pages").click();
        },
    });
}