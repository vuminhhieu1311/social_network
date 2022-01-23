<template>
    <Head title="Welcome" />

    <div class="flex justify-around items-center bg-gray-100 min-h-screen">
        <div>
            <img :src="'storage/images/social_network.jpeg'" class="h-96" />
        </div>
        <div class="text-center">
            <h1 class="text-4xl font-semibold">Social Network</h1>
            <div v-if="canLogin" class="flex justify-center space-x-6 mt-5">
                <Link
                    href="#"
                    v-if="$page.props.user"
                    class="text-lg text-gray-700 underline"
                >
                    Dashboard
                </Link>
                <template v-else>
                    <Link
                        :href="route('login')"
                        class="
                            text-white
                            bg-gray-800
                            rounded
                            px-3
                            py-1
                            hover:bg-gray-500
                        "
                        >Login</Link
                    >
                    <Link
                        :href="route('register')"
                        v-if="canRegister"
                        class="
                            text-white
                            bg-gray-800
                            rounded
                            px-3
                            py-1
                            hover:bg-gray-500
                        "
                    >
                        Register
                    </Link>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
    components: {
        Head,
        Link,
    },

    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
    },
});
</script>
