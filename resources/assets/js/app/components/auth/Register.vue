<template>
    <div class="register-container container-fluid" id="register">

        <div class="row">
            <div class="modal-content-register col-xl-4 col-lg-6 col-md-8 col-sm-8 col-10 register-box">

                <div class="close-wrap">
                    <span class="register-close" @click.prevent="close">&times</span>
                </div>

                <div class="register-title">
                    <small class="text-muted">Register with</small>
                </div>

                <div class="btns">
                    <!--<a class=" btn btn-default btn-social" @click.prevent="authenticate('google')"><i class="fab fa-google"></i> Google</a>-->
                    <a class=" btn btn-default btn-social" @click.prevent="authenticate('github')"><i class="fab fa-github"></i> GitHub</a>
                </div>


                <div class="register-title">
                    <small class="text-muted">Or</small>
                </div>

                <div :class="{ 'alert alert-danger': error }">
                    <small>{{ error }}</small>
                </div>

                <form method="post">
                    <div class="form-group">
                        <small id="name" class="form-text text-muted">Name</small>
                        <input type="text" class="form-control" name="name"
                               :class="{'name': true, 'is-invalid': errors.has('name') }"
                               v-validate="'required|min:2|max:20'"
                               v-model="name" placeholder="Enter name">
                        <small v-show="errors.has('name')" class="help text-danger">{{ errors.first('name') }}</small>
                    </div>

                    <div class="form-group">
                        <small class="form-text text-muted">Email address</small>
                        <input type="email" class="form-control" name="email"
                               :class="{'email': true, 'is-invalid': errors.has('email') }"
                               v-validate="'required|email'"
                               v-model="email" placeholder="Enter email">
                        <small v-show="errors.has('email')" class="help text-danger">{{ errors.first('email') }}</small>
                    </div>

                    <div class="form-group">
                        <small class="form-text text-muted">Password</small>
                        <input type="password" class="form-control" name="password"
                               :class="{'password': true, 'is-invalid': errors.has('password') }"
                               v-validate="'required|min:6|max:20|confirmed'"
                               v-model="password" placeholder="Enter password">
                        <small v-show="errors.has('password')" class="help text-danger">{{ errors.first('password') }}</small>
                    </div>

                    <div class="form-group">
                        <small class="form-text text-muted">Confirm Password</small>
                        <input type="password" class="form-control" name="password_confirmation"
                               v-model="password_confirmation" placeholder="Enter password">
                    </div>

                    <button type="button" class="btn btn-primary login-btn" @click.prevent="registerRegular">Register</button>
                </form>
            </div>
        </div>


    </div>
</template>

<script>
    import { mapActions } from 'vuex'

    export default {
        data() {
            return {
                name: null,
                email: null,
                password: null,
                password_confirmation: null,
                error: null
            }
        },

        methods: {
            ...mapActions({
                register: 'register'
            }),

            registerRegular() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.register({
                            name: this.name,
                            email: this.email,
                            password: this.password,
                            password_confirmation: this.password_confirmation
                        }).then((response) => {
                            document.getElementById('register').style.display = 'none';
                        }).catch((error) => {
                            this.error = error.response.data.errors.email[0];
                        });
                    }
                });
            },

            authenticate (provider) {
                let this_ = this;
                this_.close();

                this.$auth.authenticate(provider).then(function (response) {
                    this_.$store.commit('storeUser', response.data.user.data)
                    localStorage.setItem('user', JSON.stringify(response.data.user))
                    // location.reload();
                }).catch((error) => {
                    console.log(error)
                })
            },

            close() {
                this.error = null;
                document.getElementById('register').style.display = 'none';
            }
        }
    }
</script>

<style>
    #register {
        display: none;
    }
    .register-container {
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

    .modal-content-register {
        background-color: #fefefe;
        margin: auto;
        border: 1px solid #888;
    }

    .modal-content-register {
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.4s;
        animation-name: zoom;
        animation-duration: 0.4s;
    }


    .register-box {
        background-color: white;
        padding: 20px;
    }

    .close-wrap {
        text-align: right;
    }

    .register-close {
        float: right;
        cursor: pointer;
        font-weight: bold;
        color: #ea3a3a;
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

    .register-title {
        text-align: center;
    }

    .register-title > small {
        margin: 0;
        color: #bababa;
    }

    .register-btn {
        border-radius: 0;
        width: 100%;
    }
</style>