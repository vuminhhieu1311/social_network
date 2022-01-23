<template>
    <div class="flex flex-col items-end mt-5 px-3 py-3">
        <input
            type="text"
            class="border rounded-md px-2 py-1 w-full"
            placeholder="Say something..."
            v-model="form.body"
            @keyup.enter="method"
        />
        <button
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
                text-xs text-white
                uppercase
                tracking-widest
                mt-5
                hover:bg-blue-500
                focus:outline-none
                focus:border-blue-700
                focus:shadow-outline-blue
                active:bg-blue-600
                transition
                ease-in-out
                duration-150
            "
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
            @click="method"
        >
            Send
        </button>
    </div>
</template>

<script>
export default {
    props: ["form", "item", "method"],
};
</script>
