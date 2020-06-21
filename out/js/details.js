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
        el: "#v-details-main",
        data: {
            starred: data.starred,},
        methods: {toggleStar},
    });

function toggleStar()
{
    if (!data.logged)
    {
        msgbox.setMessage("You must log in to access this feature");
        location.replace("#");
    }

    $.post({
        url: "star.php",
        data: {
            img: document.URL.match(/[?&]id=(\d+)([&#]|$)/)[1],},
        success: function(result)
        {
            if (result === "success")
            {
                let stars = $("button span");
                stars.text((Number)(stars.text()) + (v.starred ? -1 : 1));
                v.starred = !v.starred;
            }
        },
    });
}

document.title = $("h2").text();
}());