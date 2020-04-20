<template>
    <div class="container">
        <NewsList/>
    </div>
</template>

<script>
    import NewsList from '@/components/NewsList'
    export default {
        name: 'Home',
        components: {
            NewsList
        },
    }
</script>
