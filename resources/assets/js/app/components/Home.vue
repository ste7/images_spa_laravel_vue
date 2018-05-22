<template>
    <div class="home-container container-fluid">

        <div class="flexbin flexbin-margin" v-if="images">
            <photo v-if="images.length" v-for="(i, index) in images"
                 :key="i.id"
                 :imagepath="i.path"
                 :userAvatar="i.user.avatar"
                 :userName="i.user.name"
                 :like="like.bind(this, i.id)"
                 :didILike="didILike(i.id, index)"
                 :open="open.bind(this, i.path)">
            </photo>
        </div>

        <image-modal></image-modal>

    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'
    import bus from './../bus'

    export default {
        data() {
            return {
                path: null
            }
        },

        computed: {
            ...mapGetters({
                images: 'getImages',
                authenticated: 'authenticated',
                user: 'getUser'
            })
        },
        methods: {
            ...mapActions({
                getImages: 'getImages',
                likeImage: 'likeImage'
            }),

            didILike(id, index) {
                if (this.authenticated) {
                    let myLike = this.images[index].likes.find(l => l.user_id == this.user.data.id);

                     if (myLike) return 'fas fa-heart';
                     else return 'far fa-heart';
                } else {
                    return 'far fa-heart';
                }
            },

            like(id) {
                if (this.authenticated) {
                    this.likeImage(id).catch((error) => {
                         alert(error.response.data.message);
                    });
                } else {
                    document.getElementById('login').style.display = 'block';
                }
            },

            open(path) {
                bus.$emit('open-image', path);
                this.path = path;
            }
        },

        created() {
            this.getImages()
        }
    }
</script>

<style>
    #basicExample2 {
        position: relative;
    }

    .okvir {
        position: absolute;
        height: 50px;
        width: 100%;
        bottom: 0;
        left: 0;
        transition-duration: 0.2s;
        transition-delay: 0.2s; /* delays for 1 second */
    }

    #basicExample2:hover  .okvir {
        -webkit-box-shadow: inset 0px -53px 149px -53px rgba(0,0,0,1);
        -moz-box-shadow: inset 0px -53px 149px -53px rgba(0,0,0,1);
        box-shadow: inset 0px -53px 149px -53px rgba(0,0,0,1);
    }
</style>