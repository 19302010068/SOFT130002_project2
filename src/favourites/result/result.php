<div id="v-favourites-result" class="favourites-result">
    <div class="load-result" style="display:none" @click="loadResult"></div>
    <p v-if="photos.length === 0">No photos yet</p>
<?php
$GLOBALS["args"]["operations"] = [
    "<input type='image' src='/img/icons/5.png' alt='Starred' v-if='active[index]' @click='toggleStar(index)'>",
    "<input type='image' src='/img/icons/6.png' alt='Unstarred' v-if='!active[index]' @click='toggleStar(index)'>"];
req("components/overview");
?>

</div>