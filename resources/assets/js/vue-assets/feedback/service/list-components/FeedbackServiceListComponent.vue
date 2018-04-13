<template>
    <div>
        <div class="row">
            <div class="col-lg-8 col-md-4 col-sm-5">
                <form class="form-inline pull-left" id="form_search_list">
                    <!-- Date range -->
                    <div class="form-group">
                        <label for="start_date">From :</label>
                        <datepicker id="start_date" :calendar-button="true" :calendar-button-icon="'fa fa-calendar'" :bootstrap-styling="true" :input-class="'form-control'" v-model="startDate"></datepicker>
                        <!-- /.input group -->
                    </div>
                    <!-- Date range -->
                    <div class="form-group">
                        <label for="end_date">To :</label>
                        <datepicker  id="end_date" :calendar-button="true" :calendar-button-icon="'fa fa-calendar'" :bootstrap-styling="true" :input-class="'form-control'" v-model="endDate"></datepicker>
                        <!-- /.input group -->
                    </div>
                    <button class="btn btn-default"
                            type="button" id="btnSearchByDate"
                            data-toggle="tooltip"
                            data-placement="bottom"
                            title="Search by date" style="margin-top: 4.5%" @click="filterByDate()">
                        Search <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>

            <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 pull-right">
                <div class="visible-xs">
                    <br>
                </div>
                <form class="form-inline">
                    <label for="select_tags">Select Service</label>
                    <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <multiselect id="select_tags"
                                     v-model="selectedService"
                                     :options="serviceOptions"
                                     :preserve-search="true"
                                     placeholder="Choose Service"
                                     label="name"
                                     track-by="name">
                        </multiselect>
                    </div>
                </form>
            </div>

        </div> <br>

        <div v-if="searchStatus !== ''">
            <i class="fa fa-circle-o-notch fa-spin"></i> {{ searchStatus }}
        </div>

        <div class="panel panel-danger" v-show="feedbackServices.length === 0">
            <div class="panel-body text-center">
                There is no data to display
            </div>
        </div>

        <div class="table-responsive" v-show="feedbackServices.length > 0">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>Created At</th>
                    <th>Customer Name</th>
                    <th>Service Name</th>
                    <th>Rating</th>
                    <th>Need Call?</th>
                    <th>Urgent?</th>
                    <th>Answered?</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="feedbackService in feedbackServices">
                    <td>
                        <a role="button" data-toggle="modal" data-target="#modal_show_feedback" @click="showDetail(feedbackService)">
                            {{ feedbackService.created_at }}
                        </a>
                    </td>
                    <td>
                        <a role="button" data-toggle="modal" data-target="#modal_show_feedback" @click="showDetail(feedbackService)">
                            <span v-if="feedbackService.customer !== null">
                                {{ feedbackService.customer.name }}
                            </span>
                            <span v-else>
                                Anonymous
                            </span>
                        </a>
                    </td>
                    <td>
                        {{ feedbackService.service.name }}
                    </td>
                    <td>
                        <span v-if="feedbackService.customer_rating === 1">
                            <i class="text-center material-icons text-red" style="font-size: 2em;">
                                sentiment_very_dissatisfied
                            </i>
                        </span>
                        <span v-else-if="feedbackService.customer_rating === 2">
                            <i class="text-center material-icons text-yellow" style="font-size: 2em;">
                                sentiment_neutral
                            </i>
                        </span>
                        <span v-else-if="feedbackService.customer_rating === 3">
                            <i class="text-center material-icons text-green" style="font-size: 2em;">
                                sentiment_very_satisfied
                            </i>
                        </span>
                    </td>
                    <td>
                        <span v-if="feedbackService.is_need_call === 1" class="text-red">Yes</span>
                        <span v-else>No</span>
                    </td>
                    <td>
                        <span v-if="feedbackService.is_urgent === 1" class="text-red">Yes</span>
                        <span v-else>No</span>
                    </td>
                    <td>
                        <span v-if="feedbackService.is_answered === 1" class="text-red">Yes</span>
                        <span v-else>No</span>
                    </td>
                    <td>
                        <a role="button" class="btn btn-warning" v-bind:href="feedbackService.show_edit_url">
                            <i class="ion ion-edit"></i>
                        </a>
                        <button class="btn btn-danger" data-toggle="modal" data-target="#modal_delete_feedback_service" @click="showDetail(feedbackService)">
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

        <!-- Modal Component -->
        <div class="modal fade" id="modal_show_feedback" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="clearState()"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-danger">Feedback Detail</h4>
                    </div>
                    <div class="modal-body">
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img v-if="feedbackService.service.img !== null" class="media-object" v-bind:src="feedbackService.service.img" width="125px">
                                    <img v-else v-bind:src="default_image" class="media-object" width="125px"/>
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading text-danger">
                                    {{ feedbackService.service.name }} ( {{ feedbackService.serviceCategory }} )
                                    <span class="mailbox-read-time pull-right visible-lg visible-md">{{ feedbackService.created_at }}</span>
                                    <span class="mailbox-read-time visible-sm visible-xs">{{ feedbackService.created_at }}</span>
                                </h4>
                            </div>
                        </div>
                        <div class="text-muted">From:
                            <span id="reply_to" class="text-info">
                                <span v-if="feedbackService.customer !== null">{{ feedbackService.customer.name }}</span>
                                <span v-else>Anonymous</span>
                            </span>
                        </div>
                        <div class="text-muted">
                            Created by :
                            <span class="text-blue"> {{ feedbackService.creator.name }} </span>
                        </div>
                        <div>
                            <span class="text-muted">
                                Satisfaction :
                            </span>
                            <button class="btn btn-link" v-if="feedbackService.customer_rating === 1">
                                <i class="text-center material-icons text-red" style="font-size: 2.5em;">
                                    sentiment_very_dissatisfied
                                </i>
                            </button>
                            <button class="btn btn-link" v-else-if="feedbackService.customer_rating === 2">
                                <i class="text-center material-icons text-yellow" style="font-size: 2.5em;">
                                    sentiment_neutral
                                </i>
                            </button>
                            <button class="btn btn-link" v-else-if="feedbackService.customer_rating === 3">
                                <i class="text-center material-icons text-green" style="font-size: 2.5em;">
                                    sentiment_very_satisfied
                                </i>
                            </button>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <span class="text-muted">Feedback : </span> <br>
                                <p align="justify">
                                    {{ feedbackService.customer_feedback }}
                                </p>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <div v-show="feedbackService.attachment !== null">
                                    <span class="text-muted">Attachment :</span>
                                    <ul class="mailbox-attachments clearfix">
                                        <li style="width: 155px;">
                                            <a>
                                                <span class="mailbox-attachment-icon has-img">
                                                    <img v-bind:src="feedbackService.attachment" alt="Attachment">
                                                </span>
                                            </a>
                                            <div class="mailbox-attachment-info">
                                                <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> attachment</a>
                                                <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 1%;">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <button v-if="feedbackService.customer !== null"
                                            class="btn btn-primary"
                                            type="button" @click="showReply = !showReply">
                                        <i class="ion ion-chatbubble-working"></i> Reply
                                    </button>
                                    <button v-else
                                            class="btn btn-primary disabled"
                                            type="button"
                                            data-toggle="tooltip"
                                            data-placement="bottom"
                                            title="Can't reply on anonymous">
                                        <i class="ion ion-chatbubble-working"></i> Reply
                                    </button>
                                </div>
                                <div class="form-group" v-bind:class="{'has-error': errors.has('reply_content')}">
                                    <input type="hidden" name="complaintServiceId" id="complaintServiceId" v-bind:value="feedbackService.systemId">
                                    <input v-if="feedbackService.customer !== null" type="hidden" name="customerId" id="customerId" v-bind:value="feedbackService.customer.systemId">
                                    <input type="hidden" name="creatorId" id="creatorId" v-bind:value="feedbackService.creator.systemId">
                                    <div v-show="showReply">
                                        <textarea id="reply_content"
                                                  name="reply_content"
                                                  class="form-control"
                                                  placeholder="Content. . ."
                                                  rows="4"
                                                  v-validate="'required'"
                                                  v-model="feedbackServiceReply.reply_content">
                                        </textarea>
                                        <span class="help-block text-red pull-left" v-show="errors.has('reply_content')">
                                            {{ errors.first('reply_content') }}
                                        </span>
                                        <button type="button" class="btn btn-success pull-right" style="margin-top: 2%;" @click="addFeedbackServiceReply()">
                                            Submit <i class="ion ion-android-send"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="container-fluid">
                                <h5>
                                    <a v-if="feedbackService.customer !== null"
                                       role="button"
                                       id="btnCollapseAllReplies" @click="showReplyList = !showReplyList">
                                        <i class="ion ion-chatboxes"></i> View All Replies
                                    </a>
                                    <a v-else
                                       role="button"
                                       class="btn btn-link disabled">
                                        <i class="ion ion-chatboxes"></i> View All Replies
                                    </a>
                                </h5>

                                <span v-if="loadReply !== ''">
                                    <i class="fa fa-circle-o-notch fa-spin"></i> {{ loadReply }}
                                </span>
                            </div>

                            <div v-show="showReplyList">
                                <div class="well" v-show="loadReply === ''">
                                    <span v-if="feedbackServiceReplies.length === 0">
                                        This complaint doesn't have any replies yet
                                    </span>
                                    <div v-else v-for="feedbackServiceReply in feedbackServiceReplies">
                                        <div class="panel panel-danger">
                                            <div class="panel-heading">
                                                <strong>
                                                    {{ feedbackServiceReply.syscreator.name }} ({{ feedbackServiceReply.syscreator_role }})
                                                </strong>
                                            </div>
                                            <div class="panel-body">
                                                <p>{{ feedbackServiceReply.reply_content }}</p>
                                                <button v-bind:data-id="feedbackServiceReply.systemId" class="btn btn-sm btn-danger" onclick="$('div#'+$(this).data('id')).toggleClass('invisible')">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                                <div class="inline invisible" v-bind:id="feedbackServiceReply.systemId">
                                                    <span class="text-orange">Delete this Reply ?</span>
                                                    <a role="button" v-bind:data-id="feedbackServiceReply.systemId" onclick="$('div#'+$(this).data('id')).addClass('invisible')">
                                                        <span class="label label-default">No</span>
                                                    </a>
                                                    <a role="button" v-bind:data-id="feedbackServiceReply.systemId" @click="deleteFeedbackServiceReply($event)">
                                                        <span class="label label-danger">Yes</span>
                                                    </a>
                                                </div>
                                            </div><!-- /panel-body -->
                                            <div class="panel-footer">
                                                <span class="text-muted">
                                                    Replied at {{ feedbackServiceReply.created_at }}
                                                </span>
                                            </div>
                                        </div><!-- /panel panel-default -->
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" @click="clearState()">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Delete Feedback Service -->
        <div class="modal fade" id="modal_delete_feedback_service" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-red" id="myModalLabel">Warning!</h4>
                    </div>
                    <div class="modal-body">
                        Are you sure want to delete this feedback ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" @click="deleteFeedbackService()">Delete</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import MultiSelect from 'vue-multiselect';

    Vue.use(VeeValidate, {
        dictionary: {
            en: {
                custom: {
                    reply_content: {
                        required: "Please enter the reply content"
                    }
                }
            }
        }
    });

    Vue.component('multiselect', MultiSelect);

    export default {
        name: "feedback-list",
        props: ['tenant_id', 'user_id'],
        components: { Datepicker },
        data() {
            return {
                feedbackServices: [],
                feedbackService: {
                    systemId: '',
                    customer: '',
                    rating: '',
                    customer_feedback: '',
                    service: [],
                    serviceCategory: [],
                    fileName: '',
                    image: '',
                    need_call: 0,
                    is_urgent: 0,
                    creator: [],
                    attachment: ''
                },
                startDate: new Date(),
                endDate: new Date(),
                show: true,
                selectedService: '',
                serviceOptions: [],
                pagination: {
                    currentPage: '',
                    endPage: '',
                    prevPage: '',
                    nextPage: '',
                    path: ''
                },
                default_image: window.location.protocol + "//" + window.location.host  + '/default-images/no-image.jpg',
                feedbackServiceReplies: [],
                feedbackServiceReply: {
                    reply_content: ''
                },
                loadReply: '',
                searchStatus: '',
                showReply: false,
                showReplyList: false
            }
        },
        created() {
            this.getFeedbackServiceList();
            this.generateSelectService();
        },
        watch: {
            selectedService: function () {
                let vm = this;
                if(vm.selectedService !== null && vm.selectedService !== '') {
                    vm.searchStatus = 'Searching...';
                    const url = window.location.protocol + "//" + window.location.host + "/" + 'api/feedback_service/' + vm.tenant_id + '/filter-by-service/' + vm.selectedService.systemId;
                    function sendRequest() {
                        axios.get(url).then(response => {
                            vm.feedbackServices = response.data.data;
                            vm.makePagination(response.data);
                            vm.searchStatus = '';
                        }).catch(error => {
                            console.log(error);
                        });
                    }
                    let debounceFunction = _.debounce(sendRequest, 1000);
                    debounceFunction();
                } else {
                    vm.getFeedbackServiceList();
                }
            },
            showReplyList: function () {
                let vm = this;
                if(vm.showReplyList === true) {
                    vm.getFeedbackServiceReply();
                }
            }
        },
        methods: {
            getFeedbackServiceList: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/feedback_service/' + vm.tenant_id + '/get-feedback-service-list';
                axios.get(url).then(response => {
                    vm.feedbackServices = response.data.data;
                    vm.makePagination(response.data);
                }).catch(error => {
                    console.log(error);
                });
            },
            generateSelectService: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/service/' + vm.tenant_id + '/generate-select-service';
                axios.get(url).then(response => {
                    vm.serviceOptions = response.data;
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
                        vm.feedbackServices = response.data.data;
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
            filterByDate: function () {
                let vm = this;
                let start_date = moment(vm.startDate).format('YYYY-MM-DD');
                let end_date = moment(vm.endDate).format('YYYY-MM-DD');
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/feedback_service/' + vm.tenant_id + '/filter-by-date/' + start_date + '/' + end_date;
                vm.searchStatus = 'Searching...';

                function sendRequest() {
                    axios.get(url).then(response => {
                        vm.feedbackServices = response.data.data;
                        vm.makePagination(response.data);
                        vm.searchStatus = '';
                    }).catch(error => {
                        console.log(error);
                    });
                }
                let debounceFunction = _.debounce(sendRequest, 1000);
                debounceFunction();
            },
            deleteFeedbackService: function() {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/feedback_service/delete-feedback-service';
                vm.searchStatus = 'Loading...';

                axios.post(url, {
                    feedback_id: vm.feedbackService.systemId
                }).then(response => {
                    if(response.data.message === 'success') {
                        function sendRequest() {
                            vm.getFeedbackServiceList();
                            vm.searchStatus = '';
                        }
                        let debounceFunction = _.debounce(sendRequest, 1000);
                        debounceFunction();
                    }
                }).catch(error => {
                    console.log(error);
                })
            },

            /* Modal Section */
            showDetail: function(selectedFeedback) {
                let vm = this;
                vm.feedbackService = selectedFeedback;
            },
            clearState: function () {
                let vm = this;
                vm.showReply = false;
                vm.showReplyList = false;
                vm.reply_content = '';
                vm.feedbackServiceReplies = [];
                vm.feedbackServiceReply.reply_content = '';
                vm.$validator.reset();
            },
            addFeedbackServiceReply: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/feedback_service_reply/add-feedback-service-reply';

                axios.post(url, {
                    reply_content: vm.feedbackServiceReply.reply_content,
                    customerId: vm.feedbackService.customer.systemId,
                    feedbackServiceId: vm.feedbackService.systemId,
                    syscreator: vm.user_id
                }).then(response => {
                    if(response.data.message === 'success') {
                        vm.getFeedbackServiceReply();
                        vm.showReplyList = true;
                        vm.feedbackServiceReply.reply_content = '';
                        vm.showReply = false;
                    }
                }).catch(error => {
                    console.log(error);
                })
            },
            getFeedbackServiceReply: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/feedback_service_reply/' + vm.feedbackService.systemId + '/get-feedback-service-replies';
                vm.loadReply = 'Loading...';

                function sendRequest() {
                    axios.get(url).then(response => {
                        console.log(response.data.data);
                        vm.feedbackServiceReplies = response.data.data;
                        vm.loadReply = '';
                    }).catch(error => {
                        console.log(error);
                    });
                }
                let debounceFunction = _.debounce(sendRequest, 1000);
                debounceFunction();
            },
            deleteFeedbackServiceReply: function (event) {
                let vm = this;
                let reply_id = $(event.currentTarget).data('id');
                console.log(reply_id);
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/feedback_service_reply/' + reply_id + '/delete-feedback-service-reply';

                axios.post(url).then(response => {
                    if(response.data.message === 'success') {
                        vm.getFeedbackServiceReply();
                    }
                }).catch(error => {
                    console.log(error);
                });
            }
        }
    }
</script>

<style scoped>

</style>