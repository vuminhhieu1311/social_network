<template>
    <div>
        <div v-for="(comment, index) in comments" :key="index">
            <comment :comment="comment" />
        </div>
    </div>
</template>

<script>
import Comment from "./Comment.vue";

export default {
    props: ["comments"],
    components: {
        Comment,
    },
};
</script>
