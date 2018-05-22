<template>
    <div class="favorites-container container-fluid" v-if="images">

        <div class="flexbin flexbin-margin" v-if="images.length > 0">
            <photo v-for="(i, index) in images"
                 :key="i.images.id"
                 :imagepath="i.images.path"
                 :userAvatar="i.images.user.avatar"
                 :userName="i.images.user.name"
                 :like="like.bind(this, i.images.id)"
                 :didILike="didILike(i.id, index)"
                 :open="open.bind(this, i.images.path)">
            </photo>
        </div>

        <div class="alert alert-primary" role="alert" v-else-if="images && images.length < 1">
            You don't have any favorite image yet!
        </div>

        <image-modal></image-modal>

    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'
    import bus from './../../bus'

    export default {
        computed: {
            ...mapGetters({
                images: 'getFavorites',
                authenticated: 'authenticated'
            })
        },
        methods: {
            ...mapActions({
                getFavorites: 'getFavorites',
                deleteFavorite: 'deleteFavorite'
            }),

            didILike(id, index) {
                return 'fas fa-heart';
            },

            like(id) {
                this.deleteFavorite(id).then(() => {
                    this.getFavorites();
                }).catch((error) => {
                    alert(error.response.data.message);
                });
            },

            open(path) {
                bus.$emit('open-image', path);
                this.path = path;
            }
        },

        created() {
             this.getFavorites();
        }
    }
</script>

<style>
    .alert-primary {
        width: 400px;
        margin: 0 auto;
        text-align: center;
    }
</style>