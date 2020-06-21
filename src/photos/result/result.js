let v = new Vue(
    {
        el: "#v-photos-result",
        data: {
            author: "",
            photos: [],
            active: new Array(8).fill(true),},
        computed: {
            isAuthor: function(){return data.logged === this.author;},},
        methods: {loadResult, fetchResult, edit, del},
    });

v.author = document.URL.match(/.*[?&]name=(.*)([&#]|$)/);
v.author = v.author ? v.author[1] : data.logged;

let recycleRecord = [];

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
                if (recycleRecord[from] === undefined)
                {
                    if (recycleRecord.length < to)
                        recycleRecord.length = to;
                    recycleRecord.fill(true, from, to);
                }
                v.active = recycleRecord.slice(from, to);
            }
        );
    }
}

function edit(index)
{
    location.assign("upload.php?id=" + v.photos[index].id);
}

function del(index)
{
    if (confirm("Are you sure you want to delete the photo?\r\nThis operation is NOT reversible."))
    {
        $.post({
            url: "photo-auth.php",
            data: {
                id: v.photos[index].id,},
            success: function(result)
            {
                if (result === "success")
                {
                    v.$set(v.active, index, false);
                    recycleRecord[data.query[0] + index] = false;
                }
            },
        });
    }
}

$.post({
    url: "user-photos.php",
    data: {
        name: v.author},
    success: function(result)
    {
        let h2 = $("h2");
        if (v.isAuthor)
            h2.text("My photos");
        else
            h2.text(v.author + (v.author.endsWith("s") ? "' photos" : "'s photos"));

        data.query = parseInt(result);
        $(".load-pages").click();
    },
});