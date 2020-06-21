<div class="overview">
<?php
$operations = isset($GLOBALS["args"]["operations"]) ? $GLOBALS["args"]["operations"] : [];
?>
    <article v-for="(photo, index) in photos" :class="active[index] ? '' : 'removed'">
        <div><a :href="'details.php?id=' + photo.id"><img :src="'/img/medium/' + photo.path" :alt="photo.path" :style="photo.style"></a></div>
        <h3>{{ photo.title }}<?php echo join($operations); ?></h3>
        <p>{{ photo.description }}</p>
    </article>
</div>