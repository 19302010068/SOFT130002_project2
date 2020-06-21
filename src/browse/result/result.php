<section id="v-browse-result" class="browse-result">
    <div class="load-result" style="display:none" @click="loadResult"></div>
    <p v-if="photos.length === 0">No result found</p>
<?php req("browse/crop") ?>

</section>