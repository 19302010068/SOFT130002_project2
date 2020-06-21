let v = new Vue(
    {
        el: "#v-browse-result",
        data: {
            photos: [],},
        methods: {loadResult, fetchResult}
    });

function loadResult()
{
    let [from, to] = data.query;
    fetchResult(from, to);
}

function fetchResult(from, to)
{
    if (to === 0)
        v.photos = [];
    else
    {
        $.getJSON(
            "fetch.php",
            {
                from,
                to,
                columns: ["id", "title", "path"],},
            function(result)
            {
                for (let i = 0; i < result.length; i++)
                {
                    result[i] =
                        {
                            id: result[i][0],
                            title: result[i][1],
                            path: result[i][2],
                            style: "",
                        };
                    let img = new Image();
                    img.src = "/img/medium/" + result[i].path;
                    img.onload = () =>
                    {
                        if (img.width > img.height)
                            v.photos[i].style = "height:200px; margin-left:" + 100 * (1 - img.width / img.height) + "px;";
                        else
                            v.photos[i].style = "width:200px; margin-top:" + 100 * (1 - img.height / img.width) + "px;";
                    };
                }
                v.photos = result;
            }
        );
    }
}