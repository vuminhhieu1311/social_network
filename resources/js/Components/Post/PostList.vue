<template>
    <div>
        <div v-for="(post, index) in posts" :key="index">
            <post :post="post" />
        </div>
    </div>
</template>

<script>
import Post from "./Post";

export default {
    props: ["posts"],
    components: {
        Post,
    },
};
</script>
