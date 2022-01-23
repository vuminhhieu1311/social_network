<template>
    <button
        :type="type"
        class="
            inline-flex
            items-center
            justify-center
            px-4
            py-2
            bg-blue-600
            border border-transparent
            rounded-md
            font-semibold
            text-white
            uppercase
            tracking-widest
            hover:bg-blue-500
            focus:outline-none focus:border-blue-700 focus:shadow-outline-blue
            active:bg-blue-600
            transition
            ease-in-out
            duration-150
        "
        @click="visit"
    >
        <slot></slot>
    </button>
</template>

<script>
export default {
    props: {
        type: {
            type: String,
            default: "button",
        },
        href: {
            type: String,
            default: "",
        },
    },

    methods: {
        visit(event) {
            console.log(this.href);

            if (!this.href) {
                return;
            }
            event.preventDefault();
            this.$inertia.visit(this.href);
        },
    },
};
</script>
