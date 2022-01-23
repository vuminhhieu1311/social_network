<template>
    <div>
        <template v-if="unreadNotification">
            <Link
                :href="unreadNotification.data.info.link"
                class="flex leading-5"
                @click="markOneAsRead(unreadNotification.id)"
            >
                <img
                    :src="unreadNotification.data.info.avatar"
                    class="h-8 w-8 rounded-full object-cover"
                />
                <div class="flex flex-col items-start text-left">
                    <span class="text-sm mx-2">{{
                        unreadNotification.data.info.message
                    }}</span>
                    <span class="text-xs mx-2">{{ unreadTimeAgo }}</span>
                </div>
            </Link>
            <Link
                :href="route('notifications.destroy', unreadNotification.id)"
                class="
                    p-2
                    rounded-md
                    text-gray-500
                    hover:bg-gray-500 hover:text-gray-300
                "
            >
                <icon name="trash" class="w-4 h-4 fill-current" />
            </Link>
        </template>

        <template v-if="readNotification">
            <Link
                :href="readNotification.data.info.link"
                class="flex leading-5"
            >
                <img
                    :src="readNotification.data.info.avatar"
                    class="h-8 w-8 rounded-full object-cover"
                />
                <div class="flex flex-col items-start text-left">
                    <span class="text-sm mx-2">{{
                        readNotification.data.info.message
                    }}</span>
                    <span class="text-xs mx-2">{{ readTimeAgo }}</span>
                </div>
            </Link>
            <Link
                :href="route('notifications.destroy', readNotification.id)"
                class="
                    p-2
                    rounded-md
                    text-gray-500
                    hover:bg-gray-500 hover:text-gray-300
                "
            >
                <icon name="trash" class="w-4 h-4 fill-current" />
            </Link>
        </template>
    </div>
</template>
<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    props: ["unreadNotification", "readNotification"],

    components: {
        Link,
    },

    data() {
        return {
            notifications: this.$page.props.auth.notifications,
            readNotifications: this.$page.props.auth.readNotifications,
            unreadNotifications: this.$page.props.auth.unreadNotifications,
        };
    },

    computed: {
        unreadTimeAgo() {
            let dateString = this.unreadNotification.data.info.sent;
            let options = { year: "numeric", month: "long", day: "numeric" };

            return new Date(dateString).toLocaleDateString(undefined, options);
        },
        readTimeAgo() {
            let dateString = this.readNotification.data.info.sent;
            let options = { year: "numeric", month: "long", day: "numeric" };

            return new Date(dateString).toLocaleDateString(undefined, options);
        },
    },

    methods: {
        markOneAsRead(id) {
            axios.post(this.route("notifications.store", id));
        }
    },
};
</script>
