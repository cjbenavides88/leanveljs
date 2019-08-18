<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1>{{ app.board.title}}</h1>
            </div>
        </div>
        <div class="bg-light d-flex justify-content-end mb-3 p-2">
            <div class="mr-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="page-size"><i class="fas fa-list-ol"></i></label>
                    </div>
                    <select v-model="table.page.size" class="custom-select" id="page-size" @change="updatePages">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="75">75</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
            <div class="">
                <div class="input-group">
                    <div class="input-group-prepend">
                                <span class="input-group-text bg-primary text-light" id="basic-addon1"><i
                                        class="fas fa-search"></i></span>
                    </div>
                    <label for="search" class="d-none">Search</label>
                    <input id="search" autocomplete="off" v-model="table.search" type="text"
                           class="form-control" placeholder="Quick Search" @keyup="updatePages">
                </div>
            </div>
        </div>
        <div class="table-wrapper">
            <div class="responsive-table border-spacing-1 mb-3 ">
                <div class="table-heading bg-light" :class="table.sortData.dir">
                    <div class="table-header sortable" tabindex="0" @click="sort('color')" @focusin="activeHeader" @focusout="deactiveHeader">Type</div>
                    <div class="table-header" >Brand</div>
                    <div class="table-header sortable" tabindex="0" @click="sort('title')" @focusin="activeHeader" @focusout="deactiveHeader">Title</div>
                    <div class="table-header sortable" tabindex="0" @click="sort('id')" @focusin="activeHeader" @focusout="deactiveHeader" >Card ID</div>
                    <div class="table-header">Lane</div>
                    <div class="table-header">Total Size</div>
                    <div class="table-header">Total Tasks</div>
                    <div class="table-header">Assigned</div>
                </div>
                <div class="table-body">
                    <div :id="index" class="table-row bg-light" v-for="(card, index) in filteredData" >
                        <div class="table-cell p-2">
                            <div class="d-inline-block" data-toggle="tooltip" :title="card.type.title">
                                <svg class=" rounded mr-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
                                    <rect width="100%" height="100%" :fill="card.color"></rect>
                                </svg>
                            </div>
                        </div>
                        <div class="table-cell">{{card.customId.value}}</div>
                        <div class="table-cell p-2">{{card.title}}</div>
                        <div class="table-cell p-2">{{card.id}}</div>
                        <div class="table-cell p-2">{{card.lane.title}} | {{card.lane.id }}</div>
                        <div class="table-cell p-2 text-center">
                            <div  v-if="card.taskBoardStats">
                                <div>{{ card.taskBoardStats.completedSize }} / {{ card.taskBoardStats.totalSize }}</div>
                                <div class="progress" style="height: 5px;">
                                    <div  class="progress-bar" role="progressbar" :style="{ width : Math.round((card.taskBoardStats.completedSize/card.taskBoardStats.totalSize)*100) + '%'}" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div v-else> - </div>
                        </div>
                        <div class="table-cell p-2 text-center">
                            <div  v-if="card.taskBoardStats">
                                <div>{{ card.taskBoardStats.completedCount }} / {{ card.taskBoardStats.totalCount }}</div>
                                <div class="progress" style="height: 5px;">
                                    <div  class="progress-bar" role="progressbar" :style="{ width : Math.round((card.taskBoardStats.completedCount/card.taskBoardStats.totalCount)*100) + '%'}" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div v-else> - </div>
                        </div>
                        <div class="table-cell p-2">
                            <div class="assigned-users" v-if="card.assignedUsers">
                                <div class="d-inline-block mx-1" v-for=" user in card.assignedUsers">
                                    <img class="rounded-lg" :src="user.avatar" :alt="user.fullName" data-toggle="tooltip" :title="user.fullName">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {tableroids} from "../../mixins/tableroids";
    export default {
        name: "BoardView",
        props : ['id'],
        mixins : [tableroids],
        data: function() {
            return {
                app: {
                    board  : [],
                },
            }
        },
        methods : {
            getBoards(){
                axios.post('leankit/board',{boardID : this.id},{'errorHandle' : true})
                    .then( response => {
                        this.setTableData(response.data.cards.cards);
                        this.app.board = response.data.board;
                    })
                    .catch( error => {
                        console.log(error);
                    });
            },

        },
        created() {
            this.getBoards();
        },
    }
</script>

<style lang="scss" scoped>

    .table-heading {


    }
</style>