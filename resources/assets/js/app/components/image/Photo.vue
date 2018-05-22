<template>
    <div class="photo-container">
        <img class="image-gal" :src="imagepath" @click.prevent="open"/>

        <div class="bottom-wrap">
            <div class="open-wrap" @click.prevent="open"></div>
            <img class="img-creator" :src="userAvatar"/>
            <span class="creator-name">{{ userName }}</span>
            <a href="#" @click.prevent="like"><i class="like-icon" :class="didILike"></i></a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['imagepath', 'like', 'didILike', 'didILike', 'userAvatar', 'userName', 'open'],

    }
</script>



<style lang="scss">
    @import "node_modules/flexbin/flexbin.scss";

    // Desktop, large screen devices
    $flexbin-row-height: 200px; // height of image rows
    $flexbin-space: 10px; // space between images

    // Tablet, medium screen devices
    $flexbin-tablet-max: 800px;
    $flexbin-row-height-tablet: 150px;
    $flexbin-space-tablet: 8px;

    // Phone, small screen devices
    $flexbin-phone-max: 400px;
    $flexbin-row-height-phone: 100px;
    $flexbin-space-phone: 4px;

    .my-flexbin {
        @include flexbin(100px, 8px);
    }

    .my-flexbin-large {
        @include flexbin(400px, 20px);

        @media (max-width: 768px) {
            @include flexbin(200px, 10px);
        }
    }



    .photo-container {
        cursor: pointer;
    }

    .image-gal {
        position: relative;
    }
    .bottom-wrap {
        position: absolute;
        height: 120px;
        width: 100%;
        bottom: 0;
        left: 0;
        opacity: 0;
        transition: 0.5s opacity;
        -webkit-box-shadow: inset 0px -63px 79px -53px rgba(0,0,0,1);
        -moz-box-shadow: inset 0px -63px 79px -53px rgba(0,0,0,1);
        box-shadow: inset 0px -63px 79px -53px rgba(0,0,0,1);
    }
    .image-gal:hover + .bottom-wrap, .bottom-wrap:hover {
        opacity: 1;
    }

    .like-icon {
        position: absolute;
        bottom: 15px;
        right: 20px;
        color: #ededed;
        transition: 0s, opacity 0.5s ease-in-out;
    }


    .img-creator {
        position: absolute;
        width: 25px;
        height: 25px;
        border-radius: 50%;
        border: 1px solid white;
        left: 20px;
        bottom: 15px;
    }
    .creator-name {
        position: absolute;
        bottom: 15px;
        left: 50px;
        color: white;
        font-size: 14px;
    }

    .open-wrap {
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
    }
</style>