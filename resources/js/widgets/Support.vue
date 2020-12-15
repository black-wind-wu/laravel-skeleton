<template>
    <button :class="btnStyle" @click="sendSupport" :disabled="isDisabled">
        {{ num }} {{ buttonName }}
    </button>
</template>

<script>
import {support} from "../api/util";

export default {
    props: ['id', 'type', 'num', 'size'],
    data() {
        return {
            buttonName: "推荐",
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
        sendSupport() {
            this.isDisabled = true;
            support(this.id, this.type).then(response => {
                this.buttonName = '已推荐';
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
