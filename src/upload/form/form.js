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