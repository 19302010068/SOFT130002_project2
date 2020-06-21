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
        el: "#v-upload-form",
        data: {
            file: null,
            src: "",
            alt: "",
            id: 0,
            title: "",
            description: "",},
        methods: {updateFile, chooseImage, verify},
    });

function updateFile()
{
    this.file = $("[type=file]")[0].files[0];

    if (this.file !== undefined)
    {
        let reader = new FileReader();
        reader.readAsDataURL(this.file);
        reader.onload = () =>
        {
            v.src = reader.result;
            v.alt = this.file.name;
            resize();
        }
    }
}

function chooseImage()
{
    $("[type=file]").click();
}

function verify(e)
{
    for (const name of ["content", "country", "city"])
    {
        if ($("[name=" + name + "]").val() === "")
        {
            msgbox.setMessage('You did not enter "' + name[0].toUpperCase() + name.substr(1) + '"');
            location.replace("#");
            e.preventDefault();
        }
    }
}

function resize()
{
    let maxWidth = $("form>div").css("width");
    $("form img, form textarea").css("max-width", maxWidth);
}

$(document).ready(() =>
{
    $("#v-select").insertAfter($("#v-upload-form .description"));
    v.file = undefined;
    $(window).resize(resize);

    if ("imageData" in data)
    {
        let d = data.imageData;
        v.file = null;
        v.src = d.path;
        v.alt = d.path;
        v.id = d.id;
        v.title = d.title;
        v.description = d.description;
        data.setSelect(
            {
                content: d.content,
                country: d.country,
                city: d.city,
            });
    }
});
}());

(function ()
{
let v = new Vue(
    {
        el: "#v-select",
        data: {
            content: "",
            country: "",
            city: "",
            cityList: [],
            currentIndex: -1,
            queryIndex_: 0,
            handle_: null},
        methods: {
            getIndex(){return this.queryIndex_++;},},
        watch: {
            country: function(){this.city = "";},
            city: debouncedGetCities,},
    });

function debouncedGetCities()
{
    if (this.handle_ !== null)
        clearTimeout(this.handle_);
    this.handle_ = setTimeout(() =>
    {
        getCities();
        this.handle_ = null;
    }, 500);

    function getCities()
    {
        if (v.cityList.includes(v.city))
            return;

        let index = v.getIndex();
        $.getJSON(
            "cities.php",
            {
                country: v.country,
                city: v.city,},
            function(result)
            {
                if (index > v.currentIndex)
                {
                    v.currentIndex = index;
                    v.cityList = result;
                }
            });
    }
}

if ("search" in data)
    data.search.callbacks.push(self =>
    {
        if (!$(".browse-advanced .action").is(self))
            v.content = v.country = "";
    });

data.setSelect = function(o)
{
    v.content = o.content[0].toUpperCase() + o.content.substr(1);
    v.country = o.country;
    $(document).ready(() =>
    {
        v.city = o.city;
        v.cityList = [v.city];
    });
};
}());