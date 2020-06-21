<section id="v-search-result" class="search-result">
    <div class="load-result" style="display:none" @click="loadResult"></div>
    <p v-if="photos.length === 0">No result found</p>
<?php req("components/overview"); ?>

</section>