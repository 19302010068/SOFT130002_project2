let v = new Vue(
    {
        el: "#v-favourites-result",
        data: {
            photos: [],
            active: new Array(8).fill(true),},
        methods: {loadResult, fetchResult, toggleStar},
    });

let starRecord = [];

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
                columns: ["id", "title", "description", "path"],},
            function(result)
            {
                for (let i = 0; i < result.length; i++)
                {
                    result[i] =
                        {
                            id: result[i][0],
                            title: result[i][1],
                            description: result[i][2],
                            path: result[i][3],
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
                if (starRecord[from] === undefined)
                {
                    if (starRecord.length < to)
                        starRecord.length = to;
                    starRecord.fill(true, from, to);
                }
                v.active = starRecord.slice(from, to);
            }
        );
    }
}

function toggleStar(index)
{
    $.post({
        url: "star.php",
        data: {
            img: v.photos[index].id,},
        success: function(result)
        {
            if (result === "success")
            {
                v.$set(v.active, index, !v.active[index]);
                let pos = data.query[0] + index;
                starRecord[pos] = !starRecord[pos];
            }
        },
    });
}

$.post({
    url: "fav-photos.php",
    data: null,
    success: function(result)
    {
        data.query = parseInt(result);
        $(".load-pages").click();
    },
});