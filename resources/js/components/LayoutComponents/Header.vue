<template>
    <!-- Heder Area -->
    <header class="header-area">
        <div class="top-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-sm-6">
                        <ul class="left-info">
                            <li>
                                <a href="mailto:hello@atorn.com">
                                    <i class="las la-envelope"></i>
                                    hello@atorn.com
                                </a>
                            </li>
                            <li>
                                <a href="tel:+823-456-879">
                                    <i class="las la-phone"></i>
                                    +0123 456 789
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-6 col-sm-6">
                        <ul class="right-info" v-if="!currentUserAuth">
                            <li class="heder-btn">
                                <a href="/login">Авторизация</a>
                            </li>
                            <li class="heder-btn">
                                <a href="/register">Регистрация</a>
                            </li>
                        </ul>
                        <ul class="right-info" v-else>
                            <li class="heder-btn">
                                <a :href="'/user/'+currentUserAuth.id">{{currentUserAuth.name}}</a>
                            </li>
                            <li class="heder-btn">
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
                            <a href="/">
                                <img src="/photos/logo.png" alt="logo">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="atorn-nav">
                <div class="container">
                    <nav class="navbar navbar-expand-md navbar-light">
                        <a class="navbar-brand" href="index.html">
                            <img src="/photos/logo.png" alt="logo">
                        </a>

                        <div class="collapse navbar-collapse mean-menu">
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a href="/" class="nav-link">
                                        Домашняя
                                    </a>
                                </li>
                                <li class="nav-item" v-if="specializations.length>0">
                                    <a href="#" class="nav-link">
                                        Специализация <i class="las la-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item" v-for="item in specializations">
                                            <a :href="'/specialization/'+item.id" class="nav-link">{{item.Name}}</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        Услуги <i class="las la-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item">
                                            <a href="services.html" class="nav-link">Services</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="service-details.html" class="nav-link">Services Details</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        Дела  <i class="las la-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item">
                                            <a href="case-study.html" class="nav-link">Case Study</a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="case-study-details.html" class="nav-link">Case Study Details</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        Адвокаты <i class="las la-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item">
                                            <a href="attorney.html" class="nav-link">Attorney</a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="attorney-details.html" class="nav-link">Attorney Details</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="nav-item">
                                    <a href="/blog" class="nav-link">
                                        Блог
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
    methods:{
        sendInfoAuthUser()
        {
          this.$root.$emit("sendInfoUser", this.currentUserAuth);
        },
        getAllSpecializations()
        {
            return axios.post("/getSpecializations")
                .then((response)=>{
                    console.log(response);
                    response.data.specializations.map((elem)=>{
                        this.specializations.push(elem);
                    });
                })
                .catch((error)=>{

                });
        },
        Logout()
        {
            axios.post("/logout").then(
                (response)=>{
                    location.reload();
                    console.log("then");
                    console.log(response);
                }
            ).catch((error)=>{
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Произошла ошибка при выходе из аккаунта',
                    showConfirmButton: false,
                    timer: 1500
                }).then(()=>{
                    window.location.href="/login";
                });
            });
        }
    },
    created()
    {
        this.$axios.post(`/checkAuthUser`).then(response=>{
            this.currentUserAuth= response.data.UserAuth;
            this.sendInfoAuthUser();
        });
        this.getAllSpecializations();
    }
}



</script>

<style scoped>

</style>
