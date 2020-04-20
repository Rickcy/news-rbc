<template>
    <div class="details card">
        <div v-if="newsDetails">
            <div class="card-body">
                <h3 class="card-title">{{newsDetails.title}}</h3>
                <div class="details__img" v-if="newsDetails.urlToImage">
                    <img :src="newsDetails.urlToImage" alt="">
                </div>
                <div class="details__content" v-html="newsDetails.content"></div>
            </div>

        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    const {ACTIONS} = require('../namespaces');

    export default {
        name: "NewsDetails",
        methods: {
            load() {
                this.$store.dispatch(ACTIONS.NEWS_ITEM, {id: this.$route.params.id})
            }
        },
        computed: {
            ...mapGetters([
                'newsDetails',
                'newsError'
            ])
        },
        mounted() {
            this.load()
        }

    }
</script>

<style scoped>
    .details {
        margin-bottom: 150px;
        margin-top: 150px
    }

    .details__img {
        max-width: 50%;
    }

    .details__content {
        margin-top: 50px
    }

    .details__img img {
        width: 100%;
    }
</style>