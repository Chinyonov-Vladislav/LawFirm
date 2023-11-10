<template>
    <!-- Heder Area -->
    <header class="header-area">
        <div class="top-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-sm-6">
                        <ul class="left-info">
                            <li>
                                <a href="##">
                                    <i class="las la-envelope"></i>
                                    example@gmail.com
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <i class="las la-phone"></i>
                                    +7(949) 456-73-89
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-6 col-sm-6">
                        <ul class="right-info" v-if="!currentUserAuth">
                            <li class="text-center heder-btn size_buttons">
                                <a href="/login">Авторизация</a>
                            </li>
                            <li class="text-center heder-btn size_buttons mt-md-2 mt-sm-2 mt-2 mt-lg-0 mt-xl-0">
                                <a href="/register">Регистрация</a>
                            </li>
                        </ul>
                        <ul class="right-info" v-else>
                            <li class="text-center heder-btn size_buttons text-truncate">
                                <a :href="'/user/'+currentUserAuth.id">{{ currentUserAuth.name }}</a>
                            </li>
                            <li class="text-center heder-btn size_buttons mt-md-2 mt-sm-2 mt-2 mt-lg-0 mt-xl-0 text-truncate">
                                <a @click="Logout" style="cursor:pointer;">Выйти из аккаунта</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Start Navbar Area -->
        <div class="navbar-area">
            <div class="atorn-responsive-nav">
                <div class="container">
                    <div class="atorn-responsive-menu">
                        <div class="logo">
                            <div class="row">
                                <div class="col-3">
                                    <a href="/">
                                        <img src="/photos/logo.png" alt="logo">
                                    </a>
                                </div>
                                <div class="col-9 d-flex align-items-center">
                                    <h6>Правовой Арсенал</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="atorn-nav">
                <div class="container">
                    <nav class="navbar navbar-expand-md navbar-light">
                        <div class="row w-100">
                            <div class="col-3 d-flex justify-content-center flex-column align-items-center">
                                <a class="navbar-brand" href="/">
                                    <img src="/photos/logo.png" alt="logo">
                                </a>
                                <h6>Правовой Арсенал</h6>
                            </div>
                            <div class="col-9">
                                <div class="collapse navbar-collapse mean-menu">
                                    <ul class="navbar-nav ms-auto">
                                        <li class="nav-item">
                                            <a href="/" class="nav-link">
                                                Домашняя
                                            </a>
                                        </li>
                                        <li class="nav-item" v-if="specializations.length>0">
                                            <a href="/specializations" class="nav-link">
                                                Специализация <i class="las la-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="nav-item" v-for="item in specializations">
                                                    <a :href="'/specialization/'+item.id" class="nav-link">{{
                                                            item.name
                                                        }}</a>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="nav-item">
                                            <a href="/services" class="nav-link">
                                                Услуги
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="/lawyers" class="nav-link">
                                                Адвокаты
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="/blog" class="nav-link">
                                                Блог
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="/reviews" class="nav-link">
                                                 Отзывы
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="/faq" class="nav-link">
                                                FAQ
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/aboutUs" class="nav-link">
                                                О нас
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <!-- End Navbar Area -->
    </header>
    <!-- End Heder Area -->
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";

export default {
    name: "Header",
    data() {
        return {
            currentUserAuth: null,
            specializations: []
        }
    },
    /*computed:{
      showButtonLoginAndRegister()
      {
          !this.currentUserAuth && (window.location.href.split('/').pop() !== 'login'|| window.location.href.split('/').pop() !== 'register')
      }
    },*/
    watch: {
        new_username(newVal, oldVal) {
            // Этот код будет выполнен при изменении пропса someProp
            console.log("Отработал watch");
            if (newVal !== oldVal) {
                this.currentUserAuth.name = newVal;
            }

            // Вызовите нужную вам функцию или выполните другие действия при изменении пропса
        }
    },
    props:
        {
            new_username: {
                default: null
            }
        },
    methods: {
        sendInfoAuthUser() {
            this.$root.$emit("sendInfoUser", this.currentUserAuth);
        },
        getAllSpecializations() {
            axios.post("/getSpecializations")
                .then((response) => {
                    console.log(response);
                    response.data.specializations.map((elem) => {
                        this.specializations.push(elem);
                    });
                })
                .catch((error) => {

                });
        },
        Logout() {
            axios.post("/logout").then(
                (response) => {
                    location.reload();
                    console.log("then");
                    console.log(response);
                }
            ).catch((error) => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Произошла ошибка при выходе из аккаунта',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = "/login";
                });
            });
        }
    },
    created() {
        this.$axios.post(`/checkAuthUser`).then(response => {
            this.currentUserAuth = response.data.UserAuth;
            this.sendInfoAuthUser();
        });
        this.getAllSpecializations();
    }
}


</script>

<style scoped>
.size_buttons{
    min-width: 250px;
    max-width: 250px;
}
</style>
