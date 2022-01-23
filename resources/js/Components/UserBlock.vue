<template>
    <div class="sm:flex sm:flex-wrap">
        <Link
            :href="route('profiles.show', item.profile.id)"
            class="sm:w-1/2"
            v-for="(item, index) in items"
            :key="index"
        >
            <div
                class="
                    flex
                    items-center
                    bg-gray-50
                    px-2
                    py-3
                    border-l border-gray-500
                    mt-5
                    hover:bg-gray-400 hover:text-blue-800
                "
            >
                <div class="flex flex-shrink-0">
                    <img
                        :src="item.profile_photo_url"
                        class="h-8 w-8 rounded-full object-cover"
                    />
                </div>
                <div class="flex flex-grow overflow-hidden">
                    <span class="text-lg ml-3">
                        {{ item.name }}
                    </span>
                </div>
            </div>
        </Link>
    </div>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Head,
        Link,
    },

    props: ["items"],
};
</script>
