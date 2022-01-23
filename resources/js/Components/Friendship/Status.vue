<template>
    <div class="flex mt-5 sm:mt-0">
        <template v-if="hasPendingRequestFrom">
            <accept :userProfile="userProfile" />
            <ignore :userProfile="userProfile" class="ml-3" />
        </template>

        <template v-else-if="hasPendingSentRequestTo">
            <h3 class="font-semibold text-md text-gray-800 leading-tight">
                Pending
            </h3>
        </template>

        <template v-else-if="isFriendWith">
            <form @submit.prevent="deleteFriend">
                <jet-danger-button type="submit">
                    <fingerprint-spinner
                        :animation-duration="1500"
                        :size="20"
                        class="text-white"
                        v-if="loading"
                    />
                    <div v-else class="flex flex-row">
                        Unfriend
                        <icon
                            name="user-minus"
                            class="w-4 h-4 fill-current ml-1"
                        />
                    </div>
                </jet-danger-button>
            </form>
        </template>

        <template v-else-if="$page.props.user.id !== userProfile.id">
            <form @submit.prevent="addFriend">
                <blue-button type="submit" class="text-xs">
                    <fingerprint-spinner
                        :animation-duration="1500"
                        :size="20"
                        class="text-white"
                        v-if="loading"
                    />
                    <div v-else class="flex flex-row">
                        Add Friend
                        <icon
                            name="user-plus"
                            class="w-4 h-4 fill-current ml-1"
                        ></icon>
                    </div>
                </blue-button>
            </form>
        </template>
    </div>
</template>

<script>
import { FingerprintSpinner } from "epic-spinners";
import Accept from "./Accept";
import BlueButton from "@/Components/Buttons/BlueButton";
import Ignore from "./Ignore";
import JetDangerButton from "@/Jetstream/DangerButton";

export default {
    props: [
        "userProfile",
        "isFriendWith",
        "hasPendingRequestFrom",
        "hasPendingSentRequestTo",
    ],

    components: {
        Accept,
        BlueButton,
        Ignore,
        FingerprintSpinner,
        JetDangerButton,
    },

    data() {
        return {
            addFriendForm: this.$inertia.form({
                user: this.profile,
            }),
            deleteFriendForm: this.$inertia.form({
                user: this.profile,
            }),
            loading: false,
        };
    },
    methods: {
        addFriend() {
            this.loading = true;
            this.addFriendForm.post(
                this.route("friends.store", this.userProfile.id),
                {
                    preserveScroll: true,
                    onSuccess: () => {
                        Toast.fire({
                            icon: "success",
                            title: "Friend request sent!",
                        });
                        this.loading = false;
                    },
                }
            );
        },

        deleteFriend() {
            this.loading = true;
            this.deleteFriendForm.delete(
                this.route("friends.destroy", this.userProfile.id),
                {
                    preserveScroll: true,
                    onSuccess: () => {
                        Toast.fire({
                            icon: "success",
                            title: "Friend has been removed!",
                        });
                        this.loading = false;
                    },
                }
            );
        },
    },
};
</script>
