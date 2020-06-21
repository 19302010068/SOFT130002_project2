<div id="v-photos-result" class="photos-result">
    <div class="load-result" style="display:none" @click="loadResult"></div>
    <template v-if="photos.length === 0">
        <p>No photos yet</p>
        <p><a href="upload.php">Upload your first photo now!</a></p>
    </template>
<?php
$GLOBALS["args"]["operations"] = [
    "<input type='image' src='/img/icons/60.png' alt='Edit' v-if='isAuthor && active[index]' @click='edit(index)'>",
    "<input type='image' src='/img/icons/19.png' alt='Delete' v-if='isAuthor && active[index]' @click='del(index)'>"];
req("components/overview");
?>

</div>