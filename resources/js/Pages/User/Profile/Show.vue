<template>
    <page-layout :title="userProfile.name">
        <template #title>
            <div class="flex justify-between items-center w-full">
                <h2
                    class="
                        flex
                        items-end
                        font-semibold
                        text-xl text-gray-800
                        leading-tight
                    "
                >
                    <img
                        :src="userProfile.profile_photo_url"
                        class="h-8 w-8 rounded-full object-cover"
                    />
                    <span class="capitalize ml-3">{{ userProfile.name }}</span>
                </h2>
                <status
                    :userProfile="userProfile"
                    :isFriendWith="isFriendWith"
                    :hasPendingRequestFrom="hasPendingRequestFrom"
                    :hasPendingSentRequestTo="hasPendingSentRequestTo"
                />
            </div>
        </template>
        <post-form :submitMethod="createPost" :form="form" textBtn="Post" />
        <infinite-scroll @loadMore="loadMorePosts">
            <post-list :posts="allPosts.data" :pagination="pagination" />
        </infinite-scroll>
    </page-layout>
</template>

<script>
import PageLayout from "@/Layouts/PageLayout.vue";
import Status from "@/Components/Friendship/Status.vue";
import PostList from "@/Components/Post/PostList.vue";
import PostForm from "@/Components/Post/PostForm.vue";
import InfiniteScroll from "@/Components/InfiniteScroll.vue";

export default {
    props: [
        "userProfile",
        "posts",
        "isFriendWith",
        "hasPendingRequestFrom",
        "hasPendingSentRequestTo",
    ],

    components: {
        PageLayout,
        Status,
        PostList,
        PostForm,
        InfiniteScroll,
    },

    data() {
        return {
            form: this.$inertia.form({
                body: this.body,
                user_id: this.userProfile.id,
            }),
            allPosts: this.posts,
        };
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
};
</script>
