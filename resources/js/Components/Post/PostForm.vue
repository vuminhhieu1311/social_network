<template>
    <form @submit.prevent="submitMethod" class="w-full">
        <div>
            <textarea
                name="post"
                rows="3"
                class="border rounded px-2 py-2 w-full"
                placeholder="Post something..."
                v-model="form.body"
            />
        </div>
        <div class="flex justify-between my-3">
            <div>
                <jet-input-error
                    :message="form.errors.body"
                    class="mt-2"
                    v-if="form.errors.body"
                />
            </div>
            <div>
                <blue-button
                    type="submit"
                    class="text-xs"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    <fingerprint-spinner
                        :animation-duration="1500"
                        :size="20"
                        class="text-white"
                        v-if="form.processing"
                    />
                    <span v-else>{{ textBtn }}</span>
                </blue-button>
            </div>
        </div>
    </form>
</template>

<script>
import { FingerprintSpinner } from "epic-spinners";
import BlueButton from "@/Components/Buttons/BlueButton";
import JetInputError from "@/Jetstream/InputError";

export default {
    props: ["submitMethod", "form", "textBtn"],
    components: {
        BlueButton,
        FingerprintSpinner,
        JetInputError,
    },
};
</script>
