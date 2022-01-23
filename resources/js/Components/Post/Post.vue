<template>
    <div class="flex border-t border-gray-400 mt-5 py-5 space-x-5">
        <div class="flex-shrink-0">
            <Link :href="route('profiles.show', post.user.profile.id)">
                <img
                    class="h-8 w-8 rounded-full object-cover"
                    :src="post.user.profile_photo_url"
                />
            </Link>
        </div>

        <div class="flex-1">
            <div>
                <div class="flex justify-between">
                    <h2 class="text-lg font-semibold underline">
                        <Link
                            :href="route('profiles.show', post.user.profile.id)"
                            >{{ post.user.name }}
                        </Link>
                    </h2>
                    <div class="relative">
                        <button
                            type="button"
                            class="focus:outline-none"
                            @click="openMenu = !openMenu"
                        >
                            <icon
                                name="ellipsis-h"
                                class="w-8 h-8 fill-current"
                            />
                        </button>
                        <div
                            v-if="openMenu"
                            class="
                                bg-gray-300
                                text-sm
                                absolute
                                w-48
                                right-0
                                text-gray-700
                                shadow-lg
                                rounded-md
                                px-4
                                py-2
                                hover:bg-gray-700 hover:text-gray-300
                                transition
                                duration-150
                                ease-in-out
                            "
                        >
                            <form @submit.prevent="deletePost">
                                <button
                                    type="submit"
                                    class="
                                        flex
                                        justify-between
                                        items-center
                                        w-full
                                        focus:outline-none
                                    "
                                >
                                    Delete Post
                                    <icon
                                        name="trash"
                                        class="w-3 h-3 fill-current"
                                    />
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <p class="bg-gray-100 rounded mt-3 px-3 py-2">
                    {{ post.body }}
                </p>
            </div>
            <div class="flex items-end my-3">
                <div>
                    <span class="text-sm italic">{{ timeAgo }}</span>
                </div>
                <div class="flex ml-3">
                    <like :item="post" :submitMethod="submitLike" />
                    <dislike
                        :item="post"
                        :submitMethod="submitDislike"
                        class="ml-2"
                    />
                </div>
            </div>
            <post-form
                :submitMethod="submitComment"
                :form="commentForm"
                textBtn="Comment"
            />
            <comment-list :comments="post.comments" />
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import moment from "moment";
import CommentList from "@/Components/Post/CommentList.vue";
import Dislike from "./Dislike.vue";
import Like from "./Like.vue";
import PostForm from "@/Components/Post/PostForm.vue";
export default {
    props: ["post"],
    components: {
        Link,
        CommentList,
        Dislike,
        Like,
        PostForm,
    },
    data() {
        return {
            openMenu: false,
            commentForm: this.$inertia.form({
                body: this.body,
                user_id: this.post.user_id,
                post_id: this.post.id,
            }),
            deleteForm: this.$inertia.form({
                userPost: this.post,
            }),
            likeForm: this.$inertia.form({
                userPost: this.post,
            }),
            dislikeForm: this.$inertia.form({
                userPost: this.post,
            }),
        };
    },
    computed: {
        timeAgo() {
            return moment(this.post.created_at).fromNow();
        },
    },
    methods: {
        submitComment() {
            this.commentForm.post(this.route("comments.store"), {
                preserveScroll: true,
                onSuccess: () => {
                    Toast.fire({
                        icon: "success",
                        title: "Your comment has successfully been published!",
                    });
                    this.commentForm.body = null;
                },
            });
        },
        deletePost() {
            this.openMenu = false;
            this.deleteForm.delete(this.route("posts.destroy", this.post), {
                preserveScroll: true,
                onError: (data) => {
                    Toast.fire({
                        icon: "error",
                        title: data.message,
                    });
                },
                onSuccess: () => {
                    Toast.fire({
                        icon: "success",
                        title: "Post has successfully been deleted!",
                    });
                },
            });
        },
        submitLike() {
            this.likeForm.post(this.route("post-like.store", this.post), {
                preserveScroll: true,
                onSuccess: () => {},
            });
        },
        submitDislike() {
            this.dislikeForm.delete(
                this.route("post-like.destroy", this.post),
                {
                    preserveScroll: true,
                    onSuccess: () => {},
                }
            );
        },
    },
};
</script>
