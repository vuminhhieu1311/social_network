<template>
    <page-layout title="All Friends">
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
                    <span class="underline text-blue-700">
                        {{ `${$page.props.user.name}'s Friends` }}
                    </span>
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
                    Browse
                    <Link
                        :href="route('profiles.index')"
                        class="underline text-blue-700 hover:text-green-500"
                    >
                        members
                    </Link>
                </span>
            </div>
        </template>
        <div>
            <h3 class="font-semibold text-lg text-gray-800 leading-tight mt-5">
                Friend Requests:
            </h3>
            <div v-if="requests.length <= 0">
                <h3 class="italic">You have no friend requests.</h3>
            </div>
            <user-block :items="requests" />
        </div>
        <div>
            <h3 class="font-semibold text-lg text-gray-800 leading-tight mt-5">
                Friends:
            </h3>
            <div v-if="friends.length <= 0">
                <h3 class="italic">You have no friends yet.</h3>
            </div>
            <user-block :items="friends" />
        </div>
    </page-layout>
</template>

<script>
import PageLayout from "@/Layouts/PageLayout.vue";
import UserBlock from "@/Components/UserBlock.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

export default {
    props: ["friends", "requests"],
    components: {
        PageLayout,
        UserBlock,
        Head,
        Link,
    },
};
</script>
