<nav id="v-pages" class="pages" v-show="pages > 1">
    <div class="load-pages" style="display:none" @click="loadPages"></div>
    <div class="numbers">
        <template v-for="number in numbers">
            <input type="button" v-if="number" :class="(number === current) ? 'current' : ''" :value="number" @click="fetchPage($event)">
            <span v-else>...</span>
        </template>
    </div>
    <div class="operations">
        <input type="button" value="&lt; Prev" @click="fetchPage(current - 1)">
        <input type="button" value="Next &gt;" @click="fetchPage(current + 1)">
        <label>
            <span>Go to page:</span>
            <input type="number" v-model.number="toPage" :min="1" :max="pages">
            <input type="button" value="Go" @click="fetchPage(toPage)">
        </label>
    </div>
</nav>