<template>
    <div>
        <div class="row">
            <div class="col-lg-8 col-md-4 col-sm-5">
                <form class="form-inline pull-left" id="form_search_list">
                    <!-- Date range -->
                    <div class="form-group">
                        <label for="date_start">From :</label>
                        <datepicker :calendar-button="true" :calendar-button-icon="'fa fa-calendar'" :bootstrap-styling="true" :input-class="'form-control'" v-model="startDate"></datepicker>
                        <!-- /.input group -->
                    </div>
                    <!-- Date range -->
                    <div class="form-group">
                        <label for="date_end">To :</label>
                        <datepicker :calendar-button="true" :calendar-button-icon="'fa fa-calendar'" :bootstrap-styling="true" :input-class="'form-control'" v-model="endDate"></datepicker>
                        <!-- /.input group -->
                    </div>
                    <button class="btn btn-default"
                            type="button" id="btnSearchByDate"
                            data-toggle="tooltip"
                            data-placement="bottom"
                            title="Search by date" style="margin-top: 4.5%">
                        Search <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>

            <div class="col-lg-4 col-md-5 col-sm-5 col-xs-6 pull-right">
                <form class="form-inline">
                    <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <multiselect id="select_tags"
                                     v-model="selectedProduct"
                                     :options="productOptions"
                                     :multiple="true"
                                     :close-on-select="false"
                                     :clear-on-select="false"
                                     :hide-selected="true"
                                     :preserve-search="true"
                                     placeholder="Choose Product"
                                     label="name"
                                     track-by="name">
                        </multiselect>
                    </div>
                </form>
            </div>

        </div> <br>

        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>Created At</th>
                    <th>Customer Name</th>
                    <th>Product Name</th>
                    <th>Rating</th>
                    <th>Need Call?</th>
                    <th>Urgent?</th>
                    <th>Answered?</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="feedbackProduct in feedbackProducts">
                        <td>
                            <a role="button">
                                {{ feedbackProduct.created_at }}
                            </a>
                        </td>
                        <td>
                            <a role="button">
                                <span v-if="feedbackProduct.customer !== null">
                                    {{ feedbackProduct.customer.name }}
                                </span>
                                <span v-else>
                                    Anonymous
                                </span>
                            </a>
                        </td>
                        <td>
                            {{ feedbackProduct.product }}
                        </td>
                        <td>
                            <span v-if="feedbackProduct.customer_rating === 1">
                                <i class="text-center material-icons text-red" style="font-size: 2em;">
                                    sentiment_very_dissatisfied
                                </i>
                            </span>
                            <span v-else-if="feedbackProduct.customer_rating === 2">
                                <i class="text-center material-icons text-yellow" style="font-size: 2em;">
                                    sentiment_neutral
                                </i>
                            </span>
                            <span v-else-if="feedbackProduct.customer_rating === 3">
                                <i class="text-center material-icons text-green" style="font-size: 2em;">
                                    sentiment_very_satisfied
                                </i>
                            </span>
                        </td>
                        <td>
                            <span v-if="feedbackProduct.is_need_call === 1" class="text-red">Yes</span>
                            <span v-else>No</span>
                        </td>
                        <td>
                            <span v-if="feedbackProduct.is_urgent === 1" class="text-red">Yes</span>
                            <span v-else>No</span>
                        </td>
                        <td>
                            <span v-if="feedbackProduct.is_answered === 1" class="text-red">Yes</span>
                            <span v-else>No</span>
                        </td>
                        <td>
                            <a role="button" class="btn btn-warning">
                                <i class="ion ion-edit"></i>
                            </a>
                            <button class="btn btn-danger">
                                <i class="ion ion-ios-trash"></i>
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
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import MultiSelect from 'vue-multiselect';

    Vue.component('multiselect', MultiSelect);

    export default {
        name: "feedback-list",
        props: ['tenant_id'],
        components: {Datepicker},
        watch: {
            selectedProduct: function () {
                let vm = this;
                if(vm.selectedProduct.length === 0) {
                    vm.getFeedbackProductList();
                } else {
                    let productIds = [];
                    for(let i=0;i<vm.selectedProduct.length;i++) {
                        productIds.push(vm.selectedProduct[i].systemId);
                    }
                    console.log(productIds);
                    const url = window.location.protocol + "//" + window.location.host + "/" + 'api/feedback_product/' + vm.tenant_id + '/filter-by-product/' + productIds;
                    axios.get(url).then(response => {
                        console.log(response.data.data);
                    }).catch(error => {
                        console.log(error);
                    });
                }
            }
        },
        created() {
            this.getFeedbackProductList();
            this.generateSelectProduct();
        },
        data() {
            return {
                feedbackProducts: [],
                startDate: moment().format('D MMM, YYYY'),
                endDate: moment().format('D MMM, YYYY'),
                show: true,
                selectedProduct: [],
                productOptions: [],
                pagination: {
                    currentPage: '',
                    endPage: '',
                    prevPage: '',
                    nextPage: '',
                    path: ''
                },
                default_image: window.location.protocol + "//" + window.location.host  + '/default-images/no-image.jpg',
                searchStatus: ''
            }
        },
        methods: {
            getFeedbackProductList: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/feedback_product/' + vm.tenant_id + '/get-feedback-product-list';
                axios.get(url).then(response => {
                    vm.feedbackProducts = response.data.data;
                    vm.makePagination(response.data);
                }).catch(error => {
                    console.log(error);
                });
            },
            generateSelectProduct: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/product/' + vm.tenant_id + '/generate-select-product';
                axios.get(url).then(response => {
                    vm.productOptions = response.data;
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
                let vm = this;
                vm.searchStatus = 'Loading...';
                function fireRequest() {
                    axios.get(url).then(response => {
                        vm.feedbackProducts = response.data.data;
                        vm.makePagination(response.data);
                        vm.searchStatus = '';
                    }).catch(error => {
                        console.log('something wrong within the process');
                        console.log(Object.assign({}, error));
                    });
                }

                var debounceFunction = _.debounce(fireRequest, 1000);
                debounceFunction(vm);
            }
        }
    }
</script>

<style scoped>

</style>