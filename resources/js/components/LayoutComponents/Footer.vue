<template>
    <div class="mt-auto">
        <footer class="footer-area pt-100 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-sm-6">
                        <div class="footer-widget">
                            <div class="row">
                                <div class="col-3">
                                    <a class="navbar-brand" href="/">
                                        <img src="/photos/logoBigWhite.png" alt="logo">
                                    </a>
                                    </div>
                                <div class="col-9 d-flex justify-content-center flex-column">
                                    <h6 style="color:white">Правовой Арсенал</h6>
                                </div>
                            </div>

                            <p>В мире правовых вызовов и решений, выбирайте надежный союз правовой экспертизы. Правовой Арсенал – ваш гарант компетентности, ваша поддержка в мире юридической уверенности. Мы защищаем ваши интересы, вооружившись знанием и опытом. Вместе – сильнее в каждом правовом вызове жизни</p>

                            <ul class="footer-socials">
                                <li>
                                    <a href="#" target="_blank">
                                        <i class="lab la-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" target="_blank">
                                        <i class="lab la-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" target="_blank">
                                        <i class="lab la-instagram"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" target="_blank">
                                        <i class="lab la-google-plus"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-2 col-sm-6">
                        <div class="footer-widget">
                            <h3>Ссылки</h3>

                            <ul class="footer-text">
                                <li>
                                    <a href="/">
                                        <i class="las la-star"></i>
                                        Домашнаяя
                                    </a>
                                </li>
                                <li>
                                    <a href="/lawyers">
                                        <i class="las la-star"></i>
                                        Адвокаты
                                    </a>
                                </li>
                                <li>
                                    <a href="/aboutUs">
                                        <i class="las la-star"></i>
                                        О нас
                                    </a>
                                </li>
                                <li>
                                    <a href="/reviews">
                                        <i class="las la-star"></i>
                                        Отзывы
                                    </a>
                                </li>

                                <li>
                                    <a href="/blog">
                                        <i class="las la-star"></i>
                                        Блог
                                    </a>
                                </li>
                                <li>
                                    <a href="/faq">
                                        <i class="las la-star"></i>
                                        FAQ
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-2 col-sm-6" v-if="specializations.length>0">
                        <div class="footer-widget pl-50">
                            <h3>Услуги</h3>
                            <ul class="footer-text">
                                <li v-for="item in specializations">
                                    <a :href="'/specialization/'+item.id">
                                        <i class="las la-star"></i>
                                        {{item.name}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="footer-widget">
                            <h3>Контактные данные</h3>

                            <ul class="info-list">
                                <li>
                                    <i class="las la-phone"></i>
                                    <a href="##">+7(949) 456-73-89</a>
                                </li>
                                <li>
                                    <i class="las la-envelope"></i>
                                    <a href="##">example@gmail.com</a>
                                </li>
                                <li>
                                    <i class="las la-map-marker-alt"></i>
                                    283001, г. Донецк, пр. Театральный, д. 13
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <div class="footer-bottom">
            <div class="container">
                <p>Copyright @{{new Date().getFullYear()}} "Правовой арсенал".</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Footer",
    data() {
        return {
            specializations: []
        }
    },
    created() {
       this.getAllSpecializations();
    },
    methods:{
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
        }
    }
}
</script>

<style scoped>

</style>
