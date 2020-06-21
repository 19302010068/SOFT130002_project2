$("form").submit(function(e)
{
    let pw = $("[type=password]");
    if (pw[0].value !== pw[1].value)
    {
        msgbox.setMessage("Passwords do not match");
        e.preventDefault();
    }
});