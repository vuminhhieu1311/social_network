<template>
    <aside
        class="
            flex flex-col
            bg-white
            shadow
            py-6
            w-full
            sm:w-1/3
            lg:w-1/4 lg:pl-4
        "
    >
        <Link
            :href="link.route"
            v-for="link in sideBarLinks"
            :key="link.name"
            class="flex items-end pl-6 py-2"
            :class="
                route().current(link.route)
                    ? 'text-white bg-blue-400 hover:bg-gray-500'
                    : 'text-gray-800 hover:bg-blue-400 hover:text-white'
            "
        >
            <img
                :src="link.image"
                class="h-8 w-8 rounded-full object-cover"
                v-if="link.image"
            />
            <icon
                :name="link.icon"
                class="fill-current w-8 h-8"
                v-if="link.icon"
            ></icon>
            <span class="ml-2 mb-1">
                {{ link.name }}
            </span>
        </Link>
    </aside>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Head,
        Link,
    },

    computed: {
        sideBarLinks() {
            return [
                {
                    name: `${this.$page.props.user.name}`,
                    route: route(
                        "profiles.show",
                        `${this.$page.props.user.profile.id}`
                    ),
                    image: `${this.$page.props.user.profile_photo_url}`,
                },
                {
                    name: "Friends",
                    route: route("friends.index"),
                    icon: "user-friends",
                },
                {
                    name: "Edit Profile",
                    route: route("profile.show"),
                    icon: "user-edit",
                },
                {
                    name: "All Members",
                    route: route("profiles.index"),
                    icon: "users",
                },
                {
                    name: "Chat Rooms",
                    route: route("chat-rooms.index"),
                    icon: "comments",
                },
            ];
        },
    },
};
</script>

<style lang="scss" scoped></style>
