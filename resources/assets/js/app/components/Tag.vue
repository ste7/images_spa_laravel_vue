 <template>
     <span class="tag" @click.prevent="select">{{ name }}</span>
</template>


<script>
    export default {
        props: ['name', 'select']
    }
</script>


<style>
    .tag {
        cursor: pointer;
        color: #585959;
        padding: 5px;
        margin: 5px ;
        font-size: 18px;
        float: left;
    }
</style>