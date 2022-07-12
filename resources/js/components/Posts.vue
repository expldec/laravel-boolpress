<template>
    <div class="container">
        <div class="row">
            <div class="col text-center my-3"><h1>Posts</h1></div>
        </div>
        <div class="row row-cols-3">
            <div v-for="(post, index) in posts" :key="index" class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ post.title }}</h5>
                    <p class="card-text">
                        {{ trimText(post.content, 100) }}
                    </p>
                    <a href="#" class="card-link">Card link</a>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li
                        class="page-item"
                        :class="{ disabled: currentPage === 1 }"
                    >
                        <a
                            class="page-link"
                            href="#"
                            @click="getPosts(currentPage - 1)"
                            >Previous</a
                        >
                    </li>
                    <li
                        v-for="n in lastPage"
                        :key="n"
                        class="page-item"
                        :class="{ active: currentPage === n }"
                    >
                        <a class="page-link" href="#" @click="getPosts(n)">{{ n }}</a>
                    </li>
                    <li
                        class="page-item"
                        :class="{ disabled: currentPage === lastPage }"
                    >
                        <a
                            class="page-link"
                            href="#"
                            @click="getPosts(currentPage + 1)"
                            >Next</a
                        >
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
export default {
    name: "Posts",
    data() {
        return {
            posts: [],
            currentPage: 1,
            lastPage: 0,
            totalPosts: 0,
        };
    },
    created() {
        this.getPosts(1);
    },
    methods: {
        getPosts(pageNumber) {
            axios
                .get("/api/posts", {
                    params: {
                        page: pageNumber,
                    },
                })
                .then((resp) => {
                    this.posts = resp.data.results.data;
                    this.currentPage = resp.data.results.current_page;
                    this.lastPage = resp.data.results.last_page;
                    this.totalPosts = resp.data.results.total;
                });
        },
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
