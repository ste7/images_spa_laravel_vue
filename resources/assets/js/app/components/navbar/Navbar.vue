<template>
    <div class="navbar-container">
        <nav class="navbar navbar-expand-lg fixed-top  navbar-dark">
            <div class="container">

                <router-link class="navbar-brand" to="/"><b>HOME</b></router-link>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <router-link class="nav-link" to="/explore">Explore</router-link>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://github.com/ste7" target="_blank">GitHub</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav mr-auto"></ul>


                    <ul class="navbar-nav" v-if="authenticated">
                        <li class="nav-item dropdown">
                            <a class="nv-link dropdown-toggle" href="#" id="navbarDropdown" @click.prevent="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <img class="nav-avatar" :src="user.data.avatar">
                                {{ user.data.name }}
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown" :class="{down: dropActive}">
                                <a class="dropdown-item logout-btn" @click.prevent="closeDrop">Profile</a>
                                <button class="dropdown-item logout-btn" @click.prevent="logout">Logout</button>
                            </div>

                        </li>
                    </ul>

                    <ul class="navbar-nav" v-else>
                        <li class="nav-item">
                            <a class="nav-link" @click.prevent="openLogin">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" @click.prevent="openRegister">Register</a>
                        </li>
                    </ul>
                </div>

            </div>
        </nav>
    </div>
</template>


<script>
    import { mapGetters, mapActions } from 'vuex'

    export default {
        data() {
            return {
                dropActive: false
            }
        },

        computed: {
            ...mapGetters({
                authenticated: 'authenticated',
                user: 'getUser'
            })
        },

        methods: {
            ...mapActions({
                out: 'logout'
            }),

            logout() {
                this.redirectIf();
                this.out();
                this.dropActive = false;
            },

            redirectIf() {
                let url = window.location.href;
                let compare = url.indexOf("http://localhost:8000/#/profile");

                if (compare !== -1) {
                    window.location.href = 'http://localhost:8000/#/';
                }
            },

            openLogin() {
                document.getElementById('register').style.display = 'none';
                document.getElementById('login').style.display = 'block';
            },

            openRegister() {
                document.getElementById('login').style.display = 'none';
                document.getElementById('register').style.display = 'block';
            },

            dropdown() {
                if (this.dropActive === false) this.dropActive = true;
                else if (this.dropActive === true) this.dropActive = false;
            },

            closeDrop() {
                this.dropActive = false;
                window.location.replace('#/profile');
            }
        }
    }
</script>


<style>
    .navbar-container {
        margin-bottom: 60px;
    }

    .down {
        display: block;
    }

    .navbar {
        background-color: #2b2b2b;
        padding-top: 5px!important;
        padding-bottom: 5px!important;
    }

    .nav-link, .nv-link {
        cursor: pointer;
        color: #c6c6c6!important;
        font-size: 14px;
    }

    .nv-link:hover {
        text-decoration: none;
    }

    .navbar-brand:hover, .nav-link:hover, .nv-link:hover {
        color: #afaeae!important;
    }

    .nav-avatar {
        width: 30px;
        border: 1px solid white;
        border-radius: 50%;
    }

    .dropdown-item:focus {
        background-color: #e2e0e0;
    }

    .logout-btn {
        cursor: pointer;
    }
</style>