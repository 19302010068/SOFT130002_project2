(function ()
{
let loc = document.URL.match(/.*\/(.*)/)[1].replace("?", "&");
let nowhere = ["", "register.php"];
let excluded = ["login.php"];
let now = new Date().toUTCString().match(/^(\w+, \w+ \w+ \w+)( \w+:\w+)/);

let v = new Vue({
    el: "#v-header",
    data: {
        logged: data.logged,
        location: "login.php" + (nowhere.includes(loc) ? "" : "?from=" + loc),
        excluded: excluded.includes(loc),
        time: now[1] + "," + now[2]},
});
}());

(function ()
{
window.msgbox = new Vue({
    el: "#v-msgbox",
    data: {message: ""},
    methods: {
        setMessage(msg)
        {
            this.message = msg;
            setTimeout(() => msgbox.message = "", 5000);
        },},
});
}());

(function ()
{
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
}());