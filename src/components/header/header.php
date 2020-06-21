<header id="v-header" class="header">
<?php
$title = isset($GLOBALS["args"][0]) ? $GLOBALS["args"][0] : "";
?>
    <div class="info">
        <div v-if="logged">Logged in as <strong>{{ logged }}</strong></div>
        <div><time>{{ time }}</time></div>
    </div>
    <h1>Share Your Travels</h1>
    <nav>
        <ul class="site">
<?php
$items = [
    ["/", "Home"],
    ["browse", "Browse"],
    ["search", "Search"]];
foreach ($items as $item)
{
    if ($item[0] === $title)
    {
        echo <<< HTML
            <li><strong>$item[1]</strong></li>

HTML;
    }
    else
    {
        if ($item[0] !== "/")
            $item[0] .= ".php";
        echo <<< HTML
            <template></template>
            <li><a href="$item[0]">$item[1]</a></li>

HTML;
    }
}
?>
            <li v-if="!(logged || excluded)"><a :href="location">Login</a></li>
            <li v-if="excluded"><strong>Login</strong></li>
        </ul>
        <div class="user" v-if="logged">
            <span>Me</span>
            <ul>
<?php
$items = [
    ["upload", "Upload"],
    ["photos", "My photos"],
    ["favourites", "Favourites"],
    ["logout", "Log out"]];
foreach ($items as $item)
{
    echo <<< HTML
                <li><a href="$item[0].php">$item[1]</a></li>

HTML;
}
?>
            </ul>
        </div>
    </nav>
</header>