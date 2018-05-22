<template>
    <div class="app-container">

        <navbar></navbar>

        <register></register>
        <login></login>


        <router-view></router-view>

        <div class="footer"></div>
    </div>
</template>

<script>
    export default {
    }
</script>


<style>
    .footer {
        height: 80px;
        width: 100%;
    }
</style>