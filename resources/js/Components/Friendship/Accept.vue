<template>
    <form @submit.prevent="acceptFriend">
        <green-button type="submit" class="text-xs">
            <fingerprint-spinner
                :animation-duration="1500"
                :size="20"
                class="text-white"
                v-if="loading"
            />
            <div v-else class="flex flex-row">
                Accept
                <icon name="user-plus" class="w-4 h-4 fill-current ml-1" />
            </div>
        </green-button>
    </form>
</template>

<script>
import { FingerprintSpinner } from "epic-spinners";
import GreenButton from "@/Components/Buttons/GreenButton";

export default {
    props: ["userProfile"],

    components: {
        FingerprintSpinner,
        GreenButton,
    },

    data() {
        return {
            acceptFriendForm: this.$inertia.form({
                user: this.userProfile,
            }),
            loading: false,
        };
    },

    methods: {
        acceptFriend() {
            this.loading = true;
            this.acceptFriendForm.patch(
                this.route("friends.update", this.userProfile.id),
                {
                    preserveScroll: true,
                    onSuccess: () => {
                        Toast.fire({
                            icon: "success",
                            title: "Successfully accepted request!",
                        });
                        this.loading = false;
                    },
                }
            );
        },
    },
};
</script>
