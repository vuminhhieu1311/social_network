<template>
    <page-layout title="Dashboard">
        <template #title>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <post-form :submitMethod="createPost" :form="form" textBtn="Post" />
        <suggestions :suggestedUsers="suggestedUsers" />
        <infinite-scroll @loadMore="loadMorePosts">
            <post-list :posts="allPosts.data" :pagination="pagination" />
        </infinite-scroll>
    </page-layout>
</template>

<script>
import { defineComponent } from "vue";
import PageLayout from "@/Layouts/PageLayout.vue";
import PostList from "@/Components/Post/PostList.vue";
import PostForm from "@/Components/Post/PostForm.vue";
import Suggestions from "@/Components/Suggestions.vue";
import InfiniteScroll from "@/Components/InfiniteScroll.vue";

export default defineComponent({
    props: ["posts", "suggestedUsers"],

    data() {
        return {
            form: this.$inertia.form({
                user_id: this.$page.props.user.id,
                body: this.body,
            }),
            allPosts: this.posts,
        };
    },

    components: {
        PageLayout,
        PostList,
        PostForm,
        Suggestions,
        InfiniteScroll,
    },

    computed: {
        pagination() {
            return (this.allPosts = this.posts);
        },
    },

    methods: {
        createPost() {
            this.form.post(this.route("posts.store"), {
                preserveScroll: true,
                onSuccess: () => {
                    Toast.fire({
                        icon: "success",
                        title: "Your post has successfully been published!",
                    });
                    this.form.body = null;
                    location.reload();
                },
            });
        },
        loadMorePosts() {
            if (!this.allPosts.next_page_url) {
                return;
            }
            return axios.get(this.allPosts.next_page_url).then((resp) => {
                this.allPosts = {
                    ...resp.data,
                    data: [...this.allPosts.data, ...resp.data.data],
                };
            });
        },
    },
});
</script>
