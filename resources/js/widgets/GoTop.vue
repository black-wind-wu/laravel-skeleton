<template>
    <span class="gotop" @click="goTop" v-show="isShow === true"><i class="fa fa-chevron-up"
                                                                   aria-hidden="true"></i></span>
</template>

<script>
export default {
    data() {
        return {
            isShow: false,
        }
    },
    mounted() {
        window.addEventListener('scroll', this.handleScroll);
    },
    methods: {
        goTop() {// 回到顶部
            document.body.scrollTop = document.documentElement.scrollTop = 0
            this.isShow = false
        },
        handleScroll() {// 滚动操作监听
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop
            if (scrollTop > 220) {
                this.isShow = true;
            } else {
                this.isShow = false;
            }
            //console.log(scrollTop)
        },
    },
    destroyed() {
        document.removeEventListener('scroll', this.handleScroll)
        document.body.scrollTop = document.documentElement.scrollTop = 0;
    }
}
</script>

<style lang="scss" scoped>
.gotop {
    width: 50px;
    height: 50px;
    position: relative;
    text-align: center;
    margin-bottom: 10px;
    display: block;
    cursor: pointer;
    border-radius: 50%;
    background: #4285f4;
    box-shadow: 0 0 8px 0 rgba(0, 0, 0, .2);
    transition: all .3s ease-out;
    position: fixed;
    right: 20px;
    bottom: 20px;
    z-index: 5;

    i {
        color: #fff;
        line-height: 50px;
    }
}

.gotop:hover {
    background: #222;
}
</style>
