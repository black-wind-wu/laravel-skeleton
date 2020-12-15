<template>
    <button class="btn btn-sm btn-primary" @click="markAsRead()">全部标记为已读</button>
</template>

<script>
    import {markNotificationsAsRead} from "../../api/user";

    export default {
        methods: {
            markAsRead() {
                markNotificationsAsRead().then(response => {
                    window.location.reload();
                }).catch((error) => {
                });
            }
        }
    }
</script>

