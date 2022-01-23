<template>
    <page-layout title="Chat Rooms">
        <template #title>
            <div class="flex flex-col">
                <h2 class="font-semibold text-xl text-blue-700 underline leading-tight">
                    Chat rooms
                </h2>
                <table class="mt-5">
                    <thead>
                        <tr class="border-b border-gray-800">
                            <th class="text-left pl-3">Room Name</th>
                            <th>Active Members</th>
                            <th class="text-right pr-3">Join</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            class="
                                border-b
                                bg-gray-50
                                h-10
                                hover:bg-gray-200 hover:text-blue-800
                                transition
                                ease-in-out
                                duration-150
                            "
                            v-for="(room, index) in rooms"
                            :key="index"
                        >
                            <td class="text-left pl-3 py-3">{{ room.name }}</td>
                            <td class="text-center py-3">{{ room.active }}</td>
                            <td class="text-right pr-3 py-3">
                                <blue-button
                                    :href="route('chat-rooms.show', room.slug)"
                                    class="text-xs"
                                    >Join</blue-button
                                >
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </template>
    </page-layout>
</template>

<script>
import BlueButton from "@/Components/Buttons/BlueButton";
import PageLayout from "@/Layouts/PageLayout";

export default {
    props: ["rooms"],

    components: {
        BlueButton,
        PageLayout,
    },
};
</script>
