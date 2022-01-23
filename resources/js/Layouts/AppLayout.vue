<template>
    <div>
        <Head :title="title" />

        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex-shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <jet-application-mark
                                        class="block h-9 w-auto"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div
                                class="
                                    hidden
                                    space-x-8
                                    sm:-my-px sm:ml-10 sm:flex
                                "
                            >
                                <jet-nav-link
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    Dashboard
                                </jet-nav-link>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative flex flex-row">
                                <jet-dropdown align="right" width="48">
                                    <template #trigger>
                                        <button
                                            v-if="
                                                $page.props.jetstream
                                                    .managesProfilePhotos
                                            "
                                            class="
                                                flex
                                                text-sm
                                                border-2 border-transparent
                                                rounded-full
                                                focus:outline-none
                                                focus:border-gray-300
                                                transition
                                            "
                                        >
                                            <template v-if="$page.props.user">
                                                <span class="ml-1 pt-3">{{
                                                    $page.props.user.name
                                                }}</span>
                                            </template>
                                            <img
                                                class="
                                                    h-8
                                                    w-8
                                                    rounded-full
                                                    object-cover
                                                    ml-3
                                                "
                                                :src="
                                                    $page.props.user
                                                        .profile_photo_url
                                                "
                                                :alt="$page.props.user.name"
                                            />
                                        </button>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div
                                            class="
                                                block
                                                px-4
                                                py-2
                                                text-xs text-gray-400
                                            "
                                        >
                                            Manage Account
                                        </div>

                                        <jet-dropdown-link
                                            :href="route('profile.show')"
                                        >
                                            Profile
                                        </jet-dropdown-link>

                                        <div
                                            class="border-t border-gray-100"
                                        ></div>

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <jet-dropdown-link as="button">
                                                Log Out
                                            </jet-dropdown-link>
                                        </form>
                                    </template>
                                </jet-dropdown>

                                <jet-dropdown align="right" width="96">
                                    <template #trigger>
                                        <button class="mt-1 focus:outline-none">
                                            <div class="flex ml-3 relative">
                                                <icon
                                                    name="bell"
                                                    class="w-6 h-6"
                                                />
                                                <template
                                                    v-if="
                                                        unreadNotifications.length >
                                                        0
                                                    "
                                                >
                                                    <span
                                                        class="
                                                            text-white text-xs
                                                            bg-red-600
                                                            rounded-full
                                                            px-2
                                                            py-1
                                                            absolute
                                                            bottom-2
                                                            left-3
                                                        "
                                                    >
                                                        {{
                                                            unreadNotifications.length
                                                        }}
                                                    </span>
                                                </template>
                                            </div>
                                        </button>
                                    </template>

                                    <template
                                        #content
                                        v-if="notifications.length > 0"
                                    >
                                        <Link
                                            :href="
                                                route('notifications.update')
                                            "
                                            class="
                                                block
                                                px-4
                                                py-2
                                                text-sm
                                                leading-5
                                                text-gray-700
                                                hover:bg-blue-200
                                                focus:outline-none
                                                focus:bg-gray-100
                                                transition
                                                duration-150
                                                ease-in-out
                                            "
                                        >
                                            Mark all as read
                                        </Link>

                                        <div
                                            class="border-t border-gray-100"
                                        ></div>

                                        <notification-list
                                            :unreadNotifications="
                                                unreadNotifications
                                            "
                                            :readNotifications="
                                                readNotifications
                                            "
                                        />
                                    </template>

                                    <template #content v-else>
                                        <div
                                            class="
                                                block
                                                text-center
                                                px-4
                                                py-2
                                                text-xs text-gray-400
                                            "
                                        >
                                            You have 0 notifications
                                        </div>
                                    </template>
                                </jet-dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="
                                    inline-flex
                                    items-center
                                    justify-center
                                    p-2
                                    rounded-md
                                    text-gray-400
                                    hover:text-gray-500 hover:bg-gray-100
                                    focus:outline-none
                                    focus:bg-gray-100
                                    focus:text-gray-500
                                    transition
                                "
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <jet-responsive-nav-link
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            Dashboard
                        </jet-responsive-nav-link>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div
                                v-if="
                                    $page.props.jetstream.managesProfilePhotos
                                "
                                class="flex-shrink-0 mr-3"
                            >
                                <img
                                    class="h-10 w-10 rounded-full object-cover"
                                    :src="$page.props.user.profile_photo_url"
                                    :alt="$page.props.user.name"
                                />
                            </div>

                            <div>
                                <div
                                    class="font-medium text-base text-gray-800"
                                >
                                    {{ $page.props.user.name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">
                                    {{ $page.props.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <jet-responsive-nav-link
                                :href="route('profile.show')"
                                :active="route().current('profile.show')"
                            >
                                Profile
                            </jet-responsive-nav-link>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <jet-responsive-nav-link as="button">
                                    Log Out
                                </jet-responsive-nav-link>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"></slot>
                </div>
            </header>

            <div class="flex flex-wrap sm:flex-nowrap">
                <!-- Page Sidebar -->
                <SideBar />

                <!-- Page Content -->
                <main
                    class="
                        bg-white
                        shadow
                        rounded
                        my-5
                        py-6
                        px-4
                        w-full
                        sm:w-2/3 sm:mx-2 sm:my-3
                        md:mx-4 md:px-10
                        lg:mx-auto
                    "
                >
                    <slot></slot>
                </main>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import JetApplicationMark from "@/Jetstream/ApplicationMark.vue";
import JetDropdown from "@/Jetstream/Dropdown.vue";
import JetDropdownLink from "@/Jetstream/DropdownLink.vue";
import JetNavLink from "@/Jetstream/NavLink.vue";
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import SideBar from "@/Components/SideBar.vue";
import NotificationList from "@/Components/Notification/NotificationList.vue";

export default defineComponent({
    props: {
        title: String,
    },

    components: {
        Head,
        JetApplicationMark,
        JetDropdown,
        JetDropdownLink,
        JetNavLink,
        JetResponsiveNavLink,
        Link,
        SideBar,
        NotificationList,
    },

    data() {
        return {
            showingNavigationDropdown: false,
            notifications: this.$page.props.auth.notifications,
            readNotifications: this.$page.props.auth.readNotifications,
            unreadNotifications: this.$page.props.auth.unreadNotifications,
        };
    },

    mounted() {
        this.listenForNotifications();
    },

    methods: {
        logout() {
            this.$inertia.post(route("logout"));
        },
        listenForNotifications() {
            Echo.private(
                `App.Models.User.${this.$page.props.user.id}`
            ).notification((notification) => {
                console.log(notification)
                let newUnreadNotifications = {
                    data: {
                        info: {
                            avatar: notification.info.avatar,
                            message: notification.info.message,
                            link: notification.info.link,
                            sent: notification.info.sent,
                        },
                    },
                    id: notification.id,
                };
                this.unreadNotifications.push(newUnreadNotifications);
                this.notifications.push(newUnreadNotifications);
            });
        },
    },
});
</script>
