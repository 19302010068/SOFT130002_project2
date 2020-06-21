let v = new Vue(
    {
        el: "#v-browse-aside",
        data: {
            contents: [],
            countries: [],
            cities: [],
            title: "",
            content: "",
            country: "",
            city: "",},
        methods: {search, searchPop},
    });

function search(...columns)
{
    data.search.init(columns.includes("title") ? $(".browse-aside .action") : null);
    $.post({
        url: "query.php",
        data: {
            db: "travelimage",
            columns: columns,
            data: columns.map(key => v[key]),},
        success: function(result)
        {
            data.query = parseInt(result);
            $(".load-pages").click();
        },
    });
}

function searchPop(column, e)
{
    this[column] = e.target.value;
    search(column);
}

data.search.callbacks.push(self =>
{
    if (!$(".browse-aside .action").is(self))
        v.title = "";
});

v.contents = ["Scenery", "City", "People", "Animal"];
$.getJSON(
    "pop-countries.php",
    null,
    function(result){v.countries = result});
v.cities= ["Firenze", "Roma", "London", "Berlin"];