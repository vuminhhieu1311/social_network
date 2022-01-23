<template>
    <div class="flex border-t border-gray-400 mt-5 py-5 space-x-5">
        <div class="flex-shrink-0">
            <Link :href="route('profiles.show', comment.user.profile.id)">
                <img
                    class="h-8 w-8 rounded-full object-cover"
                    :src="comment.user.profile_photo_url"
                />
            </Link>
        </div>

        <div class="flex-1">
            <div>
                <h2 class="text-lg font-semibold underline">
                    <Link
                        :href="route('profiles.show', comment.user.profile.id)"
                        >{{ comment.user.name }}
                    </Link>
                </h2>
                <p class="bg-gray-100 rounded mt-3 px-3 py-2">
                    {{ comment.body }}
                </p>
            </div>
            <div class="flex items-end my-3">
                <div>
                    <span class="text-sm italic">{{ timeAgo }}</span>
                </div>
                <div class="flex ml-3">
                    <like :item="comment" :submitMethod="submitLike" />
                    <dislike
                        :item="comment"
                        :submitMethod="submitDislike"
                        class="ml-2"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Dislike from "./Dislike.vue";
import Like from "./Like.vue";
import { Link } from "@inertiajs/inertia-vue3";
import moment from "moment";

export default {
    props: ["comment"],
    components: {
        Dislike,
        Like,
        Link,
    },
    data() {
        return {
            likeForm: this.$inertia.form({
                comment: this.comment,
            }),
            dislikeForm: this.$inertia.form({
                comment: this.comment,
            }),
        };
    },
    computed: {
        timeAgo() {
            return moment(this.comment.created_at).fromNow();
        },
    },
    methods: {
        submitLike() {
            this.likeForm.post(
                this.route("comment-like.store", this.comment.id),
                {
                    preserveScroll: true,
                    onSuccess: () => {},
                }
            );
        },
        submitDislike() {
            this.dislikeForm.delete(
                this.route("comment-like.destroy", this.comment.id),
                {
                    preserveScroll: true,
                    onSuccess: () => {},
                }
            );
        },
    },
};
</script>
