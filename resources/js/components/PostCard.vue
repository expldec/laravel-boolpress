<template>
    <div class="col">
        <div class="card mb-3">
            <div class="card-body">
                <img class="card-img-top" :src="post.cover" :alt="post.title">
                <h5 class="card-title">{{ post.title }}</h5>
                <p class="card-text">
                    {{ trimText(post.content, 100) }}
                </p>
                <router-link
                    :to="{ name: `blog-post`, params: { slug: post.slug } }"
                    class="card-link"
                    >Card link</router-link
                >
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "PostCard",
    props: {
        post: Object,
    },
    methods: {
        trimText(text, max) {
            if (text.length > max) {
                return text.substring(0, max) + "...";
            }
            return text;
        },
    },
};
</script>

<style></style>
