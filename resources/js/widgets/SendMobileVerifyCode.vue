<template>
    <button type="button" class="btn btn-lg bg-white text-muted" style="font-size: 1rem; border: 1px solid #ced4da;" @click="showCaptcha" :disabled="isDisabled">{{buttonName}}</button>
</template>
<script>
    import $ from "jquery";
    import {getPhoneVerifyCode} from "../api/util";

    export default {
        props: ['mobile'],
        data() {
            return {
                buttonName: "获取验证码",
                isDisabled: false,
                time: 120,
                ticket: null,
                randstr: null,
            };
        },
        mounted() {
            const s = document.createElement('script');
            s.type = 'text/javascript';
            s.src = 'https://ssl.captcha.qq.com/TCaptcha.js';
            document.body.appendChild(s);
        },
        methods: {
            showCaptcha() {
                let captcha = new TencentCaptcha(process.env.MIX_CAPTCHA_ID,
                    res => {
                        if (res.ret === 0) {
                            this.ticket = res.ticket;
                            this.randstr = res.randstr;
                            this.sendSms();
                        } else {
                            return this.$message.error('请先完成验证！')
                        }
                    }
                );
                captcha.show()
            },
            sendSms() {
                let mobile = $("#" + this.mobile).val();
                const reg = /^1[3|4|5|6|7|8|9][0-9]\d{8}$/
                if (!reg.test(mobile)) {
                    this.$message.error('手机号不正确！');
                    return
                }

                getPhoneVerifyCode(mobile, this.ticket, this.randstr).then(response => {

                }).catch((error) => {
                    this.$message.error(error.message);
                });
                let vm = this;
                vm.isDisabled = true;

                function timeDone() {
                    vm.buttonName = '' + vm.time + '秒后重新发送';
                    --vm.time;
                    if (vm.time < 0) {
                        vm.buttonName = "重新发送";
                        vm.time = 120;
                        vm.isDisabled = false;
                        window.clearInterval(interval);
                    }
                }

                timeDone();
                let interval = window.setInterval(timeDone, 1000);
            }
        }
    }
</script>
