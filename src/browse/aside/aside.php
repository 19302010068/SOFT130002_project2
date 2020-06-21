<aside id="v-browse-aside" class="browse-aside">
    <span>Filter by ...</span>
    <ul>
        <li>
            <label>
                <span>Title</span><br>
                <input type="search" name="title" v-model="title">
            </label>
            <input class="action" type="button" value="Filter" @click="search('title')">
        </li>
        <li>
            <span>Popular contents</span>
            <input type="button" v-for="content in contents" :value="content" @click="searchPop('content', $event)">
        </li>
        <li>
            <span>Popular countries/regions</span>
            <input type="button" v-for="country in countries" :value="country" @click="searchPop('country', $event)">
        </li>
        <li>
            <span>Popular cities</span>
            <input type="button" v-for="city in cities" :value="city" @click="searchPop('city', $event)">
        </li>
    </ul>
</aside>