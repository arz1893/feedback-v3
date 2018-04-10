<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for..." v-model="searchString">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" @click="filterByName()">
                                    <i class="ion ion-search"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <multiselect id="select_tags"
                                     v-model="selectedTags"
                                     :options="options"
                                     :multiple="true"
                                     :close-on-select="false"
                                     :clear-on-select="false"
                                     :hide-selected="true"
                                     :preserve-search="true"
                                     placeholder="Choose Tag..."
                                     label="name"
                                     track-by="name">
                        </multiselect>
                    </div>
                </div>

                <button type="button" class="btn btn-link" @click="getProductList()">
                    Refresh List <i class="fa fa-refresh"></i>
                </button>
            </div>
        </div>

        <transition name="fade" mode="out-in">
            <div id="product_panel" class="col-lg-12">
                <div class="row visible-lg visible-md visible-sm">
                    <div v-if="searchStatus.length > 0" class="text-center"><i class="fa fa-spinner fa-spin"></i> {{ searchStatus }}</div>
                    <div v-show="errorMessage !== ''">
                        <div class="well text-center">
                            {{ errorMessage }}
                        </div>
                    </div>
                    <div v-show="searchStatus === ''" class="col-lg-2 col-md-3 col-sm-4 col-xs-4" v-for="product in products">
                        <div class="imagebox">
                            <a role="button" v-if="type === 'feedback'" :href="product.show_feedback_url">
                                <img v-show="product.img !== ''" v-bind:src="product.img"  class="category-banner img-responsive">
                                <img v-show="product.img === ''" v-bind:src="default_image"  class="category-banner img-responsive">
                                <span class="imagebox-desc">
                                {{ product.name }}
                            </span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row visible-xs">
                    <div v-if="searchStatus.length > 0" class="text-center"><i class="fa fa-spinner fa-spin"></i> {{ searchStatus }}</div>
                    <div v-show="errorMessage !== ''">
                        <div class="well text-center">
                            {{ errorMessage }}
                        </div>
                    </div>
                    <div class="list-group">
                        <div v-show="searchStatus === ''" v-for="product in products">
                            <a role="button" class="list-group-item">
                                <img v-bind:src="product.img" style="width: 40px; height: 30px;">
                                {{ product.name }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </transition>

        <div class="text-center">
            <ul v-show="pagination.currentPage !== ''" class="pagination">
                <li v-bind:class="{disabled:pagination.prevPage === null}">
                    <a v-if="pagination.prevPage !== null" role="button" aria-label="Previous" @click="changePage(pagination.prevPage)">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                    <a v-else role="button" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li v-for="n in pagination.endPage" v-bind:class="{ active:n===pagination.currentPage }">
                    <a v-if="n !== pagination.currentPage" role="button" @click="changePage(pagination.path + '?page=' + n)">{{ n }}</a>
                    <a v-else role="button">{{ n }}</a>
                </li>
                <li v-bind:class="{disabled:pagination.nextPage === null}">
                    <a v-if="pagination.nextPage !== null" role="button" aria-label="Next" @click="changePage(pagination.nextPage)">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                    <a v-else role="button">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: "service-selection",
        props: ['tenant_id', 'type'],
        data() {
            return {
                services: [],
                searchString: '',
                options: [],
                selectedTags: [],
                searchStatus: '',
                default_image: window.location.protocol + "//" + window.location.host  + '/default-images/no-image.jpg',
                pagination: {
                    currentPage: '',
                    endPage: '',
                    prevPage: null,
                    nextPage: null,
                    path: ''
                }
            }
        },
        methods: {
            getServiceList: function () {

            }
        }
    }
</script>

<style scoped>

</style>