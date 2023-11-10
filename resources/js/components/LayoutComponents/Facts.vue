<template>
    <div class="fun-facts-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="signle-fun-fact h-100 d-flex flex-column">
                        <i class="las la-balance-scale"></i>
                        <h3><span class="odometer odometer-auto-theme" :data-count="count_cases"><div
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
                            class="odometer-value">0</span></span></span></span></span></div></span>
                            <template v-if="count_cases>9999">+</template>
                        </h3>
                        <p>Общее количество дел</p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="signle-fun-fact h-100 d-flex flex-column">
                        <i class="las la-gavel"></i>
                        <h3><span class="odometer odometer-auto-theme" :data-count="count_winner_cases"><div
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
                            class="odometer-value">0</span></span></span></span></span></div></span>
                            <template v-if="count_winner_cases>9999">+</template>
                        </h3>
                        <p>Количество выигранных дел</p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="signle-fun-fact h-100 d-flex flex-column">
                        <i class="las la-user-tie"></i>
                        <h3><span class="odometer odometer-auto-theme" :data-count="count_lawyers"><div
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
                            class="odometer-value">0</span></span></span></span></span></div></span>
                            <template v-if="count_lawyers>9999">+</template>
                        </h3>
                        <p>Количество дипломированных специалистов</p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="signle-fun-fact h-100 d-flex flex-column">
                        <i class="las la-user"></i>
                        <h3><span class="odometer odometer-auto-theme" :data-count="count_clients"><div class="odometer-inside"><span
                            class="odometer-digit"><span class="odometer-digit-spacer">8</span><span
                            class="odometer-digit-inner"><span class="odometer-ribbon"><span
                            class="odometer-ribbon-inner"><span class="odometer-value">1</span></span></span></span></span><span
                            class="odometer-digit"><span class="odometer-digit-spacer">8</span><span
                            class="odometer-digit-inner"><span class="odometer-ribbon"><span
                            class="odometer-ribbon-inner"><span class="odometer-value">0</span></span></span></span></span></div></span>
                            <template v-if="count_clients>9999">+</template>
                        </h3>
                        <p>Количество клиентов</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Facts",
    props:{
        prop_count_cases:{default:0},
        prop_count_winner_cases:{default:0},
        prop_count_lawyers:{default:0},
        prop_count_clients:{default:0}
    },
    data(){
        return {
            count_cases:0,
            count_winner_cases:0,
            count_lawyers:0,
            count_clients:0
        }
    },
    created()
    {
        this.count_cases = this.prop_count_cases;
        this.count_winner_cases = this.prop_count_winner_cases;
        this.count_lawyers = this.prop_count_lawyers;
        this.count_clients = this.prop_count_clients;
        let array = [this.count_cases,this.count_winner_cases,this.count_lawyers,this.count_clients];
        array.forEach((item)=>{
            if(item>9999)
            {
                item = 10000;
            }
        })
    }
}
</script>

<style scoped>

</style>
