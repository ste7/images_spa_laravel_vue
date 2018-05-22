<template>
    <div class="album-wrap justify-content-center align-items-center">

        <div v-if="images">
            <div v-if="images.length">
                <div v-if="images && images.length" class="album-image-wrap" v-for="i in images">
                    <img class="album-image" :src="i.path"/>
                    <i @click.prevent="deleteImage(i.id)" class="fas fa-trash fa-2x trash-icon"></i>
                </div>
            </div>

            <div class="alert alert-primary" role="alert" v-else-if="images.length < 1">
                You don't have any image yet!
            </div>
        </div>
    </div>
</template>


<script>
    import { mapActions, mapGetters } from 'vuex'

    export default {
        computed: {
            ...mapGetters({
                images: 'getImages',
                user: 'getUser'
            })
        },

        methods: {
            ...mapActions({
                getAlbum: 'getAlbum',
                deleteImage: 'deleteImage'
            })
        },

        mounted() {
             this.getAlbum();
        }
    }
</script>


<style>
    .album-wrap {
        width: 100%;
    }
    .align-items-center {
        text-align: center;
    }

    .alert-primary {
        width: 400px;
        margin: 0 auto;
        text-align: center;
    }

    .album-image-wrap {
        display: inline-block;
        margin: 5px;
        float: left;
    }

    .album-image {
        position: relative;
        width: 200px;
        height: 200px;
        object-fit: cover;
        transition: 0.3s opacity;
    }

    .album-image:hover {
        opacity: 0.6;
    }

    .album-image:hover + .trash-icon, .trash-icon:hover {
        opacity: 1;
    }

    .trash-icon {
        margin-left: -110px;
        color: #d14732;
        position: relative;
        cursor: pointer;
        z-index: 1;
        opacity: 0;
        transition: 0.3s opacity;
    }

    .trash-icon:hover {
        color: white;
    }
</style>