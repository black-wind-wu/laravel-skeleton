<template>
    <button :class="btnStyle" @click="sendCollect" :disabled="isDisabled">
        {{ buttonName }}
    </button>
</template>

<script>
import {follow} from "../api/util";

export default {
    props: ['id', 'type', 'size'],
    data() {
        return {
            buttonName: "关注",
            isDisabled: false,
            btnStyle: ''
        };
    },
    mounted() {
        if (this.size === 'sm') {
            this.btnStyle = 'btn btn-success btn-sm'
        } else if (this.size === 'lg') {
            this.btnStyle = 'btn btn-success btn-lg'
        } else {
            this.btnStyle = 'btn btn-success'
        }
    },
    methods: {
        sendCollect() {
            this.isDisabled = true;
            follow(this.id, this.type).then(response => {
                if (response.status === 'collected') {
                    this.buttonName = '已关注';
                } else {
                    this.buttonName = '关注';
                }
                this.isDisabled = false
            }).catch((error) => {
                alert(error.message)
                //this.$message.error(error.message);
                this.isDisabled = false
            });
        }
    }
}
</script>

<style scoped>

</style>
