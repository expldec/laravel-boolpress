<template>
    <div>
        <!-- <WorkInProgress /> -->
        <Posts />
    </div>
</template>

<script>
// import WorkInProgress from '../components/WorkInProgress.vue';
import Posts from '../components/Posts.vue';
export default {
    name: 'App',
    components: {
        // WorkInProgress
        Posts,
    }
}
</script>

<style>
</style>