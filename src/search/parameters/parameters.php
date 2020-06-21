<section id="v-search-parameters" class="search-parameters">
    <div class="where">
        <div>Search in</div>
        <div>
            <label><input type="radio" name="where" value="title" v-model="where">title</label>
            <label><input type="radio" name="where" value="description" v-model="where">description</label>
        </div>
    </div>
    <div class="what">
        <div>Search for</div>
        <div><label><input type="search" name="what" v-model="what"></label></div>
    </div>
    <input class="action" type="button" value="Search" @click="search">
</section>