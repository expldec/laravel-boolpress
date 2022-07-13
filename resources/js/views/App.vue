<template>
    <div>
        <Header />
        <!-- <Posts /> -->
        <router-view></router-view>
    </div>
</template>

<script>
// import WorkInProgress from '../components/WorkInProgress.vue';
import Header from '../components/Header.vue';
// import Posts from '../components/Posts.vue';
export default {
    name: 'App',
    components: {
        // WorkInProgress
        // Posts,
        Header,
    }
}
</script>

<style>
</style>