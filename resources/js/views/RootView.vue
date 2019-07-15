<template>
    <div class="row align-self-center justify-content-center h-100">
        <div class="col-lg-2 my-auto">
            <div class="card">
                <h5 class="card-header text-center">LOGIN</h5>
                <div class="card-body">
                    <div class="form">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">https://</span>
                                </div>
                                <input aria-label="Leankit Account"
                                       class="form-control"
                                       placeholder="Account"
                                       type="text"
                                       v-model="app.from.account">
                                <div class="input-group-append">
                                    <span class="input-group-text">.leankit.com</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user-alt"></i></span>
                                </div>
                                <input aria-label="Leankit Account Email"
                                       class="form-control"
                                       placeholder="Email"
                                       type="text"
                                       v-model="app.from.email">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                <input aria-label="Leankit Account Password"
                                       class="form-control"
                                       placeholder="Password"
                                       type="password"
                                       v-model="app.from.password">
                            </div>
                        </div>
                        <div class="form-group text-right mb-0">
                            <button @click="login" class="btn btn-primary" type="submit">Login</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "RootView",
        data: function() {
            return {
                app: {
                    from : {
                        account : '',
                        email   : '',
                        password: '',
                    }
                },
                catalog     : {},

            }
        },
        methods: {
            login(){
                axios.post('leankit/login',this.app.from).then( response => {
                   console.log(response.data);
                });

            }
        }
    }
</script>

<style lang="scss" scoped>
</style>

