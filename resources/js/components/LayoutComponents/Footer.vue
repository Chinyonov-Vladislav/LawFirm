<template>
    <div class="mt-auto">
        <footer class="footer-area pt-100 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-sm-6">
                        <div class="footer-widget">
                            <div class="logo">
                                <img src="/photos/logo-white.png" alt="logo">
                            </div>
                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium
                                voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint
                                occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt
                                mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum.</p>

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
                            <h3>Quick Links</h3>

                            <ul class="footer-text">
                                <li>
                                    <a href="index.html">
                                        <i class="las la-star"></i>
                                        Home
                                    </a>
                                </li>
                                <li>
                                    <a href="about.html">
                                        <i class="las la-star"></i>
                                        About Us
                                    </a>
                                </li>
                                <li>
                                    <a href="services.html">
                                        <i class="las la-star"></i>
                                        Our Services
                                    </a>
                                </li>
                                <li>
                                    <a href="case-study.html">
                                        <i class="las la-star"></i>
                                        Case Study
                                    </a>
                                </li>
                                <li>
                                    <a href="blog.html">
                                        <i class="las la-star"></i>
                                        Our Blog
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="las la-star"></i>
                                        Clients Review
                                    </a>
                                </li>
                                <li>
                                    <a href="attorney.html">
                                        <i class="las la-star"></i>
                                        Our Attorneys
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-2 col-sm-6" v-if="specializations.length>0">
                        <div class="footer-widget pl-50">
                            <h3>Services</h3>
                            <ul class="footer-text">
                                <li v-for="item in specializations">
                                    <a :href="'/specialization/'+item.id">
                                        <i class="las la-star"></i>
                                        {{item.Name}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="footer-widget">
                            <h3>Contact Info</h3>

                            <ul class="info-list">
                                <li>
                                    <i class="las la-phone"></i>
                                    <a href="tel:+0123456987">+0123 456 987</a>
                                </li>
                                <li>
                                    <i class="las la-envelope"></i>
                                    <a href="mailto:atorn@info.com">atorn@info.com</a>
                                </li>
                                <li>
                                    <i class="las la-map-marker-alt"></i>
                                    Silven House, 4 Lower Gilmor Bank Edinburgh EH3 9QP, UK
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <div class="footer-bottom">
            <div class="container">
                <p>Copyright @{{new Date().getFullYear()}} Atorn. All rights reserved <a href="https://hibootstrap.com/" target="_blank">HiBootstrap</a>
                </p>
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
