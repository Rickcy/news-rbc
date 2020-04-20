<template>
    <div id="services" class="cards-2">

        <div class="row">
            <div class="col-lg-12">
                <h2>Новости</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <NewsItem v-for="item in news" :key="item.id" :item="item"/>
            </div>
        </div>

    </div>
</template>

<script>

    import NewsItem from "@/components/NewsItem";
    import {mapGetters} from 'vuex';

    const {ACTIONS} = require('../namespaces');

    export default {
        name: "NewsList",
        components: {
            NewsItem
        },
        methods: {
            load() {
                this.$store.dispatch(ACTIONS.NEWS_LIST)
            }
        },
        computed: {
            ...mapGetters([
                'news',
                'newsError'
            ])
        },
        mounted() {
            this.load()
        }
    }
</script>

<style scoped>

</style>