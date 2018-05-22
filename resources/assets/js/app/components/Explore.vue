<template>
    <div class="explore-container container-fluid">
        <div class="row tags-wrap">
            <div class="col-12" v-if="tags">

                <tag v-bind:class="{'selected': all.selected}" :name="all.name" :select="selectAll"></tag>

                <tag v-for="(t, index) in tags"
                     :key="t.id"
                     :name="t.name"
                     :select="select.bind(this, t.id, index)">
                </tag>
            </div>
        </div>


        <div class="flexbin flexbin-margin">
            <photo v-if="images && images.length" v-for="(i, index) in images"
                 :key="i.id"
                 :imagepath="i.path"
                 :userAvatar="i.user.avatar"
                 :userName="i.user.name"
                 :like="like.bind(this, i.id)"
                 :didILike="didILike(index)"
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
                selected: [],
                all: {
                    name: 'all',
                    selected: true
                }
            }
        },

        methods: {
            ...mapActions({
                getImagesAndTags: 'getImagesAndTags',
                likeImage: 'likeImage'
            }),

            selectAll() {
                this.all.selected = true;
                this.selected = [];

                let el = document.getElementsByClassName('tag');

                for (let i = 1; i < el.length; i++) {
                    el[i].classList.remove('selected');
                }

                this.getImagesAndTags({tags: this.selected});
            },

            select(id, index) {
                this.all.selected = false;

                let el = document.getElementsByClassName('tag')[index + 1];

                if (! el.classList.contains('selected')) {
                    this.selected.unshift(id);
                    el.classList.add('selected');
                } else {
                    let index = this.selected.indexOf(id);
                    this.selected.splice(index, 1);

                    if (this.selected < 1) {
                        this.all.selected = true;
                    }

                    el.classList.remove('selected');
                }



                this.getImagesAndTags({tags: this.selected});
            },

            didILike(index) {
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

        computed: {
            ...mapGetters({
                authenticated: 'authenticated',
                user: 'getUser',
                tags: 'getTags',
                images: 'getImages'
            })
        },

        created() {
            this.getImagesAndTags({tags: this.selected});
        }
    }
</script>


<style>
    .tags-wrap {
        margin-bottom: 30px;
    }

    .selected {
        border-bottom: 2px solid #818284;
        color: #387eed!important;
    }
</style>