<template>
    <div class="h-full overflow-y-auto border-b">
        <div
            class="border-b px-3 py-3"
            v-for="message in messages"
            :key="message.id"
            :class="
                message.user.id != $page.props.user.id
                    ? 'text-right'
                    : 'text-left bg-blue-200 text-gray-200'
            "
        >
            <div
                class="flex items-center"
                :class="
                    message.user.id != $page.props.user.id
                        ? 'justify-end'
                        : ' '
                "
            >
                <img
                    :src="message.user.profile_photo_url"
                    class="w-4 h-4 rounded-full object-cover"
                />
                <Link :href="route('profiles.show', message.user.profile.id)">
                    <span
                        class="font-semibold tracking-wider ml-1"
                        :class="
                            message.user.id != $page.props.user.id
                                ? 'text-blue'
                                : 'text-gray-900'
                        "
                    >
                        {{ message.user.name }}
                    </span>
                </Link>
            </div>
            <div class="flex flex-col">
                <p class="text-sm text-gray-600">{{ message.body }}</p>
                <p class="text-xs italic text-gray-600">{{ timeAgo(message.create_at) }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import moment from "moment";

export default {
    props: ["messages"],

    components: {
        Link,
    },

    methods: {
        timeAgo(time) {
            return moment(time).fromNow();
        },
    },
}
</script>
