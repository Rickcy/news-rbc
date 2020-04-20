<template>
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">{{item.title}}</h3>
            <p>{{item.description}}</p>
            <ul class="list-unstyled li-space-lg">
                <li class="media">
                    <i class="fas fa-square"></i>
                    <a :href="item.source" target="_blank" class="media-body text-center">
                        <span class="text-black-50">Источник:</span>
                        {{item.source}}</a>
                </li>
            </ul>
            <p class="price" v-if="item.published_at">{{item.published_at}}</p>
        </div>
        <div class="button-container">
            <button class="btn-solid-reg" @click="showDetails(item.id)">Подробнее</button>
        </div>
    </div>
</template>

<script>
    import NewsEntity from '../entities/News'

    export default {
        name: "NewsItem",
        props: {
            item: NewsEntity
        },
        methods: {
            showDetails(id) {
                this.$router.push({name: 'news-details', params: {id: id}})
            }
        }
    }
</script>

<style scoped>
    .btn-solid-reg {
        color: white;
        cursor: pointer;
    }
</style>