<div class="upload-form form">
<?php req("components/select"); ?>

    <form id="v-upload-form" method="post" action="photo-auth.php" enctype="multipart/form-data" @submit="verify($event)">
        <input type="hidden" name="id" v-model="id">
        <div>
            <input type="file" accept="image/*" @change="updateFile" name="file">
            <input class="action" type="button" value="Choose a photo" @click="chooseImage">
        </div>
        <div v-show="file !== undefined">
            <img :src="src" :alt="alt">
            <hr>
            <label>
                <span>Title</span>
                <input type="text" name="title" required v-model="title">
            </label>
            <label class="description">
                <span>Description</span>
                <textarea name="description" required v-model="description"></textarea>
            </label>
            <!-- .select -->
            <div>
                <span></span>
                <input class="action" type="submit" value="Upload">
            </div>
        </div>
    </form>
</div>