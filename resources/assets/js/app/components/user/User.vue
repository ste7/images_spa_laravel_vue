<template>
    <div class="user-container">

        <avatar></avatar>

        <div class="container-fluid">

            <div class="row justify-content-center align-items-center user-pills">
                <ul class="nav nav-pills" role="tablist">
                    <li><a @click.prevent="openAlbum" class="open-album-btn" :class="{ active: isAlbum }">Album</a></li>
                    <li><a @click.prevent="openLikes" class="open-likes-btn" :class="{ active: isLikes }">Favorites</a></li>
                    <li><a @click.prevent="openUpload" class="open-upload-btn" :class="{ active: isUpload }">Upload</a></li>
                </ul>
            </div>

            <div class="row content-wrap">
                <div class="user-content col-12" :class="{ 'active-content': isAlbum, inactive: !isAlbum }">
                    <album></album>
                </div>

                <div class="col-12" :class="{ 'active-content': isLikes, inactive: !isLikes }">
                    <favorites></favorites>
                </div>

                <div class="col-12" :class="{ 'active-content': isUpload, inactive: !isUpload }">
                    <upload></upload>
                </div>
            </div>


        </div>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'

    export default {
        data() {
            return {
                uploaded: true,

                isAlbum: true,
                isLikes: false,
                isUpload: false
            }
        },

        computed: {
            ...mapGetters({
                uploadedAvatar: 'getUploadedAvatar',
                uploadedImage: 'getUploadedImage'
            })
        },

        methods: {
            ...mapActions({
                cancelAvatarUpload: 'cancelAvatarUpload',
                cancelUploadedImage: 'cancelUploadedImage'
            }),

            openAlbum() {
                this.isAlbum = true;
                this.isLikes = false;
                this.isUpload = false;
            },

            openLikes() {
                this.isLikes = true;
                this.isAlbum = false;
                this.isUpload = false;
            },

            openUpload() {
                this.isLikes = false;
                this.isAlbum = false;
                this.isUpload = true;
            }
        },

        beforeRouteLeave (to, from, next) {
            if (this.uploadedAvatar.uploaded || this.uploadedImage.uploaded) {
                const answer = window.confirm('Do you really want to leave? you have unsaved changes!')
                if (answer && this.uploadedAvatar.uploaded) {
                    this.cancelAvatarUpload({path: this.uploadedAvatar.path});
                    next()
                } if (answer && this.uploadedImage.uploaded) {
                    this.cancelUploadedImage({path: this.uploadedImage.path})
                    next()
                } else {
                    next(false)
                }
            } else {
                next()
            }
        }
    }
</script>


<style>
    .active {
        border-bottom: 2px solid #818284;
        color: #387eed!important;
    }

    .active-content {
        display: block;
    }

    .inactive {
        display: none;
    }

    .open-album-btn, .open-likes-btn, .open-upload-btn {
        cursor: pointer;
        color: #585959;
        padding: 5px;
        margin: 5px;
        font-size: 18px;
    }

    .user-pills {
        margin-bottom: 30px!important;
    }

    .content-wrap {
        margin: 0 10px
    }

</style>