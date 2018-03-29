<template>
    <div>

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

        <div class="row">
            <div class="col-lg-7 col-md-4 col-sm-5">
                <div class="form-inline pull-left" id="form_search_list">
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

            <div class="visible-xs">
                <br> <br>
            </div>

            <div class="col-lg-4 col-md-5 col-sm-5 col-lg-offset-1">
                <multiselect id="select_tags" v-model="selectedTags" :options="options" :multiple="true" :close-on-select="false" :clear-on-select="false" :hide-selected="true" :preserve-search="true" placeholder="Choose Tag..." label="name" track-by="name"></multiselect>
            </div>
        </div> <br>

        <div class="row">
            <div class="col-lg-12">
                <button type="button" class="btn btn-link" @click="getProductList()">
                    Refresh List <i class="fa fa-refresh"></i>
                </button>

                <div v-if="searchStatus.length > 0" class="text-center"><i class="fa fa-spinner fa-spin"></i> {{ searchStatus }}</div>
                <div v-show="errorMessage !== ''">
                    <div class="well text-center">
                        {{ errorMessage }}
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive" v-show="errorMessage === ''">
            <table class="table table-bordered table-striped" cellspacing="0" width="100%" id="table_product">
                <thead>
                <tr>
                    <th width="10%">Image</th>
                    <th width="20%">Name</th>
                    <th>Tags</th>
                    <th width="10%">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="product in products">
                    <td>
                        <a role="button" v-bind:href="product.show_product_url">
                            <img v-if="product.img !== ''" v-bind:src="product.img" style="width: 75px; height: 50px;">
                            <img v-else v-bind:src="default_image" style="width: 75px; height: 50px;">
                        </a>
                    </td>
                    <td>
                        <a role="button" v-bind:href="product.show_product_url">
                            {{ product.name }}
                        </a>
                    </td>
                    <td>
                        <div v-if="product.productTags.length > 0">
                            <span v-for="tag in product.productTags" class="label" v-bind:style="{ background: tag.bgColor, 'margin-right': '2px'}">
                                {{ tag.name }}
                            </span>
                        </div>
                        <div v-else>-</div>
                    </td>
                    <td>
                        <a v-bind:href="product.show_edit_product_url" role="button" class="btn btn-warning">
                            <i class="fa fa-pencil-square"></i>
                        </a>
                        <button class="btn btn-danger">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

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

        <input type="hidden" v-bind:value="tenantid" name="tenantId" id="tenantId"/>
    </div>
</template>

<script>

    import MultiSelect from 'vue-multiselect';

    Vue.component('multiselect', MultiSelect);

    export default {
        name: "product-index-component",
        props: ['tenantid'],
        template: '#demo-template',
        data() {
            return {
                products: [],
                product: {
                    name: '',
                    description: '',
                    img: '',
                    tags: []
                },
                pagination: {
                    currentPage: '',
                    endPage: '',
                    prevPage: '',
                    nextPage: '',
                    path: ''
                },
                default_image: window.location.protocol + "//" + window.location.host  + '/default-images/no-image.jpg',
                searchStatus: '',
                searchString: '',
                errorMessage: '',
                selectedTags: [],
                options: []
            }
        },
        created() {
            this.getProductList();
            this.getTagList();
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
                    const url = window.location.protocol + "//" + window.location.host + "/" + 'api/product/' + vm.tenantid + '/filter-product-list/' + tagIds;
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
        methods: {
            getProductList: function () {
                this.errorMessage = '';
                this.searchString = '';
                const url = window.location.protocol + "//" + window.location.host  + '/api/product/' + this.tenantid + '/get-all-product';
                axios.get(url).then(response => {
                    console.log(response.data.data);
                    this.products = response.data.data;
                    this.makePagination(response.data);
                }).catch(error => {
                    console.log(response);
                });
            },

            getTagList: function() {
                const url = window.location.protocol + "//" + window.location.host  + '/api/tag/' + this.tenantid + '/generate-select-tag';
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

            changePage: function (url) {
                var vm = this;
                vm.searchStatus = 'Loading...';
                function fireRequest(vm) {
                    axios.get(url).then(response => {
                        vm.products = response.data.data;
                        vm.makePagination(response.data);
                        vm.searchStatus = '';
                    }).catch(error => {
                        console.log('something wrong within the process');
                        console.log(Object.assign({}, error));
                    });
                }

                var debounceFunction = _.debounce(fireRequest, 1000);
                debounceFunction(vm);
            },
            
            filterByName: function () {
                var vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/product/' + vm.tenantid + '/filter-by-name/' + vm.searchString;
                vm.searchStatus = 'Searching...';
                vm.errorMessage = '';
                if (vm.searchString !== '') {
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
                }
            }
        }
    }
</script>


<style scoped>

</style>