<template>
    <button :class="btnStyle" @click="sendCollect" :disabled="isDisabled">
        {{ buttonName }}
    </button>
</template>

<script>
import {collect} from "../api/util";

export default {
    props: ['id', 'type', 'size'],
    data() {
        return {
            buttonName: "收藏",
            isDisabled: false,
            btnStyle: ''
        };
    },
    mounted() {
        if (this.size === 'sm') {
            this.btnStyle = 'btn btn-light btn-sm'
        } else if (this.size === 'lg') {
            this.btnStyle = 'btn btn-light btn-lg'
        } else {
            this.btnStyle = 'btn btn-light'
        }
    },
    methods: {
        sendCollect() {
            this.isDisabled = true;
            collect(this.id, this.type).then(response => {

                if (response.status === 'collected') {
                    this.buttonName = '已收藏';
                } else {
                    this.buttonName = '收藏';
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
