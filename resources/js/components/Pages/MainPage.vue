<template>
    <fragment>
        <my-preloader></my-preloader>
        <my-header></my-header>
        <div class="law-card-area pt-100" style="margin-top: 50px">
            <div class="container">
                <div class="card-contant">
                    <div class="row no-gutters">
                        <div class="col-lg-3 bor-right col-sm-6">
                            <div class="low-card">
                                <h3>Court Performance</h3>
                                <i class="las la-home"></i>
                                <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis
                                    praesentium voluptatum deleniti atque.</p>
                            </div>
                        </div>

                        <div class="col-lg-3 bor-right col-sm-6">
                            <div class="low-card">
                                <h3>Document Review</h3>
                                <i class="las la-file-alt"></i>
                                <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis
                                    praesentium voluptatum deleniti atque.</p>
                            </div>
                        </div>

                        <div class="col-lg-3 bor-right col-sm-6">
                            <div class="low-card">
                                <h3>Expert Attorney</h3>
                                <i class="las la-balance-scale"></i>
                                <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis
                                    praesentium voluptatum deleniti atque.</p>
                            </div>
                        </div>

                        <div class="col-lg-3 bor-right col-sm-6">
                            <div class="low-card">
                                <h3>Case Dismissed</h3>
                                <i class="las la-gavel"></i>
                                <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis
                                    praesentium voluptatum deleniti atque.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="about-area pt-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title" style="text-align: center;">
                            <span>Наши преимущества</span>
                            <h2>We Are Providing <span>Top Services</span> With Excellent Performance</h2>
                        </div>
                        <div class="row about-text">
                            <div class="col-lg-6 advantages_left">
                                <ul>
                                    <li>
                                        <i class="las la-check-square"></i>
                                        100% Success Rate
                                    </li>
                                    <li>
                                        <i class="las la-check-square"></i>
                                        No Need Extra Cost for Consultation
                                    </li>
                                    <li>
                                        <i class="las la-check-square"></i>
                                        Expert Legal Service
                                    </li>
                                    <li>
                                        <i class="las la-check-square"></i>
                                        Highly Recommendation
                                    </li>
                                </ul>
                            </div>

                            <div class="col-lg-6 advantages_right">
                                <ul>
                                    <li>
                                        <i class="las la-check-square"></i>
                                        Fast Support
                                    </li>
                                    <li>
                                        <i class="las la-check-square"></i>
                                        High Court Performance
                                    </li>
                                    <li>
                                        <i class="las la-check-square"></i>
                                        Free Counseling
                                    </li>
                                    <li>
                                        <i class="las la-check-square"></i>
                                        Quick Complete Case
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="service-area ptb-100" v-if="specializations.length>0">
            <div class="container">
                <div class="section-title">
                    <span>Практики</span>
                    <h2>We Are Providing <span>Top Services</span> With Excellent Performance</h2>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-sm-6" v-for="item in specializations">
                        <div class="service-card">
                            <div class="service-text">
                                <i :class="'las '+item.Icon"></i>
                                <h3><a href="##">{{concatenateWords(item.Name)}} <span>{{getLastWord(item.Name)}}</span></a></h3> <!-- добавить ссылку -->
                                <p>{{item.Description}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="fun-facts-area pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="signle-fun-fact">
                            <i class="las la-balance-scale"></i>
                            <h3><span class="odometer odometer-auto-theme" data-count="5600"><div
                                class="odometer-inside"><span class="odometer-digit"><span
                                class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span
                                class="odometer-ribbon"><span class="odometer-ribbon-inner"><span
                                class="odometer-value">5</span></span></span></span></span><span
                                class="odometer-formatting-mark">,</span><span class="odometer-digit"><span
                                class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span
                                class="odometer-ribbon"><span class="odometer-ribbon-inner"><span
                                class="odometer-value">6</span></span></span></span></span><span class="odometer-digit"><span
                                class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span
                                class="odometer-ribbon"><span class="odometer-ribbon-inner"><span
                                class="odometer-value">0</span></span></span></span></span><span class="odometer-digit"><span
                                class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span
                                class="odometer-ribbon"><span class="odometer-ribbon-inner"><span
                                class="odometer-value">0</span></span></span></span></span></div></span>+
                            </h3>
                            <p>Solved Cases</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="signle-fun-fact">
                            <i class="las la-gavel"></i>
                            <h3><span class="odometer odometer-auto-theme" data-count="4000"><div
                                class="odometer-inside"><span class="odometer-digit"><span
                                class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span
                                class="odometer-ribbon"><span class="odometer-ribbon-inner"><span
                                class="odometer-value">4</span></span></span></span></span><span
                                class="odometer-formatting-mark">,</span><span class="odometer-digit"><span
                                class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span
                                class="odometer-ribbon"><span class="odometer-ribbon-inner"><span
                                class="odometer-value">0</span></span></span></span></span><span class="odometer-digit"><span
                                class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span
                                class="odometer-ribbon"><span class="odometer-ribbon-inner"><span
                                class="odometer-value">0</span></span></span></span></span><span class="odometer-digit"><span
                                class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span
                                class="odometer-ribbon"><span class="odometer-ribbon-inner"><span
                                class="odometer-value">0</span></span></span></span></span></div></span>+
                            </h3>
                            <p>Cases Won</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="signle-fun-fact">
                            <i class="las la-trophy"></i>
                            <h3><span class="odometer odometer-auto-theme" data-count="1500"><div
                                class="odometer-inside"><span class="odometer-digit"><span
                                class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span
                                class="odometer-ribbon"><span class="odometer-ribbon-inner"><span
                                class="odometer-value">1</span></span></span></span></span><span
                                class="odometer-formatting-mark">,</span><span class="odometer-digit"><span
                                class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span
                                class="odometer-ribbon"><span class="odometer-ribbon-inner"><span
                                class="odometer-value">5</span></span></span></span></span><span class="odometer-digit"><span
                                class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span
                                class="odometer-ribbon"><span class="odometer-ribbon-inner"><span
                                class="odometer-value">0</span></span></span></span></span><span class="odometer-digit"><span
                                class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span
                                class="odometer-ribbon"><span class="odometer-ribbon-inner"><span
                                class="odometer-value">0</span></span></span></span></span></div></span>+
                            </h3>
                            <p>Awards Won</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="signle-fun-fact">
                            <i class="lab la-gitkraken"></i>
                            <h3><span class="odometer odometer-auto-theme" data-count="10"><div class="odometer-inside"><span
                                class="odometer-digit"><span class="odometer-digit-spacer">8</span><span
                                class="odometer-digit-inner"><span class="odometer-ribbon"><span
                                class="odometer-ribbon-inner"><span class="odometer-value">1</span></span></span></span></span><span
                                class="odometer-digit"><span class="odometer-digit-spacer">8</span><span
                                class="odometer-digit-inner"><span class="odometer-ribbon"><span
                                class="odometer-ribbon-inner"><span class="odometer-value">0</span></span></span></span></span></div></span>
                            </h3>
                            <p>Top 10 Law Firms</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="blog-area pt-100 pb-70">
            <div class="container">
                <div class="section-title">
                    <span>Последние новости из мира юриспруденции от наших адвокатов</span>
                    <h2>Top <span>Blog</span> Related To Law, Cases &amp; Consulting</h2>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-sm-6">
                        <div class="blog-card">
                            <a href="blog-details.html">
                                <img src="/photos/news.jpg" alt="Image">
                            </a>
                            <div class="blog-card-text">
                                <h3><a href="blog-details.html">Новость 1</a></h3>
                                <ul>
                                    <li>
                                        <i class="las la-calendar"></i>
                                        22 Sep 2021
                                    </li>
                                    <li>
                                        <i class="las la-user-alt"></i>
                                        Thomas Albeny
                                    </li>
                                </ul>

                                <p>At vero eos et accusamus et iusto odio praesentium voluptatum deleniti atque corrupti
                                    quos dolores et quas molestias excepturi sint occaecati cupiditate.</p>

                                <a href="blog-details.html" class="read-more">
                                    Read More <i class="las la-angle-double-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <div class="blog-card">
                            <a href="blog-details.html">
                                <img src="assets/img/news&amp;blog/blog2.jpg" alt="Image">
                            </a>
                            <div class="blog-card-text">
                                <h3><a href="blog-details.html">Broken Bonds: rights after a divorce</a></h3>
                                <ul>
                                    <li>
                                        <i class="las la-calendar"></i>
                                        23 Sep 2021
                                    </li>
                                    <li>
                                        <i class="las la-user-alt"></i>
                                        Rick Barry
                                    </li>
                                </ul>

                                <p>At vero eos et accusamus et iusto odio praesentium voluptatum deleniti atque corrupti
                                    quos dolores et quas molestias excepturi sint occaecati cupiditate.</p>

                                <a href="blog-details.html" class="read-more">
                                    Read More <i class="las la-angle-double-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6 offset-sm-3 offset-lg-0">
                        <div class="blog-card">
                            <a href="blog-details.html">
                                <img src="assets/img/news&amp;blog/blog3.jpg" alt="Image">
                            </a>
                            <div class="blog-card-text">
                                <h3><a href="blog-details.html">The virtue of justice consists in moderation</a></h3>
                                <ul>
                                    <li>
                                        <i class="las la-calendar"></i>
                                        24 Sep 2021
                                    </li>
                                    <li>
                                        <i class="las la-user-alt"></i>
                                        Julius Erving
                                    </li>
                                </ul>

                                <p>At vero eos et accusamus et iusto odio praesentium voluptatum deleniti atque corrupti
                                    quos dolores et quas molestias excepturi sint occaecati cupiditate.</p>

                                <a href="blog-details.html" class="read-more">
                                    Read More <i class="las la-angle-double-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <my-footer></my-footer>
    </fragment>
</template>

<script>
import Preloader from "../LayoutComponents/Preloader.vue";

export default {
    name: "MainPage",
    components: {Preloader},
    props:{
        specializations:{
            default: []
        },
        news:{
            default:[]
        }
    },
    methods:{
        getLastWord(str)
        {
            const words = str.split(' ');
            return words[words.length - 1];
        },
        concatenateWords(str)
        {
           return str.split(' ').slice(0,-1).join(' ')
        }
    },
    mounted() {
      console.log(this.specializations);
    }
}
</script>

<style scoped>

</style>
