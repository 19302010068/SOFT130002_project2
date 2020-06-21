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