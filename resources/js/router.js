import Vue from 'vue';
import VueRouter from 'vue-router';
 
import Home from "./pages/Home.vue";
import NotFound from "./pages/NotFound.vue";
import Blog from "./pages/Blog.vue";
import SinglePost from "./pages/SinglePost.vue";
import About from "./pages/About.vue";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "home",
            component: Home
        },
        {
            path: "/about",
            name: "about",
            component: About
        },
        {
            path: "/blog",
            name: "blog",
            component: Blog
        },
        {
            path: "/blog/:slug",
            name: "blog-post",
            component: SinglePost
        },
        {
            path: "/*",
            name: "not-found",
            component: NotFound
        }
    ]
});
  
 export default router;