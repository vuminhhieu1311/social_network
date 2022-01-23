<template>
    <page-layout title="All Members">
        <template #title>
            <div
                class="
                    flex flex-col
                    items-center
                    sm:flex-row sm:justify-between
                "
            >
                <h2
                    class="
                        flex
                        items-end
                        font-semibold
                        text-xl text-gray-800
                        leading-tight
                    "
                >
                    <Link
                        :href="route('profiles.index')"
                        class="underline text-blue-700"
                    >
                        Members
                    </Link>
                </h2>
                <span
                    class="
                        text-gray-800
                        leading-tight
                        text-lg
                        capitalize
                        mt-5
                        sm:mt-0
                    "
                >
                    Visit your
                    <Link :href="route('friends.index')" class="underline text-blue-700 hover:text-green-500"
                        >friends
                    </Link>
                </span>
            </div>
        </template>
        <infinite-scroll @loadMore="loadMoreMembers">
            <user-block :items="allMembers.data" />
        </infinite-scroll>
    </page-layout>
</template>

<script>
import PageLayout from "@/Layouts/PageLayout.vue";
import UserBlock from "@/Components/UserBlock.vue";
import InfiniteScroll from "@/Components/InfiniteScroll.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

export default {
    props: ["users"],

    components: {
        PageLayout,
        UserBlock,
        InfiniteScroll,
        Head,
        Link,
    },

    data() {
        return {
            allMembers: this.users,
        };
    },

    methods: {
        loadMoreMembers() {
            if (!this.allMembers.next_page_url) {
                return;
            }
            return axios.get(this.allMembers.next_page_url).then((resp) => {
                this.allMembers = {
                    ...resp.data,
                    data: [...this.allMembers.data, ...resp.data.data],
                };
            });
        },
    },
};
</script>
