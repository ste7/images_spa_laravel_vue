<template>
    <div class="login-container container-fluid" id="login">

        <div class="row">
            <div class="modal-content-login col-xl-4 col-lg-6 col-md-8 col-sm-8 col-10 login-box">

                <div class="close-wrap">
                    <span class="login-close" @click.prevent="close">&times</span>
                </div>

                <div class="login-title">
                    <small class="text-muted">Login with</small>
                </div>

                <div class="btns">
                    <!--<a class=" btn btn-default btn-social" @click.prevent="authenticate('google')"><i class="fab fa-google"></i> Google</a>-->
                    <a class=" btn btn-default btn-social" @click.prevent="authenticate('github')"><i class="fab fa-github"></i> GitHub</a>
                </div>


                <div class="login-title">
                    <small class="text-muted">Or</small>
                </div>

                <div :class="{ 'alert alert-danger': error }">
                    <small>{{ error }}</small>
                </div>

                <form method="post">

                    <div class="form-group">
                        <small id="email" class="form-text text-muted">Email address</small>
                        <input type="email" class="form-control" id="email" name="email"
                               :class="{'email': true, 'is-invalid': errors.has('email') }"
                               v-validate="'required|email'"
                               v-model="email" placeholder="Enter email">
                        <small v-show="errors.has('email')" class="help text-danger">{{ errors.first('email') }}</small>

                    </div>

                    <div class="form-group">
                        <small id="password" class="form-text text-muted">Password</small>
                        <input type="password" class="form-control" id="password" name="password"
                               :class="{'password': true, 'is-invalid': errors.has('password') }"
                               v-validate="'required'"
                               v-model="password" placeholder="Enter password">
                        <small v-show="errors.has('password')" class="help text-danger">{{ errors.first('password') }}</small>
                    </div>

                    <button type="button" class="btn btn-primary login-btn" @click.prevent="loginRegular">Login</button>
                </form>
            </div>
        </div>


    </div>
</template>


<script>
    import { mapActions, mapMutations } from 'vuex'
    import axios from 'axios'

    export default {
        data() {
            return {
                email: null,
                password: null,
                error: null,

                signinWin: ''
            }
        },

        methods: {
            ...mapActions({
                login: 'login',
                auth: 'authenticate'
            }),

            loginRegular() {
                this.error = null;
                this.$validator.validateAll().then((result) => {
                    this.error = null;
                    if (result) {
                        this.error = null;
                        this.login({
                            email: this.email,
                            password: this.password,
                        }).then((response) => {
                            document.getElementById('login').style.display = 'none';
                        }).catch((error) => {
                            this.error = error.response.data.error;
                        });
                    }
                });
            },

            authenticate (provider) {
                let this_ = this;
                this_.close();
                console.log('open')

                this.$auth.authenticate(provider).then(function (response) {
                    console.log('yes')
                    this_.$store.commit('storeUser', response.data.user.data)
                    localStorage.setItem('user', JSON.stringify(response.data.user))
                    // location.reload();
                }).catch((error) => {
                    console.log('no')
                    console.log(error)
                    console.log(error.response)
                    console.log(error.data)
                    console.log(error.response.data)
                })
            },

            close() {
                this.error = null;
                document.getElementById('login').style.display = 'none';
            }
        }
    }
</script>


<style>
    #login {
        display: none;
    }

    .login-container {
        display: block;
        position: fixed;
        z-index: 1;
        padding-top: 100px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);
    }

    .close-wrap {
        text-align: right;
    }

    .login-close {
        float: right;
        cursor: pointer;
        font-weight: bold;
        color: #ea3a3a;
    }

    .modal-content-login {
        background-color: #fefefe;
        margin: auto;
        border: 1px solid #888;
    }

    .modal-content-login {
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.4s;
        animation-name: zoom;
        animation-duration: 0.4s;
    }


    .login-box {
        background-color: white;
        padding: 20px;
    }

    .btns {
        vertical-align: top;
    }

    .btn-social {
        border: 1px solid #a09f9f;
        border-radius: 0;
        right: 0;
        width: 100%;
        vertical-align: top;
        margin: 10px 0 10px 0;
    }


    .form-control {
        border-radius: 0;
    }

    .login-title {
        text-align: center;
    }

    .login-title > small {
        margin: 0;
        color: #bababa;
    }

    .login-btn {
        border-radius: 0;
        width: 100%;
    }
</style>