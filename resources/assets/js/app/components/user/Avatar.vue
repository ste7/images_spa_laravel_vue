<template>
    <div class="avatar-container">
        <div class="justify-content-center align-items-center">
            <div class="avatar-upload-wrap" v-if="user">
                <form method="post" enctype="multipart/form-data">
                    <label for="file-input">
                        <img class="avatar-image" :src="this.path"/>
                        <img v-show="! isDisabledUploader" class="avatar-image2" src="https://www.shareicon.net/data/512x512/2017/05/09/885771_camera_512x512.png"/>
                    </label>

                    <input id="file-input" v-if="! isDisabledUploader" type="file" v-on:change="fileChange" :disabled="isDisabledUploader"/>
                </form>
            </div>

            <i v-show="loading" class="fa fa-spinner fa-spin avatar-spinner"></i>

            <div class="avatar-error" :class="{ 'alert alert-danger': error }">
                <small>{{ error }}</small>
            </div>

            <button class="avatar-save-btn" id="avatar-save-btn" @click.prevent="save" :disabled="isDisabledBtn">Save</button>
            <button class="cancel-cancel-btn" id="upload-cancel-btn" @click.prevent="cancel" :disabled="isDisabledBtn">Cancel</button>

        </div>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'

    export default {
        data() {
            return {
                error: null,

                path: null,
                loading: false,

                isDisabledBtn: true,
                isDisabledUploader: false
            }
        },

        methods: {
            ...mapActions({
                uploadAvatar: 'uploadAvatar',
                saveAvatar: 'saveAvatar',
                cancelUpload: 'cancelAvatarUpload'
            }),

            file(e) {
                let fileData = new FormData();
                fileData.append('avatar', e.target.files[0]);

                return fileData;
            },

            fileChange(e) {
                this.error = null;
                this.uploadAvatar(this.file(e)).then((response) => {
                    this.loading = true;
                    this.path = response.data.path;
                    this.isDisabledBtn = false;
                    this.isDisabledUploader = true;
                    setTimeout(function() {
                            this.loading = false;
                        }.bind(this), 1000);
                }).catch((error) => {
                    this.error = error.response.data.errors.avatar[0];
                });
            },

            save() {
                this.saveAvatar({path: this.path}).then((response) => {
                    this.path = response.data.path;
                    this.isDisabledBtn = true;
                    this.isDisabledUploader = false;
                });
            },

            cancel() {
                this.cancelUpload({path: this.path}).then((response) => {
                    this.path = response.data.path;
                    this.isDisabledBtn = true;
                    this.isDisabledUploader = false;
                })
            }
        },

        computed: {
            ...mapGetters({
                user: 'getUser'
            })
        },

        mounted() {
            if (this.user) {
                this.path = this.user.data.avatar;
            }
        }
    }
</script>


<style>
    .avatar-container {
        border-bottom: 1px solid #eaeaea;
        padding: 10px 0;
        margin-bottom: 10px;
    }
    .avatar-wrap {
        text-align: center;
        height: 260px;
    }


    .align-items-center {
        text-align: center;
    }



    #file-input {
        display: none;
    }

    .avatar-upload-wrap {
        width: 150px;
        border-radius: 50%;
        cursor: pointer;
        position: relative;
        text-align: center;
        margin: auto;
        height: 150px;
    }

    .avatar-image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        cursor: pointer;
        position: absolute;
        margin: 0;
        padding: 0;
        top: 0;
        left: 0;

    }

    .avatar-image2 {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        cursor: pointer;
        position: absolute;
        margin: 0;
        padding: 0;
        top: 0;
        left: 0;
        visibility: hidden;
        opacity: 0.8;
    }

    .avatar-upload-wrap:hover .avatar-image2 {
        visibility: visible;
    }


    .avatar-save-btn, .cancel-cancel-btn {
        cursor: pointer;
        border-radius: 2px;
        color: white;
        border: none;
        padding: 0 15px;
        width: 80px;
    }
    .avatar-save-btn {
        background-color: #4286f4;
    }
    .avatar-save-btn:hover {
        background-color: #2b76ef;
        color: #f2f2f2;
    }

    .cancel-cancel-btn {
        background-color: #e2603f;
    }
    .cancel-cancel-btn:hover {
        background-color: #db4d29;
        color: #f2f2f2;
    }


    .avatar-error {
        width: 400px;
        margin: 10px auto 10px auto;
        padding: 5px;
    }

    .avatar-spinner {
        margin: 10px auto 0 auto;
    }

    .avatar-spinner {
        font-size: 20px;
        color: #db4d29;
    }

    .spinnerActive {
        display: none;
    }
</style>