<template>
    <div class="flex items-center">
        <span>{{ item.liked }}</span>
        <form @submit.prevent="submitMethod">
            <button type="submit" class="focus:outline-none">
                <icon
                    name="thumbs-up"
                    class="w-3 h-3 ml-1 fill-current hover:text-green-600"
                />
            </button>
        </form>
    </div>
</template>

<script>
export default {
    props: ["item", "submitMethod"],
};
</script>
