let v = new Vue(
    {
        el: "#v-index-dice",
        data: {
            photos: [],
            active: new Array(8).fill(true),},
        methods: {
            roll: function(){fetch("random.php");},},
    });

function fetch(url)
{
    $.getJSON(
        url,
        null,
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
        }
    );
}

fetch("pop-photos.php");