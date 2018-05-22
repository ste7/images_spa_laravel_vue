<template>
    <div class="upload-container">
        <div class="justify-content-center align-items-center">

            <div class="upload-wrap">

                <form method="post" enctype="multipart/form-data">
                    <label for="image-input">
                        <div class="upload-image">

                            <i v-show="uploadIcon" class="fas fa-upload fa-3x upload-icon"></i>
                            <i v-show="loading" class="fa fa-spinner fa-spin fa-2x image-spinner"></i>

                            <img class="image" :src="path"/>
                        </div>
                    </label>

                    <input id="image-input" v-if="! isDisabledUploader" type="file" @change="fileChange" :disabled="isDisabledUploader"/>
                    <input id="tags" v-model="tags" type="text" name="tags" @keydown.enter.prevent="preventSubmit" placeholder="Enter 2/15 tags separated by comma, eg: abstract, art">

                </form>
            </div>

            <button class="upload-save-btn" id="upload-save-btn" @click.prevent="save" :disabled="isDisabled">Save</button>
            <button class="cancel-image-btn" id="upload-cancel-btn" @click.prevent="cancel" :disabled="isDisabled">Cancel</button>

            <div class="error" :class="{ 'alert alert-danger': error }">
                <small>{{ error }}</small>
            </div>
        </div>
    </div>
</template>


<script>
    import { mapActions, mapGetters } from 'vuex'

    export default {
        data() {
            return {
                path: null,
                tags: null,
                error: null,

                loading: false,
                uploadIcon: true,
                isDisabled: true,
                isDisabledUploader: false
            }
        },

        computed: {
            ...mapGetters({
                uploadedImage: 'getUploadedImage'
            })
        },

        methods: {
            ...mapActions({
                uploadImage: 'uploadImage',
                saveImage: 'saveImage',
                cancelUploadedImage: 'cancelUploadedImage'
            }),

            fileDelete() {
                let fileData = new FormData();

                fileData.delete('image');
            },

            file(e) {
                let fileData = new FormData();
                fileData.append('image', e.target.files[0]);

                return fileData;
            },

            fileChange(e) {
                this.error = null;
                this.uploadIcon = false;
                this.loading = true;

                this.uploadImage(this.file(e)).then((response) => {
                    this.loading = false;
                    this.isDisabled = false;
                    this.isDisabledUploader = true;
                    this.path = response.data.path;
                }).catch((error) => {
                    this.error = error.response.data.errors.image[0];
                    this.loading = false;
                    this.uploadIcon = true;
                });
            },

            save() {
                let array = [];

                if (this.tags) {
                    let replace = this.tags.replace(/ /g,'');
                    array = replace.split(",");
                }

                this.saveImage({path: this.path, tags: array}).then(() => {
                    this.path = null;
                    this.uploadIcon = true;
                    this.isDisabled = true;
                    this.isDisabledUploader = false;
                    this.error = null;
                    this.tags = null;
                }).catch((error) => {
                    this.error = error.response.data.errors.tags[0];
                });
            },

            cancel() {
                this.uploadReady = false;
                this.$nextTick(() => {
                    this.uploadReady = true;
                })
                this.cancelUploadedImage({path: this.uploadedImage.path}).then(() => {
                    this.path = null;
                    this.uploadIcon = true;
                    this.isDisabled = true;
                    this.isDisabledUploader = false;
                });
            },

            preventSubmit(e) {
                e.preventDefault();
            }
        }
    }
</script>


<style>
    .align-items-center {
        text-align: center!important;
    }

    #image-input {
        display: none;
    }

    .upload-wrap {
        width: 350px;
        height: 350px;
        cursor: pointer;
        position: relative;
        margin: auto;
    }

    .upload-image {
        width: 350px;
        height: 350px;
        cursor: pointer;
        position: absolute;
        border: 1px solid #e8e8e8;
        margin: 0;
        font-weight: normal;
        padding: 0;
        top: 0;
        left: 0;
        overflow: hidden;
        object-fit: cover;
    }

    #tags {
        position: absolute;
        left: 0;
        bottom: -40px;
        width: 100%;
    }

    #tags:focus {
        outline: none;
    }

    .image {
        position: absolute;
        top: 0;
        left: 0;
        max-height: 100%;
    }

    .upload-icon, .image-spinner {
        margin-top: 120px;
    }

    .image-spinner {
        color: #db4d29;
    }

    .upload-save-btn {
        margin-top: 50px;
        cursor: pointer;
        border-radius: 2px;
        background-color: #4286f4;
        color: white;
        border: none;
        padding: 0 15px;
        width: 80px;
    }
    .upload-save-btn:hover {
        background-color: #2b76ef;
        color: #f2f2f2;
    }


    .cancel-image-btn {
        margin-top: 50px;
        cursor: pointer;
        border-radius: 2px;
        background-color: #d33b19;
        color: white;
        border: none;
        padding: 0 15px;
        width: 80px;
    }
    .cancel-image-btn:hover {
        background-color: #c12907;
        color: #f2f2f2;
    }


    .error {
        width: 350px;
        margin: 10px auto 0 auto;
        padding: 5px;
    }



    #tags {
        padding-left: 5px;
    }
    #tags::placeholder {
        color: #adabab;
        font-size: 13px;
    }
    #tags::-webkit-input-placeholder { /* Chrome/Opera/Safari */
        color: #adabab;
        font-size: 13px;
    }
    #tags::-moz-placeholder { /* Firefox 19+ */
        color: #adabab;
        font-size: 13px;
    }
    #tags:-ms-input-placeholder { /* IE 10+ */
        color: #adabab;
        font-size: 13px;
    }
    #tags:-moz-placeholder { /* Firefox 18- */
        color: #adabab;
        font-size: 13px;
    }
</style>