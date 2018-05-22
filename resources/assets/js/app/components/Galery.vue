<template>
    <div id="basicExample2">
        <img v-for="i in images" src="https://i1.wp.com/detechter.com/wp-content/uploads/2015/01/autumn-trees-facebook-cover-timeline-banner-for-fb.jpg?resize=662%2C244">
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'

    export default {
        props: ['my'],

        computed: {
            ...mapGetters({
                images: 'getImages'
            })
        },

        methods: {
            ...mapActions({
                getImages: 'getImages'
            })
        },

        created() {
            this.getImages();
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