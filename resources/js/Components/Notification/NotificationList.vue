<template>
    <div>
        <notification
            v-for="unreadNotification in unreadNotifications"
            :key="unreadNotification.id"
            :unreadNotification="unreadNotification"
            class="
                flex
                justify-between
                items-center
                bg-blue-100
                text-sm text-gray-700
                hover:bg-blue-200
                px-4
                py-2
                transition
                duration-150
                ease-in-out
            "
        />

        <notification
            v-for="readNotification in readNotifications"
            :key="readNotification.id"
            :readNotification="readNotification"
            class="
                flex
                justify-between
                items-center
                bg-gray-100
                text-gray-400
                hover:bg-blue-200
                px-4
                py-2
                transition
                duration-150
                ease-in-out
            "
        />
    </div>
</template>

<script>
import Notification from "./Notification.vue";

export default {
    props: ["readNotifications", "unreadNotifications"],

    components: {
        Notification,
    },
};
</script>
