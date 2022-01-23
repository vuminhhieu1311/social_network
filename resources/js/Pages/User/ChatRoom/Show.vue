<template>
    <page-layout :title="room.name">
        <template #title>
            <div class="flex flex-col">
                <Link
                    :href="route('chat-rooms.index')"
                    class="flex text-gray-800"
                >
                    <icon name="angle-left" class="w-3 h-3 fill-current" />
                    <span
                        class="font-semibold text-lg capitalize underline ml-2"
                        >Back</span
                    >
                </Link>
                <div class="flex justify-between items-center mt-5">
                    <h3
                        class="
                            font-semibold
                            text-lg text-gray-800
                            leading-tight
                        "
                    >
                        Welcome to: {{ room.name }}
                    </h3>
                    <h4>{{ activeCount }} active users</h4>
                </div>

                <div class="flex space-x-4 mt-5">
                    <div
                        class="
                            flex-shrink-0
                            rounded-md
                            border border-gray-300
                            h-128
                        "
                    >
                        <active-users :users="users" />
                    </div>
                    <div
                        class="
                            flex-1
                            rounded-md
                            border border-gray-300
                            flex flex-col
                            h-128
                        "
                    >
                        <chat-box :messages="messages" id="container" />
                        <chat-input
                            :method="submitMessage"
                            :form="form"
                            :item="room"
                        />
                    </div>
                </div>
            </div>
        </template>
    </page-layout>
</template>

<script>
import ChatBox from "@/Components/Chat/ChatBox";
import ChatInput from "@/Components/Chat/ChatInput";
import PageLayout from "@/Layouts/PageLayout";
import { Link } from "@inertiajs/inertia-vue3";
import ActiveUsers from "@/Components/Chat/ActiveUsers";

export default {
    props: ["room", "messages"],

    components: {
        ChatBox,
        ChatInput,
        PageLayout,
        Link,
        ActiveUsers,
    },

    data() {
        return {
            form: this.$inertia.form({
                body: this.body,
                room: this.room,
            }),
            activeCount: 0,
            users: [],
            updateActiveForm: this.$inertia.form({
                room: this.room,
                count: 0,
            }),
        };
    },

    mounted() {
        this.connect();
        this.updateActive();
    },

    methods: {
        submitMessage() {
            this.form.post(this.route("chat-rooms.store", this.room), {
                preserveScroll: true,
                onSuccess: () => {
                    this.form.body = null;
                    this.scrollToBottom();
                },
            });
        },
        updateActive() {
            this.updateActiveForm.post(
                this.route("chat-rooms.update", this.room),
                {
                    preserveScroll: true,
                    onSuccess: () => {},
                }
            );
        },
        scrollToBottom() {
            let container = document.querySelector("#container");
            container.scrollTop = container.scrollHeight;
        },
        connect() {
            Echo.join(`chat.${this.room.id}`)
                .here((users) => {
                    console.log(users);
                    this.activeCount = users.length;
                    this.users = users;
                    this.updateActiveForm.count = this.activeCount;
                    this.updateActive();
                })
                .joining((user) => {
                    console.log(user);
                    this.activeCount++;
                    this.users.push(user);
                    this.updateActiveForm.count = this.activeCount;
                    this.updateActive();
                })
                .leaving((user) => {
                    console.log(user);
                    this.activeCount--;
                    this.users.splice(this.users.indexOf(user), 1);
                    this.updateActiveForm.count = this.activeCount;
                    this.updateActive();
                })
                .listen("NewChatMessageEvent", (e) => {
                    let newMessage = {
                        body: e.message.body,
                        user: e.user,
                    };
                    this.messages.push(newMessage);
                    this.scrollToBottom();
                });
        },
    },

    beforeUnmount() {
        if ((this.users.length = 1)) {
            this.updateActiveForm.count = 0;
            this.updateActive();
        } else {
            this.updateActive();
        }
    },

    unmounted() {
        console.log("destroyed");
        Echo.leave(`chat.${this.room.id}`);
    },
};
</script>
