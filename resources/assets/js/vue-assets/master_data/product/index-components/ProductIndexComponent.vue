<template>
    <div>
        <div class="row">
            <div class="col-lg-8 col-md-4 col-sm-5">
                <form class="form-inline pull-left" id="form_search_list">
                    <!-- Date range -->
                    <div class="form-group">
                        <label for="date_start">From :</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="date_start" name="date_start">
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- Date range -->
                    <div class="form-group">
                        <label for="date_end">To :</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="date_end" name="date_end">
                        </div>
                        <!-- /.input group -->
                    </div>

                    <button class="btn btn-default"
                            type="button" id="btnSearchByDate"
                            data-toggle="tooltip"
                            data-placement="bottom"
                            title="Search by date">
                        Search <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>
        </div> <br> <br>

        <div class="table-responsive">
            <table class="table table-bordered table-striped" cellspacing="0" width="100%" id="table_product">
                <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Tags</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="product in products">
                    <td>
                        <a role="button">
                            <img v-if="product.img !== ''" v-bind:src="product.img" style="width: 75px; height: 50px;">
                            <img v-else v-bind:src="default_image" style="width: 75px; height: 50px;">
                        </a>
                    </td>
                    <td>
                        <a role="button">
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
                        <button class="btn btn-warning">
                            <i class="fa fa-pencil-square"></i>
                        </button>
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
                    <a v-if="pagination.prevPage !== null" role="button" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                    <a v-else role="button" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li v-for="n in pagination.endPage" v-bind:class="{ active:n===pagination.currentPage }">
                    <a v-if="n !== pagination.currentPage" role="button" >{{ n }}</a>
                    <a v-else role="button">{{ n }}</a>
                </li>
                <li v-bind:class="{disabled:pagination.nextPage === null}">
                    <a v-if="pagination.nextPage !== null" role="button" aria-label="Next">
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
        name: "product-index-component",
        props: ['tenantid'],
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
                default_image: window.location.protocol + "//" + window.location.host  + '/default-images/no-image.jpg'
            }
        },
        created() {
            this.getProductList();
        },
        methods: {
            getProductList: function () {
                const url = window.location.protocol + "//" + window.location.host  + '/api/product/' + this.tenantid + '/get-all-product';
                axios.get(url).then(response => {
                    console.log(response.data.data);
                    this.products = response.data.data;
                    this.makePagination(response.data);
                }).catch(error => {
                    console.log(response);
                })
            },

            makePagination: function (data) {
                let vm = this;
                vm.pagination.currentPage = data.meta.current_page;
                vm.pagination.endPage = data.meta.last_page;
                vm.pagination.path = data.meta.path;
                vm.pagination.prevPage = (data.links.prev === null ? null:data.links.prev);
                vm.pagination.nextPage = (data.links.next === null ? null:data.links.next);
            },
        }
    }
</script>

<style scoped>

</style>