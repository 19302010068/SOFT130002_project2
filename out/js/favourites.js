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
}());

(function ()
{
const NUM_PER_PAGE = 8;

let v = new Vue(
    {
        el: "#v-pages",
        data: {
            pages: 1,
            current: 1,
            toPage: 1,},
        computed: {numbers},
        methods: {loadPages, fetchPage},
    });

function numbers()
{
    if (this.pages === 1)
        return [1];

    let result = [1, this.pages];
    for (let i = this.current - 2; i <= this.current + 2; i++)
        result.push(i);
    result = Array.from(new Set(result));
    result.sort((a, b) => a - b);
    let start = result.indexOf(1);
    let end = result.lastIndexOf(this.pages);
    result = result.slice(start, end + 1);

    if (result[1] - result[0] > 1)
    {
        result.unshift(null);
        result[0] = result[1];
        result[1] = null;
    }
    if (result[result.length - 1] - result[result.length - 2] > 1)
    {
        result[result.length] = result[result.length - 1];
        result[result.length - 2] = null;
    }
    return result;
}

function loadPages()
{
    this.current = 1;
    this.toPage = 1;

    let pages = Math.ceil(data.query / NUM_PER_PAGE);
    if (pages === 0)
    {
        this.pages = 1;
        data.query = [0, 0];
        $(".load-result").click();
    }
    else
    {
        this.pages = pages;
        fetchPage(1, true);
    }
}

function fetchPage(page, force=false)
{
    if (typeof page === "object")
        page = (Number)(page.target.value);
    if ((page < 1 || page > this.pages || page !== Math.floor(page) || page === this.current) && !force)
        return;

    this.current = page;
    data.query = [(page - 1) * NUM_PER_PAGE, page * NUM_PER_PAGE];
    $(".load-result").click();
}
}());