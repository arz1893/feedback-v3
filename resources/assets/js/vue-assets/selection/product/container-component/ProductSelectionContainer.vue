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
                            <a role="button">
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

        <div class="col-lg-12">
            <ul class="pager">
                <li v-show="pagination.prevPage === null" v-bind:class="{'disabled' : pagination.prevPage === null}"><a href="#prev">&larr; Prev</a></li>
                <li v-show="pagination.prevPage !== null"><a href="#prev" @click="nextPage(pagination.prevPage)">&larr; Prev</a></li>
                <li v-show="pagination.nextPage === null" v-bind:class="{'disabled' : pagination.nextPage === null}"><a href="#next">Next &rarr;</a></li>
                <li v-show="pagination.nextPage !== null"><a href="#next" @click="nextPage(pagination.nextPage)">Next &rarr;</a></li>
            </ul>
            <div class="text-center">Page {{ pagination.currentPage }} of {{ pagination.endPage }}</div>
        </div>
    </div>
</template>

<script>
    import MultiSelect from 'vue-multiselect';

    Vue.component('multiselect', MultiSelect);

    export default {
        name: "product-selection",
        props: ['tenant_id'],
        data() {
            return {
                products: [],
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
        watch: {
            selectedTags: function (value) {
                var vm = this;

                if(value.length === 0) {
                    vm.getProductList();
                } else {
                    var tagIds = [];
                    for(var i=0;i<value.length;i++) {
                        tagIds.push(value[i].systemId);
                    }
                    const url = window.location.protocol + "//" + window.location.host + "/" + 'api/product/' + vm.tenant_id + '/filter-product-list/' + tagIds;
                    vm.searchStatus = 'Searching...';
                    vm.searchString = '';
                    console.log(value);
                    function filterProducts() {

                        axios.get(url)
                            .then(function (response) {
                                console.log(response.data.data);
                                if (response.data.data.length === 0) {
                                    vm.products = response.data.data;
                                    vm.errorMessage = 'no data found';
                                    vm.searchStatus = '';
                                } else {
                                    vm.products = response.data.data;
                                    vm.makePagination(response.data);
                                    vm.errorMessage = '';
                                    vm.searchStatus = '';
                                }
                            })
                            .catch(error => {
                                console.log(Object.assign({}, error));
                            });
                    }

                    var debounceFunction = _.debounce(filterProducts, 1000);
                    debounceFunction();
                }
            }
        },
        created() {
            this.getTagList();
            this.getProductList();
        },
        methods: {
            getProductList: function () {
                this.errorMessage = '';
                this.searchString = '';
                this.searchStatus = '';
                const url = window.location.protocol + "//" + window.location.host  + '/api/product/' + this.tenant_id + '/get-all-product';
                axios.get(url).then(response => {
                    console.log(response.data.data);
                    this.products = response.data.data;
                    this.makePagination(response.data);
                }).catch(error => {
                    console.log(error);
                });
            },

            getTagList: function() {
                const url = window.location.protocol + "//" + window.location.host  + '/api/tag/' + this.tenant_id + '/generate-select-tag';
                axios.get(url).then(response => {
                    this.options = response.data;
                }).catch(error => {
                    console.log(error);
                });
            },

            makePagination: function (data) {
                let vm = this;
                vm.pagination.currentPage = data.meta.current_page;
                vm.pagination.endPage = data.meta.last_page;
                vm.pagination.path = data.meta.path;
                vm.pagination.prevPage = (data.links.prev === null ? null:data.links.prev);
                vm.pagination.nextPage = (data.links.next === null ? null:data.links.next);
            },
            filterByName: function () {
                var vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/product/' + vm.tenant_id + '/filter-by-name/' + vm.searchString;
                vm.searchStatus = 'Searching...';
                vm.errorMessage = '';
                if (vm.searchString.length > 0) {
                    function fireRequest() {
                        axios.get(url).then(response => {
                            if (response.data.data.length === 0) {
                                vm.errorMessage = 'no data found';
                                vm.searchStatus = '';
                                vm.products = response.data.data;
                                vm.pagination.currentPage = '';
                            } else {
                                vm.products = response.data.data;
                                vm.makePagination(response.data);
                                vm.searchStatus = '';
                            }
                        }).catch(error => {
                            console.log(error);
                        });
                    }
                    var debounceFunction = _.debounce(fireRequest, 1000);
                    debounceFunction();
                } else {
                    vm.getProductList();
                }
            }
        }
    }
</script>

<style scoped>

</style>