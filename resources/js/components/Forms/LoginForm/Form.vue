<template>
    <div class="row align-self-center justify-content-center h-100">
        <div class="col-lg-2 my-auto" v-if="!app.login">
            <div id="login-form-container" >
                <div class="card shadow" >
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
                                           v-model="from.account">
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
                                           v-model="from.email">
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
                                           v-model="from.password">
                                </div>
                            </div>
                            <div class="form-group text-right mb-0">
                                <button @click="submit" class="btn btn-primary" type="submit">Login</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 my-auto" v-else>
            <div class="text-center user">
                <img :src="app.user.avatar" :alt="app.user.avatar" class="img-fluid border border-light avatar shadow">
                <div class="bg-light pt-5 mt-n5 rounded shadow">
                    <p class="welcome mb-0 mt-2">
                        <strong>Welcome</strong>
                    </p>
                    <p class="font-exo full-name text-muted px-3 pt-0 pb-3 text-uppercase">
                       <strong>{{ app.user.fullName}}</strong>
                    </p>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
    export default {
        name: "LoginForm",
        data: function() {
            return {
                from: {
                    account : '',
                    email   : '',
                    password: '',
                },
                app: {
                    submitting  : false,
                    login       : false, //false
                    user        : {
                        fullName    : '',
                        avatar      : ''
                    },
                }
            }
        },
        methods: {
            submit(){
                axios.post('leankit/login',this.from,{'errorHandle' : true})
                    .then( response => {
                        this.app.user = response.data;
                        this.app.user.avatar = response.data.avatar.replace('/?s=25','?s=300');
                        this.app.login = true;

                        setTimeout(() => {
                            this.$router.push('/board');
                        }, 3000)
                    })
                    .catch( error => {
                        console.log(error);
                    });
            }
        },
        computed: {
            formValidation: function(){
                return true;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .user {
        img {
            border-width: 5px !important;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            border-radius: 50%;
            width: 300px;
            height: 300px;

        }

        .welcome{
            font-size: 1.5rem;
        }

        .full-name{
            font-size: 3.5rem;
        }
    }
</style>